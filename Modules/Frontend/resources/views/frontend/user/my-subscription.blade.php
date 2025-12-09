<x-frontend-user :assets="$assets ?? []">

    <div class="container-fluid pt-4 pb-4 section-color ">
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
                            <h5 class="font-h5 mb-4">{{ __('frontend::message.my_subscription') }}</h5>
                            <ul class="nav nav-payment-tabs row" id="tab-text" role="tablist">
                                <li class="nav-item col-md-6" role="presentation">
                                    <a class="nav-link favourite-tab font-h6 text-center {{ $type == 'active' ? 'active' : '' }}" data-bs-toggle="tab" href="#active" data-type="active" role="tab" aria-selected="{{ $type == 'active' ? 'true' : 'false' }}">{{ __('message.active') }}</a>
                                </li>
                                <li class="nav-item col-md-6" role="presentation">
                                    <a class="nav-link favourite-tab font-h6 text-center {{ $type == 'history' ? 'active' : '' }}" data-bs-toggle="tab" href="#history" data-type="history" role="tab" aria-selected="{{ $type == 'history' ? 'true' : 'false' }}">{{ __('frontend::message.history') }}</a>
                                </li>
                            </ul>
        
                            <div class="tab-content">
                                <div id="active" class="tab-pane fade {{ $type == 'active' ? 'show active' : '' }}" role="tabpanel">
                                    <div class="row pt-5 payment-history">
                                        @if (count($active_subscription) > 0) 
                                            @foreach ($active_subscription as $subscription)
                                                <div class="card border-0 subscription-card">
                                                    <div class="card-body subscription-active mb-3">
                                                        <div>
                                                            <div class="d-flex justify-content-between">
                                                                <p class="total-month title-color">{{ optional($subscription->package)->name }}</p>
                                                                <p class="total-amount">{{ getPriceFormat($subscription->total_amount) }}</p>
                                                            </div>
                                                            <p class="payment-date"> {{ date('jS M Y', strtotime($subscription->subscription_start_date)) }} to {{ date('jS M Y', strtotime($subscription->subscription_end_date)) }}</p>
                                                            <span class="payment-desc">{!! optional($subscription->package)->description !!}</span>
                                                            <div class="d-flex justify-content-between">
                                                                @if (isset($subscription->payment_type))
                                                                    <ul class="payment-type mb-0 ms-1">
                                                                        <li>{{ $subscription->payment_type }}</li>
                                                                    </ul>
                                                                @else
                                                                    <div class=""></div>
                                                                @endif
                                                                <p class="mb-0 subscription-status-active">{{ ucfirst($subscription->status) }}</p>
                                                            </div>
                                                            <hr>
                                                            <div class="mt-4 mb-2 text-center">
                                                                <button class="cancle-subscription-btn text-white border-0 p-2" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $subscription->id }}">Cancel Subscription</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="cancelModal{{ $subscription->id }}" aria-labelledby="cancelModalLabel{{ $subscription->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content w-75 mx-auto border-radius-20">
                                                            <div class="modal-body text-center">
                                                                <h5 class="my-3">{{ __('frontend::message.cancel_subscription') }}</h5>
                                                                <form action="{{ route('cancel.subscription') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{ $subscription->id }}">
                                                                    <div class="d-flex justify-content-between gap-2">
                                                                        <button type="button" class="bg-white w-100 p-2 cancel-no-btn" data-bs-dismiss="modal" aria-label="Close">{{ __('message.no') }}</button>
                                                                        <button type="submit" class="text-white w-100 p-2 cancel-yes-btn text-decoration-none">{{ __('message.yes') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="d-flex justify-content-center flex-column align-items-center mt-5">
                                                <img src="{{ asset('frontend-section/images/no-data.png') }}" class="nodata-img">
                                                <p class="font-p mt-4 mb-5">{{ __('frontend::message.subscription_plans') }}</p>
                                                <a href="{{ route('pricing-plan') }}" class="btn view-plan-btn text-white mb-5 w-100">{{ __('frontend::message.view_plans') }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="modal fade" id="cancleModal" aria-labelledby="cancleModalLabel" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content w-75 mx-auto border-radius-20">
                                            <div class="modal-body text-center">
                                                <h5 class="my-3">{{ __('message.cancel_subscription') }}</h5>
                                                <div class="d-flex justify-content-between gap-2">
                                                    <button class="bg-white w-100 p-2 cancel-no-btn" data-bs-dismiss="modal" aria-label="Close">{{ __('message.no') }}</button>
                                                    <a href="{{ route('cancel.subscription') }}" class="text-white w-100 p-2 cancel-yes-btn text-decoration-none">{{ __('message.yes') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div id="history" class="tab-pane fade {{ $type == 'history' ? 'show active' : '' }}" role="tabpanel">
                                    <div class="row pt-5 payment-history">
                                        @if (count($subscription_list) > 0) 
                                            @foreach ($subscription_list as $subscription)
                                                <div class="card border-0 subscription-card">
                                                    <div class="card-body {{ $subscription->status == 'active' ? 'subscription-active' : 'subscription-inactive' }} mb-3">
                                                        <div>
                                                            <div class="d-flex justify-content-between">
                                                                <p class="total-month title-color">{{ optional($subscription->package)->name }}</p>
                                                                <p class="total-amount">{{ getPriceFormat($subscription->total_amount) }}</p>
                                                            </div>
                                                            <p class="payment-date"> {{ date('jS M Y', strtotime($subscription->subscription_start_date)) }} to {{ date('jS M Y', strtotime($subscription->subscription_end_date)) }}</p>
                                                            <span class="payment-desc">{!! optional($subscription->package)->description !!}</span>
                                                            <div class="d-flex justify-content-between">
                                                                @if (isset($subscription->payment_type))
                                                                    <ul class="payment-type mb-0 ms-1">
                                                                        <li>{{ $subscription->payment_type }}</li>
                                                                    </ul>
                                                                @else
                                                                    <div></div>
                                                                @endif
                                                                <p class="mb-0 {{ $subscription->status == 'active' ? 'subscription-status-active' : 'subscription-status-inactive' }}">{{ ucfirst($subscription->status) }}</p>
                                                            </div>                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="d-flex justify-content-center flex-column align-items-center mt-5">
                                                <img src="{{ asset('frontend-section/images/no-data.png') }}" class="nodata-img">
                                                <p class="font-p mt-4 mb-5">{{ __('frontend::message.subscription_plans') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('bottom_script')
        <script>
            $(document).on('show.bs.modal', '.modal', function () {
                $('.navbar').css('z-index', '1');
            });

            $(document).on('hidden.bs.modal', '.modal', function () {
                $('.navbar').css('z-index', '1050');
            });
        </script>
    @endsection
</x-frontend-user>
