<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('frontend::message.workouts') }}</h4>
            </div>
            <div class="container">
                <div class="d-flex align-items-center position-absolute pb-3 bottom-0 banner-content ps-sm-0 ps-3">
                    <a href="{{ route('workouts') }}" class="text-decoration-none">{{ __('message.workout') }}</a>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <div id="get-dynamic-data-list" data-type-key="workout"></div>

    </main>

</x-frontend-layout>
