@extends('frontend.homepage.layout')
@section('content')
    @include('frontend.component.slide')
    @php
        $aboutWidget = $widgets['about-us'] ?? null;
        $aboutCat = (isset($aboutWidget->object) && $aboutWidget->object->isNotEmpty()) ? $aboutWidget->object->first() : null;
        $aboutPosts = $aboutCat ? $aboutCat->posts : collect();
    @endphp

    @if($aboutWidget && $aboutCat && $aboutPosts->isNotEmpty())
    <!-- INTRODUCTION SECTION (DYNAMICALLY LOADED FROM DB WIDGET) -->
    <div class="panel-intro-virex">
        <div class="uk-container uk-container-center">
            <div class="intro-container-inner">
                <!-- Left Containerized Image -->
                <div class="intro-image-box">
                    <img src="{{ $aboutPosts->first()->image ?? '/userfiles/image/aabout.png' }}" alt="VIREX About Image">
                </div>

                <!-- Right Overlapping Card -->
                <div class="intro-card">
                    <!-- Heading -->
                    <div class="intro-header">
                        <span class="intro-tag">{{ $aboutCat->languages->name ?? 'VIREX – ĐƠN VỊ ĐỘC QUYỀN PHÂN PHỐI SẢN PHẨM S&Mai TẠI VIỆT NAM' }}</span>
                        <h2 class="intro-title">
                            @php
                                $widgetTitle = $aboutWidget->name ?? 'VIREX – Kết nối công nghệ tiên tiến, kiến tạo giải pháp bền vững cho mọi công trình';
                                // Add spans for styling specific words in title
                                $widgetTitleStyled = str_replace(
                                    ['Kết nối', 'kiến tạo'],
                                    ['<span class="highlight-orange">Kết nối</span>', '<span class="highlight-orange">kiến tạo</span>'],
                                    $widgetTitle
                                );
                            @endphp
                            {!! $widgetTitleStyled !!}
                        </h2>
                        <p class="intro-subtitle">
                            {!! $aboutWidget->description[$config['language']] ?? ($aboutWidget->description[1] ?? '') !!}
                        </p>
                    </div>

                    <!-- Tabs Header -->
                    <div class="intro-tabs-header">
                        @foreach($aboutPosts as $index => $post)
                            @php
                                $postLang = $post->languages->first();
                            @endphp
                            <button class="intro-tab-btn @if($index === 0) active @endif" data-tab="tab-{{ $post->id }}">{{ $postLang->name ?? '' }}</button>
                        @endforeach
                    </div>

                    <!-- Tabs Content -->
                    <div class="intro-tabs-content">
                        @foreach($aboutPosts as $index => $post)
                            @php
                                $postLang = $post->languages->first();
                            @endphp
                            <div class="intro-tab-panel @if($index === 0) active @endif" id="tab-{{ $post->id }}">
                                <p>{!! $postLang->description ?? '' !!}</p>
                                <p>{!! $postLang->content ?? '' !!}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

<style>
/* CSS Styles for the updated Virex Intro Section */
.panel-intro-virex {
    width: 100%;
    background-color: #ffffff;
    padding: 80px 0 0 0;
    position: relative;
    box-sizing: border-box;
    overflow: hidden;
}
.panel-intro-virex .uk-container {
    max-width: 1280px !important;
    position: relative;
    z-index: 2;
    width: 100%;
}
.intro-container-inner {
    position: relative;
    width: 100%;
    min-height: 881px;
}
.intro-image-box {
    width: 1066px;
    height: 881px;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    position: absolute;
    left: 0;
    top: 0;
    z-index: 1;
}
.intro-image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.intro-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    border-radius: 8px;
    padding: 40px;
    position: absolute;
    width: 825px;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    z-index: 10;
    font-family: 'Roboto', sans-serif; /* Explicitly set unified font */
}
.intro-tag {
    font-size: 13px;
    font-weight: 700;
    color: #1b745a; /* Brand Pine Green */
    letter-spacing: 0.5px;
    position: relative;
    padding-left: 25px;
    display: inline-block;
    margin-bottom: 15px;
    font-family: 'Roboto', sans-serif;
}
.intro-tag::before {
    content: "";
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 15px;
    height: 2px;
    background-color: #1b745a;
}
.intro-title {
    font-size: 28px;
    font-weight: 700;
    line-height: 1.35;
    color: #222;
    margin: 0 0 15px 0;
    font-family: 'Roboto', sans-serif;
}
.highlight-orange {
    color: #ee7e22; /* Consistent with VIREX brand logo */
}
.intro-subtitle {
    font-size: 14px;
    line-height: 1.6;
    color: #555;
    margin-bottom: 25px;
    font-family: 'Roboto', sans-serif;
}
.intro-tabs-header {
    display: flex;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    margin-bottom: 0;
}
.intro-tab-btn {
    border: none;
    outline: none;
    background: #e5e7eb;
    color: #444;
    padding: 10px 25px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    margin-right: 5px;
    font-family: 'Roboto', sans-serif; /* Unify button font */
}
.intro-tab-btn.active {
    background-color: #1b745a; /* Brand Pine Green */
    color: #fff;
}
.intro-tabs-content {
    background-color: rgba(27, 116, 90, 0.85); /* Semi-transparent brand green */
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    padding: 30px;
    color: #fff;
    font-family: 'Roboto', sans-serif; /* Unify content font */
}
.intro-tab-panel {
    display: none;
}
.intro-tab-panel.active {
    display: block;
}
.intro-tab-panel p {
    font-size: 13.5px;
    line-height: 1.7;
    margin: 0 0 15px 0;
    color: rgba(255, 255, 255, 0.95);
    text-align: justify;
    font-family: 'Roboto', sans-serif;
}
.intro-tab-panel p:last-child {
    margin-bottom: 0;
}

@media (min-width: 960px) and (max-width: 1199px) {
    .intro-container-inner {
        min-height: 660px;
    }
    .intro-image-box {
        width: 800px;
        height: 660px;
    }
    .intro-card {
        width: 620px;
        left: 240px;
        right: auto;
    }
}

@media (max-width: 959px) {
    .panel-intro-virex {
        padding: 40px 0;
    }
    .intro-container-inner {
        display: flex;
        flex-direction: column;
        min-height: auto;
        align-items: stretch;
    }
    .intro-image-box {
        position: static;
        width: 100%;
        max-width: 100%;
        height: 350px;
        margin-bottom: 20px;
    }
    .intro-card {
        position: static;
        width: 100%;
        max-width: 100%;
        transform: none;
        padding: 20px;
        background: #fff;
        backdrop-filter: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .intro-title {
        font-size: 22px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.intro-tab-btn');
    const tabPanels = document.querySelectorAll('.intro-tab-panel');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');

            // Remove active class from all buttons and panels
            tabButtons.forEach(b => b.classList.remove('active'));
            tabPanels.forEach(p => p.classList.remove('active'));

            // Add active class to current button and target panel
            this.classList.add('active');
            const panel = document.getElementById(targetTab);
            if (panel) {
                panel.classList.add('active');
            }
        });
    });
});
</script>

    @php
        $productWidget = $widgets['solution-product'] ?? null;
        $productCat = (isset($productWidget->object) && $productWidget->object->isNotEmpty()) ? $productWidget->object->first() : null;
        $productChildren = $productCat ? collect($productCat->childrens) : collect();
    @endphp

    @if($productCat && $productChildren->isNotEmpty())
    <div class="panel-product-slider">
        <div class="uk-container uk-container-center">
            <div class="product-slider-grid">
                <div class="product-left-content wow fadeInLeft" data-wow-delay="0.1s">
                    <span class="tag">{{ $productWidget->description[$config['language']] ?? ($productWidget->description[1] ?? 'Dịch vụ của chúng tôi') }}</span>
                    <h2 class="title">{{ $productCat->languages->name }}</h2>
                    <div class="description">
                        {!! $productCat->languages->description !!}
                    </div>
                    <div class="navigation-controls">
                        <button class="nav-btn prev-btn"><i class="fa fa-angle-left"></i></button>
                        <button class="nav-btn next-btn"><i class="fa fa-angle-right"></i></button>
                    </div>
                    <div class="action-btn-wrapper">
                        <a href="{{ write_url($productCat->languages->canonical) }}" class="btn-xem-san-pham">
                            <span>Xem Sản phẩm</span>
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="product-right-slider wow fadeInRight" data-wow-delay="0.2s">
                    <div class="swiper-container product-swiper">
                        <div class="swiper-wrapper">
                            @foreach($productChildren as $idx => $child)
                                <div class="swiper-slide product-slide-item">
                                    <a href="{{ write_url($child->languages->canonical) }}" class="product-card">
                                        <div class="card-image @if(($child->image_fit ?? 'cover') === 'contain') image-contain @endif">
                                            <img src="{{ $child->image }}" alt="{{ $child->languages->name }}">
                                        </div>
                                        <div class="card-footer" style="background-color: {{ $child->background ?? '#006D3A' }} !important;">
                                            <span class="card-title">{{ $child->languages->name }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var productSwiper = new Swiper('.product-swiper', {
                slidesPerView: 3,
                spaceBetween: 15,
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.next-btn',
                    prevEl: '.prev-btn',
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 15
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 15
                    },
                    960: {
                        slidesPerView: 3,
                        spaceBetween: 15
                    }
                }
            });
        });
    </script>
    @endif

     @php
        $marquee = $menu['marquee']
    @endphp
    @if(isset($marquee) && !is_null($marquee) && count($marquee))
    <div class="panel-marquee">
        <div class="marquee__inner">
            <!-- group 1 (thực tế) -->
            <div class="marquee__group">
                @foreach($marquee as $key => $val)
                @php
                    $name = $val['item']->languages->first()->pivot->name;
                    $canonical = write_url($val['item']->languages->first()->pivot->canonical);
                @endphp
                <a class="marquee__item" href="{{ $canonical }}"><i class="fa fa-diamond marquee-icon"></i>{{ $name }}</a>
                @endforeach
            </div>

            <div class="marquee__group" aria-hidden="true">
                @foreach($marquee as $key => $val)
                @php
                    $name = $val['item']->languages->first()->pivot->name;
                    $canonical = write_url($val['item']->languages->first()->pivot->canonical);
                @endphp
                <a class="marquee__item" href="{{ $canonical }}"><i class="fa fa-diamond marquee-icon"></i>{{ $name }}</a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @php
        $reasonsCat = App\Models\PostCatalogue::with(['languages'])->find(5);
        $reasonsPosts = $reasonsCat ? $reasonsCat->posts()->with('languages')->orderBy('order', 'asc')->take(3)->get() : collect();
    @endphp

    @if($reasonsCat && $reasonsPosts->isNotEmpty())
    <div class="panel-reasons-virex">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium uk-flex-middle" data-uk-grid-margin>
                <!-- Left Column -->
                <div class="uk-width-large-1-2 uk-width-1-1 wow fadeInLeft" data-wow-delay="0.1s">
                    <div class="reasons-left-content">
                        {!! $reasonsCat->languages->first()->pivot->description ?? '' !!}
                    </div>
                </div>

                <!-- Right Column -->
                <div class="uk-width-large-1-2 uk-width-1-1 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="reasons-right-list">
                        @foreach($reasonsPosts as $index => $post)
                            @php
                                $postLang = $post->languages->first();
                                $cardClass = ($index === 0) ? 'reasons-card bg-pine-green' : 'reasons-card bg-light-grey';
                            @endphp
                            <div class="{{ $cardClass }}">
                                <div class="reasons-card-inner">
                                    <div class="reasons-card-icon">
                                        <img src="{{ $post->image }}" alt="{{ $postLang->pivot->name ?? 'Icon' }}">
                                    </div>
                                    <div class="reasons-card-content">
                                        <h3 class="reasons-card-title">{{ $postLang->pivot->name ?? '' }}</h3>
                                        <div class="reasons-card-desc">
                                            {!! $postLang->pivot->description ?? '' !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @php
        $solutionWidget = $widgets['solution'] ?? null;
        $solutionCat = (isset($solutionWidget->object) && $solutionWidget->object->isNotEmpty()) ? $solutionWidget->object->first() : null;
        $solutionPosts = $solutionCat ? $solutionCat->posts : collect();
    @endphp

    @if(false && $solutionPosts->isNotEmpty())
    <div class="panel-solution">
        <div class="uk-container uk-container-center">
            @php
                $widgetTitle = $solutionWidget->name ?? 'Một cánh cửa mở ra một hành trình ấn tượng';
                $widgetDesc = $solutionWidget->description[$config['language']] ?? ($solutionWidget->description[1] ?? 'Sứ mệnh tạo nên giá trị bền vững và tinh thần trách nhiệm từ tinh hoa công nghệ Nhật Bản, Thanh nhôm MAXPRO.JP hướng đến những giá trị vượt ra ngoài giới hạn của trải nghiệm vận hành');
            @endphp
            <div class="solution-header uk-text-center wow fadeInUp" data-wow-delay="0.1s">
                <h2 class="solution-title">{{ $widgetTitle }}</h2>
                <p class="solution-subtitle">{!! $widgetDesc !!}</p>
            </div>
            
            <div class="solution-tabs-wrapper uk-text-center wow fadeInUp" data-wow-delay="0.2s">
                <ul class="solution-tabs">
                    @foreach($solutionPosts as $index => $post)
                        @php
                            $lang = $post->languages->first();
                        @endphp
                        <li class="solution-tab-item @if($index === 0) active @endif" data-slide-index="{{ $index }}">
                            <span>{{ $lang->name }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="solution-slider-container wow fadeInUp" data-wow-delay="0.3s">
            <div class="solution-slides-wrapper">
                @foreach($solutionPosts as $index => $post)
                    @php
                        $lang = $post->languages->first();
                    @endphp
                    <div class="solution-slide @if($index === 0) active @endif" data-slide-index="{{ $index }}" style="background-image: url('{{ $post->image }}?v={{ time() }}')">
                        <div class="uk-container uk-container-center solution-slide-inner">
                            <div class="solution-card-overlay">
                                <h3 class="solution-card-title">{{ $lang->description }}</h3>
                                <p class="solution-card-text">{{ $lang->content }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.solution-tab-item');
            const slides = document.querySelectorAll('.solution-slide');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetIndex = this.getAttribute('data-slide-index');
                    
                    // Update active tab
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Update active slide
                    slides.forEach(slide => {
                        if (slide.getAttribute('data-slide-index') === targetIndex) {
                            slide.classList.add('active');
                        } else {
                            slide.classList.remove('active');
                        }
                    });
                });
            });
        });
    </script>
    @endif

    @php
        $projectKeyword = App\Enums\SlideEnum::PROJECT;
        $projectSlideItems = $slides[$projectKeyword]['item'] ?? [];
    @endphp

    @if(!empty($projectSlideItems))
    <div class="panel-featured-projects">
        <div class="project-header wow fadeInUp" data-wow-delay="0.1s">
            <h2 class="title">DỰ ÁN TIÊU BIỂU</h2>
        </div>
        <div class="project-slider-wrapper wow fadeInUp" data-wow-delay="0.2s">
            <div class="swiper-container project-swiper">
                <div class="swiper-wrapper">
                    @foreach($projectSlideItems as $item)
                        @php
                            $imgSrc = $item['image'] ?? '';
                            $imgAlt = $item['alt'] ?? ($item['name'] ?? 'Dự án VIREX');
                        @endphp
                        <div class="swiper-slide project-slide-item">
                            <a href="{{ $imgSrc }}" data-uk-lightbox="{group:'featured-projects'}" title="{{ $imgAlt }}" class="project-card-virex">
                                <img src="{{ $imgSrc }}" alt="{{ $imgAlt }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Stylized Navigation Arrows -->
            <button type="button" class="project-nav-btn project-prev" aria-label="Dự án trước">
                <svg viewBox="0 0 24 24" class="nav-icon"><path fill="currentColor" d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>
            <button type="button" class="project-nav-btn project-next" aria-label="Dự án tiếp">
                <svg viewBox="0 0 24 24" class="nav-icon"><path fill="currentColor" d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var projectEl = document.querySelector('.project-swiper');
            if (projectEl) {
                if (projectEl.swiper) {
                    try { projectEl.swiper.destroy(true, true); } catch (e) {}
                }
                var projectSwiper = new Swiper('.project-swiper', {
                    slidesPerView: 6,
                    slidesPerGroup: 1,
                    spaceBetween: 0,
                    loop: true,
                    autoplay: {
                        delay: 3500,
                        disableOnInteraction: false,
                    },
                    navigation: {
                        nextEl: '.project-next',
                        prevEl: '.project-prev',
                    },
                    breakpoints: {
                        320: { slidesPerView: 2 },
                        480: { slidesPerView: 3 },
                        768: { slidesPerView: 4 },
                        1024: { slidesPerView: 6 },
                        1280: { slidesPerView: 6 }
                    }
                });
            }
        });
    </script>
    @endif

    @php
        $newsWidget = $widgets['homepage-news'] ?? null;
        $newsCat = (isset($newsWidget->object) && $newsWidget->object->isNotEmpty()) ? $newsWidget->object->first() : null;
        $newsPosts = $newsCat ? $newsCat->posts : collect();
        $featuredNews = $newsPosts->first();
        $listNews = $newsPosts->skip(1)->take(4);

        $videoWidget = $widgets['homepage-video'] ?? null;
        $videoCat = (isset($videoWidget->object) && $videoWidget->object->isNotEmpty()) ? $videoWidget->object->first() : null;
        $videoPosts = $videoCat ? $videoCat->posts : collect();
        $firstVideo = $videoPosts->first();
    @endphp

    @if($newsCat && $newsPosts->isNotEmpty() && $videoCat && $videoPosts->isNotEmpty())
    <div class="panel-news-video">
        <div class="uk-container uk-container-center">
            <div class="section-header uk-text-center wow fadeInUp" data-wow-delay="0.1s">
                <h2 class="section-title">TIN TỨC NỔI BẬT</h2>
            </div>
            
            <div class="uk-grid uk-grid-medium" data-uk-grid-margin>
                <!-- 1. Featured News (Left Column) -->
                <div class="uk-width-large-1-3 uk-width-medium-1-2 wow fadeInLeft" data-wow-delay="0.2s">
                    @if($featuredNews)
                        @php
                            $featuredLang = $featuredNews->languages->first();
                            $featuredDate = \Carbon\Carbon::parse($featuredNews->created_at)->format('d-m-y H:i');
                        @endphp
                        <a href="{{ write_url($featuredLang->canonical) }}" class="featured-news-card">
                            <div class="card-image">
                                <img src="{{ $featuredNews->image }}" alt="{{ $featuredLang->name }}">
                            </div>
                            <div class="card-date">
                                <span class="dot"></span>
                                {{ $featuredDate }}
                            </div>
                            <h3 class="card-title">{{ $featuredLang->name }}</h3>
                            <p class="card-desc">{{ $featuredLang->description }}</p>
                        </a>
                    @endif
                </div>

                <!-- 2. News List (Middle Column) -->
                <div class="uk-width-large-1-3 uk-width-medium-1-2 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="news-list-wrapper">
                        @foreach($listNews as $post)
                            @php
                                $lang = $post->languages->first();
                                $postDate = \Carbon\Carbon::parse($post->created_at)->format('d-m-y H:i');
                            @endphp
                            <a href="{{ write_url($lang->canonical) }}" class="news-list-item">
                                <div class="item-thumb">
                                    <img src="{{ $post->image }}" alt="{{ $lang->name }}">
                                </div>
                                <div class="item-content">
                                    <h4 class="item-title">{{ $lang->name }}</h4>
                                    <div class="item-meta">
                                        <span class="item-date">
                                            <span class="dot"></span>
                                            {{ $postDate }}
                                        </span>
                                        <span class="btn-readmore">Đọc tiếp</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 3. Video Column (Right Column) -->
                <div class="uk-width-large-1-3 uk-width-1-1 wow fadeInRight" data-wow-delay="0.4s">
                    @if($firstVideo)
                        <div class="video-gallery-wrapper">
                            <!-- Main Video Player -->
                            <div class="video-iframe-container" id="mainVideoPlayerContainer">
                                {!! $firstVideo->video !!}
                            </div>

                            <!-- Clickable Video Text List -->
                            <div class="video-text-list">
                                @foreach($videoPosts as $index => $post)
                                    @php
                                        $lang = $post->languages->first();
                                    @endphp
                                    <div class="video-text-item @if($index === 0) active @endif" 
                                         data-video-code="{{ $post->video }}">
                                        <i class="fa fa-play-circle video-icon"></i>
                                        <span class="video-title">{{ $lang->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Switcher -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videoItems = document.querySelectorAll('.video-text-item');
            const playerContainer = document.getElementById('mainVideoPlayerContainer');

            videoItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Avoid redundant work if already active
                    if (this.classList.contains('active')) return;

                    // Remove active from all items, add to clicked
                    videoItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    const newCode = this.getAttribute('data-video-code');

                    // Smooth transition effect
                    playerContainer.classList.add('switching');

                    setTimeout(() => {
                        playerContainer.innerHTML = newCode;
                        
                        // Small delay to allow iframe source to load before removing fade
                        setTimeout(() => {
                            playerContainer.classList.remove('switching');
                        }, 150);
                    }, 200);
                });
            });
        });
    </script>
    @endif

@endsection
