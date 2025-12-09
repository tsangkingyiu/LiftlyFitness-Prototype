<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative pe-0 ps-0 search-section">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 banner-frame">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                <h4 class="mb-4">{{ __('frontend::message.blogs') }}</h4>
                <div class="input-group search-group mx-auto position-relative">
                    <form action="{{ route('search') }}" method="GET" class="d-flex w-100">
                        <input type="hidden" name="section" value="{{ $section }}">
                        <input type="text" class="form-control search-form" name="query" value="{{ request()->query('query') }}" placeholder="{{ __('frontend::message.search_blog') }}" id="search-query" autocomplete="off">
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
        <section class="pt-4 pb-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-h6 mb-4">{{ __('frontend::message.recent_blogs') }}</h6>
                            @if (count($data['latest_blog']) > 0)
                                <a href="{{ route('recent.blog') }}" class="text-decoration-none">
                                    <span class="font-span mb-4 see-all">{{ __('message.see_all') }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row blog">
                    <div id="blog-slider" class="owl-carousel mb-3 search-data-list">
                        @if(!empty($data['latest_blog']) && $data['latest_blog']->isNotEmpty())
                            @foreach ($data['latest_blog'] as $blog)
                                <a href="{{ route('blog.details', $blog->slug) }}">
                                    <img src="{{ getSingleMediaSettingImage($blog->id ? $blog : null, 'post_image') }}" class="img-fluid w-100 blog-image">
                                <div class="position-absolute top-0 start-0 m-3 blog-time d-flex align-items-center">
                                    <svg class="me-2" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12.5" cy="12.1057" r="10" stroke="white" stroke-width="1.8"/>
                                        <path d="M12.5 8.10571V12.1057L15 14.6057" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="text-white">{{ dateAgoFormate($blog->datetime ?? $blog->created_at) }}</span>
                                </div>
                                <div class="position-absolute bottom-0 start-0 m-3 m-md-5 blog-heading text-white">
                                    <h4 class="font-h4 mb-0">{{ $blog->title }}</h4>
                                </div>
                            </a>
                            @endforeach
                        @else
                            <p class="text-muted">{{ __('frontend::message.no_latest_blog_available_at_moment') }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-h6 mt-3">{{ __('frontend::message.trending_blogs') }}</h6>
                            @if(count($data['blog']) > 0)
                                <a href="{{ route('trending.blog.list') }}" class="text-decoration-none mt-3">
                                    <span class="font-span mb-4 see-all">{{ __('message.see_all') }}</span>
                                </a>
                            @endif
                        </div>
                        <hr class="hr">
                    </div>
                </div>
                <div class="row">
                    @foreach ($data['blog']->isNotEmpty() ? $data['blog'] : [(object) ['id' => '', 'title' => $data['dummy_title'],'created_at' => 'N/A', 'category_ids' => []]] as $blog)
                        <div class="col-lg-6">
                            <a href="{{ $blog->id != null ? route('blog.details',$blog->slug) : 'javascript:void(0)' }}" class="text-decoration-none">
                                <div class="card blog-card mb-3 border-0 p-3">
                                    <div class="row">
                                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                                            <img src="{{ getSingleMediaSettingImage($blog->id != null ? $blog : null,'post_image') }}" class="img-fluid post-img">
                                        </div>
                
                                        <div class="col-md-8">
                                            <div class="pt-1">
                                                <h6 class="font-h6 title-color pe-4">{{ $blog->title }}</h6>
                                                <div class="d-flex flex-wrap align-items-center blog-card-time justify-content-lg-between">
                                                    <span class="">
                                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="12" cy="12.2109" r="10" stroke="#8A8A8A" stroke-width="2.25"/>
                                                            <path d="M12 8.21094V12.2109L14.5 14.7109" stroke="#8A8A8A" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                        {{ date('d M, Y', strtotime($blog->datetime ?? $blog->created_at)) }}
                                                    </span>
                                                </div>
                                                <span class="">
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
            </div>
        </section>
    </main>

</x-frontend-layout>
