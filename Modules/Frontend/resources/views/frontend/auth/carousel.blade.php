@php
    $frontend_data = Modules\Frontend\Models\FrontendData::where('type','walkthrough')->get();
@endphp
<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @for($i = 0; $i < count($frontend_data); $i++)
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"
            aria-current="true" aria-label="Slide {{ $i }}"></button>
        @endfor
    </div>
    <div class="carousel-inner">
        @foreach(count($frontend_data) > 0 ? $frontend_data : [(object) ['id' => '','type' => 'walkthrough','title' => DummyData('dummy_title')]]  as $key => $values)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <div class="d-flex justify-content-center">
                    <img src="{{ getSingleMediaSettingImage($values->id != null ? $values : null, 'walkthrough') }}" class="pb-5 mb-5 img-fluid carousel-img">
                </div>
                <div class="carousel-caption">
                    <h5>{{ $values->title }}</h5>
                </div>
            </div>
        @endforeach
    </div>
    @if (count($frontend_data) > 1) 
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">{{ __('message.previous') }}</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">{{ __('message.next') }}</span>
        </button>
    @endif
</div>