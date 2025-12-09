@push('scripts')
    <script>
        function getAssignList(type = ''){
            url = "{{ route('get.frontend.data') }}";
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    'type': "{{ $type }}",
                },
                success: function(res){
                    if (!['client-testimonial'].includes(res.type)) {
                        if (res.count_data >= 3 ) {                                                
                            $('#'+type+'-section-btn').hide();
                        }else{
                            $('#'+type+'-section-btn').show();
                        }
                    }
                    $('#'+type+'-section-data').html(res.data);
                }
            });
        }
        $(document).ready(function () {
            getAssignList('{{$type}}');
        });
    </script>
@endpush
<x-app-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3">
                            <h5 class="font-weight-bold">{{ $pageTitle }}</h5>
                            @if(in_array($type,['ultimate-workout','fitness-product','client-testimonial','walkthrough']))
                                <a href="#" class="float-end btn btn-sm btn-primary" data-modal-form="form" data-size="lg"
                                data--href="{{ route('frontend.website.form', ['type' => 'section','sub_type' => $type ,'frontend_id' => '']) }}"
                                data-app-title="{{ __('frontend::message.add_form_title',['form' => $pageTitle ]) }}"
                                id="{{ $type }}-section-btn"
                                data-placement="top">{{ __('frontend::message.add_form_title',['form' => $pageTitle ]) }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(!in_array($type,['walkthrough']))
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{ html()->form('POST', route('frontend.website.information.update',  $type))->attribute('enctype', 'multipart/form-data')->attribute('data-toggle', 'validator')->open() }}
                                <div class="row">
                                    @foreach($data as $key => $value)
                                        @if( in_array($key, ['app_name', 'title','subtitle','playstore_url','appstore_url','trustpilot_url'] ))
                                            <div class="col-md-6 form-group">
                                                {{ html()->label(__('frontend::message.'.$key), $key)->class('form-control-label mb-1') }}
                                                {{ html()->text($key, $value ?? null)->placeholder(__('frontend::message.'.$key))->class('form-control') }}
                                            </div>
                                        @elseif (in_array($key,['description']))
                                            <div class="col-md-6 form-group">
                                                {{ html()->label(__('frontend::message.'.$key), $key)->class('form-control-label mb-1') }}
                                                {{ html()->textarea($key, $value ?? null)->class('form-control textarea')->rows(3)->placeholder(__('frontend::message.'.$key)) }}
                                            </div>
                                        @elseif (in_array($key,['playstore_totalreview','appstore_totalreview','playstore_review','appstore_review','trustpilot_review','trustpilot_totalreview']))
                                            <div class="col-md-6 form-group">
                                                {{ html()->label(__('frontend::message.'.$key), $key)->class('form-control-label mb-1') }}
                                                {{ html()->number($key, $value ?? null)->class('form-control')->placeholder(__('frontend::message.'.$key))->attribute('min',0)->attribute('step','any') }}
                                            
                                                @if(in_array($key, ['appstore_review','trustpilot_review','playstore_review']))
                                                    <span class="text-danger"> <b> {{__('message.note')}}</b> :- {{ __('frontend::message.'.$key).' '.__('frontend::message.less_than_equal_review') }}</span>                    
                                                @endif
                                            </div>
                                        @else
                                            <div class="form-group col-md-4">
                                                <label class="form-control-label" for="{{ $key }}">{{ __('frontend::message.'.$key) }} </label>
                                                <div class="custom-file">
                                                    <input type="file" name="{{ $key }}" class="form-control file-input custom-file-input" accept="image/*" data--target="{{$key}}_image_preview">
                                                </div>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                                <img id="{{$key}}_image_preview" src="{{ getSingleMedia($value, $key) }}" alt="{{$key}}" class="attachment-image mt-1 {{$key}}_image_preview">
                                            </div>
                                        @endif

                                    @endforeach
                                </div>
                                <hr>
                                <div class="col-md-12 mt-1 mb-4">
                                    <button class="btn btn-md btn-primary float-md-end" id="saveButton">{{ __('message.save') }}</button>
                                </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                </div>
            @endif
            @if(in_array($type,['ultimate-workout','fitness-product','client-testimonial','walkthrough']))
                <div class="col-lg-12" id="frontend_data_table">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="font-weight-bold">{{ __('message.list_form_title',['form'=> $pageTitle ])}}</h5>
                            <div class="table-responsive mt-4 assign-profile-max-height">
                                <table id="basic-table" class="table table-striped mb-0" role="grid">
                                    <thead>
                                        <tr>
                                            <th>{{ __('message.image') }}</th>
                                            <th>{{ __('message.title') }}</th>
                                            @if (in_array($type,['client-testimonial']))
                                                <th>{{ __('frontend::message.subtitle') }}</th>
                                            @endif
                                            @if (!in_array($type,['walkthrough']))
                                                <th>{{ __('message.description') }}</th>
                                            @endif
                                            <th colspan="2">{{ __('message.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="{{ $type }}-section-data">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
