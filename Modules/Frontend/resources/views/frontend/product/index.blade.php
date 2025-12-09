<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('message.product') }}</h4>
                <div class="input-group search-group mx-auto position-relative">
                    <form action="{{ route('search') }}" method="GET" class="d-flex w-100">
                        <input type="hidden" name="section" value="{{ $section }}">
                        <input type="text" class="form-control search-form" name="query" value="{{ request()->query('query') }}" placeholder="{{ __('frontend::message.search_product') }}" id="search-query" autocomplete="off">
                        <button type="submit" class="btn btn-link p-0 magnifer">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11.5" cy="11.5" r="9.5" stroke="#666666" stroke-width="1.5"/>
                                <path d="M18.5 18.5L22 22" stroke="#666666" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </form>
                    <ul class="list-group position-absolute w-100" id="suggestions" style="display:none;"></ul>
                </div>
            </div>
        </div>
    </section>
    
    <main class="section-color">
        <section class="pt-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-h6 mb-4">{{ __('frontend::message.product_categories') }}</h6>
                            @if (count($data['product_category']) > 0)
                                <a href="{{ route('product.categories') }}" class="text-decoration-none"><span class="font-span mb-4 see-all">{{ __('message.see_all') }}</span></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="product-slider" class="owl-carousel mb-3 search-data-list">
                        @foreach ($data['product_category']->isNotEmpty() ? $data['product_category'] : [(object) ['id' => '', 'title' => $data['dummy_title']]] as $product_category )
                            <div class="card border-0 border-radius-12 m-2">
                                <div class="card-body main-card text-center p-0 pb-1">
                                    <a href="{{ $product_category->id != null ? route('product.categories.list', $product_category->slug) : 'javascript:void(0)' }}" class="text-decoration-none">
                                        <img src="{{ getSingleMediaSettingImage($product_category->id != null ? $product_category : null,'productcategory_image') }}" class="img-fluid productcategory_image">
                                        <span class="d-flex justify-content-center p-1 mt-2 title-color">{{ $product_category->title }}</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-h6 mb-4">{{ __('frontend::message.fitness_accessories') }}</h6>
                            @if (count($data['product']) > 0)
                                <a href="{{ route('product.list') }}" class="text-decoration-none"><span class="font-span mb-4 see-all">{{ __('message.see_all') }}</span></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row pb-5">
                    @foreach ($data['product']->isNotEmpty() ? $data['product'] : [(object) ['id' => '','title' => $data['dummy_title']]] as $product)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                <div class="card border-0 border-radius-16">
                                <a href="{{ $product->id != null ? route('product.details', $product->slug) : 'javascript:void(0)' }}" class="text-decoratio-none">
                                    <img src="{{ getSingleMediaSettingImage($product->id != null ? $product : null,'product_image') }} " class="product_image img-fluid">
                                </a>
                                <div class="card-body border-radius-16">
                                    <p class="card-text text-center text-truncate">{{ $product->title }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
</x-frontend-layout>
