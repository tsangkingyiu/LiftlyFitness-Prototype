<x-frontend-layout :assets="$assets ?? []">

    <section class="price-header">
        <div class="container-fluid position-relative ps-0 pe-0">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center">
                <h4 class="font-h4 mb-4">{{ __('frontend::message.unlimited_access') }}</h4>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section>
            <div class="container pricing pt-5 pb-3">
                <div class="row card-section">
                    @if (count($data['package']) > 0)
                        @foreach($data['package'] as $index => $value)
                            <div class="col-lg-4">
                                <div class="card pricing-card border-0 mb-3">
                                    <div class="price-subcard">
                                        <h6 class="card-title plan-title text-center mb-3 mt-3">{{ $value->name }}</h6>
                                        <div class="d-flex justify-content-center mb-3">
                                            <h5 class="font-h5 me-3 price mt-3">{{ getPriceFormat($value->price) }}</h5>
                                            <h6 class="font-h6 total-time mt-3">/ {{ $value->duration.' '. $value->duration_unit }}</h6>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text mt-3 mb-4">{{ strip_tags($value->description) }}</p>
                                        <hr class="hr">
                                        <div class="text-center mb-3">
                                            <a href="{{ auth()->check() && $value->id != null ? route('payment', ['package_id' => encryptDecryptId($value->id, 'encrypt')]) : route('frontend.signin') }}" class="btn subscribe-btn text-white mt-3">
                                                {{ __('frontend::message.subscribe') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center flex-column align-items-center mt-5 pb-5">
                            <img src="{{ asset('frontend-section/images/no-data.png') }}" class="nodata-img">
                            <p class="font-p mt-4 mb-5">{{ __('message.not_found_entry',['name' => __('frontend::message.package')]) }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
</x-frontend-layout>
