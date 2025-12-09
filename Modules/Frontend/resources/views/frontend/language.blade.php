<x-frontend-auth-layout>

    <h3 class="mb-3 mt-3 mx-2 ms-3">
            <span class="me-3"><a href="{{ route('browse') }}">
            <svg width="11" height="20" viewBox="0 0 11 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.99805 1L0.998047 10L9.99805 19" stroke="var(--site-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg></a>
        </span>{{ __('frontend::message.choose_language') }}
    </h3>

    <div class="card shadow-none m-0 border-0">
        <div class="p-0">
            <ul class="list-group list-group-flush">
                @php
                    $language_option = appSettingData('get')->language_option;
                    if(!empty($language_option)){
                        $language_array = languagesArray($language_option);
                    }
                @endphp
                @if(count($language_array) > 0)
                    @foreach($language_array as $lang)
                        <li class="iq-sub-card list-group-item">
                            <a class="dropdown-item p-0" data-lang="{{ $lang['id'] }}" href="{{ route('change.language', ['locale' => $lang['id']]) }}">
                                @php
                                    $flag_path = file_exists(public_path('/images/flag/' . $lang['id'] . '.png')) ? asset('/images/flag/' . $lang['id'] . '.png') : asset('/images/lang_flag.png');
                                @endphp
                                <img src="{{ $flag_path }}" alt="img-flag-{{ $lang['id'] }}" class="img-fluid me-2 selected-lang-list" height="30" width="30" />
                                {{ $lang['title'] }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>

</x-frontend-auth-layout>
