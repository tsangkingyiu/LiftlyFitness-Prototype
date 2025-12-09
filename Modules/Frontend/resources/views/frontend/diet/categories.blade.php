<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('frontend::message.diet_categories') }}</h4>

            </div>
            <div class="container">
                <div class="d-flex align-items-center position-absolute pb-3 bottom-0 banner-content ps-sm-0 ps-3">
                    <a href="{{ route('diet') }}" class="text-decoration-none">{{ __('message.diet') }}</a><span> / {{ __('frontend::message.diet_categories') }}</span>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="diet-categories-section" id="diet-categories-section">
            <div class="container pt-4">
                <div class="row pb-4" id="load_more" data-route={{ route('diet.categories') }}>
                    @foreach ($data['category_diet']->isNotEmpty() ? $data['category_diet'] : [(object) ['id' => '', 'title' => $data['dummy_title']]] as $diet_category)
                        <div class="col-12 col-md-3 col-lg-2 mb-4">
                            <div class="card border-0 border-radius-12">
                                <div class="card-body main-card text-center p-0 pb-2 border-radius-12">
                                    <a href="{{ route('diet.categories.list', $diet_category->slug) }}" class="text-decoration-none">
                                        <img src="{{ getSingleMediaSettingImage($diet_category->id != null ? $diet_category : null, 'categorydiet_image') }}" class="img-fluid w-100">
                                        <span class="d-flex justify-content-center mt-3 title-color">{{ $diet_category->title }}</span>
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
