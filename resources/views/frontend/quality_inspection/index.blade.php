@extends('frontend.homepage.layout')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap');

    /* Custom Styling for Quality Inspection Page */
    .qi-wrapper,
    .qi-wrapper button,
    .qi-wrapper h1,
    .qi-wrapper h2,
    .qi-wrapper h3,
    .qi-wrapper h4,
    .qi-wrapper span,
    .qi-wrapper p,
    .qi-wrapper a,
    .qi-tab-btn {
        font-family: 'Roboto', 'Manrope', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
    }

    .qi-wrapper {
        background-color: #f8fafc;
        padding-bottom: 80px;
    }
    .qi-wrapper i.fa,
    .qi-wrapper .fa {
        font-family: 'FontAwesome' !important;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
    }
    .qi-hero {
        background: linear-gradient(135deg, #034833 0%, #047857 50%, #059669 100%);
        padding: 60px 0 50px;
        color: #ffffff;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .qi-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(circle at 80% 20%, rgba(131, 205, 32, 0.25) 0%, transparent 60%);
        pointer-events: none;
    }
    .qi-hero-breadcrumbs {
        list-style: none;
        padding: 0;
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.85);
    }
    .qi-hero-breadcrumbs a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        transition: color 0.2s;
    }
    .qi-hero-breadcrumbs a:hover {
        color: #ffffff;
    }
    .qi-hero-title {
        font-size: 32px;
        font-weight: 800;
        text-transform: uppercase;
        margin: 0 0 12px;
        letter-spacing: 0.5px;
        color: #ffffff;
    }
    .qi-hero-subtitle {
        font-size: 15px;
        color: rgba(255, 255, 255, 0.9);
        max-width: 720px;
        margin: 0 auto;
        line-height: 1.6;
    }
    .qi-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }
    .qi-section {
        margin-top: 40px;
        background: #ffffff;
        border-radius: 16px;
        padding: 35px 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        border: 1px solid #e2e8f0;
    }
    .qi-section-header {
        border-bottom: 2px solid #034833;
        padding-bottom: 16px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .qi-section-title {
        font-size: 22px;
        font-weight: 700;
        color: #034833;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .qi-section-title i {
        color: #83cd20;
        font-size: 24px;
    }
    .qi-badge {
        background: #ecfdf5;
        color: #047857;
        font-size: 13px;
        font-weight: 600;
        padding: 4px 14px;
        border-radius: 20px;
        border: 1px solid #a7f3d0;
    }
    
    /* Document Cards */
    .qi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 24px;
    }
    .qi-card {
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .qi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(3, 72, 51, 0.12);
        border-color: #83cd20;
    }
    .qi-card-image-wrap {
        position: relative;
        aspect-ratio: 3 / 4;
        background: #f1f5f9;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .qi-card-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .qi-card:hover .qi-card-image-wrap img {
        transform: scale(1.05);
    }
    .qi-card-overlay {
        position: absolute;
        inset: 0;
        background: rgba(3, 72, 51, 0.65);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .qi-card:hover .qi-card-overlay {
        opacity: 1;
    }
    .qi-btn-zoom {
        background: #ffffff;
        color: #034833;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease;
    }
    .qi-btn-zoom:hover {
        transform: scale(1.1);
        background: #83cd20;
        color: #ffffff;
    }
    .qi-card-body {
        padding: 14px 16px;
        text-align: center;
        background: #ffffff;
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .qi-card-name {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        line-height: 1.4;
    }

    /* Tabs Styling */
    .qi-tabs-nav {
        display: flex;
        gap: 8px;
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 30px;
        overflow-x: auto;
        padding-bottom: 2px;
    }
    .qi-tab-btn {
        padding: 12px 24px;
        font-size: 15px;
        font-weight: 700;
        color: #475569;
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        transition: all 0.25s ease;
        white-space: nowrap;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .qi-tab-btn:hover {
        color: #034833;
        background: #f0fdf4;
    }
    .qi-tab-btn.active {
        color: #034833;
        border-bottom-color: #034833;
        background: #ecfdf5;
    }
    .qi-tab-content {
        display: none;
    }
    .qi-tab-content.active {
        display: block;
        animation: fadeIn 0.35s ease-in-out;
    }

    /* Sub-sections for Ống PCCC */
    .qi-sub-section {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
    }
    .qi-sub-title {
        font-size: 16px;
        font-weight: 700;
        color: #034833;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #cbd5e1;
    }

    /* Empty State Box */
    .qi-empty-box {
        text-align: center;
        padding: 48px 24px;
        background: #f8fafc;
        border-radius: 12px;
        border: 2px dashed #cbd5e1;
        margin: 10px 0;
    }
    .qi-empty-icon {
        font-size: 40px;
        color: #94a3b8;
        margin-bottom: 12px;
    }
    .qi-empty-title {
        font-size: 16px;
        font-weight: 700;
        color: #334155;
        margin: 0 0 6px;
    }
    .qi-empty-desc {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .qi-section {
            padding: 24px 16px;
        }
        .qi-hero-title {
            font-size: 24px;
        }
        .qi-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 16px;
        }
        .qi-tab-btn {
            padding: 10px 16px;
            font-size: 14px;
        }
    }
</style>

<div class="qi-wrapper">
    <!-- Hero Banner -->
    <div class="qi-hero">
        <div class="qi-container">
            <ul class="qi-hero-breadcrumbs">
                <li><a href="/">Trang chủ</a></li>
                <li>/</li>
                <li style="font-weight: 700; color: #ffffff;">Kiểm định chất lượng</li>
            </ul>
            <h1 class="qi-hero-title">Kiểm Định Chất Lượng & Giấy Tờ Chứng Nhận</h1>
            <p class="qi-hero-subtitle">
                Tổng hợp đầy đủ hồ sơ kiểm định chất lượng, biên bản ủy quyền độc quyền phân phối và chứng nhận tiêu chuẩn quốc tế của VIREX.
            </p>
        </div>
    </div>

    <div class="qi-container">
        <!-- Phần 1: Ủy nhiệm độc quyền phân phối -->
        <div class="qi-section wow fadeInUp" data-wow-delay="0.1s">
            <div class="qi-section-header">
                <h2 class="qi-section-title">
                    <i class="fa fa-certificate"></i> 1. Ủy nhiệm độc quyền phân phối
                </h2>
                <span class="qi-badge">Bản chính thức</span>
            </div>

            @php
                $authSlides = $slides['quality-authorization']['item'] ?? [];
            @endphp

            @if(!empty($authSlides))
                <div class="qi-grid">
                    @foreach($authSlides as $index => $item)
                        <div class="qi-card">
                            <div class="qi-card-image-wrap">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] ?? 'Biên bản ủy quyền' }}">
                                <div class="qi-card-overlay">
                                    <a href="{{ $item['image'] }}" class="qi-btn-zoom" data-uk-lightbox="{group:'authorization'}" title="{{ $item['name'] ?? 'Biên bản ủy quyền' }}">
                                        <i class="fa fa-search-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="qi-card-body">
                                <h3 class="qi-card-name">{{ $item['name'] ?? 'Biên bản ủy quyền độc quyền phân phối' }}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="qi-empty-box">
                    <div class="qi-empty-icon"><i class="fa fa-clock-o"></i></div>
                    <h4 class="qi-empty-title">Dữ liệu đang được cập nhật</h4>
                    <p class="qi-empty-desc">Hồ sơ ủy quyền phân phối đang được hoàn thiện và sẽ sớm công bố.</p>
                </div>
            @endif
        </div>

        <!-- Phần 2: Giấy tờ kiểm nghiệm -->
        <div class="qi-section wow fadeInUp" data-wow-delay="0.2s">
            <div class="qi-section-header">
                <h2 class="qi-section-title">
                    <i class="fa fa-shield"></i> 2. Giấy tờ kiểm nghiệm
                </h2>
                <span class="qi-badge">Hồ sơ chứng nhận</span>
            </div>

            <!-- Tabs Nav -->
            <div class="qi-tabs-nav">
                <button class="qi-tab-btn active" onclick="switchTab(event, 'tab-pccc')">
                    <i class="fa fa-fire-extinguisher"></i> Ống PCCC
                </button>
                <button class="qi-tab-btn" onclick="switchTab(event, 'tab-inox')">
                    <i class="fa fa-cubes"></i> Ống Inox
                </button>
                <button class="qi-tab-btn" onclick="switchTab(event, 'tab-nhua')">
                    <i class="fa fa-tint"></i> Ống nhựa
                </button>
                <button class="qi-tab-btn" onclick="switchTab(event, 'tab-van')">
                    <i class="fa fa-sliders"></i> Các loại Van
                </button>
            </div>

            <!-- Tab Content 1: Ống PCCC -->
            <div id="tab-pccc" class="qi-tab-content active">
                <!-- 1. ISO -->
                <div class="qi-sub-section">
                    <h3 class="qi-sub-title">
                        <i class="fa fa-check-square-o" style="color: #034833;"></i> ISO (Chứng nhận tiêu chuẩn ISO)
                    </h3>
                    @php $isoSlides = $slides['quality-pccc-iso']['item'] ?? []; @endphp
                    @if(!empty($isoSlides))
                        <div class="qi-grid">
                            @foreach($isoSlides as $item)
                                <div class="qi-card">
                                    <div class="qi-card-image-wrap">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                        <div class="qi-card-overlay">
                                            <a href="{{ $item['image'] }}" class="qi-btn-zoom" data-uk-lightbox="{group:'pccc-iso'}" title="{{ $item['name'] }}">
                                                <i class="fa fa-search-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="qi-card-body">
                                        <h3 class="qi-card-name">{{ $item['name'] }}</h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="color: #64748b; font-style: italic;">Chưa có dữ liệu ISO.</p>
                    @endif
                </div>

                <!-- 2. Kết luận thử nghiệm S&Mai -->
                <div class="qi-sub-section">
                    <h3 class="qi-sub-title">
                        <i class="fa fa-file-text-o" style="color: #034833;"></i> Kết luận thử nghiệm S&Mai
                    </h3>
                    @php $smaiSlides = $slides['quality-pccc-smai']['item'] ?? []; @endphp
                    @if(!empty($smaiSlides))
                        <div class="qi-grid">
                            @foreach($smaiSlides as $item)
                                <div class="qi-card">
                                    <div class="qi-card-image-wrap">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                        <div class="qi-card-overlay">
                                            <a href="{{ $item['image'] }}" class="qi-btn-zoom" data-uk-lightbox="{group:'pccc-smai'}" title="{{ $item['name'] }}">
                                                <i class="fa fa-search-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="qi-card-body">
                                        <h3 class="qi-card-name">{{ $item['name'] }}</h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="color: #64748b; font-style: italic;">Chưa có dữ liệu kết luận thử nghiệm S&Mai.</p>
                    @endif
                </div>

                <!-- 3. KQKN -->
                <div class="qi-sub-section" style="margin-bottom: 0;">
                    <h3 class="qi-sub-title">
                        <i class="fa fa-clipboard" style="color: #034833;"></i> KQKN (Kết quả kiểm nghiệm)
                    </h3>
                    @php $kqknSlides = $slides['quality-pccc-kqkn']['item'] ?? []; @endphp
                    @if(!empty($kqknSlides))
                        <div class="qi-grid">
                            @foreach($kqknSlides as $item)
                                <div class="qi-card">
                                    <div class="qi-card-image-wrap">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                        <div class="qi-card-overlay">
                                            <a href="{{ $item['image'] }}" class="qi-btn-zoom" data-uk-lightbox="{group:'pccc-kqkn'}" title="{{ $item['name'] }}">
                                                <i class="fa fa-search-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="qi-card-body">
                                        <h3 class="qi-card-name">{{ $item['name'] }}</h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="color: #64748b; font-style: italic;">Chưa có dữ liệu kết quả kiểm nghiệm KQKN.</p>
                    @endif
                </div>
            </div>

            <!-- Tab Content 2: Ống Inox -->
            <div id="tab-inox" class="qi-tab-content">
                @php $inoxSlides = $slides['quality-inox']['item'] ?? []; @endphp
                @if(!empty($inoxSlides))
                    <div class="qi-grid">
                        @foreach($inoxSlides as $item)
                            <div class="qi-card">
                                <div class="qi-card-image-wrap">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                    <div class="qi-card-overlay">
                                        <a href="{{ $item['image'] }}" class="qi-btn-zoom" data-uk-lightbox="{group:'inox'}" title="{{ $item['name'] }}">
                                            <i class="fa fa-search-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="qi-card-body">
                                    <h3 class="qi-card-name">{{ $item['name'] }}</h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="qi-empty-box">
                        <div class="qi-empty-icon"><i class="fa fa-clock-o"></i></div>
                        <h4 class="qi-empty-title">Dữ liệu đang được cập nhật</h4>
                        <p class="qi-empty-desc">Hồ sơ kiểm định Ống Inox hiện đang được hoàn thiện và sẽ cập nhật sớm nhất.</p>
                    </div>
                @endif
            </div>

            <!-- Tab Content 3: Ống nhựa -->
            <div id="tab-nhua" class="qi-tab-content">
                @php $nhuaSlides = $slides['quality-nhua']['item'] ?? []; @endphp
                @if(!empty($nhuaSlides))
                    <div class="qi-grid">
                        @foreach($nhuaSlides as $item)
                            <div class="qi-card">
                                <div class="qi-card-image-wrap">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                    <div class="qi-card-overlay">
                                        <a href="{{ $item['image'] }}" class="qi-btn-zoom" data-uk-lightbox="{group:'nhua'}" title="{{ $item['name'] }}">
                                            <i class="fa fa-search-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="qi-card-body">
                                    <h3 class="qi-card-name">{{ $item['name'] }}</h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="qi-empty-box">
                        <div class="qi-empty-icon"><i class="fa fa-clock-o"></i></div>
                        <h4 class="qi-empty-title">Dữ liệu đang được cập nhật</h4>
                        <p class="qi-empty-desc">Hồ sơ kiểm định Ống nhựa hiện đang được hoàn thiện và sẽ cập nhật sớm nhất.</p>
                    </div>
                @endif
            </div>

            <!-- Tab Content 4: Các loại Van -->
            <div id="tab-van" class="qi-tab-content">
                @php $vanSlides = $slides['quality-van']['item'] ?? []; @endphp
                @if(!empty($vanSlides))
                    <div class="qi-grid">
                        @foreach($vanSlides as $item)
                            <div class="qi-card">
                                <div class="qi-card-image-wrap">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                    <div class="qi-card-overlay">
                                        <a href="{{ $item['image'] }}" class="qi-btn-zoom" data-uk-lightbox="{group:'van'}" title="{{ $item['name'] }}">
                                            <i class="fa fa-search-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="qi-card-body">
                                    <h3 class="qi-card-name">{{ $item['name'] }}</h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="qi-empty-box">
                        <div class="qi-empty-icon"><i class="fa fa-clock-o"></i></div>
                        <h4 class="qi-empty-title">Dữ liệu đang được cập nhật</h4>
                        <p class="qi-empty-desc">Hồ sơ kiểm định Các loại Van hiện đang được hoàn thiện và sẽ cập nhật sớm nhất.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(evt, tabId) {
        evt.preventDefault();
        const tabBtns = document.querySelectorAll('.qi-tab-btn');
        const tabContents = document.querySelectorAll('.qi-tab-content');

        tabBtns.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));

        evt.currentTarget.classList.add('active');
        const activeTab = document.getElementById(tabId);
        if (activeTab) {
            activeTab.classList.add('active');
        }
    }
</script>
@endsection
