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
                            <h5 class="font-h5 mb-4">{{ $sub_type == 'assign-workout-diet' ? __('frontend::message.assigned_workout_diet') :  __('frontend::message.favorite') }}</h5>
                            <ul class="nav row" id="tab-text" role="tablist">
                                <li class="nav-item col-md-6" role="presentation">
                                    <a class="nav-link favourite-tab font-h6 text-center {{ $type == 'workouts' ? 'active' : '' }}" sub-type="{{ $sub_type }}" data-bs-toggle="tab" href="#workouts" data-type="workouts" role="tab" aria-selected="{{ $type == 'workouts' ? 'true' : 'false' }}">{{ __('frontend::message.workouts') }}</a>
                                </li>
                                <li class="nav-item col-md-6" role="presentation">
                                    <a class="nav-link favourite-tab font-h6 text-center {{ $type == 'diets' ? 'active' : '' }}" sub-type="{{ $sub_type }}" data-bs-toggle="tab" href="#diets" data-type="diets" role="tab" aria-selected="{{ $type == 'diets' ? 'true' : 'false' }}">{{ __('frontend::message.diets') }}</a>
                                </li>
                            </ul>
        
                            <div class="tab-content">
                                <div id="workouts" class="tab-pane fade {{ $type == 'workouts' ? 'show active' : '' }}" role="tabpanel">
                                    <div class="row" id="workouts-favourite-data"></div>
                                </div>
        
                                <div id="diets" class="tab-pane fade {{ $type == 'diets' ? 'show active' : '' }}" role="tabpanel">
                                    <div class="row" id="diets-favourite-data">
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
    $(document).ready(function () {

            getfavoriteList('workouts','','{{ $sub_type}}');
            $(document).on('click', '.favourite-tab', function () {
                let type = $(this).data('type');
                let sub_type = $(this).attr('sub-type');
                getfavoriteList(type,'',sub_type);
            });

            function getfavoriteList(type,favourite_id,sub_type) {
                $.ajax({
                    url: "{{ route('favourite.list') }}",
                    type: 'GET',
                    data: {
                        'type': type,
                        'favourite_id': favourite_id,
                        'sub_type': sub_type
                    },
                    dataType: 'json',
                    success: function (response) {
                        if(response.status) {
                            $('#' + type + '-favourite-data').html(response.data);
                        }

                        if(response.message) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                        }
                    }
                });
            }

            $(document).on('click', '.toggle-favorites', function () {
                var id = $(this).data('id');
                var type = $(this).data('type');
                let sub_type = $(this).attr('sub-type');
                getfavoriteList(type,id,sub_type);
            });
        });
    </script>
@endsection

</x-frontend-user>



