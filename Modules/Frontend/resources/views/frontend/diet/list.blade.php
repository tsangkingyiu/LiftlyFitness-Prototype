<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('frontend::message.dietary_options') }}</h4>
            </div>
            <div class="container">
                <div class="d-flex align-items-center position-absolute pb-3 bottom-0 banner-content ps-sm-0 ps-3">
                    <a href="{{ route('diet') }}" class="text-decoration-none">{{ __('message.diet') }}</a><span> / {{ __('frontend::message.dietary_options') }}</span>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="diet-categories pt-5" id="dietary-section">
            <div class="container">
                <div class="row pb-3" id="load_more" data-route={{ route('diet.list') }}>
                    @foreach ($data['diet']->isNotEmpty() ? $data['diet'] : [(object) ['id' => '', 'title' => $data['dummy_title'], 'is_premium' => 0]] as $diet)       
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card border-0 position-relative">
                                <a href="{{ $diet->id == null ? 'javascript:void(0)' : (checkPremium($diet, auth()->user()) ? route('pricing-plan') : route('diet.details', $diet->slug)) }}">
                                    <img src="{{ getSingleMediaSettingImage($diet->id != null ? $diet : null,'diet_image') }}">
                                    <div class="position-absolute top-0 start-0 m-2">
                                        @if(SettingData('subscription', 'subscription_system') == 1 && $diet->is_premium == 1)
                                            <span class="badge bg-badge-orange text-white">
                                                {{ __('frontend::message.pro') }}
                                            </span>
                                        @endif
                                    </div>
                                </a>
                                @if (!empty($diet->id))
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <button class="btn p-1 card-heart11 toggle-favorite" data-id="{{ $diet->id }}" data-type="diet">
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
                                    <p class="card-text title-color text-truncate">{{ $diet->title }}</p>
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
