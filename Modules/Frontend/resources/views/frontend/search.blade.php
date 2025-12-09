<x-frontend-layout :assets="$assets ?? []">
    
    <main class="section-color">
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('frontend::message.' .$section) }}</h4>
                <div class="input-group search-group mx-auto">
                    <form action="{{ route('search') }}" method="GET" class="d-flex w-100">
                        <input type="hidden" name="section" value="{{ $section }}">
                        <input type="text" class="form-control search-form" name="query" value="{{ request()->query('query') }}" placeholder="{{ __('frontend::message.search_' . $section) }}" id="search-query" autocomplete="off">
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
                <div class="position-absolute pb-3 banner-content breadcrumbs">
                    @switch($section)
                        @case('exercise')
                            <a href="{{ route('workouts') }}" class="text-decoration-none">{{ __('message.workout') }}</a><span> / {{ __('message.' .$section) }}</span>
                            @break
                        @case('diet')
                            <a href="{{ route('diet') }}" class="text-decoration-none">{{ __('message.diet') }}</a>
                            @break
                        @case('blog')
                            <a href="{{ route('blog') }}" class="text-decoration-none">{{ __('frontend::message.blog') }}</a>
                            @break
                        @case('product')
                            <a href="{{ route('products') }}" class="text-decoration-none">{{ __('message.product') }}</a>
                            @break
                        @case('bodypart_exercise')
                        @case('equipment_exercise')
                        @case('exercise_level')
                            <a href="{{ route('workouts') }}" class="text-decoration-none">{{ __('frontend::message.home') }}</a><span> / {{ __('frontend::message.' .$section) }}</span>
                            @break
                        @default
                    @endswitch
                </div>
            </div>
        </div>
        
        <div class="container">
            @if ($results->isEmpty())
                <div class="d-flex justify-content-center flex-column align-items-center mt-5 pb-5">
                    <img src="{{ asset('frontend-section/images/no-data.png') }}" class="nodata-img">
                    <p class="font-p mt-4 mb-5">{{ __('message.not_found_entry',['name' => __('frontend::message.' .$section)]) }}</p>
                </div>
            @else
                @switch($section)
                    @case('exercise')
                        <div id="get-dynamic-data-list" data-type-key="exercise">
    
                        </div>
                        @break 
                    @case('diet')
                        <div class="row pb-5 diet-categories mt-5">
                            @foreach ($results as $diet)
                                <div class="col-sm-6 col-md-4 col-lg-3 suggestion-index search-data-list mb-4">
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
                                            </a>
                                        <div class="card-body">
                                            <p class="card-text text-truncate">{{ $diet->title }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @break
                    @case('blog')
                        <div class="row mt-5 pb-5">
                            @foreach ($results as $blog)
                                <div class="col-lg-6 suggestion-index search-data-list">
                                    <a href="{{ $blog->id != null ? route('blog.details', $blog->slug) : 'javascript:void(0)' }}" class="text-decoration-none">
                                        <div class="card blog-card mb-3 border-0 p-3">
                                            <div class="row">
                                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                                    <img src="{{ getSingleMediaSettingImage($blog->id != null ? $blog : null,'post_image') }}" class="img-fluid post-img">
                                                </div>  
                                                <div class="col-md-8">
                                                    <div class="pt-1">
                                                        <h6 class="font-h6 title-color pe-4">{{ $blog->title }}</h6>
                                                        <div class="d-flex flex-wrap align-items-center blog-card-time justify-content-lg-between">
                                                            <span>
                                                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <circle cx="12" cy="12.2109" r="10" stroke="#8A8A8A" stroke-width="2.25"/>
                                                                    <path d="M12 8.21094V12.2109L14.5 14.7109" stroke="#8A8A8A" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                                {{ date('d M, Y', strtotime($blog->datetime ?? $blog->created_at)) }}
                                                            </span>
                                                        </div>
                                                        <span>
                                                            <ul class="mb-0 d-flex flex-wrap p-0 mt-2 trending-category">
                                                                @if(isset($blog->category_titles) && $blog->category_titles->isNotEmpty())
                                                                    @foreach ($blog->category_titles as $category_title )
                                                                        <li class="me-2">{{ $category_title }}</li>
                                                                    @endforeach
                                                                @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @break
                    @case('product')
                        <div class="row mt-5 pb-5">
                            @foreach ($results as $product)
                                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 search-data-list">
                                    <div class="card border-0 border-radius-16">
                                        <a href="{{ $product->id != null ? route('product.details', $product->slug) : 'javascript:void(0)' }}" class="text-decoratio-none">
                                            <img src="{{ getSingleMediaSettingImage($product->id != null ? $product : null,'product_image') }} " class="product_image img-fluid">
                                        </a>
                                        <div class="card-body border-radius-16">
                                        <p class="card-text text-truncate">{{ $product->title }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @break
                    @case('bodypart_exercise')
                    @case('equipment_exercise')
                    @case('exercise_level')
                        <div class="row pb-5 mt-5 exercises-list">
                            @foreach($results as $exercise)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card border-0 border-radius-12">
                                        <a href="{{ $exercise->id == null ? 'javascript:void(0)' : (checkPremium($exercise, auth()->user()) ? route('pricing-plan') : route('bodypart.exercises.detail', $exercise->slug)) }}">
                                            <img src="{{ getSingleMediaSettingImage($exercise->id != null ? $exercise : null,'exercise_image') }}">
                                            <div class="position-absolute top-0 start-0 m-3">
                                                @if(SettingData('subscription', 'subscription_system') == 1 && $exercise->is_premium == 1)
                                                    <span class="badge bg-badge-orange text-white">
                                                        {{ __('frontend::message.pro') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </a>
                                        <div class="card-body">
                                            <p class="mb-2">{{ $exercise->title }}</p>
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
                        </div>
                    @break
                    @default
                @endswitch
            @endif
        </div>
    </main>

</x-frontend-layout>
