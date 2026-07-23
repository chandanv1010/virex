@inject('slideService', 'App\Services\V1\Core\SlideService')
@php
    $partnerKeyword = App\Enums\SlideEnum::PARTNER;
    $langId = $config['language'] ?? 1;
    $partnerSlides = $slideService->getSlide([$partnerKeyword], $langId);
    $partnerItems = $partnerSlides[$partnerKeyword]['item'] ?? [];
@endphp

@if(empty($product) && !empty($partnerItems))
<div class="panel-partner" style="background: #f8fafc; padding: 50px 0 30px 0; border-top: 1px solid #eaeaea; border-bottom: 1px solid #eaeaea;">
    <div class="uk-container uk-container-center">
        <div class="partner-header wow fadeInUp" data-wow-delay="0.1s" style="text-align: center; margin-bottom: 30px;">
            <h2 class="partner-title" style="font-family: 'UTM Avo', sans-serif !important; font-size: 26px; font-weight: 700; color: #1e4794; margin: 0;"><span class="highlight-green" style="color: #006D3A;">Đối tác</span> của chúng tôi</h2>
            <p class="partner-subtitle" style="font-family: 'Manrope', sans-serif; font-size: 14.5px; color: #6b7280; margin-top: 8px;">
                Đây là những đối tác tin cậy của chúng tôi
            </p>
        </div>
        
        <div class="swiper-container partner-swiper wow fadeInUp" data-wow-delay="0.2s" style="overflow: hidden; padding-bottom: 30px;">
            <div class="swiper-wrapper" style="display: flex; align-items: center;">
                @foreach($partnerItems as $item)
                    <div class="swiper-slide partner-slide-item">
                        <div class="partner-logo-card" style="background: #fff; padding: 15px 20px; border-radius: 8px; border: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: center; height: 150px !important; box-shadow: 0 4px 10px rgba(0,0,0,0.02); transition: all 0.2s; width: 100% !important; box-sizing: border-box !important;">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] ?? 'Partner' }}" style="height: 120px !important; max-height: 120px !important; width: auto !important; max-width: 100% !important; object-fit: contain !important; display: block;">
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Pagination Dots -->
            <div class="swiper-pagination partner-pagination" style="bottom: 0;"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var partnerEl = document.querySelector('.partner-swiper');
        if (partnerEl) {
            if (partnerEl.swiper) {
                try {
                    partnerEl.swiper.destroy(true, true);
                } catch (e) {
                    console.warn(e);
                }
            }
            var partnerSwiper = new Swiper('.partner-swiper', {
                slidesPerView: 6,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.partner-pagination',
                    clickable: true,
                },
                breakpoints: {
                    320: {
                        slidesPerView: 2,
                        spaceBetween: 15
                    },
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    960: {
                        slidesPerView: 4,
                        spaceBetween: 25
                    },
                    1200: {
                        slidesPerView: 6,
                        spaceBetween: 30
                    }
                }
            });
        }
    });
</script>
@endif

<footer class="footer">
    <div class="uk-container uk-container-center">
        <!-- 4 Columns Grid -->
        <div class="uk-grid uk-grid-large footer-grid" data-uk-grid-margin>
            <!-- Column 1 -->
            <div class="uk-width-large-2-5 uk-width-medium-1-2 uk-width-1-1">
                <div class="footer-col brand-col">
                    <h3 class="col-title brand-title">CÔNG TY CỔ PHẦN XUẤT NHẬP KHẨU VIREX</h3>
                    <p class="brand-desc">
                        VIREX là cầu nối đưa các sản phẩm tiên tiến của S&MAI đến với thị trường Việt Nam và góp phần nâng cao chất lượng và hiệu quả cho các công trình dân dụng, công nghiệp.
                    </p>
                    <div class="office-info">
                        <h4 class="office-title">Văn phòng</h4>
                        <ul class="contact-details uk-list">
                            <li class="address">- Địa chỉ: Thôn Phúc Lộc, Xã Đông Anh, Thành phố Hà Nội, Việt Nam</li>
                            <li class="warehouse">- Kho bãi: nhà máy Z153, Xã Thư Lâm, Thành phố Hà Nội, Việt Nam</li>
                            <li class="phone">- Số điện thoại: 0828 27 6666</li>
                            <li class="email">- Email: <a href="mailto:virexvn8386@gmail.com">virexvn8386@gmail.com</a></li>
                            <li class="website">- Website: <a href="https://virex.vn/" target="_blank">https://virex.vn/</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Column 2, 3, 4 (Dynamic Menus from database) -->
            @php
                $footerMenus = $menu['footer-menu'] ?? [];
            @endphp
            @foreach($footerMenus as $fMenu)
                @php
                    $parentName = $fMenu['item']->languages->first()->pivot->name ?? '';
                    $children = $fMenu['children'] ?? [];
                @endphp
                <div class="uk-width-large-1-5 uk-width-medium-1-2 uk-width-1-1">
                    <div class="footer-col links-col">
                        <h3 class="col-title">{{ $parentName }}</h3>
                        <ul class="col-links uk-list">
                            @foreach($children as $cMenu)
                                @php
                                    $cName = $cMenu['item']->languages->first()->pivot->name ?? '';
                                    $cCanonical = $cMenu['item']->languages->first()->pivot->canonical ?? '#';
                                @endphp
                                <li>
                                    <a href="{{ (strpos($cCanonical, 'http') === 0 || $cCanonical === '#') ? $cCanonical : write_url($cCanonical) }}">
                                        - {{ $cName }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Big centered logo at the bottom (moved above copyright) -->
        <div class="footer-bottom-brand">
            <span class="brand-char">V</span>
            <span class="brand-char">I</span>
            <span class="brand-char">R</span>
            <span class="brand-char">E</span>
            <span class="brand-char">X</span>
        </div>

        <!-- Centered Copyright Bar -->
        <div class="footer-copyright-bar uk-text-center">
            <p>© CÔNG TY CỔ PHẦN XUẤT NHẬP KHẨU VIREX - Thôn Phúc Lộc, Xã Đông Anh, Thành phố Hà Nội, Việt Nam. Đại diện: ÔNG TRỊNH VĂN TUẤN | Mã số thuế: 0111454672</p>
        </div>
    </div>
</footer>

<div id="fb-root"></div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll reveal for brand characters
        const brandContainer = document.querySelector('.footer-bottom-brand');
        if (brandContainer) {
            if ('IntersectionObserver' in window) {
                const brandObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            brandContainer.classList.add('reveal-active');
                            setTimeout(() => {
                                brandContainer.classList.add('reveal-complete');
                            }, 1500);
                            brandObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.15
                });
                brandObserver.observe(brandContainer);
            } else {
                brandContainer.classList.add('reveal-active', 'reveal-complete');
            }
        }

        const fbContainer = document.getElementById('fb-fanpage-lazy');
        if (!fbContainer) return;

        // Lazy load Facebook Fanpage on viewport proximity
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        observer.unobserve(entry.target);
                        loadFacebookSDK();
                    }
                });
            }, {
                rootMargin: '200px 0px'
            });
            observer.observe(fbContainer);
        } else {
            loadFacebookSDK();
        }

        function loadFacebookSDK() {
            const href = fbContainer.getAttribute('data-href');
            fbContainer.innerHTML = `
                <div class="fb-page" 
                     data-href="${href}" 
                     data-tabs="" 
                     data-small-header="false" 
                     data-adapt-container-width="true" 
                     data-hide-cover="false" 
                     data-show-facepile="true">
                     <blockquote cite="${href}" class="fb-xfbml-parse-ignore">
                          <a href="${href}">Facebook</a>
                     </blockquote>
                </div>
            `;

            if (!document.getElementById('facebook-jssdk-lazy')) {
                const script = document.createElement('script');
                script.id = 'facebook-jssdk-lazy';
                script.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v18.0';
                script.async = true;
                script.defer = true;
                script.crossOrigin = 'anonymous';
                document.body.appendChild(script);
            } else {
                if (window.FB) {
                    window.FB.XFBML.parse(fbContainer);
                }
            }
        }
    });
</script>

