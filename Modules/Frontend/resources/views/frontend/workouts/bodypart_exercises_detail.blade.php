<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative ps-0 pe-0">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 detail-frame">
            <div class="container">
                <div class="d-flex align-items-center position-absolute top-0 bottom-0 banner-content ps-sm-0 ps-3">
                    <div>
                        <a href="{{ route('workouts') }}" class="text-decoration-none">{{ __('message.workout') }}</a> 
                        <span> / {{ $data['exercise']->title }}</span>
                       <span> / {{ __('message.detail_form_title',['form' => ''])}}</span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="exercises-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-3 w-100">
                        @php
                            $videoUrl = $data['exercise']->video_url ?? null;
                            $videoType = $data['exercise']->video_type ?? null;
                            $videoUrlClean = $videoUrl ? str_replace('&amp;', '&', $videoUrl) : null;
                            $upload_url = getMediaFileExit($data['exercise'], 'exercise_video') ? getSingleMedia($data['exercise'], 'exercise_video', null) : null;
                            $uploadUrlExtension = $upload_url ? pathinfo($upload_url, PATHINFO_EXTENSION) : null;

                            $mimeType = null;
                            
                            if ($videoUrlClean) {
                                if (Str::contains($videoUrlClean, '.mp4')) {
                                    $mimeType = 'video/mp4';
                                } elseif (Str::contains($videoUrlClean, '.m3u8')) {
                                    $mimeType = 'application/x-mpegURL';
                                } elseif (Str::contains($videoUrlClean, 'youtu.be')) {
                                    $mimeType = 'video/youtube';
                                }
                            }
                        @endphp

                        @if($videoType === 'url' && $videoUrlClean)
                            @if($mimeType === 'video/youtube')
                                <video id="youtube-video" class="video-js vjs-default-skin w-100" height="544" preload="auto">
                                    <source src="{{ $videoUrlClean }}" type="{{ $mimeType }}" />
                                </video>
                            @elseif($mimeType === 'video/mp4' || $mimeType === 'application/x-mpegURL')
                                <video id="exercise-video" class="video-js vjs-default-skin w-100" height="544" preload="auto">
                                    <source src="{{ $videoUrlClean }}" type="{{ $mimeType }}" />
                                </video>
                            @endif
                        @elseif($videoType === 'upload_video' && $upload_url)
                            <video id="exercise-video" class="video-js vjs-default-skin w-100" height="544" preload="auto">
                                <source src="{{ $upload_url }}" type="video/mp4" />
                            </video>
                        @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h5 class="font-h5">{{ $data['exercise']->title }}</h5>
                            <div class="text-decoration-none">
                                <span class="me-2">
                                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.66602 19.4388V14.6055C1.66602 14.0532 2.11373 13.6055 2.66602 13.6055H5.66602C6.2183 13.6055 6.66602 14.0532 6.66602 14.6055V19.4388" stroke="var(--site-color)"/>
                                    <path d="M6.66602 19.4388V9.60547C6.66602 9.05318 7.11373 8.60547 7.66602 8.60547H11.4993C12.0516 8.60547 12.4993 9.05318 12.4993 9.60547V19.4388" stroke="var(--site-color)"/>
                                    <path d="M12.5 19.4388V4.60547C12.5 4.05318 12.9477 3.60547 13.5 3.60547H17.3333C17.8856 3.60547 18.3333 4.05318 18.3333 4.60547V19.4388" stroke="var(--site-color)"/>
                                    </svg>
                                </span>
                                <span class="mb-4">{{ optional($data['exercise']->level)->title }}</span>
                            </div>
                        </div>
                        <hr class="hr">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <table class="custom-table border-0 w-100 text-center">
                            @if($data['exercise']->type == 'sets' && !empty($data['exercise']->sets) && is_array($data['exercise']->sets))
                                <thead>
                                    <tr>
                                        @foreach($data['exercise']->sets as $val)
                                            <th>
                                                <span class="title-color">{{ $data['exercise']->based == 'reps' ? $val['reps'].' x' : $val['time'].' s' }}</span><br>
                                                <span class="title-color">{{ isset($val['weight']) ? '- '.$val['weight'].' kg' : '' }}</span>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach($data['exercise']->sets as $val)
                                            <td class="title-color">{{ $val['rest'] }} s</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            @elseif($data['exercise']->type != 'sets' && !empty($data['exercise']->duration))
                                <thead>
                                    <tr>
                                        <th colspan="3">
                                            <span class="title-color">{{ __('message.duration') }}</span><br>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $data['exercise']->duration }}</td>
                                    </tr>
                                </tbody>
                            @endif
                        </table>
                        
                        @if (!empty($data['exercise']->instruction))
                            <div class="mt-3 instructions">
                                <h6 class="font-h6">{{ __('frontend::message.instructions') }}</h6>
                                <p class="font-p">{!! str_replace('<img', '<img class="img-fluid"', $data['exercise']->instruction) !!}</p>
                            </div>
                            <hr class="hr">
                        @endif
    
                        <div class="mt-3 body-parts">
                            <h6 class="font-h6 mb-3">{{ __('message.bodypart').'s' }}</h6>
                            <div class="row">
                                @foreach($data['exercise_bodypart']->isNotEmpty() ? $data['exercise_bodypart'] : [(object) ['id' => '','title' => $data['dummy_title']]] as $body_parts)
                                    <div class="col-3 col-md-2 col-lg-1 text-center mb-2 me-2">
                                        <a href="{{ route('bodypart.exercises.list', $body_parts->slug) }}"><img src="{{ getSingleMediaSettingImage($body_parts->id != null ? $body_parts : null ,'bodypart_image') }}" class=""></a>
                                        <span class="d-flex justify-content-center mt-2">{{ $body_parts->title }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @if (isset($data['exercise']->equipment)) 
                        <hr class="hr">
                            <div class="mt-3 equipment">
                                <h6 class="font-h6 mb-3">{{ __('frontend::message.equipments') }}</h6>
                                <div class="row">
                                    <div class="col-5 col-md-3 col-lg-2 mb-2 me-2">
                                        <div class="card border-0 mt-2">
                                            <img src="{{ getSingleMediaSettingImage($data['exercise']->equipment,'equipment_image') }}" class="img-fluid">
                                            <div class="card-img-overlay d-flex align-items-center justify-content-center py-3">
                                                <p class="text-center m-0">{{ isset($data['exercise']) ? optional($data['exercise']->equipment)->title : '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @if (!empty($data['exercise']->tips))
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button tips" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="12.1057" r="10" stroke="var(--site-color)" stroke-width="1.5"/>
                                                <path d="M12 17.1057V11.1057" stroke="var(--site-color)" stroke-width="1.5" stroke-linecap="round"/>
                                                <circle cx="1" cy="1" r="1" transform="matrix(1 0 0 -1 11 9.10571)" fill="var(--site-color)"/>
                                            </svg>
                                            <span class="tips-span ms-2 title-color">{{ __('message.tips') }}</span>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body tips">
                                            <div>{!! $data['exercise']->tips !!}</div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        @endif
                    </div>
                        
                </div>
            </div>
        </section>
    </main>

    @section('bottom_script')
        <script>
           $(document).ready(function () {
                var player;
                var Options = {
                    autoplay: 'muted',
                    controls: true,
                    fluid: true,
                    bigPlayButton: false,
                    playsinline: true,
                    playbackRates: [0.5, 1, 1.5, 2],
                    plugins: {
                        hotkeys: {
                            volumeStep: 0.1,
                            seekStep: 5,
                            enableModifiersForNumbers: false,
                            enableVolumeScroll: false,
                            enableFullscreenToggle: false,
                            enableNumbers: false
                        }
                    },
                    controlBar: {
                        volumePanel: {
                            inline: false
                        },
                        skipButtons: {
                            forward: 10,
                            backward: 10
                        }
                    }
                };

                if ($('#exercise-video').length) {
                    player = videojs('exercise-video', Options);
                } 
                else if ($('#youtube-video').length) {
                    player = videojs('youtube-video', Options);
                }
                if (player) {
                    var videoType = "{{ $mimeType }}";
                    var videoUrl = {!! json_encode($videoUrlClean) !!};
                    var videoSourceType = "{{ $data['exercise']->video_type }}";
                    var uploadUrlExtension = "{{ $uploadUrlExtension }}"
        
                    if (videoSourceType === 'url') { 
                        if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                            player.src({ 
                                type: 'video/youtube', 
                                src: videoUrl 
                            });
                        } else if (videoType === 'video/mp4' || videoType === 'application/x-mpegURL') {
                            player.src({
                                type: videoType,
                                src: videoUrl
                            });
                        } else {
                            // console.error("Unsupported video type for URL:");
                        }
                    } else if (videoSourceType === 'upload_video') {
    
                        if (uploadUrlExtension === 'mp4' || uploadUrlExtension === 'webm' ) {
                            player.src({
                                type: 'video/' + uploadUrlExtension,
                                src: "{{ $data['exercise']->video_type == 'url' ? $data['exercise']->video_url : getSingleMediaSettingImage($data['exercise']->id != null ? $data['exercise'] : null, 'exercise_video') }}"
                            });
                        } else {
                            // console.error("Unsupported upload video type.");
                        }
                    } else {
                        // console.error("Invalid video source type:");
                    }

                    player.on('error', function() {
                        var error = player.error();
                        // console.error('Error Code: ', error.code);
                        // console.error('Error Message: ', error.message);
                    });

                    $('#exercise-video, #youtube-video').on('contextmenu', function(e) {
                        e.preventDefault();
                    });

                }else{
                    // console.warn("Player could not be initialized.");
                }
            });
        </script>
    @endsection
</x-frontend-layout>
