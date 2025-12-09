@component('mail::message')
# {{ __('frontend::message.new_blog') }}: {{ $post->title }}

{!! $post->description !!}

@component('mail::button', ['url' => route('blog.details', $post->slug)])
{{ __('frontend::message.view_blog') }}
@endcomponent

{{ __('frontend::message.if_you_would_like_to_unsubscribe_click_the_button_below') }}

@component('mail::button', ['url' => route('unsubscribe', ['email' => encryptDecryptId($subscriber->email,'encrypt')])])
{{ __('frontend::message.unsubscribe') }}
@endcomponent

{{ __('frontend::message.thanks') }},<br>
{{ config('app.name') }}
@endcomponent