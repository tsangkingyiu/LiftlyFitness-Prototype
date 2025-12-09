<div id="loading">
    @include('frontend::frontend.partials._body_loader')
</div>
@include('frontend::frontend.partials._body_header')

<div id="remoteModelData" class="modal fade" role="dialog"></div>
<div class="content-page">

    {{-- <div class="card join-for-free d-none position-absolute start-50 end-0" id="show">
        <div class="card-body">
            <h4 class="font-h4 text-white">JOIN FOR FREE!</h4>
            <p class="join-free-p">Join for free and start building and tracking your workouts. Get support from other Fitness Blender members and more!</p>
            <a href="#" class="btn btn-join my-2 text-white w-100">Join</a>
            <a href="#" class="btn btn-signin my-2 text-white w-100">Sign in</a>
        </div>
    </div> --}}
    
    {{-- <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body p-0 position-relative">
                    <div class="position-relative">
                        <img src="{{ asset('frontend-section/images/popup.png') }}" class="position-absolute w-100 h-100 d-none d-md-block popup-img">
                        <div class="row g-0 position-relative trial-card">
                            <div class="col-md-9 col-lg-7 d-flex align-items-center">
                                <div class="p-5">
                                    <h3 class="font-h3 mb-3">14 Days FREE...!!!</h3>
                                    <p class="font-p">
                                        Experience the full potential of our fitness platform with a free trial. Discover the
                                        features, try workouts, and see how our tools can help you achieve your fitness
                                        goals.
                                    </p>
                                    <div class="mt-4 d-flex flex-wrap justify-content-start">
                                        <a href="#" class="btn explore-btn me-3 mb-2">Explore More Plans 
                                            <img src="{{ asset('frontend-section/images/dark-arrow.png') }}" class="ms-2" width="12px">
                                        </a>
                                        <a href="#" class="btn free-trial text-white mb-2">Start Free Trial 
                                            <img src="{{ asset('frontend-section/images/arrow.png') }}" class="ms-2" width="12px">
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-4 position-relative d-none d-lg-block">
                                <img src="{{ asset('frontend-section/images/girl-busy-in-phone.png') }}" class="img-fluid h-100 w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{ $slot }}
</div>

@include('frontend::frontend.partials._body_footer')
@include('frontend::frontend.partials._scripts')
