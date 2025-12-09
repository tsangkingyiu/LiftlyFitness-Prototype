<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative ps-0 pe-0">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 detail-frame">
            <div class="container">
                <div class="d-flex align-items-center position-absolute top-0 bottom-0 banner-content ps-sm-0 ps-3">
                    <div>
                        <a href="{{ route('blog') }}" class="text-decoration-none">{{ __('frontend::message.blog') }}</a> 
                        <span> / {{ __('frontend::message.detail') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="blog-detail pt-4">
            <div class="container">
                <div class="row">
                    @if(!empty($data['blog_detail']))
                        <h5 class="font-h5 mb-1 title-color">{{ $data['blog_detail']->title }}</h5>
                        <div class="col-12 blog-card-time mb-2">
                            <span>
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12.2109" r="10" stroke="#8A8A8A" stroke-width="2.25"></circle>
                                    <path d="M12 8.21094V12.2109L14.5 14.7109" stroke="#8A8A8A" stroke-width="2.25"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                {{ date('d M, Y', strtotime($data['blog_detail']->datetime ?? $data['blog_detail']->created_at )) }}
                            </span>
                        </div>
                        <hr class="hr">
    
                        <div class="col-md-8 mb-5">
                            <img src="{{ getSingleMediaSettingImage($data['blog_detail']['id'] != null ? $data['blog_detail'] : null,'post_image') }}" class="w-100 blog-img">
                            <div class="d-flex mt-3">
                                <p>{{ __('frontend::message.categories') }}</p>
                                <p>
                                    <ul class="mb-3 d-flex flex-wrap blog-cat">
                                        @foreach ($data['blog_detail']->category_titles as $title)    
                                                <li class="me-2">{{ $title }}</li>
                                        @endforeach
                                    </ul>
                                </p>
                            </div>
                            <div class="mt-3">
                                {!! $data['blog_detail']['description'] !!}    
                            </div>
                            <div class="mt-3">
                                @foreach ($data['blog_detail']->tags as $value)    
                                    <span class="hash-btn btn text-decoration-none me-2 mb-1">{{ $value }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="col-md-4">
                        <div class="related-blogs">
                            <div class="d-flex align-items-center">
                                <h6 class="font-h6 title-color mb-0">{{ __('frontend::message.related_blogs') }}</h6>
                            </div>
                        </div>
                        <div class="mb-3 border-0 pt-3 related-blog">
                            @foreach ($data['related_blog']->isNotEmpty() ? $data['related_blog'] : [(object) ['id' => '', 'title' => $data['dummy_title'], 'created_at' => 'N/A', 'category_ids' => []]] as $related_blog)
                                <div class="card blog-card mt-2 mb-3 border-0 p-2">
                                    <a href="{{ route('blog.details', $related_blog->slug) }}" class="text-decoration-none">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-12 col-lg-3 mb-3 mb-lg-0 text-center">
                                                <img src="{{ getSingleMediaSettingImage($related_blog->id != null ? $related_blog : null, 'post_image') }}" class="img-fluid w-100" alt="Related Blog">
                                            </div>
                                            <div class="col-12 col-lg-9">
                                                <div class="pt-1 ps-lg-3 related-content">
                                                    <h5 class="mb-2 related-blog-title title-color">{{ $related_blog->title }}</h5>
                                                    <div class="mb-2">
                                                        <span class="blog-card-time">  
                                                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <circle cx="12" cy="12.2109" r="10" stroke="#8A8A8A" stroke-width="2.25"/>
                                                                <path d="M12 8.21094V12.2109L14.5 14.7109" stroke="#8A8A8A" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                            {{ date('d M, Y', strtotime($related_blog->datetime ?? $related_blog->created_at )) }}
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
                </div>
            </div>
        </section>
    </main>

</x-frontend-layout>
