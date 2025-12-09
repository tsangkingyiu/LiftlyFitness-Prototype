<x-frontend-user :assets="$assets ?? []">

    <div class="container-fluid pt-4 pb-4 section-color">
        <div class="container pb-5">
            <div class="row">
                <div class="col-md-3 side-bar">
                    <div class="card border-0">
                        @include('frontend::frontend.partials._body_sidebar')
                    </div>
                </div>
                <div class="col-lg-9 col-12">
                    <div class="card text-center p-4 border-0 logout-card">
                        <div class="card-body">
                            <img src="{{ asset('frontend-section/images/logout.png') }}" alt="Delete Icon"
                                width="70" height="70">
                            <p class="mt-3 mb-4">{{ __('frontend::message.logout_account') }}</p>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="javascript:void(0)" class="logout-btn text-white text-decoration-none"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('message.logout') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-frontend-user>
