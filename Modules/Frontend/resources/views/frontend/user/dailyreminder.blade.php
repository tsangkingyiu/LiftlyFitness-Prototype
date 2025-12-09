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
                    <div class="card border-0">
                        <div class="card-body">
                            <h5 class="font-h5">{{ __('message.reminders') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-frontend-user>
