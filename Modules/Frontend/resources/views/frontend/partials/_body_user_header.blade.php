<div class="progress-bar-container">
    <div class="progress">
        <div class="progress-bar" role="progressbar" id="scrollProgressBar"></div>
    </div>
</div>

<button class="btn back-to-top rounded-circle">
    <span>
        <svg width="18" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 20L12 4M12 4L18 10M12 4L6 10" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </span>
</button>

<nav class="navbar navbar-expand-lg navbar-light px-0 py-3 header user-header">
    <div class="container-xl ps-0 pe-0">
        <a class="navbar-brand ps-1" href="{{ route('browse') }}">
            <img src="{{ getSingleMediaSettingImage(getSettingFirstData('app-info','logo_image'),'logo_image') }}" alt="Logo" width="45" height="45" alt="Logo">
            <span class="nav-site-name">{{ SettingData('app-info', 'app_name') }}</span>
        </a>

        <span class="d-flex">
            <div class="nav-item theme-scheme-dropdown dropdown iq-dropdown mt-2 me-2 d-lg-none d-block">
                <div class="btn sit_color_theam sit_darkcolor_theam pe-0" data-bs-toggle="tooltip" title="{{ __('message.sit_dark_color_theam') }}" data-setting="color-mode" data-name="color" data-value="dark">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.80273C12.4142 1.80273 12.75 2.13852 12.75 2.55273V3.55273C12.75 3.96695 12.4142 4.30273 12 4.30273C11.5858 4.30273 11.25 3.96695 11.25 3.55273V2.55273C11.25 2.13852 11.5858 1.80273 12 1.80273ZM4.39861 4.95134C4.6915 4.65845 5.16638 4.65845 5.45927 4.95134L5.85211 5.34418C6.145 5.63707 6.145 6.11195 5.85211 6.40484C5.55921 6.69773 5.08434 6.69773 4.79145 6.40484L4.39861 6.012C4.10572 5.71911 4.10572 5.24424 4.39861 4.95134ZM19.6011 4.9516C19.894 5.2445 19.894 5.71937 19.6011 6.01226L19.2083 6.4051C18.9154 6.69799 18.4405 6.69799 18.1476 6.4051C17.8547 6.11221 17.8547 5.63733 18.1476 5.34444L18.5405 4.9516C18.8334 4.65871 19.3082 4.65871 19.6011 4.9516ZM12 7.30273C9.1005 7.30273 6.75 9.65324 6.75 12.5527C6.75 15.4522 9.1005 17.8027 12 17.8027C14.8995 17.8027 17.25 15.4522 17.25 12.5527C17.25 9.65324 14.8995 7.30273 12 7.30273ZM5.25 12.5527C5.25 8.82481 8.27208 5.80273 12 5.80273C15.7279 5.80273 18.75 8.82481 18.75 12.5527C18.75 16.2807 15.7279 19.3027 12 19.3027C8.27208 19.3027 5.25 16.2807 5.25 12.5527ZM1.25 12.5527C1.25 12.1385 1.58579 11.8027 2 11.8027H3C3.41421 11.8027 3.75 12.1385 3.75 12.5527C3.75 12.9669 3.41421 13.3027 3 13.3027H2C1.58579 13.3027 1.25 12.9669 1.25 12.5527ZM20.25 12.5527C20.25 12.1385 20.5858 11.8027 21 11.8027H22C22.4142 11.8027 22.75 12.1385 22.75 12.5527C22.75 12.9669 22.4142 13.3027 22 13.3027H21C20.5858 13.3027 20.25 12.9669 20.25 12.5527ZM18.1476 18.7004C18.4405 18.4075 18.9154 18.4075 19.2083 18.7004L19.6011 19.0932C19.894 19.3861 19.894 19.861 19.6011 20.1539C19.3082 20.4468 18.8334 20.4468 18.5405 20.1539L18.1476 19.761C17.8547 19.4681 17.8547 18.9933 18.1476 18.7004ZM5.85211 18.7006C6.145 18.9935 6.145 19.4684 5.85211 19.7613L5.45927 20.1541C5.16638 20.447 4.6915 20.447 4.39861 20.1541C4.10572 19.8612 4.10572 19.3864 4.39861 19.0935L4.79145 18.7006C5.08434 18.4077 5.55921 18.4077 5.85211 18.7006ZM12 20.8027C12.4142 20.8027 12.75 21.1385 12.75 21.5527V22.5527C12.75 22.9669 12.4142 23.3027 12 23.3027C11.5858 23.3027 11.25 22.9669 11.25 22.5527V21.5527C11.25 21.1385 11.5858 20.8027 12 20.8027Z" fill="#2F2F2F"/>
                    </svg>    
                </div>
                <div class="btn active sit_color_theam sit_lightcolor_theam pe-0" data-bs-toggle="tooltip" title="{{ __('message.sit_light_color_theam') }}" data-setting="color-mode" data-name="color" data-value="light" style="display:none;">
                    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#fff" d="M9,2C7.95,2 6.95,2.16 6,2.46C10.06,3.73 13,7.5 13,12C13,16.5 10.06,20.27 6,21.54C6.95,21.84 7.95,22 9,22A10,10 0 0,0 19,12A10,10 0 0,0 9,2Z" />
                    </svg>
                </div>   
            </div>
            <button class="navbar-toggler m-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </span>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-lg-auto navbar-font"></div>
            <div class="nav-item theme-scheme-dropdown dropdown iq-dropdown d-lg-block d-none">
                <div class="btn sit_color_theam sit_darkcolor_theam pe-0" data-bs-toggle="tooltip" title="{{ __('message.sit_dark_color_theam') }}" data-setting="color-mode" data-name="color" data-value="dark">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.80273C12.4142 1.80273 12.75 2.13852 12.75 2.55273V3.55273C12.75 3.96695 12.4142 4.30273 12 4.30273C11.5858 4.30273 11.25 3.96695 11.25 3.55273V2.55273C11.25 2.13852 11.5858 1.80273 12 1.80273ZM4.39861 4.95134C4.6915 4.65845 5.16638 4.65845 5.45927 4.95134L5.85211 5.34418C6.145 5.63707 6.145 6.11195 5.85211 6.40484C5.55921 6.69773 5.08434 6.69773 4.79145 6.40484L4.39861 6.012C4.10572 5.71911 4.10572 5.24424 4.39861 4.95134ZM19.6011 4.9516C19.894 5.2445 19.894 5.71937 19.6011 6.01226L19.2083 6.4051C18.9154 6.69799 18.4405 6.69799 18.1476 6.4051C17.8547 6.11221 17.8547 5.63733 18.1476 5.34444L18.5405 4.9516C18.8334 4.65871 19.3082 4.65871 19.6011 4.9516ZM12 7.30273C9.1005 7.30273 6.75 9.65324 6.75 12.5527C6.75 15.4522 9.1005 17.8027 12 17.8027C14.8995 17.8027 17.25 15.4522 17.25 12.5527C17.25 9.65324 14.8995 7.30273 12 7.30273ZM5.25 12.5527C5.25 8.82481 8.27208 5.80273 12 5.80273C15.7279 5.80273 18.75 8.82481 18.75 12.5527C18.75 16.2807 15.7279 19.3027 12 19.3027C8.27208 19.3027 5.25 16.2807 5.25 12.5527ZM1.25 12.5527C1.25 12.1385 1.58579 11.8027 2 11.8027H3C3.41421 11.8027 3.75 12.1385 3.75 12.5527C3.75 12.9669 3.41421 13.3027 3 13.3027H2C1.58579 13.3027 1.25 12.9669 1.25 12.5527ZM20.25 12.5527C20.25 12.1385 20.5858 11.8027 21 11.8027H22C22.4142 11.8027 22.75 12.1385 22.75 12.5527C22.75 12.9669 22.4142 13.3027 22 13.3027H21C20.5858 13.3027 20.25 12.9669 20.25 12.5527ZM18.1476 18.7004C18.4405 18.4075 18.9154 18.4075 19.2083 18.7004L19.6011 19.0932C19.894 19.3861 19.894 19.861 19.6011 20.1539C19.3082 20.4468 18.8334 20.4468 18.5405 20.1539L18.1476 19.761C17.8547 19.4681 17.8547 18.9933 18.1476 18.7004ZM5.85211 18.7006C6.145 18.9935 6.145 19.4684 5.85211 19.7613L5.45927 20.1541C5.16638 20.447 4.6915 20.447 4.39861 20.1541C4.10572 19.8612 4.10572 19.3864 4.39861 19.0935L4.79145 18.7006C5.08434 18.4077 5.55921 18.4077 5.85211 18.7006ZM12 20.8027C12.4142 20.8027 12.75 21.1385 12.75 21.5527V22.5527C12.75 22.9669 12.4142 23.3027 12 23.3027C11.5858 23.3027 11.25 22.9669 11.25 22.5527V21.5527C11.25 21.1385 11.5858 20.8027 12 20.8027Z" fill="#2F2F2F"/>
                    </svg>    
                </div>
                <div class="btn active sit_color_theam sit_lightcolor_theam pe-0" data-bs-toggle="tooltip" title="{{ __('message.sit_light_color_theam') }}" data-setting="color-mode" data-name="color" data-value="light" style="display:none;">
                  <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill="#fff" d="M9,2C7.95,2 6.95,2.16 6,2.46C10.06,3.73 13,7.5 13,12C13,16.5 10.06,20.27 6,21.54C6.95,21.84 7.95,22 9,22A10,10 0 0,0 19,12A10,10 0 0,0 9,2Z" />
                  </svg>
                </div>   
            </div>

            <div class="nav-item dropdown d-lg-block d-none">
                <a href="#" class="nav-link dropdown-toggle" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @php
                        $selected_lang_flag = file_exists(public_path('/images/flag/' .app()->getLocale() . '.png')) ? asset('/images/flag/' . app()->getLocale() . '.png') : asset('/images/lang_flag.png');
                    @endphp
                    <img src="{{ $selected_lang_flag }}" class="img-fluid rounded selected-lang" alt="lang-flag" height="35" width="35">
                  </a>

                  <div class="sub-drop dropdown-menu dropdown-menu-end p-0 language-menu  border-0" aria-labelledby="dropdownMenuButton2">
                    <div class="card shadow-none m-0 border-0">
                        <div class="p-0">
                            <ul class="list-group list-group-flush">
                                @php
                                    $language_option = appSettingData('get')->language_option;
                                    if(!empty($language_option)){
                                        $language_array = languagesArray($language_option);
                                    }
                                @endphp
                                @if(count($language_array) > 0)
                                    @foreach($language_array as $lang)
                                        <li class="iq-sub-card list-group-item">
                                            <a class="dropdown-item p-0" data-lang="{{ $lang['id'] }}" href="{{ route('change.language', ['locale' => $lang['id']]) }}">
                                                @php
                                                    $flag_path = file_exists(public_path('/images/flag/' . $lang['id'] . '.png')) ? asset('/images/flag/' . $lang['id'] . '.png') : asset('/images/lang_flag.png');
                                                @endphp
                                                <img src="{{ $flag_path }}" alt="img-flag-{{ $lang['id'] }}" class="img-fluid me-2 selected-lang-list" height="30" width="30" />
                                                {{ $lang['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 mt-lg-0 navbar-font">
                <img src="{{ getSingleMedia(auth()->user(),'profile_image', null) }}" height="40" width="40" class="profile_image">
                <span class="ms-1 display">{{ Auth()->user()->display_name }}</span>
                <div class="head-sidebar">
                    <a class="nav-item nav-link d-lg-none d-block mt-2" href="{{ route('language.setting') }}">{{ __('message.language_settings') }}</a>
                    @include('frontend::frontend.partials._body_sidebar')
                </div>
            </div>
        </div>
    </div>
</nav>
