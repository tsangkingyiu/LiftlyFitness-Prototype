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
                            <h5 class="font-h5">{{ __('frontend::message.change') .' / '. __('frontend::message.update_password') }}</h5>
                            <p class="mt-3 font-p">{{ __('frontend::message.your_new_password_must_be_different') }}</p>
                            {{ html()->form('POST', route('update.password'))->attribute('data-toggle', 'validator')->id('user-password')->open() }}

                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        {{ html()->hidden('id', null)->class('form-control-data') }}

                                        <div class="form-group">
                                            {{ html()->label(__('message.old_password') . ' <span class="text-danger">*</span>')->for('old_password')->class('font-p form-label') }}
                                            {{ html()->password('old')->class('form-control input-form')->id('old_password')->placeholder(__('message.old_password'))->attribute('required') }}
                                        </div>
                                        <div class="form-group mt-3">
                                            {{ html()->label(__('message.password') . ' <span class="text-danger">*</span>')->for('password')->class('font-p form-label') }}
                                            {{ html()->password('password')->class('form-control input-form')->id('password')->placeholder(__('message.new_password'))->attribute('required') }}
                                        </div>
                                        <div class="form-group mt-3">
                                            {{ html()->label(__('message.confirm_new_password') . ' <span class="text-danger">*</span>')->for('password-confirm')->class('font-p form-label') }}
                                            {{ html()->password('password_confirmation')->class('form-control input-form')->id('password-confirm')->placeholder(__('message.confirm_new_password'))->attribute('required') }}
                                        </div>
                                    </div>
                                    <div class="form-group mt-4 d-flex justify-content-center">
                                        {{ html()->submit(__('frontend::message.submit'))->id('submit')->class('btn change-pwd-btn mt-3 text-white') }}
                                    </div>
                                </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</x-frontend-user>