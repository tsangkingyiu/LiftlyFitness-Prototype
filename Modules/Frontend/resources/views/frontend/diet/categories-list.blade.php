<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative ps-0 pe-0">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 detail-frame">
            <div class="container">
                <div class="d-flex align-items-center position-absolute top-0 bottom-0 banner-content ps-sm-0 ps-3">
                    <div>
                        <a href="{{ route('diet') }}" class="text-decoration-none">{{ __('message.diet') }}</a></a> 
                        <span> / {{ __('frontend::message.detail_form_title',['form' => '']) }}</span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="diet-categories pt-4">
            <div class="container">
                <div class="row">
                    @if (count($data['diet_list']) > 0)
                        @foreach ($data['diet_list']->isNotEmpty() ? $data['diet_list'] : [(object) ['id' => '', 'title' => $data['dummy_title'], 'is_premium' => 0]] as  $diet)       
                            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card border-0 position-relative">
                                    <a href="{{ $diet->id == null ? 'javascript:void(0)' : (checkPremium($diet, auth()->user()) ? route('pricing-plan') : route('diet.details',$diet->slug)) }}">
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
                                        <p class="card-text text-truncate">{{ $diet->title }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center flex-column align-items-center mt-5">
                            <img src="{{ asset('frontend-section/images/no-data.png') }}" class="nodata-img">
                            <p class="font-p mt-4 mb-5 title-color">{{ __('message.no') . ' ' . __('message.diet') . ' ' . __('message.data') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

</x-frontend-layout>
