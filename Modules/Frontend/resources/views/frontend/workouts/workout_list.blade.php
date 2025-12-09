<section class="pt-3">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12 mb-3">
                <div class="d-flex flex-wrap align-items-center">
                    <a href="javascript:void(0)" class="btn btn-custom filter-btn {{ $data['filter_type'] == 'all' ? 'active' : '' }}" filter-type="all">{{ __('frontend::message.all') }}</a>
                    @if($data['data_key'] == 'workout')
                        <a href="javascript:void(0)" class="btn btn-custom filter-btn {{ $data['filter_type'] == 'workout_type' ? 'active' : '' }}" filter-type="workout_type">{{ __('message.workouttype') }}</a>
                    @endif

                    @if($data['data_key'] == 'exercise')
                        <a href="javascript:void(0)" class="btn btn-custom filter-btn {{ $data['filter_type'] == 'equipment' ? 'active' : '' }}" filter-type="equipment">{{ __('frontend::message.equipments') }}</a>
                    @endif
                    <a href="javascript:void(0)" class="btn btn-custom filter-btn {{ $data['filter_type'] == 'level' ? 'active' : '' }}" filter-type="level">{{ __('frontend::message.workout_levels') }}</a>
                </div>
            </div>

            @if (in_array($data['filter_type'],['workout_type','level','equipment']))
                <div class="col-12 col-lg-12 tab_dynamic_container" id="{{ $data['filter_type'] }}_container">
                    <div class="d-flex flex-wrap align-items-center">
                        @foreach ($data[$data['filter_type']] as $value)
                            <div class="form-check me-3">
                                <input class="form-check-input check-form" type="checkbox" id="{{ $value->id }}" 
                                {{ in_array($value->id,$data[$data['filter_type'].'_ids']) ? 'checked' : '' }}>
                                <label class="form-check-label check-label" for="{{ $value->id }}">{{ $value->title }}</label>
                            </div>
                        @endforeach
                        <button type="button" class="btn btn-select-all select-clear-all-btn  ms-auto" selected-type="{{ $data['selected_type'] }}" filter-checked-type="{{ $data['filter_type'] }}">{{ __('frontend::message.'.$data['selected_type']) }}</button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<section class="workout-slider mt-4">
    <div class="container">
        <hr class="hr {{ $data['data_key'] == 'exercise' ? 'd-none' : '' }}">
        <div class="row" id="{{ $data['data_key'] }}_pagination">
            @if(in_array($data['data_key'] ,['workout','exercise']))
                @include('frontend::frontend/ajaxloadmore', ['type' => $data['data_key'].'_pagination' , 'data' => $data])
            @endif
        </div>
    </div>
    <div class="text-center">
        <button class="bg-transparent p-3 mb-5 load-more-btn" data-keys="{{ $data['data_key'] }}_pagination" id="dynamic-workout-data-load-btn">{{ __('frontend::message.load_more') }}</button>
    </div>
</section>

<section class="d-none dynamic-no-data-fount">
    <div class="container pricing pb-3">
        <div class="row card-section">
            <div class="d-flex justify-content-center flex-column align-items-center mt-5 pb-5">
                <img src="{{ asset('frontend-section/images/no-data.png') }}" class="nodata-img">
                <p class="font-p mt-4 mb-5">{{ __('message.not_found_entry',['name' => __('message.'.$data['data_key'])]) }}</p>
            </div>
        </div>
    </div>
</section>