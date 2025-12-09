<x-frontend-layout :assets="$assets ?? []">

    <section>
        <div class="container-fluid position-relative ps-0 pe-0">
            <img id="bannerImage" src="{{ asset('frontend-section/images/banner-frame.png') }}" class="w-100 detail-frame">
            <div class="container">
                <div class="d-flex align-items-center position-absolute top-0 bottom-0 banner-content ps-sm-0 ps-3">
                    <div>
                        <a href="{{ route('blog') }}" class="text-decoration-none">{{ __('frontend::message.blog') }}</a>
                        <span> / {{ __('frontend::message.recent_blogs') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="section-color">
        <section class="recent-blog" id="recent-blog-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-h6 mb-4 mt-4">{{ __('frontend::message.recent_blogs') }}</h6>
                        </div>
                    </div>
                </div>
                <div class="row" id="load_more" data-route={{ route('recent.blog') }}>
                    @foreach ($data['recent_blog']->isNotEmpty() ? $data['recent_blog'] : [(object) ['id' => '', 'title' => $data['dummy_title'], 'created_at' => 'N/A', 'category_ids' => []]] as $recent_blog)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card border-0 position-relative border-radius-12">
                                <img src="{{ getSingleMediaSettingImage($recent_blog->id != null ? $recent_blog : null, 'post_image') }}"
                                    class="card-img-top">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <span class="mb-2">
                                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="12.2109" r="10" stroke="#8A8A8A"
                                                    stroke-width="2.25" />
                                                <path d="M12 8.21094V12.2109L14.5 14.7109" stroke="#8A8A8A"
                                                    stroke-width="2.25" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            {{ date('d M, Y', strtotime($recent_blog->datetime ?? $recent_blog->created_at)) }}
                                        </span>
                                    </div>
                                    <p class="mb-1">{{ $recent_blog->title }}</p>
                                    <div class="read-more">
                                        <a href="{{ route('blog.details', $recent_blog->slug) }}"
                                            class="text-decoration-none">
                                            <span class="font-span me-2">{{ __('frontend::message.read_more') }}</span>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 5L15 12L9 19" stroke="var(--site-color)" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    @if ($data['hasData'])
                        <button class="bg-transparent mb-5 load-more-btn" id="load_more_button">{{ __('frontend::message.load_more') }}</button>
                    @endif
                </div>
            </div>
        </section>
    </main>

</x-frontend-layout>
