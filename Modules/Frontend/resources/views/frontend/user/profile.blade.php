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
                            {{ html()->modelForm($data['user_data'], 'POST', route('profile.update'))->attribute('data-toggle', 'validator')->attribute('enctype', 'multipart/form-data')->attribute('autocomplete', 'off')->open() }}
                            {!! html()->hidden('id', null)->class('form-control') !!}

                            <h5 class="font-h5">{{ __('frontend::message.edit_profile') }}</h5>
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle image-fluid profile_image_preview" src="{{ getSingleMedia($data['user_data'],'profile_image', null) }}" alt="profile-pic" height="100" width="100">

                                <div class="ms-3 mt-3">
                                    <div class="form-group col-md-4">
                                        <div>{{ html()->file('profile_image')->class('form-control d-none')->id('profile_image')->accept('image/*') }}</div>
                                        <button type="button" class="btn upload-img-btn text-white" id="uploadImageButton">{{ __('frontend::message.upload_image') }}</button>
                                    </div>
                                    <p class="mt-2 font-span">{{ __('frontend::message.photos_must_be_jpeg_or_png') }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="user-content">        
                                    <div class="row mt-3">
                                        <div class="form-group col-md-4">
                                            {{ html()->label(contents: __('message.first_name') . ' <span class="text-danger">*</span>')->class('font-p form-label mb-2') }}
                                            {{ html()->text(name: 'first_name')->placeholder(__('message.first_name'))->class('form-control input-form')->attribute('required','required') }}
                                        </div>
        
                                        <div class="form-group col-md-4">
                                            {{ html()->label(contents: __('message.last_name') . ' <span class="text-danger">*</span>')->class('font-p form-label mb-2') }}
                                            {{ html()->text(name: 'last_name')->placeholder(__('message.first_name'))->class('form-control input-form')->attribute('required','required') }}
                                        </div>

                                        <div class="form-group col-md-4">
                                            {{ html()->label(__('message.email') . ' <span class="text-danger">*</span>')->for('email')->class('font-p form-label mb-2') }}
                                            {{ html()->email('email', old('email', $data['user_data']->email ?? ''))->placeholder(__('message.email'))->class('form-control input-form')->attribute('required','readonly') }}
                                        </div>

                                        <div class="form-group col-md-4">
                                            {{ html()->label(__('message.phone_number'))->for('phone_number')->class('font-p form-label mb-2') }}
                                            {{ html()->text('phone_number', old('phone_number', $data['user_data']->phone_number ?? ''))->id('number')->class('form-control input-form-data') }}
                                        </div>

                                        <div class="form-group col-md-4">
                                            {{ html()->label(__('message.age') . ' <span class="text-danger">*</span>')->for('age')->class('font-p form-label') }}
                                            {{ html()->number('age', old('age', $data['user_profile']->age ?? ''))->class('form-control input-form') }}
                                        </div>

                                        <div class="form-group col-md-4">
                                            {{ html()->label(__('message.gender') . ' <span class="text-danger">*</span>')->for('gender')->class('font-p form-label') }}
                                            {{ html()->select('gender', ['male' => __('message.male'), 'female' => __('message.female'), 'other' => __('message.other')], old('gender'))->class('form-control input-form select2js')->attribute('required') }}
                                        </div>

                                        <div class="form-group col-md-4">
                                            {{ html()->label(__('message.weight') . ' <span class="text-danger">*</span>')->for('weight-input')->class('font-p form-label mb-2') }}
                                            <div class="input-group position-relative">
                                                {{ html()->number('weight', value: old('weight', default: $data['user_profile']->weight ?? ''))->class('form-control input-form form-input-data weight-unit')->id('weight-input')->placeholder('28')->attribute('min', 0)->attribute('step', 'any') }}
                                                <div class="input-group-append">
                                                    <div class="btn-group p-2" role="group" aria-label="Weight units">
                                                        {{ html()->radio('weight_unit', old('weight_unit', $data['user_profile']->weight_unit ?? '') == 'lbs', 'lbs')->class('btn-check')->id('lbs') }}
                                                        {{ html()->label('LBS')->for('lbs')->class('btn btn-outline-secondary d-flex align-items-center border-0 btn-unit') }}
                                        
                                                        {{ html()->radio('weight_unit', old('weight_unit', $data['user_profile']->weight_unit ?? 'kg') == 'kg', 'kg')->class('btn-check')->id('kg') }}
                                                        {{ html()->label('KG')->for('kg')->class('btn btn-outline-secondary d-flex align-items-center border-0 btn-unit') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            {{ html()->label(__('message.height') . ' <span class="text-danger">*</span>')->for('height-input')->class('font-p form-label mb-2') }}
                                            <div class="input-group position-relative">
                                                {{ html()->number('height', old('height', $data['user_profile']->height ?? ''))->class('form-control input-form form-input-data height-unit')->id('height-input')->placeholder('168.0')->attribute('min', 0)->attribute('step', 'any') }}
                                                <div class="input-group-append">
                                                    <div class="btn-group p-2" role="group" aria-label="Height units">
                                                        {{ html()->radio('height_unit', old('height_unit', $data['user_profile']->height_unit ?? '') == 'feet', 'feet')->class('btn-check')->id('feet') }}
                                                        {{ html()->label('FEET')->for('feet')->class('btn btn-outline-secondary d-flex align-items-center border-0 btn-unit') }}
                                        
                                                        {{ html()->radio('height_unit', old('height_unit', $data['user_profile']->height_unit ?? 'cm') == 'cm', 'cm')->class('btn-check')->id('cm') }}
                                                        {{ html()->label('CM')->for('cm')->class('btn btn-outline-secondary d-flex align-items-center border-0 btn-unit') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 d-flex justify-content-center">
                                            {{ html()->submit( __('frontend::message.save_changes') )->class('btn profile-save-btn mt-5 text-white') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

  @section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#uploadImageButton').on('click', function() {
                $('#profile_image').click();
            });
        });

     
        $(document).on('change','#profile_image',function(){
            readURL(this);
        })
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                var res=isImage(input.files[0].name);

                if(res==false){
                    var msg = "{{ __('message.image_png_jpg') }}";
                    Toast.fire({
                        icon: 'success',
                        title: msg
                    });
                    return false;
                }

                reader.onload = function(e) {
                $('.profile_image_preview').attr('src', e.target.result);
                    $("#imagelabel").text((input.files[0].name));
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function getExtension(filename) {
            var parts = filename.split('.');
            return parts[parts.length - 1];
        }

        function isImage(filename) {
            var ext = getExtension(filename);
            switch (ext.toLowerCase()) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return true;
            }
            return false;
        }
    </script>
  @endsection
</x-frontend-user>


