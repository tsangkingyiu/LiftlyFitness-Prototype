<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('frontend::message.equipment_based_exercise') }}</h4>
            </div>
            <div class="container">
                <div class="d-flex align-items-center position-absolute pb-3 bottom-0 banner-content ps-sm-0 ps-3">
                    <a href="{{ route('workouts') }}" class="text-decoration-none">{{ __('message.workout') }}</a>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="equipment-exercise pb-2 pt-3" id="equipment-exercise-section">
            <div class="container">
                <div class="row" id="load_more" data-route="{{ route('equipment.based.exercise') }}">
                    @foreach($data['equipment']->isNotEmpty() ? $data['equipment'] : [(object) ['id' => '','title' => $data['dummy_title']]] as $equipment)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-2 mb-3">
                            <div>
                                <div class="card border-0 mt-2 border-radius-16">
                                    <a href="{{ route('equipment.exercises.list', $equipment->slug) }}">
                                        <img src="{{ getSingleMediaSettingImage($equipment->id != null ? $equipment : null,'equipment_image') }}" class="equipment-img">
                                    </a>
                                    <div class="card-img-overlay">
                                        <p class="text-center">{{ $equipment->title }}</p>
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
