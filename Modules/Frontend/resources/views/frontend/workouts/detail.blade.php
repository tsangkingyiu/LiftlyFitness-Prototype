<x-frontend-layout :assets="$assets ?? []">
    <section>
        <div class="container-fluid position-relative ps-0 pe-0">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 detail-frame">
            <div class="container">
                <div class="d-flex align-items-center position-absolute top-0 bottom-0 banner-content ps-sm-0 ps-3">
                    <div>
                        <a href="{{ route('workouts') }}" class="text-decoration-none">{{ __('message.workout') }}</a>  
                        <span> / {{ $data['workout']->title }}</span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="workout-detail">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="font-h5 text-white mb-4 mt-3">{{ $data['workout']->title }}</h5>
                        <div class="d-flex justify-content-start">
                            <div class="word-break">
                                <div class="d-flex justify-content-center mb-2 mt-3">
                                    <svg width="31" height="30" viewBox="0 0 31 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.8984 15.248L15.7485 10.398M19.6285 14.278L14.7785 19.1281" stroke="var(--site-color)" stroke-width="1.5"/>
                                        <path d="M4.78946 19.5241C3.65922 18.3939 3.0941 17.8288 3.01349 17.1386C2.9955 16.9846 2.9955 16.829 3.01349 16.6749C3.0941 15.9848 3.65922 15.4197 4.78946 14.2895C5.91969 13.1592 6.48481 12.5941 7.17493 12.5135C7.32898 12.4955 7.4846 12.4955 7.63865 12.5135C8.32876 12.5941 8.89388 13.1592 10.0241 14.2895L16.2105 20.4759C17.3408 21.6061 17.9059 22.1712 17.9865 22.8613C18.0045 23.0154 18.0045 23.171 17.9865 23.3251C17.9059 24.0152 17.3408 24.5803 16.2105 25.7105C15.0803 26.8408 14.5152 27.4059 13.8251 27.4865C13.671 27.5045 13.5154 27.5045 13.3614 27.4865C12.6712 27.4059 12.1061 26.8408 10.9759 25.7105L4.78946 19.5241Z" stroke="var(--site-color)" stroke-width="1.5"/>
                                        <path d="M14.7895 9.52412C13.6592 8.39388 13.0941 7.82876 13.0135 7.13865C12.9955 6.9846 12.9955 6.82898 13.0135 6.67493C13.0941 5.98481 13.6592 5.41969 14.7895 4.28946C15.9197 3.15922 16.4848 2.5941 17.1749 2.51349C17.329 2.4955 17.4846 2.4955 17.6386 2.51349C18.3288 2.5941 18.8939 3.15922 20.0241 4.28945L26.2105 10.4759C27.3408 11.6061 27.9059 12.1712 27.9865 12.8613C28.0045 13.0154 28.0045 13.171 27.9865 13.3251C27.9059 14.0152 27.3408 14.5803 26.2105 15.7105C25.0803 16.8408 24.5152 17.4059 23.8251 17.4865C23.671 17.5045 23.5154 17.5045 23.3614 17.4865C22.6712 17.4059 22.1061 16.8408 20.9759 15.7105L14.7895 9.52412Z" stroke="var(--site-color)" stroke-width="1.5"/>
                                        <path d="M23.0234 3.12305L26.9035 7.00306" stroke="var(--site-color)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3.62207 22.5229L7.50208 26.403" stroke="var(--site-color)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h6 class="text-white font-h6">{{ optional($data['workout']->workouttype)->title }}</h6>
                                <p class="font-p text-white">{{ __('message.workouttype') }}</p>
                            </div>
                            <div class="vr mx-5 mt-4"></div>
                            <div class="word-break">
                                <div class="d-flex justify-content-center mb-2 mt-3">
                                    <span class="me-2">
                                        <svg width="30" height="30" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.66602 19.4388V14.6055C1.66602 14.0532 2.11373 13.6055 2.66602 13.6055H5.66602C6.2183 13.6055 6.66602 14.0532 6.66602 14.6055V19.4388" stroke="var(--site-color)"/>
                                        <path d="M6.66602 19.4388V9.60547C6.66602 9.05318 7.11373 8.60547 7.66602 8.60547H11.4993C12.0516 8.60547 12.4993 9.05318 12.4993 9.60547V19.4388" stroke="var(--site-color)"/>
                                        <path d="M12.5 19.4388V4.60547C12.5 4.05318 12.9477 3.60547 13.5 3.60547H17.3333C17.8856 3.60547 18.3333 4.05318 18.3333 4.60547V19.4388" stroke="var(--site-color)"/>
                                        </svg>
                                    </span>
                                </div>
                                <h6 class="text-white font-h6">{{ optional($data['workout']->level)->title }}</h6>
                                <p class="font-p text-white">{{ __('message.level') }}</p>
                            </div>
                        </div>
                        <div class="mb-md-3 mb-0">
                            @if (!empty($data['workout']->id))
                                <button class="btn mt-3 favourite-btn text-white toggle-favorite rounded-pill d-flex justify-content-center align-items-center" data-id="{{ $data['workout']->id }}" data-type="workout" data-subtype="workout-detail">
                                    <span class="favorite-icon mt-2">
                                        @if ($data['workout']['is_favorite'])
                                            {!! getfilledHeartSvg() !!}
                                        @else
                                            {!! getblankHeartSvg() !!}
                                        @endif
                                    </span>
                                    <p class="ms-2 m-0">{{ __('frontend::message.favorite') }}</p>
                                </button>
                            @else
                                <button class="btn mt-3 favourite-btn text-white mb-3">
                                    <span class="favorite-icon">{!! getblankHeartSvg() !!}</span>
                                    <span class="favorite-text">{{ __('frontend::message.favorite') }}</span>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 pt-5 pb-5">
                        <img src="{{ getSingleMediaSettingImage($data['workout'] ,'workout_image') }}" alt="Workout Detail Image" class="workout-detail-img">
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container mt-4">
                <div class="row mb-4">
                    <h5 class="font-h5">{{ __('frontend::message.instructions') }}</h5>
                    <div>
                        <p class="font-p">{!! $data['workout']->description !!}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex flex-wrap mb-1 p-0 gap-2 px-1">
                        @foreach($data['workout']->workoutDay as $val)
                            <h6 class="font-h6">
                                <a href="javascript:void(0)" 
                                exercise-days-id="{{ encryptDecryptId($val->id, 'encrypt') }}" 
                                workout-days="{{ $val->sequence }}" 
                                class="btn day-btn workout_day_exercise exercise_day_tab_{{ $val->sequence }} ms-0">
                                    {{ __('frontend::message.day').' '.$val->sequence + 1 }}
                                </a>
                            </h6>
                        @endforeach
                    </div>
                    <hr class="hr">
                </div>
            </div>
        </section>

        <section class="mt-3">
            <div class="container exercises-list" id="workout-day-exrcise">
                
            </div>
        </section>
    </main>

    @section('bottom_script')
    <script>
        (function ($) {
            $(document).ready(function () {
                function getWoroutDayExercises(id, workout_days) {
                    $.ajax({
                        url: "{{ route('get.workout.day.exercise') }}",
                        type: 'get',
                        data: { 'id': id, 'workout_days': workout_days },
                        dataType: 'json',
                        success: function (response) {
                            $('#workout-day-exrcise').html(response.data);
                            $('.workout_day_exercise').removeClass('active');
                            $('.exercise_day_tab_' + response.workout_days).addClass('active');
                        }
                    });
                }

                let initialId = $('.exercise_day_tab_0').attr('exercise-days-id');
                getWoroutDayExercises(initialId, 0);

                $(document).on('click', '.workout_day_exercise', function () {
                    let id = $(this).attr('exercise-days-id');
                    let workout_days = $(this).attr('workout-days');
                    getWoroutDayExercises(id, workout_days);
                });
            });
        })(jQuery);
    </script>
    @endsection
</x-frontend-layout>
