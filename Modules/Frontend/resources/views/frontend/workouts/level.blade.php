<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('frontend::message.workout_levels') }}</h4>
            </div>
            <div class="container">
                <div class="d-flex align-items-center position-absolute pb-3 bottom-0 banner-content ps-sm-0 ps-3">
                    <a href="{{ route('workouts') }}" class="text-decoration-none">{{ __('message.workout') }}</a>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="workout-level pt-4 pb-4" id="workout-level-section">
            <div class="container">
                <div class="row" id="load_more" data-route="{{ route('get.levels') }}">
                    @foreach($data['level']->isNotEmpty() ? $data['level'] : [(object) ['id' => '','title' => $data['dummy_title']]] as $level)
                        <div class="col-sm-6 col-md-4 col-lg-4 mb-4">
                            <div class="card border-0">
                                <div class="workout-level-card p-0 position-relative">
                                <a href="{{ route('workout.level', $level->slug ) }}">
                                    <img src="{{ getSingleMediaSettingImage($level->id != null ? $level : null,'level_image') }}" class="w-100">
                                </a>
                                <div class="workout-level-card-text position-absolute">
                                    <p class="card-text text-center text-white m-0">{{ $level->title }}</p>
                                </div>
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
