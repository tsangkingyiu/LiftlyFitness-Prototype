@if ($type == 'workouts')
    @if (count($data['workouts']) > 0)
        @foreach ($data['workouts'] as $workout)
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 mt-4 position-relative">
            <a href="{{ $workout->id == null ? 'javascript:void(0)' : (checkPremium($workout, auth()->user()) ? route('pricing-plan') : route('workout.detail', $workout->slug)) }}">
                <img src="{{ getSingleMediaSettingImage($workout->id != null ? $workout : null, 'workout_image') }}" class="workout-img img-fluid w-100">
                <div class="position-absolute top-0 start-0 m-3 ps-2">
                    @if(SettingData('subscription', 'subscription_system') == 1 && $workout->is_premium == 1)
                        <span class="badge bg-badge-orange text-white">
                            {{ __('frontend::message.pro') }}
                        </span>
                    @endif
                </div>
            </a>
            @if (!empty($workout->id))
                <div class="position-absolute top-0 end-0 m-3 pe-2">
                    <button class="btn p-1 card-heart11 toggle-favorites" data-id="{{ $workout->id }}" data-type="workouts" sub-type="{{ $sub_type }}">
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
            <div class="card-body">
                <p class="card-title">{{ $workout->title }}</h5>
                @if ($workout->id != null)
                    <div class="d-flex justify-content-between">
                        <span class="font-p">{{  optional($workout->workouttype)->title }}</span class="font-p">
                        <span class="font-p">{{ optional($workout->level)->title }}</span>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    @else
        <div class="d-flex justify-content-center flex-column align-items-center mt-5">
            <img src="{{ asset('frontend-section/images/no-data.png') }}" class="nodata-img">
            <p class="font-p mt-4 mb-5">{{ __('frontend::message.havent_any_data') }}</p>
        </div>
    @endif
@endif

@if ($type == 'diets')
    @if (count($data['diets']) > 0)
        @foreach ($data['diets'] as $diet)
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 mt-4 position-relative diet-categories">
            <a href="{{ $diet->id == null ? 'javascript:void(0)' : (checkPremium($diet, auth()->user()) ? route('pricing-plan') : route('diet.details', $diet->slug)) }}">
                <img src="{{ getSingleMediaSettingImage($diet->id != null ? $diet : null,'diet_image') }}">
                <div class="position-absolute top-0 start-0 m-3 ps-2">
                    @if(SettingData('subscription', 'subscription_system') == 1 && $diet->is_premium == 1)
                        <span class="badge bg-badge-orange text-white">
                            {{ __('frontend::message.pro') }}
                        </span>
                    @endif
                </div>
            </a>
            @if (!empty($diet->id))
                <div class="position-absolute top-0 end-0 m-3 pe-2">
                    <button class="btn p-1 card-heart11 toggle-favorites" data-id="{{ $diet->id }}" data-type="diets" sub-type="{{ $sub_type }}">
                        @if ($diet->is_favorite)
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
            <div class="card-body">
                <p class="font-p">{{ $diet->title }}</p>
            </div>
        </div>
        @endforeach
    @else
        <div class="d-flex justify-content-center flex-column align-items-center mt-5">
            <img src="{{ asset('frontend-section/images/no-data.png') }}" class="nodata-img">
            <p class="font-p mt-4 mb-5">{{ __('frontend::message.havent_any_data') }}</p>
        </div>
    @endif
@endif
