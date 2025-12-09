<x-frontend-auth-layout :assets="$assets ?? []">
    <section>
        <div class="">
            <img class="position-absolute top-0 end-0 pattern-img" src="{{ asset('frontend-section/images/pattern.png') }}">
        </div>

        <div class="row m-0 align-items-center vh-100 carousel-section">
            <div class="col-lg-6 d-none d-lg-block">
                @include('frontend::frontend.auth.carousel')
            </div>
            <div id="phone-number-section" class="col-lg-6 h-100 otp-section">
                <div class="row justify-content-center mb-4">
                    <div class="col-md-10">
                        <div class="border-0 mb-0 auth-card">
                            <div class="card-body auth-cardbody">
                                <div class="alert alert-success" id="sentSuccess" style="display: none;"></div>

                                <div class="d-flex justify-content-center align-items-center border rounded-circle arrow-container mb-3 position-relative back-btn">
                                    <a href="{{ route('frontend.signin') }}">
                                        <svg width="11" height="20" viewBox="0 0 11 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.99805 1L0.998047 10L9.99805 19" stroke="var(--site-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </div>
                                <div class="mb-5">
                                    <h5 class="font-h5">{{ __('frontend::message.continue_with_phone') }}</h5>
                                    <span class="font-p">{{ __('frontend::message.receive_code') }}</span>
                                </div>
            
                                <form id="phone-number-form" onsubmit="event.preventDefault(); phoneAuth();">
                                    <div class="row">
                                        <div class="col-lg-12 mb-4">
                                            <div class="form-group">
                                                <label for="number" class="font-p form-label">{{ __('message.phone_number') }}</label><br>
                                                <input type="text" id="number" value="{{ old('phone') }}" class="form-control form-phone-data" placeholder="{{ __('message.phone_number') }}" required autofocus>
                                                <br>
                                                <span class="text-danger mt-2" id="number_error" style="display: none"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="recaptcha-container" class="mb-3"></div>
                                    <div class="d-flex justify-content-center mb-4">
                                        <button type="submit" class="btn login-btn text-white w-100 col-lg-12">{{ __('frontend::message.continue') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="verification-code-section" class="col-lg-6 h-100 otp-section" style="display: none">
                <div class="row justify-content-center mb-4">
                    <div class="col-md-10">
                        <div class="border-0 mb-0 auth-card">
                            <div class="card-body auth-cardbody">
                                <div class="d-flex justify-content-center align-items-center border rounded-circle arrow-container mb-3 position-relative back-btn">
                                    <a href="{{ route('frontend.signin') }}">
                                        <svg width="11" height="20" viewBox="0 0 11 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.99805 1L0.998047 10L9.99805 19" stroke="var(--site-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </div>
                                <div class="mb-5">
                                    <h5 class="font-h5">{{ __('frontend::message.enter_verification_code') }}</h5>
                                </div>
            
                                <form id="verification-code-form" onsubmit="event.preventDefault(); codeverify();">
                                    <div class="row">
                                        <div class="col-lg-12 mb-4">
                                            <div class="form-group">
                                                <input type="text" id="verificationCode" class="form-control form-control-data" placeholder="{{ __('frontend::message.enter_verification_code') }}" required autofocus>
                                                <span class="text-danger mt-2" id="verification_error" style="display: none"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="recaptcha-container"></div>
                                    <div class="d-flex justify-content-center mb-4 mt-3">
                                        <button type="submit" class="btn login-btn text-white w-100 col-lg-12">{{ __('frontend::message.verify_code') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="newUserModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content otp-modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newUserModalLabel">{{ __('frontend::message.fill_details') }}</h5>
                        </div>
                        <div class="modal-body">
                            <form id="newUserForm">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">{{ __('message.first_name') }}</label>
                                    <input type="text" name="first_name" class="form-control form-control-data" id="firstName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">{{ __('message.last_name') }}</label>
                                    <input type="text" name="last_name" class="form-control form-control-data" id="lastName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('message.email') }}</label>
                                    <input type="email" name="email" class="form-control form-control-data" id="email" required>
                                </div>
                                <div class="text-danger" id="modal_error" style="display: none;"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="submitNewUser" class="btn login-btn text-white">{{ __('frontend::message.submit') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@section('bottom_script')  

    <script type="text/javascript">
    
        window.onload=function () {
        render();
        };
    
        function render() {
            window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }
    
        function phoneAuth() {
            
            // var number = $("#number").val();
            var number = iti.getNumber();
            
            $("#number_error").hide();

            firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
                
                window.confirmationResult=confirmationResult;
                coderesult=confirmationResult;

                $("#phone-number-section").hide();
                $("#verification-code-section").show();
    
                Toast.fire({
                    icon: 'success',
                    title: 'Message Sent Successfully.'
                });
                
                
            }).catch(function (error) {
                $("#number_error").text(error.message);
                $("#number_error").show();
            });
    
        }
    
    var confirmationResult;
    
    function codeverify() {
        var code = $("#verificationCode").val();
        var phoneNumber = iti.getNumber();
        $("#verification_error").hide();
        $(".error-message").remove();

        if (!code) {
            $("#verificationCode").after("<div class='error-message' style='color: red;'>This field is required.</div>");
            return;
        }

        coderesult.confirm(code).then(function (result) {
            confirmationResult = result;
            var user = result.user; 
            var uid = user.uid;

            $.ajax({
                url: "{{ route('otp.register') }}",  
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    phone_number: phoneNumber,
                    uid: uid
                },
                success: function(response) {
                    if (response.success) {
                        if (response.is_new_user) {
                            $('#newUserModal').modal('show');
                        } else {
                            window.location.href = response.redirect_url;
                        }
                    } else {

                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        });

                        setTimeout(function() {
                            window.location.href = response.redirect_url;
                        }, 2000);
                        
                    }
                },
                error: function(error) {
                    $("#verification_error").text("{{ __('frontend::message.an_error_occurred_please_try_again') }}");
                    $("#verification_error").show();
                }
            });
        }).catch(function (error) {
            $("#verification_error").text(error.message);
            $("#verification_error").show();
        });
    }

    $(document).on('click', '#submitNewUser', function() {
        var firstName = $('#firstName').val().trim();
        var lastName = $('#lastName').val().trim();
        var email = $('#email').val().trim();

        $("#modal_error").hide();

        var uid = confirmationResult.user.uid; 

        $.ajax({
            url: "{{ route('save.new.user') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                phone_number: iti.getNumber(),
                uid: uid,
                first_name: firstName,
                last_name: lastName,
                email: email,
            },
            success: function(response) {                
                if (response.success) {
                    $('#newUserModal').modal('hide');
                    window.location.href = response.redirect_url;
                } else {
                    $("#modal_error").text(response.message);
                    $("#modal_error").show();
                }
            },
            error: function(error) {
                if (error.status === 422) {
                    $(".error-message").remove();
                    $.each(error.responseJSON.all_message, function (key, messages) {
                        $("[name='" + key + "']").after(
                            "<div class='error-message' style='color: red;'>" + messages[0] + "</div>"
                        );
                    });
                } else {
                    $("#modal_error").text("{{ __('frontend::message.an_error_occurred_please_try_again') }}").show();
                }

            }
        });
    });
    </script>

@endsection

</x-frontend-auth-layout>
