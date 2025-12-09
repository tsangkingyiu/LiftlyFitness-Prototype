<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('frontend::message.product_categories') }}</h4>
            </div>
            <div class="container">
                <div class="d-flex align-items-center position-absolute pb-3 bottom-0 banner-content ps-sm-0 ps-3">
                    <a href="{{ route('products') }}" class="text-decoration-none">{{ __('message.product') }}</a><span> / {{ __('frontend::message.product_categories') }}</span>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="diet-categories-section pt-4" id="product-categories-section">
            <div class="container">
                <div class="row pb-4" id="load_more" data-route={{ route('product.categories') }}>
                    @foreach ($data['product_category']->isNotEmpty() ? $data['product_category'] : [(object) ['id' => '', 'title' => $data['dummy_title']]] as $product_category)
                        <div class="col-12 col-md-3 col-lg-2 mb-4">
                            <div class="card border-0 border-radius-12">
                                <div class="card-body main-card text-center p-0 pb-2 border-radius-12">
                                    <a href="{{ route('product.categories.list', $product_category->slug) }}" class="text-decoration-none">
                                        <img src="{{  getSingleMediaSettingImage($product_category->id != null ? $product_category : null,'productcategory_image') }}" class="img-fluid w-100">
                                        <span class="d-flex justify-content-center mt-2 title-color">{{ $product_category->title }}</span>
                                    </a>
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
