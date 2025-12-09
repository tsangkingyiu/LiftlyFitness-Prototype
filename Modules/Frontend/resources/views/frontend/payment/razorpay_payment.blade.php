<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <script src="{{ asset('frontend-section/js/razorpay_checkout.js') }}"></script>
</head>
<body>
    <!-- Razorpay Payment Form -->
    <form action="{{ route('razorpay.payment.callback',['package_id' => $package_id]) }}" method="POST" id="razorpay-form">
        @csrf
        <input type="hidden" id="order_id" value=" {{ $data['order_id'] }}">
    </form>

    <script type="text/javascript">
        window.onload = function() {
            var options = {
                "key": "{{ $data['razorpay_key'] }}", 
                "amount": "{{ $data['amount'] * 100 }}",
                "currency": "{{ $data['currency'] }}",
                "name": "{{ $data['name'] }}",
                "description": "{{ $data['description'] }}",
                "image": "{{ $data['image'] }}",
                "order_id": "{{ $data['order_id'] }}",

                "theme": {
                    "color": "#ec7e4a"
                },
                "handler": function (response){
                    var form = document.getElementById('razorpay-form');
                    
                    var paymentIdField = document.createElement('input');
                    paymentIdField.setAttribute('type', 'hidden');
                    paymentIdField.setAttribute('name', 'razorpay_payment_id');
                    paymentIdField.setAttribute('value', response.razorpay_payment_id);
                    form.appendChild(paymentIdField);

                    var orderIdField = document.createElement('input');
                    orderIdField.setAttribute('type', 'hidden');
                    orderIdField.setAttribute('name', 'razorpay_order_id');
                    orderIdField.setAttribute('value', response.razorpay_order_id);
                    form.appendChild(orderIdField);

                    var signatureField = document.createElement('input');
                    signatureField.setAttribute('type', 'hidden');
                    signatureField.setAttribute('name', 'razorpay_signature');
                    signatureField.setAttribute('value', response.razorpay_signature);
                    form.appendChild(signatureField);

                    form.submit();
                },
                "modal": {
                    "escape": false,
                    "ondismiss": function() {
                        window.location.href = "{{ route('payment',['package_id' => $package_id]) }}";
                    }
                }
            };

            var rzp1 = new Razorpay(options);
            rzp1.open();
        }
    </script>
</body>
</html>
