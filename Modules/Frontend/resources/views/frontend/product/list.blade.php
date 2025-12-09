<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('frontend::message.fitness_accessories') }}</h4>
            </div>
            <div class="container">
                <div class="d-flex align-items-center position-absolute pb-3 bottom-0 banner-content ps-sm-0 ps-3">
                    <a href="{{ route('products') }}" class="text-decoration-none">{{ __('message.product') }}</a><span> / {{ __('frontend::message.fitness_accessories') }}</span>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="pt-4" id="product-accessories-section">
            <div class="container">
                <div class="row mb-2" id="load_more" data-route={{ route('product.list') }}>
                    @foreach ($data['product']->isNotEmpty() ? $data['product'] : [(object) ['id' => '','title' => $data['dummy_title']]] as $product)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                            <div class="card border-0 border-radius-16">
                                <a href="{{ route('product.details', $product->slug) }}" class="text-decoration-none">
                                    <img src="{{ getSingleMediaSettingImage($product->id != null ? $product : null,'product_image') }} " class="product_image img-fluid">
                                </a>
                                <div class="card-body border-radius-16">
                                <p class="card-text text-center text-truncate">{{ $product->title }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    @if($data['hasData'])
                        <button class="bg-transparent mb-5 load-more-btn" id="load_more_button">{{ __('frontend::message.load_more') }}</button>
                    @endif
                </div>
            </div>
        </section>
    </main>
</x-frontend-layout>
