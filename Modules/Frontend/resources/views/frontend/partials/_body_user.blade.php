<div id="loading">
    @include('frontend::frontend.partials._body_loader')
</div>
@include('frontend::frontend.partials._body_user_header')
<head>
    <style>
        :root {
            --site-color: {{ $app_settings->color ?? '#EC7E4A' }};
        }
    </style>
</head>

<div id="remoteModelData" class="modal fade" role="dialog"></div>
<div class="content-page">
    {{ $slot }}
</div>



{{-- @include('frontend::frontend.partials._body_footer') --}}

@include('frontend::frontend.partials._scripts')
