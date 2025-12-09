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
                            <h5 class="font-h5 mb-4">{{ __('frontend::message.metrics_settings') }}</h5>
                            @foreach($data as $key => $val)
                                <div class="switch-container">
                                    <h6 class="font-h6 metrics-heading mb-2 mt-1">{{ __('message.'.$key) }}</h6>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input metrics-check-input change_checked_status" name="{{ $key }}" data-name="{{ $key }}" data-id="{{ auth()->id() }}" type="checkbox" role="switch" id="{{ $key }}Switch" {{ $val == null || $val == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-user>
