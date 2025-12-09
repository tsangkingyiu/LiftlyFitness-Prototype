<x-frontend-auth-layout>
    <section>
        <div class="">
            <img class="position-absolute top-0 end-0 pattern-img" src="{{ asset('frontend-section/images/pattern.png') }}">
        </div>

        <div class="row m-0 align-items-center vh-100 carousel-section">
            <div class="col-lg-6 d-none d-lg-block">
                @include('frontend::frontend.auth.carousel')
            </div>
            <div class="col-lg-6 h-100 otp-section">
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
                                    <h5 class="font-h5">{{ __('auth.forgot_password') }}</h5>
                                    <span class="font-p">{{ __('frontend::message.password_reset') }}</span>
                                </div>
                                <x-auth-session-status class="mb-4" :status="session('status')" />
                                <form method="POST" action="{{ route('frontend.password.email') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 mb-4">
                                            <div class="form-group">
                                                <label for="email" class="font-p form-label">{{ __('message.email') }}</label>
                                                <input name="email" type="email" value="{{ old('email') }}" id="email" class="form-control form-control-data" aria-describedby="email" placeholder="{{ __('message.email') }}" required autofocus>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mb-4">
                                        <button type="submit" class="btn login-btn text-white w-100 col-lg-12">{{ __('frontend::message.continue') }}</button>
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
