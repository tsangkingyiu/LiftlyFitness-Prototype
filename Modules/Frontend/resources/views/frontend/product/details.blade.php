<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative ps-0 pe-0">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 detail-frame">
            <div class="container">
                <div class="d-flex align-items-center position-absolute top-0 bottom-0 banner-content ps-sm-0 ps-3">
                    <div>
                        <a href="{{ route('products') }}" class="text-decoration-none">{{ __('message.product') }}</a>
                        <a class="text-decoration-none" href="{{ route('product.categories') }}"><span> /  {{ $data['product']->title }}</span></a><span> / {{ __('frontend::message.detail') }}</span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="product_section">
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-6 mb-3 d-flex justify-content-center">
                        <img src="{{ getSingleMediaSettingImage($data['product']->id != null ? $data['product'] : null, 'product_image') }}"
                            class="img-fluid product-img">
                    </div>
                    <div class="col-md-6">
                        <h4 class="font-h4">{{ $data['product']['title'] }}</h4>
                        <span class="font-span product-price">{{ getPriceFormat($data['product']['price']) }}</span>
                        <hr class="hr">
                        <div class="font-p">
                            {!! $data['product']['description'] !!}    
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="{{ $data['product']['affiliate_link'] }}" target="_blank" class="btn fit-btn product-btn text-white mt-3">{{ __('frontend::message.buy_now') }} 
                                <span>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20.7405 5.44365C20.7405 4.78964 20.2104 4.25946 19.5563 4.25946H8.89866C8.24465 4.25946 7.71447 4.78964 7.71447 5.44365C7.71447 6.09766 8.24465 6.62784 8.89866 6.62784L18.3722 6.62784V16.1013C18.3722 16.7553 18.9023 17.2855 19.5563 17.2855C20.2104 17.2855 20.7405 16.7553 20.7405 16.1013V5.44365ZM4.83735 21.8373L20.3937 6.281L18.719 4.6063L3.16265 20.1627L4.83735 21.8373Z" fill="white"/>
                                    </svg>     
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</x-frontend-layout>
