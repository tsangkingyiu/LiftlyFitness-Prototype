<x-frontend-auth-layout>

    <section>
        <div class="">
            <img class="position-absolute top-0 end-0 pattern-img" src="{{ asset('frontend-section/images/pattern.png') }}">
        </div>

        <div class="row m-0 align-items-center vh-100 carousel-section">
            <div class="col-lg-6 d-none d-lg-block">
                @include('frontend-website.auth.carousel')
            </div>
            <div class="col-lg-6 h-100 otp-section">
                <div class="row justify-content-center mb-4">
                    <div class="col-md-10">
                        <div class="border-0 mb-0 auth-card">
                            <div class="card-body">
                                <div class="mb-5">
                                    <h5 class="font-h5">{{ __('auth.forgot_password') }}</h5>
                                    <span class="font-p">{{ __('message.please_enter_your_email_to_request_password_reset') }}</span>
                                </div>
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <!-- Password Reset Token -->
                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                    <div class="row">
                                        <div class="col-lg-12 mb-1">
                                            <div class="form-group">
                                                {{ html()->label(__('message.email').' <span class="text-danger">*</span>')->class('font-p form-label') }}
                                                {{ html()->email('email', old('email') ?? $request->email)->placeholder(__('message.email'))->class('form-control form-control-data')->required()->autofocus() }}
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-1">
                                            <div class="form-group">
                                                {{ html()->label(__('message.password').' <span class="text-danger">*</span>')->class('font-p form-label') }}
                                                {{ html()->password('password')->placeholder(__('message.password'))->class('form-control form-control-data')->required() }}
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-4">
                                            <div class="form-group">
                                                {{ html()->label(__('auth.password_confirmation').' <span class="text-danger">*</span>')->class('font-p form-label') }}
                                                {{ html()->password('password_confirmation')->placeholder(__('auth.password_confirmation'))->class('form-control form-control-data')->required() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mb-4">
                                        <button type="submit" class="btn login-btn text-white w-100 col-lg-12">{{ __('auth.reset_password') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-frontend-auth-layout>
