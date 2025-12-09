<x-frontend-layout :assets="$assets ?? []">

    {{-- START MAIN SECTION --}}
    <section class="main-banner d-flex align-items-center">
        <div class="container overflow-hidden">
            <div class="row">
                <div class="col-md-6 main">
                    <h1 class="mb-3" data-aos="fade-down" data-aos-duration="3000">{{ $data['app-info']['title'] }}<span class="ms-1">{{ $data['app-info']['app_name'] }}</span>
                    </h1>
                    <p class="main-p" data-aos="fade-right" data-aos-duration="3000">{{ $data['app-info']['description'] }}</p>
                    <div class="col-lg-7 d-flex" data-aos="fade-down-left" data-aos-duration="3000">
                        <p class="d-flex justify-content-center align-items-center">
                            {{ __('frontend::message.scan_qr_code_download_our_app') }}</p>
                        <a href="{{ $data['download-app']['appstore_url']['url'] }}" {{ $data['download-app']['appstore_url']['target'] }} class="text-decoration-none ">
                            <img src="{{ $data['download-app']['appstore_image'] }}" class="me-2 img-fluid mb-2 our-app-icon" alt="App QR">
                        </a>
                        <a href="{{ $data['download-app']['playstore_url']['url'] }}" {{ $data['download-app']['playstore_url']['target'] }} class="text-decoration-none">
                            <img src="{{ $data['download-app']['playstore_image'] }}" class="ms-2 img-fluid mb-2 our-app-icon" alt="Play QR">
                        </a>
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-center align-items-center" data-aos="fade-down-right" data-aos-duration="3000">
                    <img src="{{ $data['app-info']['image'] }}" class="img-fluid" alt="Hero Image">
                </div>
            </div>
        </div>
    </section>

    {{-- END MAIN SECTION --}}

    {{-- START ULTIMATE WORKOUT SECTION --}}

    <section class="workout">
        <div class="container overflow-hidden">
            <div class="row gap-3 gap-lg-0">
                <div class="d-flex justify-content-center ultimate-title" data-aos="fade-down" data-aos-duration="3000">
                    <h3 class="font-h3 text-center">{{ $data['ultimate-workout']['title'] }}
                        <span class="font-span">{{ $data['ultimate-workout']['subtitle'] }}</span>
                    </h3>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="3000">
                    @foreach ($ultimate_workout->isNotEmpty() ? $ultimate_workout : [(object) ['id'=>'']] as $key => $item)
                        <img id="blockquote-image-{{ $key }}"
                            src="{{ getSingleMediaSettingImage($item->id != null ? $item : null,'ultimate-workout') }}"
                            class="img-fluid blockquote-image {{ $loop->first ? '' : 'd-none' }}" alt="Workout Image">
                    @endforeach
                </div>
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="3000">
                    @foreach ($ultimate_workout->isNotEmpty() ? $ultimate_workout : [(object) ['title' => $data['dummy_title'], 'description' => $data['dummy_description']]] as $index => $workout)
                        <div class="blockquote-card {{ $loop->first ? 'selected' : '' }}"
                            data-index="{{ $index }}">
                            <div class="blockquote-card-outer">
                                <div class="blockquote-card-inner">
                                    <h6 class="font-h6">{{ $workout->title }}</h6>
                                    <p class="font-p">{{ $workout->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('workouts') }}" class="btn fit-btn text-white mt-3">
                            <span>{{ __('frontend::message.explore_exercise') }}</span>
                            <span>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.7405 5.44365C20.7405 4.78964 20.2104 4.25946 19.5563 4.25946H8.89866C8.24465 4.25946 7.71447 4.78964 7.71447 5.44365C7.71447 6.09766 8.24465 6.62784 8.89866 6.62784L18.3722 6.62784V16.1013C18.3722 16.7553 18.9023 17.2855 19.5563 17.2855C20.2104 17.2855 20.7405 16.7553 20.7405 16.1013V5.44365ZM4.83735 21.8373L20.3937 6.281L18.719 4.6063L3.16265 20.1627L4.83735 21.8373Z" fill="white"/>
                                </svg>     
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- END ULTIMATE WORKOUT SECTION --}}

    {{-- START NUTRITION SECTION --}}

    <section class="nutrition">
        <div class="container overflow-hidden">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-right" data-aos-duration="3000">
                    <h3 class="font-h3" data-aos="zoom-out-down" data-aos-duration="3000">{{ $data['nutrition']['title'] }} <br><span
                            class="font-span">{{ $data['nutrition']['subtitle'] }}</span></h3>
                    <p class="w-75">{{ $data['nutrition']['description'] }}</p>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('diet') }}" class="btn fit-btn text-white mt-3 mb-2">{{ __('frontend::message.explore_diet_plans') }}
                            <span>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.7405 5.44365C20.7405 4.78964 20.2104 4.25946 19.5563 4.25946H8.89866C8.24465 4.25946 7.71447 4.78964 7.71447 5.44365C7.71447 6.09766 8.24465 6.62784 8.89866 6.62784L18.3722 6.62784V16.1013C18.3722 16.7553 18.9023 17.2855 19.5563 17.2855C20.2104 17.2855 20.7405 16.7553 20.7405 16.1013V5.44365ZM4.83735 21.8373L20.3937 6.281L18.719 4.6063L3.16265 20.1627L4.83735 21.8373Z" fill="white"/>
                                </svg>     
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="3000">
                    <img src="{{ $data['nutrition']['image'] }}" class="img-fluid" alt="Nutrition Image">
                </div>
            </div>
        </div>
    </section>

    {{-- END NUTRITION SECTION --}}


    {{-- START FITNESS PRODUCT SECTION --}}

    <section class="fitness-product">
        <div class="container overflow-hidden">
            <div class="row gap-3 gap-lg-0">
                <div class="d-flex justify-content-center fitness-title" data-aos="fade-down" data-aos-duration="3000">
                    <h3 class="font-h3 text-center">{{ $data['fitness-product']['title'] }} <br>
                        <span class="font-span">{{ $data['fitness-product']['subtitle'] }}</span>
                    </h3>
                </div>
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="3000">
                    @foreach ($fitness_product->isNotEmpty() ? $fitness_product : [(object) ['id'=>'']] as $key => $item)
                        <img id="fitness-product-image-{{ $key }}"
                            src="{{ getSingleMediaSettingImage($item->id != null ? $item : null, 'fitness-product') }}"
                            class="img-fluid fitness-product-image {{ $loop->first ? '' : 'd-none' }}" alt="Fitness image">
                    @endforeach
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="3000">
                    @foreach ($fitness_product->isNotEmpty() ? $fitness_product : [(object) ['title' => $data['dummy_title'], 'description' => $data['dummy_description']]] as $index => $fitness)
                        <div class="fitness-product-card" {{ $loop->first ? 'selected' : '' }} data-index="{{ $index }}">
                            <div class="fitness-product-card-outer">
                                <div class="fitness-product-card-inner">
                                    <h6 class="font-h6">{{ $fitness->title }}</h6>
                                    <p class="font-p">{{ $fitness->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('products') }}" class="btn fit-btn text-white mt-3">{{ __('frontend::message.explore_exercise_products') }}
                            <span>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.7405 5.44365C20.7405 4.78964 20.2104 4.25946 19.5563 4.25946H8.89866C8.24465 4.25946 7.71447 4.78964 7.71447 5.44365C7.71447 6.09766 8.24465 6.62784 8.89866 6.62784L18.3722 6.62784V16.1013C18.3722 16.7553 18.9023 17.2855 19.5563 17.2855C20.2104 17.2855 20.7405 16.7553 20.7405 16.1013V5.44365ZM4.83735 21.8373L20.3937 6.281L18.719 4.6063L3.16265 20.1627L4.83735 21.8373Z" fill="white"/>
                                </svg>     
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- END FITNESS PRODUCT SECTION --}}

    {{-- SATRT FITNESS BLOG SECTION --}}

    <section class="fitness-blog">
        <div class="container overflow-hidden">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-left" data-aos-duration="3000">
                    <h3 class="font-h3">{{ $data['fitness-blog']['title'] }} 
                        <span class="font-span">{{ $data['fitness-blog']['subtitle'] }}</span>
                    </h3>
                    <p class="w-75">{{ $data['fitness-blog']['description'] }}</p>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('products') }}" class="btn fit-btn text-white mt-3 mb-2">{{ __('frontend::message.explore_fitness_products') }} 
                            <span>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.7405 5.44365C20.7405 4.78964 20.2104 4.25946 19.5563 4.25946H8.89866C8.24465 4.25946 7.71447 4.78964 7.71447 5.44365C7.71447 6.09766 8.24465 6.62784 8.89866 6.62784L18.3722 6.62784V16.1013C18.3722 16.7553 18.9023 17.2855 19.5563 17.2855C20.2104 17.2855 20.7405 16.7553 20.7405 16.1013V5.44365ZM4.83735 21.8373L20.3937 6.281L18.719 4.6063L3.16265 20.1627L4.83735 21.8373Z" fill="white"/>
                                </svg>     
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="3000">
                    <img src="{{ $data['fitness-blog']['image'] }}" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    {{-- END FITNESS BLOG SECTION --}}

    {{-- START DOWNLOAD APP SECTION --}}

    <section class="download-app">
        <div class="container overflow-hidden">
            <div class="row">
                <div class="col-lg-6 mb-4" data-aos="fade-left" data-aos-duration="3000">
                    <img src="{{ $data['download-app']['image'] }}" class="img-fluid">
                </div>
                <div class="col-lg-6 d-flex justify-content-center align-items-center" data-aos="fade-right" data-aos-duration="3000">
                    <div>
                        <h3 class="font-h3"> {{ $data['download-app']['title'] }} <br> <span class="font-span">{{ $data['download-app']['subtitle'] }}</span></h3>
                        <p class="">{{ $data['download-app']['description'] }}</p>
                        <div class="d-flex">
                            <a href="{{ $data['download-app']['appstore_url']['url'] }}" {{ $data['download-app']['appstore_url']['target'] }} class="text-decoration-none ">
                                <img src="{{ $data['download-app']['appstore_image'] }}" class="me-3 img-fluid our-app-icon">
                            </a>
                            <a href="{{ $data['download-app']['playstore_url']['url'] }}" {{ $data['download-app']['playstore_url']['target'] }} class="text-decoration-none">
                                <img src="{{ $data['download-app']['playstore_image'] }}" class="img-fluid our-app-icon">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- END DOWNLOAD APP SECTION --}}

    {{-- START CLIENT REVIEW SECTION --}}

    <section class="client-review">
        <div class="container overflow-hidden">
            <div class="row">
                <div class="col-md-6">
                    <div data-aos="fade-down" data-aos-duration="3000">
                        <h3 class="font-h3">
                            {{ $data['client-testimonial']['title'] }} 
                            <span class="font-span">{{ $data['client-testimonial']['subtitle'] }}</span>
                        </h3>
                    </div>
                    <div class="d-flex row" data-aos="zoom-in" data-aos-duration="3000">
                        <div class="col-sm-4 col-lg-4 d-flex align-items-center rating-section">
                            <div class="mt-3 rating-content">
                                {!! renderStars($data['client-testimonial']['appstore_review'] ?? 0) !!}
                                <h6 class="mt-2 review">{{ $data['client-testimonial']['appstore_review'] }}/5 - {{ $data['client-testimonial']['playstore_totalreview'] }}+ {{ __('frontend::message.reviews') }}</h6>
                            </div>
                            <a href="{{ $data['download-app']['appstore_url']['url'] }}" {{ $data['download-app']['appstore_url']['target'] }} class="text-decoration-none me-lg-5">
                                <img id="appstoreImage" src="{{ asset('frontend-section/images/app-store-light.png') }}" class="img-fluid">
                            </a>
                        </div>
                        <div class="col-sm-4 col-lg-4 d-flex align-items-center rating-section">
                            <div class="mt-3 rating-content">
                                {!! renderStars($data['client-testimonial']['playstore_review'] ?? 0) !!}
                                <h6 class="mt-2 review">{{ $data['client-testimonial']['playstore_review'] }}/5 - {{ $data['client-testimonial']['appstore_totalreview'] }}+ {{ __('frontend::message.reviews') }}</h6>
                            </div>
                            <a href="{{ $data['download-app']['playstore_url']['url'] }}" {{ $data['download-app']['playstore_url']['target'] }} class="text-decoration-none me-lg-5">
                                <img id="playstoreImage" src="{{ asset('frontend-section/images/play-store-dark.png') }}" class="img-fluid">
                            </a>
                        </div>
                        <div class="col-sm-4 col-lg-4 d-flex align-items-center rating-section">
                            <div class="mt-3 rating-content">
                                {!! renderStars($data['client-testimonial']['trustpilot_review'] ?? 0) !!}
                                <h6 class="mt-2 review">{{ $data['client-testimonial']['trustpilot_totalreview'] }}+ {{ __('frontend::message.reviews') }}</h6>
                            </div>
                            <a href="{{ $data['download-app']['trustpilot_url']['url'] }}" {{ $data['download-app']['trustpilot_url']['target'] }} class="text-decoration-none me-lg-5">
                                <img id="trustpilotImage" src="{{ asset('frontend-section/images/trust.png') }}" class="img-fluid">
                            </a>

                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-12">
                <div id="client-slider" class="owl-carousel">
                    @foreach ($client_testimonial->isNotEmpty() ? $client_testimonial : [(object) ['id' => '','title' => $data['dummy_title'], 'subtitle' => $data['dummy_title'], 'description' => $data['dummy_description']]] as $index => $client_review)
                        <div class="card mb-3 border-0 fixed-card">
                            <div class="row g-0">
                                <div class="col-md-3 d-flex justify-content-center align-items-center position-relative client-img-card">
                                    <img src="{{ getSingleMediaSettingImage($client_review->id != null ? $client_review : null, 'client-testimonial', 'client-testimonial') }}" class="client-img">
                                    <div class="d-md-block d-none vertical-line"></div>
                                </div>
                                <div class="d-md-none client-slider-line">
                                    <div class="horizontal-line"></div>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body client-card-body mb-1">
                                        <h5 class="card-title mb-1 title-color text-truncate">{{ $client_review->title }}</h5>
                                        <h6 class="title-color">{{ $client_review->subtitle }}</h6>
                                        <p class="card-text mt-3">{{ $client_review->description }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- SATRT NEWSLETTER SECTION --}}

    <section class="px-sm-0 px-2 mb-5">
        <div class="newsletter container mx-auto py-5 mt-5 overflow-hidden">
            <h3 class="m-0 text-center responsive-heading mx-auto text-white" data-aos="fade-down" data-aos-duration="3000">{{ $data['newsletter']['title'] }}</h3>
            <form action="{{ route('subscribe') }}" method="POST" class="p-2 mx-auto" autocomplete="off">
                @csrf 
                <div class="search mt-5 d-flex justify-content-between border p-2 rounded-pill" data-aos="zoom-in" data-aos-duration="3000">
                    <input type="email" name="email" class="form-control custom-input border-0 bg-transparent text-white" placeholder="{{ __('message.email') }}..." required>
                    <button type="submit" class="text-white border-0 newsletter-btn">{{ __('frontend::message.subscribe') }}</button>
                </div>
            </form>
        </div>
    </section>

    {{-- END NEWSLETTER SECTION --}}

</x-frontend-layout>
