<?php

namespace Modules\Frontend\App\Traits;

use App\Models\Package;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

trait PaypalTrait
{
    private $apiContext;

    public function initializePayPal()
    {
        $paymentGateway = PaymentGateway::where('type', 'paypal')->first();

        $clientId = $paymentGateway->is_test == 1 ? $paymentGateway->test_value['client_id'] : $paymentGateway->live_value['client_id'];
        $secret = $paymentGateway->is_test == 1 ? $paymentGateway->test_value['secret_key'] : $paymentGateway->live_value['secret_key'];
        // $mode = $paymentGateway->is_test == 1 ? 'sandbox' : 'live';
        // $mode = 'sandbox';

        // $this->apiContext = new ApiContext(
        //     new OAuthTokenCredential(
        //         config('paypal.client_id'),
        //         config('paypal.secret')
        //     )
        // );

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential($clientId, $secret)
        );

        $this->apiContext->setConfig([
            // 'mode' => $mode,
            'http.ConnectionTimeOut' => 1000,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE',
        ]);

        // $this->apiContext->setConfig(config('paypal.settings'));
    }

    public function sendPaypalPayment(Request $request)
    {
        $this->initializePayPal();
        
        $auth_user = auth()->user();
        $package_id =  encryptDecryptId($request->input('package_id'),'decrypt');
        $package = Package::find($package_id);

        if (!$package) {
            return redirect()->back()->with('error', __('message.not_found_entry',['name' => __('message.package') ]));
        }

        $currency = SettingData('CURRENCY', 'CURRENCY_CODE') ?? 'USD';
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = (new \PayPal\Api\Item())
            ->setName($package->title)
            ->setCurrency($currency)
            ->setQuantity(1)
            ->setPrice($package->price);

        $amount = (new Amount())
            ->setCurrency($currency)
            ->setTotal($package->price);

        $transaction = (new Transaction())
            ->setAmount($amount)
            ->setItemList((new \PayPal\Api\ItemList())->setItems([$item]))
            ->setDescription($package->description);

        $redirectUrls = (new RedirectUrls())
            ->setReturnUrl(route('paypal.callback', ['package_id' => $request->input('package_id')]))
            ->setCancelUrl(route('pricing-plan'));

        $payment = (new Payment())
            ->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
            return redirect($payment->getApprovalLink());
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return redirect()->back()->with('error', 'Connection error: ' . $ex->getMessage());
        }
    }

    public function paypalPaymentCallback(Request $request)
    {
        $this->initializePayPal();

        $paymentId = $request->get('paymentId');
        $payerId = $request->get('PayerID');
        $request['payment'] = 'paypal';
        
        if (!$paymentId || !$payerId) {
            return redirect()->route('pricing-plan')->with('error', __('message.payment_failed'));
        }

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = (new PaymentExecution())->setPayerId($payerId);

        try {
            $result = $payment->execute($execution, $this->apiContext);
            if ($result->getState() === 'approved') {
                return $this->paymentSuccess($request);
            }
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return redirect()->route('pricing-plan')->with('error', __('message.payment_failed') . ' ' . $ex->getMessage());
        }

        return redirect()->route('pricing-plan')->with('error', __('message.payment_not_approved'));
    }
}
