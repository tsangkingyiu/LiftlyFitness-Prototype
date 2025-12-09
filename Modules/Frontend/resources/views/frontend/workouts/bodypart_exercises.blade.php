<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('frontend::message.body_parts_exercises') }}</h4>
            </div>
            <div class="container">
                <div class="d-flex align-items-center position-absolute pb-3 bottom-0 banner-content ps-sm-0 ps-3">
                    <a href="{{ route('workouts') }}" class="text-decoration-none">{{ __('message.workout') }}</a><span> / {{ __('frontend::message.body_parts_exercises') }}</span>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section id="bodypart-exercise-section">
            <div class="container bodyparts-exercises pt-5">
                <div class="row" id="load_more" data-route="{{ route('bodypart.exercises') }}">
                    @foreach($data['body_parts']->isNotEmpty() ? $data['body_parts'] : [(object) ['id' => '','title' => $data['dummy_title']]] as $body_parts)
                        <div class="col-6 col-md-3 col-lg-2 text-center mb-4">
                            <a href="{{ route('bodypart.exercises.list', $body_parts->slug) }}"><img src="{{ getSingleMediaSettingImage($body_parts->id != null ? $body_parts : null ,'bodypart_image') }}" class="img-fluid"></a>
                            <span class="d-flex justify-content-center mt-2">{{ $body_parts->title }}</span>
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
