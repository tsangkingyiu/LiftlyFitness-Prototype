<div class="row">
    @if(count($data) > 0)
        @foreach($data as $workout_day_exercise)
            @php
              $exercise = optional($workout_day_exercise->exercise);
            @endphp
            <div class="col-md-3">
                <div class="card border-0 border-radius-12 mb-4">
                    <a href="{{ $exercise->id == null ? 'javascript:void(0)' : (checkPremium($exercise, auth()->user()) ? route('pricing-plan') : route('bodypart.exercises.detail', $exercise->slug)) }}">
                        <img src="{{ getSingleMediaSettingImage($exercise ,'exercise_image') }}" class="img-fluid">
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
        <p class="text-center">{{ __('frontend::message.blissful_break') }}</p>
    @endif
</div>