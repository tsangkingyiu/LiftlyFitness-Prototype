@php

    $dummy_title = Dummydata('dummy_title');
    $dummy_desc = Dummydata('dummy_description');
    $pages = Modules\Frontend\Models\Pages::where('status', '1')->get();
    $playstoreUrl = SettingData('download-app', 'playstore_url') ?? 'javascript:void(0)';
    $appstoreUrl = SettingData('download-app', 'appstore_url') ?? 'javascript:void(0)';
@endphp

<footer class="text-lg-start text-white footer mt-auto">
    <div class="container p-4 pb-0 footer-content">
        <section class="">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="d-flex align-items-baseline">
                        <a href="" class="mb-4">
                            <img src="{{ getSingleMediaSettingImage(getSettingFirstData('app-info', 'logo_image'), 'logo_image') }}" width="40" height="40" class="me-2"></a>
                        <h4 class="mb-4 site-name">{{ SettingData('app-info', 'app_name') }}</h4>
                    </div>
                    <p class="mb-4 site-text">{{ $app_settings->site_description ?? $dummy_desc }}</p>
                    <div class="mb-3">
                        <a href="{{ $app_settings->contact_email ? 'mailto:' . $app_settings->contact_email : 'javascript:void(0)' }}" {{ $app_settings->contact_email ? 'target="_blank"' : '' }} class="text-white text-decoration-none site-text"> 
                            <img src="{{ asset('frontend-section/images/mail.png') }}" width="24" height="24" class="me-2">
                            {{ $app_settings->contact_email ?? $dummy_title }}
                        </a>
                    </div>
                    <div class="mb-3">
                        <a href="{{ $app_settings->contact_number ? 'tel:' . $app_settings->contact_number : 'javascript:void(0)' }}" {{ $app_settings->contact_number ? 'target="_blank"' : '' }} class="text-decoration-none site-text text-white">
                            <img src="{{ asset('frontend-section/images/phone.png') }}" width="24" height="24" class="me-2">
                            {{ $app_settings->contact_number ?? $dummy_title }}
                        </a>
                    </div>
                </div>

                <hr class="w-100 clearfix d-md-none" />

                <div class="col-lg-2 col-md-6 col-sm-6 mt-4 mt-lg-0 mt-md-0">
                    <h4 class="mb-4 subtitle">{{ __('frontend::message.programs') }}</h4>
                    <p><a href="{{ route('workouts') }}" class="text-white site-text">{{ __('frontend::message.workouts') }}</a></p>
                    <p><a href="{{ route('diet') }}" class="text-white site-text">{{ __('frontend::message.diet_plans') }}</a></p>
                    <p><a href="{{ route('products') }}" class="text-white site-text">{{ __('frontend::message.products') }}</a></p>
                    <p><a href="{{ route('blog') }}" class="text-white site-text">{{ __('frontend::message.fitness_blogs') }}</a></p>
                    @if(SettingData('subscription', 'subscription_system') == 1 && (!Auth::check() || !Auth::user()->is_subscribe))
                        <p><a href="{{ route('pricing-plan') }}" class="text-white site-text">{{ __('frontend::message.pricing_plan') }}</a></p>
                    @endif
                </div>

                <hr class="w-100 clearfix d-md-none" />
                
                <div class="col-lg-2 col-md-6 col-sm-6 mt-lg-0 mt-4">
                    <h4 class="mb-4 subtitle">{{ __('message.pages') }}</h4>
                    <p class="mb-3 footer-p">
                        <a href="{{ route('privacy.policy') }}"
                            class="text-white text-decoration-none">{{ __('message.privacy_policy') }}</a>
                    </p>
                    <p class="mb-3 footer-p">
                      <a href="{{ route('terms.condition') }}"
                          class="text-white text-decoration-none">{{ __('message.terms_condition') }}</a>
                    </p>
                        @if (count($pages) > 0)
                            <ul class="list-unstyled">
                                @foreach ($pages as $page)
                                    <li class="mb-3">
                                        <a href="{{ isset($page->slug) && $page->slug != null  ? route('pages', ['slug' => $page->slug]) : 'javascript:void(0)' }}" class="site-text text-white text-decoration-none">
                                            {{ ucwords($page->title) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                </div>

                <hr class="w-100 clearfix d-md-none" />

                <div class="col-lg-4 col-md-6 col-sm-6 mt-lg-0 mt-4">
                    <h4 class="mb-4 subtitle">{{ __('frontend::message.experience_mighty_fitness_app_on_mobile') }}</h4>
                    <div class="d-flex">
                        <a class="me-2 mb-3" href="{{ $playstoreUrl }}"
                            {{ $playstoreUrl != 'javascript:void(0)' ? 'target="_blank"' : '' }}>
                            <img src="{{ asset('frontend-section/images/play-store.png') }}" width="153" class="img-fluid">
                        </a>
                        <a class="mb-3" href="{{ $appstoreUrl }}"
                            {{ $appstoreUrl != 'javascript:void(0)' ? 'target="_blank"' : '' }}>
                            <img src="{{ asset('frontend-section/images/app-store.png') }}" width="153" class="img-fluid">
                        </a>
                    </div>
                    <div class="d-flex qr">
                        <a class="me-3" href="{{ $appstoreUrl }}"
                            {{ $appstoreUrl != null ? 'target="_blank"' : '' }}>
                            <img src="{{ getSingleMediaSettingImage(getSettingFirstData('download-app', 'appstore_image'), 'appstore_image') }}" class="img-fluid">
                        </a>
                        <p class="d-flex align-items-center">{{ __('frontend::message.scan_qr_code_download_our_app') }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <hr class="my-3 w-100">

    <div class="container mx-auto pb-3">
        <div class="d-flex gap-md-0 gap-3 flex-wrap justify-content-md-between justify-content-center align-items-center">
            <p class="m-0 copyright text-sm-start text-center">{{ $app_settings->site_copyright ?? $dummy_title }}</p>
            <div class="d-flex gap-3 align-items-center">
                <a class="me-2 text-decoration-none" href="{{ $app_settings->instagram_url ?? 'javascript:void(0)' }}"
                    {{ $app_settings->instagram_url != null ? 'target="_blank"' : '' }}>
                    <img src="{{ asset('frontend-section/images/instagram.png') }}" width="25" height="25" alt="Instagram">
                </a>
                <a class="me-2 text-decoration-none" href="{{ $app_settings->facebook_url ?? 'javascript:void(0)' }}"
                    {{ $app_settings->facebook_url != null ? 'target="_blank"' : '' }}>
                    <img src="{{ asset('frontend-section/images/facebook.png') }}" width="25" height="25" alt="Facebook">
                </a>
                <a class="me-2 text-decoration-none" href="{{ $app_settings->twitter_url ?? 'javascript:void(0)' }}"
                    {{ $app_settings->twitter_url != null ? 'target="_blank"' : '' }}>
                    <img src="{{ asset('frontend-section/images/twitter.png') }}" width="25" height="25" alt="Twitter">
                </a>
                <a class="me-2 text-decoration-none" href="{{ $app_settings->linkedin_url ?? 'javascript:void(0)' }}"
                    {{ $app_settings->linkedin_url != null ? 'target="_blank"' : '' }}>
                    <img src="{{ asset('frontend-section/images/youtube.png') }}" width="25" height="25" alt="Linkedin">
                </a>
            </div>
        </div>
    </div>
</footer>
