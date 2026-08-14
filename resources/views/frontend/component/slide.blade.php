@php
    $slideKeyword = App\Enums\SlideEnum::MAIN;
    $rawPhone = $system['contact_hotline'] ?? ($system['contact_phone'] ?? '0963892881');
    $zaloPhone = preg_replace('/[^0-9]/', '', $rawPhone);
    $zaloUrl = !empty($zaloPhone) ? 'https://zalo.me/' . $zaloPhone : ($system['social_zalo'] ?? 'https://zalo.me/');
@endphp

@if(!empty($slides[$slideKeyword]['item']))
    <div class="panel-slide page-setup" data-setting="">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($slides[$slideKeyword]['item'] as $key => $val)
                    <div class="swiper-slide">
                        <div class="slide-inner uk-flex uk-flex-middle uk-flex-between">
                            {{-- Hình ảnh slide nhấp vào mở Zalo --}}
                            <a href="{{ $zaloUrl }}" target="_blank" class="slide-image img-cover" title="Liên hệ Zalo {{ $rawPhone }}">
                                <img src="{{ $val['image'] }}" alt="{{ $val['name'] }}" />
                            </a>

                            {{-- Nội dung text --}}
                            <div class="slide-content wow fadeInLeft" data-wow-delay="0.3s">
                                <h2 class="slide-title">{{ $val['name'] }}</h2>

                                @if(!empty($val['alt']))
                                    <p class="slide-description">
                                        {{ $val['alt'] }}
                                    </p>
                                @endif

                                <a href="{{ $zaloUrl }}" target="_blank" class="slide-btn">LIÊN HỆ NGAY</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
