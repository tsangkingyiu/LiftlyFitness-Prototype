<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('message.diet') }}</h4>
                <div class="input-group search-group mx-auto position-relative">
                    <form action="{{ route('search') }}" method="GET" class="d-flex w-100">
                        <input type="hidden" name="section" value="{{ $section }}">
                        <input type="text" class="form-control search-form" name="query" value="{{ request()->query('query') }}" placeholder="{{ __('frontend::message.search_diet') }}" id="search-query" autocomplete="off">
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
        <section class="diet pt-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-h6 mb-4">{{ __('frontend::message.diet_categories') }}</h6>
                            @if (count($data['category_diet']) > 0)
                                <a href="{{ route('diet.categories') }}" class="text-decoration-none"><span class="font-span mb-4 see-all">{{ __('message.see_all') }}</span></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="diet-slider" class="owl-carousel mb-3 search-data-list">
                        @foreach ($data['category_diet']->isNotEmpty() ? $data['category_diet'] : [(object) ['id' => '', 'title' => $data['dummy_title']]] as $diet_category )
                            <div class="card border-0 border-radius-12 m-2">
                                <div class="card-body main-card text-center p-0 pb-1">
                                    <a href="{{ $diet_category->id != null ? route('diet.categories.list', $diet_category->slug) : 'javascript:void(0)' }}" class="text-decoration-none">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ getSingleMediaSettingImage($diet_category->id != null ? $diet_category : null,'categorydiet_image') }}" class="img-fluid category-diet-img">
                                        </div>
                                        <span class="d-flex justify-content-center p-1 mt-2 title-color">{{ $diet_category->title }}</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="diet-categories">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-h6 mb-4">{{ __(key: 'frontend::message.dietary_options') }}</h6>
                            @if (count($data['diet']) > 0)
                                <a href="{{ route('diet.list') }}" class="text-decoration-none"><span class="font-span mb-4 see-all">{{ __('message.see_all') }}</span></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row pb-5">
                    @foreach ($data['diet']->isNotEmpty() ? $data['diet'] : [(object) ['id' => '','title' => $data['dummy_title'], 'is_premium' => 0]] as $diet)
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
                                        <button class="btn p-1 card-heart11 toggle-favorite" data-id="{{ $diet->id }}" data-type="diet" >
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
            </div>
        </section>
    </main>
</x-frontend-layout>
