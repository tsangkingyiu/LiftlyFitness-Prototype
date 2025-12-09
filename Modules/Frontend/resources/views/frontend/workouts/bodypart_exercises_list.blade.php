<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ $data['body_parts']->title ?? '' }}</h4>
                <div class="input-group search-group mx-auto">
                    @php
                        $exercise_id = request('slug') ?? null;
                    @endphp
                    <form action="{{ route('search') }}" method="GET" class="d-flex w-100">
                        <input type="hidden" name="section" value="{{ $section }}" data-id="{{ $exercise_id }}">
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
            <div class="container">
                <div class="d-flex align-items-center position-absolute pb-3 bottom-0 banner-content ps-sm-0 ps-3">
                    <a href="{{ route('workouts') }}" class="text-decoration-none">{{ __('message.workout') }}</a>
                    <span> / {{ $data['body_parts']->title ?? '' }}</span>                
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="py-5">
            <div class="container exercises-list">
                <div class="row gy-3">
                    @if (count($data['exercise']) > 0)
                        @foreach($data['exercise'] as $exercise)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-2 search-data-list">
                                <div class="card border-0 border-radius-12 mb-sm-0 mb-2">
                                    <a href="{{ $exercise->id == null ? 'javascript:void(0)' : (checkPremium($exercise, auth()->user()) ? route('pricing-plan') : route('bodypart.exercises.detail', $exercise->slug )) }}">
                                        <img src="{{ getSingleMediaSettingImage($exercise->id != null ? $exercise : null, 'exercise_image') }}" class="card-img-top">
                                        <div class="position-absolute top-0 start-0 m-3">
                                            @if(SettingData('subscription', 'subscription_system') == 1 && $exercise->is_premium == 1)
                                                <span class="badge bg-badge-orange text-white">
                                                    {{ __('frontend::message.pro') }}
                                                </span>
                                            @endif
                                        </div>
                                    </a>   
                                    <div class="card-body exercises-list-card-body">
                                        <p class="mb-2 text-truncate">{{ $exercise->title }}</p>
                                        @if (in_array($exercise->based, ['reps', 'time']) && !empty($exercise->sets))
                                            @foreach ($exercise->sets as $val)
                                                <span>{{ $val[$exercise->based] . ($exercise->based == 'reps' ? 'x' : 's') }}</span>
                                            @endforeach
                                        @else
                                            <span>{{ $exercise->duration . ' ' . __('message.duration') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center flex-column align-items-center mt-5">
                            <img src="{{ asset('frontend-section/images/no-data.png') }}" class="nodata-img">
                            <p class="font-p mt-4 mb-5">{{ __('message.no') . ' ' . __('message.data') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
    
</x-frontend-layout>
