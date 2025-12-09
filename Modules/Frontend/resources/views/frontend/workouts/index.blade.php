<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('message.workout') }}</h4>
                <div class="input-group search-group mx-auto position-relative">
                    <form action="{{ route('search') }}" method="GET" class="d-flex w-100">
                        <input type="hidden" name="section" value="{{ $section }}">
                        <input type="text" class="form-control search-form" name="query" value="{{ request()->query('query') }}" placeholder="{{ __('frontend::message.search_exercise') }}" id="search-query" autocomplete="off">
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
        <section class="body-part pt-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-h6 mb-4">{{ __('message.bodypart') .' '. __('message.exercise') }}</h6>
                            @if(count($data['body_parts']) > 0)
                                <a href="{{ route('bodypart.exercises') }}" class="text-decoration-none"><span class="font-span mb-4 see-all">{{ __('message.see_all') }}</span></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="body-part-slider" class="owl-carousel search-data-list">
                        @foreach($data['body_parts']->isNotEmpty() ? $data['body_parts'] : [(object) ['id' => '','title' => $data['dummy_title']]] as $body_parts)
                            <div class="text-center">
                                <a class="d-flex justify-content-center" href="{{ $body_parts->id != null ? route('bodypart.exercises.list', $body_parts->slug) : 'javascript:void(0)' }}"><img src="{{ getSingleMediaSettingImage($body_parts->id != null ? $body_parts : null,'bodypart_image') }}" class="rounded-circle img-fluid body-part-img"></a>
                                <span class="d-block text-center bodypart-title mt-2">{{ $body_parts->title }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr class="hr">
            </div>
        </section>

        <section class="pt-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-h6 mb-4">{{ __('frontend::message.equipment_based_exercise') }}</h6>
                            @if(count($data['equipment'])  > 0 )
                                <a href="{{ route('equipment.based.exercise') }}" class="text-decoration-none"><span class="font-span mb-4 see-all">{{ __('message.see_all') }}</span></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="equipment-slider" class="owl-carousel mb-3">
                        @foreach($data['equipment']->isNotEmpty() ? $data['equipment'] : [(object) ['id' => '','title' => $data['dummy_title']]] as $equipment)
                            <div class="pe-4">
                                <div class="card border-0 mt-2 border-radius-12">
                                    <div class="card-body p-0 border-radius-12">
                                        <a href="{{ $equipment->id != null ? route('equipment.exercises.list', $equipment->slug) : 'javascript:void(0)' }}">
                                            <img src="{{ getSingleMediaSettingImage($equipment->id != null ? $equipment : null,'equipment_image') }}" class="img-fluid equipment-based-image">
                                        </a>
                                    </div>
                                    <div class="card-img-overlay">
                                        <p class="text-center mb-2">{{ $equipment->title }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr class="hr">
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-h6 mb-4">{{ __('message.workout') }}</h6>
                            @if(count($data['workout'])  > 0 )
                                <a href="{{ route('all.workout') }}" class="text-decoration-none"><span class="font-span mb-4 see-all">{{ __('message.see_all') }}</span></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="workout-slider" class="owl-carousel mb-3">
                        @foreach ($data['workout']->isNotEmpty() ? $data['workout'] : [(object) ['id' => '', 'title' => $data['dummy_title'], 'is_premium' => 0]] as $workout)
                            <div class="pe-0 pe-sm-3">
                                <div class="workout-card card border-0 position-relative border-radius-12">
                                    <div class="card-body p-0 border-radius-12">
                                        <a href="{{ $workout->id == null ? 'javascript:void(0)' : (checkPremium($workout, auth()->user()) ? route('pricing-plan') : route('workout.detail', $workout->slug)) }}">
                                            <img src="{{ getSingleMediaSettingImage($workout->id != null ? $workout : null, 'workout_image') }}" class="workout-img">
                                            <div class="position-absolute top-0 start-0 m-2">
                                                @if(SettingData('subscription', 'subscription_system') == 1 && $workout->is_premium == 1)
                                                    <span class="badge bg-badge-orange text-white">
                                                        {{ __('frontend::message.pro') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </a>        
                                        @if (!empty($workout->id))
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <button class="btn p-1 card-heart11 toggle-favorite" data-id="{{ $workout->id }}" data-type="workout">
                                                    @if ($workout->is_favorite)
                                                        {!! getfilledHeartSvg() !!}
                                                    @else
                                                        {!! getblankHeartSvg() !!}
                                                    @endif
                                                </button>
                                            </div>
                                        @else
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <button class="btn p-1 card-heart11">
                                                    {!! getblankHeartSvg() !!}
                                                </button>
                                            </div>
                                        @endif
                                        <div class="position-absolute workout-card-text w-100">
                                            <span class="text-white workout-content-span ms-3">{{ $workout->title }}</span>
                                            @if ($workout->id != null)
                                                <ul class="workout-content mb-0">
                                                    <li class="text-white">
                                                        <span class="text-white">{{ optional($workout->workouttype)->title }}</span>
                                                        <span>|</span> <span class="text-white">
                                                            {{ optional($workout->level)->title }}</span>
                                                    </li>
                                                </ul>
                                            @endif
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr class="hr">
            </div>
        </section>

        <section class="workout-level pb-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-h6 mb-4">{{ __('frontend::message.workout_levels') }}</h6>
                            @if(count($data['level'])  > 0 )
                                <a href="{{ route('get.levels') }}" class="text-decoration-none"><span class="font-span mb-4 see-all">{{ __('message.see_all') }}</span></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($data['level']->isNotEmpty() ? $data['level'] : [(object) ['id' => '','title' => $data['dummy_title']]] as $level)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card border-0">
                                <div class="workout-level-card p-0 position-relative">
                                    <a href="{{ $level->id != null ? route('workout.level', $level->slug) : 'javascript:void(0)' }}">
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
            </div>
        </section>
    </main>

</x-frontend-layout>
