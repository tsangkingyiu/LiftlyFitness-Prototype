<x-frontend-layout :assets="$assets ?? []">
    <section class="pt-1">
        <div class="payment-container mt-4">
            @if( count($payment_gateway) > 0 )
                <form id="payment-form" method="POST">
                    @csrf
                    @foreach($payment_gateway as $key => $value)
                        <div class="form-check payment-option d-flex align-items-center position-relative">
                            <input class="form-check-input" type="radio" name="payment" id="{{ $value->type }}" value="{{ $value->type }}" >
                            <label class="form-check-label d-flex align-items-center" for="{{ $value->type }}">
                                <img src="{{ asset('images/'.$value->type.'.png') }}">
                                {{ __('message.'.$value->type) }}
                            </label>
                        </div>
                    @endforeach                
                    <input type="hidden" id="payment-action-url" name="payment_action_url" value="">
                    <button type="button" id="pay-button" class="btn btn-select text-white d-block mx-auto w-50">
                        {{ __('frontend::message.pay_now') }}
                    </button>
                </form>
            @else
                <div class="d-flex justify-content-center flex-column align-items-center mt-5 pb-5">
                    <img src="{{ asset('frontend-section/images/no-data.png') }}" class="nodata-img">
                    <p class="font-p mt-4 mb-5">{{ __('message.not_found_entry',['name' => __('message.payment')]) }}</p>
                </div>
            @endif
        </div>
    </section>

    @section('bottom_script')
        <script>
            $('input[name="payment"]').change(function() {
                const selectedValue = $(this).val();
                let actionUrl = '';

                switch (selectedValue) {
                    case 'razorpay':
                        actionUrl = "{{ route('razorpay',['package_id'=> $package_id]) }}";
                        break;
                    case 'stripe':
                        actionUrl = "{{ route('stripe.payment',['package_id'=> $package_id]) }}";
                        break;
                    case 'paypal':
                        actionUrl = "{{ route('paypal.payment',['package_id'=> $package_id]) }}";
                        break;
                    case 'paystack':
                        actionUrl = "{{ route('paystack',['package_id'=> $package_id]) }}";
                        break;
                }

                $('#payment-action-url').val(actionUrl);
                $('#payment-form').attr('action', actionUrl);
            });
        </script>
        <script>
            $('#pay-button').click(function() {
                const payment_type = $('input[name="payment"]:checked').val();
                const form = $('#payment-form');
                let status = false;

                switch (payment_type) {
                    case 'razorpay':
                    case 'stripe':
                    case 'paystack':
                    case 'paypal':
                        status = true;
                        break;
                    default:
                        status = false;
                        break;
                }

                if (status) {
                    form.submit();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: "{{ __('frontend::message.payment_select_payment_method') }}",
                    });
                }
            });
        </script>
    @endsection
</x-frontend-layout>
