<x-frontend-auth-layout :assets="$assets ?? []">

    <section>
        <div class="row m-0 align-items-center carousel-section">
            <div class="col-lg-6 d-none d-lg-block">
                @include('frontend::frontend.auth.carousel')
            </div>
            <div class="col-lg-6 login-section">
                <div class="row justify-content-center mb-4">
                    <div class="col-md-10">
                        <div class="border-0 mb-0 auth-card">
                            <div class="auth-cardbody">
                                <div class="d-flex align-items-center mb-4 pt-3">
                                    <div class="d-flex justify-content-center align-items-center border rounded-circle arrow-container me-3 position-relative">
                                        <a href="{{ route('frontend.signin') }}">
                                            <svg width="11" height="20" viewBox="0 0 11 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.99805 1L0.998047 10L9.99805 19" stroke="var(--site-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </div>
                                    <h5 class="font-h5 m-0 your-self">{{ __('frontend::message.tell_us_about_yourself') }}</h5>
                                </div>
                                <form  method="POST" action="{{route('user.store')}}" data-toggle="validator" id="user_form">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-lg-6 mb-1">
                                            <div class="form-group">
                                                <label for="name" class="font-p form-label">{{ __('message.first_name') }}</label>
                                                <input type="text" name="first_name" value="{{ old('first_name') }}" id="name" class="form-control form-control-data" placeholder="{{ __('frontend::message.enter_first_name') }}"  autofocus>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-1">
                                            <div class="form-group">
                                                <label for="last_name" class="font-p form-label">{{ __('message.last_name') }}</label>
                                                <input type="text" name="last_name" value="{{ old('last_name') }}" id="last_name" class="form-control form-control-data" placeholder="{{ __('frontend::message.enter_last_name') }}"  autofocus>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-1">
                                            <div class="form-group">
                                                <label for="email" class="font-p form-label">{{ __('message.email') }}<span class="text-danger ms-1">*</span></label>
                                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control form-control-data" placeholder="{{ __('message.email') }}"  autofocus>
                                            </div>
                                        </div>
                                         <div class="col-lg-6 mb-1">
                                            <label for="password" class="font-p form-label">{{ __('message.password') }}<span class="text-danger ms-1">*</span></label>
                                            <div class="password-container">
                                                <input class="form-control form-control-data password password-input" type="password" value="{{ old('password') }}" placeholder="{{ __('message.password') }} " id="password" name="password"  autocomplete="new-password">
                                                <i class="toggle-password togglePassword">
                                                    <svg class="icon-hide" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: block;">
                                                        <path d="M2.68936 6.70456C2.52619 6.32384 2.08528 6.14747 1.70456 6.31064C1.32384 6.47381 1.14747 6.91472 1.31064 7.29544L2.68936 6.70456ZM15.5872 13.3287L15.3125 12.6308L15.3125 12.6308L15.5872 13.3287ZM9.04145 13.7377C9.26736 13.3906 9.16904 12.926 8.82185 12.7001C8.47466 12.4742 8.01008 12.5725 7.78417 12.9197L9.04145 13.7377ZM6.37136 15.091C6.14545 15.4381 6.24377 15.9027 6.59096 16.1286C6.93815 16.3545 7.40273 16.2562 7.62864 15.909L6.37136 15.091ZM22.6894 7.29544C22.8525 6.91472 22.6762 6.47381 22.2954 6.31064C21.9147 6.14747 21.4738 6.32384 21.3106 6.70456L22.6894 7.29544ZM19 11.1288L18.4867 10.582L18.4867 10.582L19 11.1288ZM19.9697 13.1592C20.2626 13.4521 20.7374 13.4521 21.0303 13.1592C21.3232 12.8663 21.3232 12.3914 21.0303 12.0985L19.9697 13.1592ZM11.25 16.5C11.25 16.9142 11.5858 17.25 12 17.25C12.4142 17.25 12.75 16.9142 12.75 16.5H11.25ZM16.3714 15.909C16.5973 16.2562 17.0619 16.3545 17.409 16.1286C17.7562 15.9027 17.8545 15.4381 17.6286 15.091L16.3714 15.909ZM5.53033 11.6592C5.82322 11.3663 5.82322 10.8914 5.53033 10.5985C5.23744 10.3056 4.76256 10.3056 4.46967 10.5985L5.53033 11.6592ZM2.96967 12.0985C2.67678 12.3914 2.67678 12.8663 2.96967 13.1592C3.26256 13.4521 3.73744 13.4521 4.03033 13.1592L2.96967 12.0985ZM12 13.25C8.77611 13.25 6.46133 11.6446 4.9246 9.98966C4.15645 9.16243 3.59325 8.33284 3.22259 7.71014C3.03769 7.3995 2.90187 7.14232 2.8134 6.96537C2.76919 6.87696 2.73689 6.80875 2.71628 6.76411C2.70597 6.7418 2.69859 6.7254 2.69411 6.71533C2.69187 6.7103 2.69036 6.70684 2.68957 6.70503C2.68917 6.70413 2.68896 6.70363 2.68892 6.70355C2.68891 6.70351 2.68893 6.70357 2.68901 6.70374C2.68904 6.70382 2.68913 6.70403 2.68915 6.70407C2.68925 6.7043 2.68936 6.70456 2 7C1.31064 7.29544 1.31077 7.29575 1.31092 7.29609C1.31098 7.29624 1.31114 7.2966 1.31127 7.2969C1.31152 7.29749 1.31183 7.2982 1.31218 7.299C1.31287 7.30062 1.31376 7.30266 1.31483 7.30512C1.31698 7.31003 1.31988 7.31662 1.32353 7.32483C1.33083 7.34125 1.34115 7.36415 1.35453 7.39311C1.38127 7.45102 1.42026 7.5332 1.47176 7.63619C1.57469 7.84206 1.72794 8.13175 1.93366 8.47736C2.34425 9.16716 2.96855 10.0876 3.8254 11.0103C5.53867 12.8554 8.22389 14.75 12 14.75V13.25ZM15.3125 12.6308C14.3421 13.0128 13.2417 13.25 12 13.25V14.75C13.4382 14.75 14.7246 14.4742 15.8619 14.0266L15.3125 12.6308ZM7.78417 12.9197L6.37136 15.091L7.62864 15.909L9.04145 13.7377L7.78417 12.9197ZM22 7C21.3106 6.70456 21.3107 6.70441 21.3108 6.70427C21.3108 6.70423 21.3108 6.7041 21.3109 6.70402C21.3109 6.70388 21.311 6.70376 21.311 6.70368C21.3111 6.70352 21.3111 6.70349 21.3111 6.7036C21.311 6.7038 21.3107 6.70452 21.3101 6.70576C21.309 6.70823 21.307 6.71275 21.3041 6.71924C21.2983 6.73223 21.2889 6.75309 21.2758 6.78125C21.2495 6.83757 21.2086 6.92295 21.1526 7.03267C21.0406 7.25227 20.869 7.56831 20.6354 7.9432C20.1669 8.69516 19.4563 9.67197 18.4867 10.582L19.5133 11.6757C20.6023 10.6535 21.3917 9.56587 21.9085 8.73646C22.1676 8.32068 22.36 7.9668 22.4889 7.71415C22.5533 7.58775 22.602 7.48643 22.6353 7.41507C22.6519 7.37939 22.6647 7.35118 22.6737 7.33104C22.6782 7.32097 22.6818 7.31292 22.6844 7.30696C22.6857 7.30398 22.6867 7.30153 22.6876 7.2996C22.688 7.29864 22.6883 7.29781 22.6886 7.29712C22.6888 7.29677 22.6889 7.29646 22.689 7.29618C22.6891 7.29604 22.6892 7.29585 22.6892 7.29578C22.6893 7.29561 22.6894 7.29544 22 7ZM18.4867 10.582C17.6277 11.3882 16.5739 12.1343 15.3125 12.6308L15.8619 14.0266C17.3355 13.4466 18.5466 12.583 19.5133 11.6757L18.4867 10.582ZM18.4697 11.6592L19.9697 13.1592L21.0303 12.0985L19.5303 10.5985L18.4697 11.6592ZM11.25 14V16.5H12.75V14H11.25ZM14.9586 13.7377L16.3714 15.909L17.6286 15.091L16.2158 12.9197L14.9586 13.7377ZM4.46967 10.5985L2.96967 12.0985L4.03033 13.1592L5.53033 11.6592L4.46967 10.5985Z" fill="#666666"/>
                                                        </svg>
                                       
                                                    <svg class="icon-show" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"  style="display: none;">
                                                        <path d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" stroke="#666666" stroke-width="1.5"/>
                                                        <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="#666666" stroke-width="1.5"/>
                                                    </svg>
                                                </i>
                                            </div>
                                        </div>
                                         <div class="col-lg-6 mb-1">
                                            <div class="form-group">
                                               <label for="confirm-password" class="font-p form-label">{{ __('frontend::message.confirm_password') }}<span class="text-danger ms-1">*</span></label>
                             
                                               <div class="password-container">
                                                    <input class="form-control form-control-data password password-input" type="password" id="confirm-password"  value="{{ old('password_confirmation') }}" placeholder="{{ __('message.password') }}" name="password_confirmation"  >
                                                    <i class="toggle-password togglePassword">
                                                        <svg class="icon-hide" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: block;">
                                                            <path d="M2.68936 6.70456C2.52619 6.32384 2.08528 6.14747 1.70456 6.31064C1.32384 6.47381 1.14747 6.91472 1.31064 7.29544L2.68936 6.70456ZM15.5872 13.3287L15.3125 12.6308L15.3125 12.6308L15.5872 13.3287ZM9.04145 13.7377C9.26736 13.3906 9.16904 12.926 8.82185 12.7001C8.47466 12.4742 8.01008 12.5725 7.78417 12.9197L9.04145 13.7377ZM6.37136 15.091C6.14545 15.4381 6.24377 15.9027 6.59096 16.1286C6.93815 16.3545 7.40273 16.2562 7.62864 15.909L6.37136 15.091ZM22.6894 7.29544C22.8525 6.91472 22.6762 6.47381 22.2954 6.31064C21.9147 6.14747 21.4738 6.32384 21.3106 6.70456L22.6894 7.29544ZM19 11.1288L18.4867 10.582L18.4867 10.582L19 11.1288ZM19.9697 13.1592C20.2626 13.4521 20.7374 13.4521 21.0303 13.1592C21.3232 12.8663 21.3232 12.3914 21.0303 12.0985L19.9697 13.1592ZM11.25 16.5C11.25 16.9142 11.5858 17.25 12 17.25C12.4142 17.25 12.75 16.9142 12.75 16.5H11.25ZM16.3714 15.909C16.5973 16.2562 17.0619 16.3545 17.409 16.1286C17.7562 15.9027 17.8545 15.4381 17.6286 15.091L16.3714 15.909ZM5.53033 11.6592C5.82322 11.3663 5.82322 10.8914 5.53033 10.5985C5.23744 10.3056 4.76256 10.3056 4.46967 10.5985L5.53033 11.6592ZM2.96967 12.0985C2.67678 12.3914 2.67678 12.8663 2.96967 13.1592C3.26256 13.4521 3.73744 13.4521 4.03033 13.1592L2.96967 12.0985ZM12 13.25C8.77611 13.25 6.46133 11.6446 4.9246 9.98966C4.15645 9.16243 3.59325 8.33284 3.22259 7.71014C3.03769 7.3995 2.90187 7.14232 2.8134 6.96537C2.76919 6.87696 2.73689 6.80875 2.71628 6.76411C2.70597 6.7418 2.69859 6.7254 2.69411 6.71533C2.69187 6.7103 2.69036 6.70684 2.68957 6.70503C2.68917 6.70413 2.68896 6.70363 2.68892 6.70355C2.68891 6.70351 2.68893 6.70357 2.68901 6.70374C2.68904 6.70382 2.68913 6.70403 2.68915 6.70407C2.68925 6.7043 2.68936 6.70456 2 7C1.31064 7.29544 1.31077 7.29575 1.31092 7.29609C1.31098 7.29624 1.31114 7.2966 1.31127 7.2969C1.31152 7.29749 1.31183 7.2982 1.31218 7.299C1.31287 7.30062 1.31376 7.30266 1.31483 7.30512C1.31698 7.31003 1.31988 7.31662 1.32353 7.32483C1.33083 7.34125 1.34115 7.36415 1.35453 7.39311C1.38127 7.45102 1.42026 7.5332 1.47176 7.63619C1.57469 7.84206 1.72794 8.13175 1.93366 8.47736C2.34425 9.16716 2.96855 10.0876 3.8254 11.0103C5.53867 12.8554 8.22389 14.75 12 14.75V13.25ZM15.3125 12.6308C14.3421 13.0128 13.2417 13.25 12 13.25V14.75C13.4382 14.75 14.7246 14.4742 15.8619 14.0266L15.3125 12.6308ZM7.78417 12.9197L6.37136 15.091L7.62864 15.909L9.04145 13.7377L7.78417 12.9197ZM22 7C21.3106 6.70456 21.3107 6.70441 21.3108 6.70427C21.3108 6.70423 21.3108 6.7041 21.3109 6.70402C21.3109 6.70388 21.311 6.70376 21.311 6.70368C21.3111 6.70352 21.3111 6.70349 21.3111 6.7036C21.311 6.7038 21.3107 6.70452 21.3101 6.70576C21.309 6.70823 21.307 6.71275 21.3041 6.71924C21.2983 6.73223 21.2889 6.75309 21.2758 6.78125C21.2495 6.83757 21.2086 6.92295 21.1526 7.03267C21.0406 7.25227 20.869 7.56831 20.6354 7.9432C20.1669 8.69516 19.4563 9.67197 18.4867 10.582L19.5133 11.6757C20.6023 10.6535 21.3917 9.56587 21.9085 8.73646C22.1676 8.32068 22.36 7.9668 22.4889 7.71415C22.5533 7.58775 22.602 7.48643 22.6353 7.41507C22.6519 7.37939 22.6647 7.35118 22.6737 7.33104C22.6782 7.32097 22.6818 7.31292 22.6844 7.30696C22.6857 7.30398 22.6867 7.30153 22.6876 7.2996C22.688 7.29864 22.6883 7.29781 22.6886 7.29712C22.6888 7.29677 22.6889 7.29646 22.689 7.29618C22.6891 7.29604 22.6892 7.29585 22.6892 7.29578C22.6893 7.29561 22.6894 7.29544 22 7ZM18.4867 10.582C17.6277 11.3882 16.5739 12.1343 15.3125 12.6308L15.8619 14.0266C17.3355 13.4466 18.5466 12.583 19.5133 11.6757L18.4867 10.582ZM18.4697 11.6592L19.9697 13.1592L21.0303 12.0985L19.5303 10.5985L18.4697 11.6592ZM11.25 14V16.5H12.75V14H11.25ZM14.9586 13.7377L16.3714 15.909L17.6286 15.091L16.2158 12.9197L14.9586 13.7377ZM4.46967 10.5985L2.96967 12.0985L4.03033 13.1592L5.53033 11.6592L4.46967 10.5985Z" fill="#666666"/>
                                                            </svg>
                                           
                                                        <svg class="icon-show" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"  style="display: none;">
                                                            <path d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" stroke="#666666" stroke-width="1.5"/>
                                                            <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="#666666" stroke-width="1.5"/>
                                                        </svg>
                                                    </i>
                                                </div>
                                            </div>
                                         </div>
                                         <div class="col-lg-12 mb-1">
                                            <div class="form-group">
                                               <label for="phone" class="font-p form-label">{{ __('message.phone_number') }}</label><br>
                                               <input class="form-control form-control-data" type="text" value="{{ old('phone_number') }}" id="number" name="phone_number" placeholder="{{ __('frontend::message.enter_phone_number') }}">
                                            </div>
                                         </div>
                                        <div class="col-lg-6 mb-1">
                                            <div class="form-group">
                                                <label for="age" class="font-p form-label">{{ __('frontend::message.how_old_you_are') }}<span class="text-danger ms-1">*</span></label>
                                                <input type="number" name="age" value="{{ old('age') }}" id="age" class="form-control form-control-data" placeholder="28" min="0" step="1" autofocus>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-1">
                                            <div class="form-group">
                                                <label class="form-label font-p">{{ __('frontend::message.whats_your_gender') }}</label>
                                                <select class="form-select form-control-data" name="gender">
                                                    <option value="male" {{ (old('gender') == 'male' ? 'selected' : '') }}>{{ __('message.male') }}</option>
                                                    <option value="female" {{ (old('gender') == 'female' ? 'selected' : '') }}>{{ __('message.female') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-1">
                                            <div class="form-group">
                                                <label for="weight-input" class="font-p form-label">{{ __('message.weight') }}<span class="text-danger ms-1">*</span></label>
                                            </div>
                                            <div class="input-group position-relative">
                                                <input type="number" class="form-control form-input-data weight-unit" id="weight-input" placeholder="28" name="weight" value="{{ old('weight') }}" min="0" step="any"> 
                                                <div class="input-group-append">
                                                    <div class="btn-group p-2" role="group" aria-label="Weight units">
                                                        <input type="radio" class="btn-check" id="lbs" name="weight_unit" value="lbs" {{ old('weight_unit') == 'lbs' ? 'checked' : '' }}>
                                                        <label class="btn btn-outline-secondary d-flex align-items-center border-0 btn-unit" for="lbs">LBS</label>
                                                        <input type="radio" class="btn-check" id="kg" name="weight_unit" value="kg" {{ old('weight_unit', 'kg') == 'kg' ? 'checked' : '' }}>
                                                        <label class="btn btn-outline-secondary d-flex align-items-center border-0 btn-unit" for="kg">KG</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="form-group">
                                                <label for="height-input" class="font-p form-label">{{ __('message.height') }}<span class="text-danger ms-1">*</span></label>
                                            </div>
                                            <div class="input-group position-relative">
                                                <input type="number" class="form-control form-input-data height-unit" id="height-input" placeholder="168.0" name="height" value="{{ old('height') }}" min="0" step="any">
                                                <div class="input-group-append">
                                                    <div class="btn-group p-2" role="group" aria-label="Height units">
                                                        <input type="radio" class="btn-check" id="feet" name="height_unit" value="feet" {{ old('height_unit') == 'feet' ? 'checked' : '' }}>
                                                        <label class="btn btn-outline-secondary d-flex align-items-center border-0 btn-unit" for="feet">FEET</label>
                                                        <input type="radio" class="btn-check" id="cm" name="height_unit" value="cm" {{ old('height_unit', 'cm') == 'cm' ? 'checked' : '' }}>
                                                        <label class="btn btn-outline-secondary d-flex align-items-center border-0 btn-unit" for="cm">CM</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-center mb-4">
                                        <button type="submit" id='submit-btn' class="btn login-btn text-white w-100 col-lg-12">
                                            <span id="button-loader" style="display:none;">
                                                <div class="spinner-border spinner-border-sm text-light" role="status"></div>
                                            </span>
                                            {{ __('frontend::message.submit') }}
                                        </button>
                                    </div>
                                    <p class="new-user text-center">{{ __('frontend::message.already_have_an_account') }} <a href="{{ route('frontend.signin') }}" class="text-decoration-none"><span class="register-now">{{ __('auth.login') }}</span></a></p>
                                </form>
                            </div>
                        </div>
                        <img class="pattern-img position-absolute top-0 end-0" src="{{ asset('frontend-section/images/pattern.png') }}" alt="Pattern Image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @section('bottom_script')
        <script>
            $(document).ready(function() {
                $('#submit-btn').on('click', function(e) {
                    e.preventDefault();
                    $('#button-loader').show();
                    $('#submit-btn').prop('disabled', true);
    
                    setTimeout(function() {
                        $('#user_form').submit();
                    }, 1000);
                });
            });
        </script>
    @endsection

</x-frontend-auth-layout>


    
