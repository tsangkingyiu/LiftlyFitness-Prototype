<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Package;
use App\Models\PaymentGateway;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Traits\SubscriptionTrait;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Paystack;
use App\Traits\PaypalTrait;


class PaymentController extends Controller
{
    use SubscriptionTrait;
    // use PaypalTrait;

    public function payment(Request $request)
    {
        $auth_user = auth()->user();
        $package_id =  request('package_id');
        $package_data = Package::find(encryptDecryptId($package_id,'decrypt'));


        if ($package_data && $package_data->price == 0) {
            $this->subscriptionSave($request);
            return redirect()->route('my.subscription')->with('success', __('frontend::message.payment_was_successful'));
        }

        $payment_gateway = PaymentGateway::whereIn('type', ['stripe', 'razorpay', 'paystack'])->where('status', 1)->get();

        return view('frontend::frontend/payment/payment',compact('package_id','auth_user','payment_gateway'));
    
    }

    public function razorpay(Request $request)
    {
        $auth_user = auth()->user();
        $package_id = request('package_id');
        $package_data = Package::find(encryptDecryptId($package_id,'decrypt'));

        if ( empty($package_data) ) {
            return redirect()->back()->with('error', __('message.not_found_entry',['name' => __('frontend::message.package') ]));
        }

        // $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        $paymentGateway = PaymentGateway::where('status', 1)->where('type', 'razorpay')->first();


        $razorpay_key = $paymentGateway->is_test == 1 ? $paymentGateway->test_value['key_id'] : $paymentGateway->live_value['key_id'];
        $razorpay_secret = $paymentGateway->is_test == 1 ? $paymentGateway->test_value['secret_id'] : $paymentGateway->live_value['secret_id'];
        
        try {
            $api = new Api($razorpay_key, $razorpay_secret);

            $order = $api->order->create([
                'receipt' => 'order_rcptid_11',
                'amount' => $package_data->price * 100,
                'currency' => SettingData('CURRENCY', 'CURRENCY_CODE') ?? 'USD'
            ]);
            $data = [
                'order_id' => $order['id'],
                // 'razorpay_key' => config('services.razorpay.key'),
                'razorpay_key' => $razorpay_key,
                'amount' => $package_data->price,
                'name' => env('APP_NAME'),
                'currency' => SettingData('CURRENCY', 'CURRENCY_CODE') ?? 'USD',
                'description' => $package_data->description,
                'image' => getSingleMedia(appSettingData('get'),'site_logo',null),
                'callback_url' => route('razorpay.payment.callback'),
            ];
    
            return view('frontend::frontend/payment/razorpay_payment',compact('package_id','data','auth_user'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    
    }

    public function razorpayPaymentCallback(Request $request)
    {
        $paymentGateway = PaymentGateway::where('type', 'razorpay')->first();

        $razorpay_key = $paymentGateway->is_test == 1 ? $paymentGateway->test_value['key_id'] : $paymentGateway->live_value['key_id'];
        $razorpay_secret = $paymentGateway->is_test == 1 ? $paymentGateway->test_value['secret_id'] : $paymentGateway->live_value['secret_id'];

        $api = new Api($razorpay_key, $razorpay_secret);
        // $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $attributes = [
            'razorpay_signature' => $request->input('razorpay_signature'),
            'razorpay_payment_id' => $request->input('razorpay_payment_id'),
            'razorpay_order_id' => $request->input('razorpay_order_id')
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);
            $request['payment'] = 'razorpay';
            $this->subscriptionSave($request);
            return redirect()->route('my.subscription')->with('success', __('frontend::message.payment_was_successful'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function stripe(Request $request)
    {
        $package_id =  encryptDecryptId(request('package_id'),'decrypt');
        $package_data = Package::find($package_id);

        if ( empty($package_data) ) {
            return redirect()->back()->with('error', __('message.not_found_entry',['name' => __('frontend::message.package') ]));
        }

        $paymentGateway = PaymentGateway::where('status','1')->where('type', 'stripe')->first();

        $stripe_secret = $paymentGateway->is_test == 1 ? $paymentGateway->test_value['secret_key'] : $paymentGateway->live_value['secret_key'];

        if (empty($stripe_secret)) {
            return redirect()->back()->with('error', __('frontend::message.payment_key_missing'));
        }

        try {
            // Stripe::setApiKey(config('services.stripe.secret'));
            Stripe::setApiKey($stripe_secret);

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => SettingData('CURRENCY', 'CURRENCY_CODE') ?? 'USD',
                        'product_data' => [
                            'name' => 'Product Name',
                        ],
                        'unit_amount' => $package_data->price * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success',$request->all()),
                'cancel_url' => route('pricing-plan'),
            ]);
    
            return redirect($session->url);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
       
    }

    public function paymentSuccess(Request $request)
    {
        $this->subscriptionSave($request);
        return redirect()->route('my.subscription')->with('success', __('frontend::message.payment_was_successful'));
    }

    public function subscriptionSave($request)
    {
        $request['package_id'] = encryptDecryptId($request->package_id,'decrypt');
        $data = $request->all();
        $user_id = auth()->id();
        $user = User::where('id', $user_id)->first();
        $package_data = Package::where('id',$data['package_id'])->first();

        if ( empty($package_data) ) {
            return redirect()->back()->with('error', __('message.not_found_entry',['name' => __('frontend::message.package') ]));
        }
        
        $get_existing_plan = $this->get_user_active_subscription_plan($user_id);
        
        $active_plan_left_days = 0;
        
        $data['user_id'] = $user_id;
        $data['status'] = config('frontend.constant.SUBSCRIPTION_STATUS.PENDING');
        $data['subscription_start_date'] = date('Y-m-d H:i:s');
        $data['total_amount'] = $package_data->price;
        $data['payment_status'] = 'paid';
        $data['payment_type'] = $request->payment;
        // $data['txn_id'] = $request->order_id;

        if($get_existing_plan)
        {
            $active_plan_left_days = $this->check_days_left_plan($get_existing_plan, $data);
            if($package_data->id != $get_existing_plan->package_id)
            {
                $get_existing_plan->update([
                    'status' => config('frontend.constant.SUBSCRIPTION_STATUS.INACTIVE')
                ]);
                $get_existing_plan->save();
            }
        }

        $data['subscription_end_date'] = $this->get_plan_expiration_date( $data['subscription_start_date'], $package_data->duration_unit, $active_plan_left_days, $package_data->duration );

        $data['package_data'] = $package_data ?? null;

        $subscription = Subscription::create($data);

        if( $subscription->payment_status == 'paid' ) {
            $subscription->status = config('frontend.constant.SUBSCRIPTION_STATUS.ACTIVE');
            $subscription->save();
            $user->update([ 'is_subscribe' => 1 ]);
        }

        // $message = __('message.save_form', ['form' => __('message.subscription')]);
        // return response()->json(['status' => true, 'message' => $message ]);
    }


    public function paystack(Request $request)
    {
        $auth_user = auth()->user();
        $package_id =  request('package_id');
        $package_data = Package::find(encryptDecryptId($package_id,'decrypt'));

        if ( empty($package_data) ) {
            return redirect()->back()->with('error', __('message.not_found_entry',['name' => __('frontend::message.package') ]));
        }

        $paymentGateway = PaymentGateway::where('status', 1)->where('type', 'paystack')->first();

        if (!$paymentGateway) {
            return redirect()->back()->with('error', __('Payment gateway configuration not found.'));
        }

        $testValue = $paymentGateway->test_value ?? [];
        $liveValue = $paymentGateway->live_value ?? [];

        $areKeysValid = function ($values) {
            return isset($values['public_key'], $values['secret_key'], $values['payment_url']) && !empty($values['public_key']) && !empty($values['secret_key']) && !empty($values['payment_url']);
        };
        
        if ($paymentGateway->is_test == 1) {
            if (!$areKeysValid($testValue)) {
                return redirect()->back()->with('error', __('frontend::message.payment_key_missing'));
            }
        } else {
            if (!$areKeysValid($liveValue)) {
                return redirect()->back()->with('error', __('frontend::message.payment_key_missing'));
            }
        }

        config([
            'paystack.publicKey' => $paymentGateway->is_test == 1 ? $paymentGateway->test_value['public_key'] : $paymentGateway->live_value['public_key'],
            'paystack.secretKey' => $paymentGateway->is_test == 1 ? $paymentGateway->test_value['secret_key'] : $paymentGateway->live_value['secret_key'],
            'paystack.paymentUrl' => $paymentGateway->is_test == 1 ? $paymentGateway->test_value['payment_url'] : $paymentGateway->live_value['payment_url'],
        ]);

        try {
            $data = [
                "email" => $auth_user->email,
                "orderID" => "ORDER_" . uniqid(),
                "amount" => $package_data->price * 100,
                "quantity" => 1,
                "currency" => SettingData('CURRENCY', 'CURRENCY_CODE') ?? 'USD',
                "reference" => Paystack::genTranxRef(),
                "metadata" => json_encode([
                    'user_id' => $auth_user->id,
                    'package_id' => $package_id,
                    'package_price' => $package_data->price,
                ]),
                "callback_url" => route('paystack.payment.callback'),
            ];

            // Redirect to Paystack
            return Paystack::getAuthorizationUrl($data)->redirectNow();
        } catch (\Exception $e) {

            if ($e instanceof \GuzzleHttp\Exception\ClientException) {
                $response = json_decode($e->getResponse()->getBody()->getContents(), true);
                $errorMessage = $response['message'] ?? 'An error occurred';
            } else {
                $errorMessage = 'An unexpected error occurred';
            }
        
            return redirect()->back()->with([
                'error' => $errorMessage,
            ]);

        }
    }

    public function handleGatewayCallback()
    {
        $paymentGateway = PaymentGateway::where('status', 1)->where('type', 'paystack')->first();

        config([
            'paystack.publicKey' => $paymentGateway->is_test == 1 ? $paymentGateway->test_value['public_key'] : $paymentGateway->live_value['public_key'],
            'paystack.secretKey' => $paymentGateway->is_test == 1 ? $paymentGateway->test_value['secret_key'] : $paymentGateway->live_value['secret_key'],
            'paystack.paymentUrl' => $paymentGateway->is_test == 1 ? $paymentGateway->test_value['payment_url'] : $paymentGateway->live_value['payment_url'],
        ]);
    
        try {
            $paymentDetails = Paystack::getPaymentData();
            
            if ($paymentDetails['status'] && $paymentDetails['data']['status'] === 'success') {
                $metadata = $paymentDetails['data']['metadata'];
        
                if (!is_array($metadata)) {
                    $metadata = json_decode($metadata, true);
                }
        
                $request = new Request();
                $request->merge([
                    'payment' => 'paystack',
                    'package_id' => $metadata['package_id'],
                ]);
                
                $this->subscriptionSave($request);
        
                return redirect()->route('my.subscription')->with('success', __('frontend::message.payment_was_successful'));
            } else {
                return redirect()->route('pricing-plan')->with('error', __('frontend::message.payment_failed'));
            }
        } catch (\Exception $e) {
            // Log::error('Error in Paystack callback: ' . $e->getMessage());
            return redirect()->route('pricing-plan')->with('error', __('An error occurred during payment verification.'));
        }
    }

    public function paypalPayment(Request $request)
    {
        return $this->sendPaypalPayment($request);
    }

    public function paypalCallback(Request $request)
    {
        return $this->paypalPaymentCallback($request);
    }
    
}

