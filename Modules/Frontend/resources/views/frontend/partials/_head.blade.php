<link rel="shortcut icon" class="site_favicon_preview" href="{{ getSingleMedia(appSettingData('get'), 'site_favicon', null) }}" />


<link rel="stylesheet" href="{{ asset('frontend-section/sass/app.scss') }}">

<link rel="stylesheet" href="{{ asset('vendor/intlTelInput/css/intlTelInput.css') }}">

@if (in_array('animation',$assets ?? []))
   <link rel="stylesheet" href="{{ asset('frontend-section/css/aos.css') }}">
@endif

@if(in_array('videojs',$assets ?? []))
   <link rel="stylesheet" href="{{ asset('frontend-section/css/video-js.css') }}">
@endif

@if(mighty_language_direction() == 'rtl')
   <link rel="stylesheet" href="{{asset('css/rtl.css?v=1.1.0')}}">
@endif

<style>
   :root {
       --site-color: {{ $app_settings->color ?? '#EC7E4A' }};
   }
</style>
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" /> --}}

{{-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> --}}
