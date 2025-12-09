 @switch($type)
     @case('workout-level')
        @foreach($data['level'] as $level)
            <div class="col-sm-6 col-md-4 col-lg-4 mb-4">
                <div class="card border-0">
                    <div class="workout-level-card p-0 position-relative">
                    <a href="{{ route('workout.level', $level->slug) }}">
                        <img src="{{ getSingleMediaSettingImage($level->id != null ? $level : null,'level_image') }}" class="w-100">
                    </a>
                    <div class="workout-level-card-text position-absolute">
                        <p class="card-text text-center text-white m-0">{{ $level->title }}</p>
                    </div>
                    </div>
                </div>
            </div>
        @endforeach
    @break
    @case('body-parts')
        @foreach($data['body_parts'] as $body_parts)
            <div class="col-6 col-md-3 col-lg-2 text-center mb-4">
                <a href="{{ route('bodypart.exercises.list', $body_parts->slug) }}"><img src="{{ getSingleMediaSettingImage($body_parts->id != null ? $body_parts : null ,'bodypart_image') }}" class="img-fluid"></a>
                <span class="d-flex justify-content-center mt-2">{{ $body_parts->title }}</span>
            </div>
        @endforeach
    @break
    @case('equipment-based-exercise')
        @foreach($data['equipment'] as $equipment)
            <div class="col-6 col-sm-6 col-md-4 col-lg-2 mb-3">
                <div>
                    <div class="card border-0 mt-2 border-radius-16">
                        <a href="{{ route('equipment.exercises.list', $equipment->slug) }}">
                            <img src="{{ getSingleMediaSettingImage($equipment->id != null ? $equipment : null,'equipment_image') }}" class="equipment-img">
                        </a>
                        <div class="card-img-overlay">
                            <p class="text-center">{{ $equipment->title }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @break
    @case('workout-section')
       @foreach($data['workout'] as $workout)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="pe-md-3">
                    <div class="card border-0 pb-4 position-relative">
                        <a href="{{ $workout->id == null ? 'javascript:void(0)' : (checkPremium($workout, auth()->user()) ? route('pricing-plan') : route('workout.detail', $workout->slug)) }}">
                            <img src="{{ getSingleMediaSettingImage($workout->id != null ? $workout : null,'workout_image') }}" class="img-fluid w-100">
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
                                <button class="btn p-1 card-heart1 toggle-favorite" data-id="{{ $workout->id }}" data-type="workout">
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
                        <div class="card-body ps-0">
                            <p class="mb-2">{{ $workout->title }}</p>
                            @if ($workout->id != null)
                                <div class="d-flex justify-content-between">
                                    <span>{{ optional($workout->workouttype)->title ?? '' }}</span>
                                    <span>{{ optional($workout->level)->title ?? '' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @break
    @case('diet-categories')
        @foreach ($data['category_diet'] as $diet_category)
            <div class="col-12 col-md-3 col-lg-2 mb-4">
                <div class="card border-0 border-radius-12">
                    <div class="card-body main-card text-center p-0 pb-2 border-radius-12">
                        <a href="{{ route('diet.categories.list', $diet_category->slug) }}" class="text-decoration-none">
                            <img src="{{ getSingleMediaSettingImage($diet_category->id != null ? $diet_category : null, 'categorydiet_image') }}" class="img-fluid w-100">
                            <span class="d-flex justify-content-center mt-3 title-color">{{ $diet_category->title }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @break
    @case('dietary-options')
        @foreach ($data['diet'] as $diet)       
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
                        <p class="card-text text-truncate">{{ $diet->title }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @break
    @case('product-categories')
        @foreach ($data['product_category'] as $product_category)
            <div class="col-12 col-md-3 col-lg-2 mb-4">
                <div class="card border-0 border-radius-12">
                    <div class="card-body main-card text-center p-0 pb-2">
                        <a href="{{ route('product.categories.list', $product_category->slug) }}" class="text-decoration-none">
                            <img src="{{  getSingleMediaSettingImage($product_category->id != null ? $product_category : null,'productcategory_image') }}" class="img-fluid w-100">
                            <span class="d-flex justify-content-center mt-2 title-color">{{ $product_category->title }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @break
    @case('product-accessories')
        @foreach ($data['product'] as $product)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                <div class="card border-0 border-radius-16">
                    <a href="{{ route('product.details', $product->slug) }}" class="text-decoration-none">
                        <img src="{{ getSingleMediaSettingImage($product->id != null ? $product : null,'product_image') }} " class="product_image img-fluid">
                    </a>
                    <div class="card-body border-radius-16">
                    <p class="card-text title-color text-center text-truncate">{{ $product->title }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @break
    @case('recent-blog')
        @foreach ($data['recent_blog'] as $recent_blog)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card border-0 position-relative border-radius-12">
                    <img src="{{ getSingleMediaSettingImage($recent_blog->id != null ? $recent_blog : null,'post_image')  }}" class="card-img-top">
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="mb-2"> 
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12.2109" r="10" stroke="#8A8A8A" stroke-width="2.25"/>
                                    <path d="M12 8.21094V12.2109L14.5 14.7109" stroke="#8A8A8A" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                {{ date('d M, Y', strtotime($recent_blog->datetime ?? $recent_blog->created_at)) }}
                            </span>
                        </div>
                        <p class="mb-1">{{ $recent_blog->title }}</p>
                        <div class="read-more">
                            <a href="{{ route('blog.details', $recent_blog->slug) }}" class="text-decoration-none">
                                <span class="font-span me-2">{{ __('frontend::message.read_more') }}</span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 5L15 12L9 19" stroke="var(--site-color)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @break
    @case('trending-blog')
        @foreach ($data['trending_blog'] as $trending_blog)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card border-0 position-relative border-radius-12">
                    <img src="{{ getSingleMediaSettingImage($trending_blog->id != null ? $trending_blog : null,'post_image') }}" class="trending-blog-img">
                    <div class="card-body">
                            <div class="mb-2">
                                <span class="mb-2"> 
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.2109" r="10" stroke="#8A8A8A" stroke-width="2.25"/>
                                        <path d="M12 8.21094V12.2109L14.5 14.7109" stroke="#8A8A8A" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    {{ date('d M, Y', strtotime($trending_blog->datetime ?? $trending_blog->created_at)) }}
                                </span>
                            </div>
                        <p class="mb-1">{{ $trending_blog->title }}</p>
                        <div class="read-more">
                            <a href="{{ route('blog.details', $trending_blog->slug) }}" class="text-decoration-none">
                                <span class="font-span me-2">{{ __('frontend::message.read_more') }}</span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 5L15 12L9 19" stroke="var(--site-color)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @break
    @case('workout_pagination')
        @foreach($data['workout'] as $workout)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card border-0 position-relative border-radius-12">
                    <a href="{{ $workout->id == null ? 'javascript:void(0)' : (checkPremium($workout, auth()->user()) ? route('pricing-plan') : route('workout.detail', $workout->slug)) }}">
                        <img src="{{ getSingleMediaSettingImage($workout->id != null ? $workout : null,'workout_image') }}" class="img-fluid w-100">
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
                            <button class="btn p-1 card-heart1 toggle-favorite" data-id="{{ $workout->id }}" data-type="workout">
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
                        <p class="mb-2 text-truncate">{{ $workout->title }}</p>
                        @if ($workout->id != null)
                            <div class="d-flex justify-content-between">
                                <span class="text-truncate mw-50">{{ optional($workout->workouttype)->title ?? '' }}</span>
                                <span class="text-truncate mw-45">{{ optional($workout->level)->title ?? '' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @break
    @case('exercise_pagination')
        @foreach($data['exercise'] as $exercise)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-2 search-data-list">
                <div class="card border-0 border-radius-12 mb-4">
                    <a href="{{ $exercise->id == null ? 'javascript:void(0)' : (checkPremium($exercise, auth()->user()) ? route('pricing-plan') : route('bodypart.exercises.detail', $exercise->slug)) }}">
                        <img src="{{ getSingleMediaSettingImage($exercise->id != null ? $exercise : null ,'exercise_image') }}" class="">
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
    @break
     @default
         
 @endswitch
 