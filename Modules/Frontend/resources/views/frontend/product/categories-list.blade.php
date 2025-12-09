<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative ps-0 pe-0">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 detail-frame">
            <div class="container">
                <div class="d-flex align-items-center position-absolute top-0 bottom-0 banner-content ps-sm-0 ps-3">
                    <div>
                        <a href="{{ route('products') }}" class="text-decoration-none">{{ __('message.product') }}</a></a> 
                        <span> / {{ __('frontend::message.details') }}</span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="pt-5 pb-4">
            <div class="container">
                <div class="row mb-3">
                    @if (count($data['product_list']) > 0)
                        @foreach ($data['product_list']->isNotEmpty() ? $data['product_list'] : [(object) ['id' => '','title' => $data['dummy_title']]] as $product_list)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="card border-0 border-radius-16">
                                    <a href="{{ route('product.details', $product_list->slug) }}" class="text-decoration-none">
                                        <img src="{{ getSingleMediaSettingImage($product_list->id != null ? $product_list : null,'product_image') }} " class="product_image img-fluid">
                                    </a>
                                    <div class="card-body border-radius-16">
                                    <p class="card-text text-center text-truncate">{{ $product_list->title }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center flex-column align-items-center mt-5">
                            <img src="{{ asset('frontend-section/images/no-data.png') }}" class="nodata-img">
                            <p class="font-p mt-4 mb-5">{{ __('message.no') . ' ' . __('message.product') . ' ' . __('message.data') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

</x-frontend-layout>
