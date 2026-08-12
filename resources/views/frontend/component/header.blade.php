<header class="tazen-header">
    <!-- TOP BAR -->
    <div class="header-top-bar">
        <div class="uk-container uk-container-center header-container">
            <div class="top-bar-container">
                <!-- Left: Hotline & Email -->
                <div class="top-bar-left">
                    <a href="tel:{{ $system['contact_hotline'] ?? '024 7309 9997' }}" class="top-bar-info">
                        <i class="fa fa-phone icon-blue"></i> Hotline: {{ $system['contact_hotline'] ?? '024 7309 9997' }}
                    </a>
                    <a href="mailto:{{ $system['contact_email'] ?? 'contact@virex.vn' }}" class="top-bar-info">
                        <i class="fa fa-envelope icon-blue"></i> Email: {{ $system['contact_email'] ?? 'contact@virex.vn' }}
                    </a>
                </div>

                <!-- Center: Search Input -->
                <div class="top-bar-search">
                    <form action="{{ url('tim-kiem') }}" method="GET" class="search-form">
                        <input type="text" name="keyword" placeholder="Tìm sản phẩm, danh mục, thương hiệu..." value="{{ request('keyword') }}" class="search-input">
                        <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>

                <!-- Right: Zalo, Facebook, Yêu cầu báo giá -->
                <div class="top-bar-right">
                    <a href="{{ $system['social_zalo'] ?? '#' }}" class="top-bar-btn btn-zalo" target="_blank">
                        <svg class="zalo-img" style="width: 16px; height: 16px; fill: #0068ff; vertical-align: middle; margin-right: 4px;" viewBox="0 0 24 24">
                            <path d="M12.002 2C6.5 2 2 5.86 2 10.63c0 2.92 1.68 5.53 4.27 7.02-.12.48-.77 2.92-.85 3.25-.1.38.09.37.38.18.27-.17 2.43-1.62 3.37-2.26.9.23 1.86.36 2.83.36 5.5 0 10-3.86 10-8.63C22 5.86 17.5 2 12.002 2zm3.83 11.25c0 .41-.34.75-.75.75H9.67c-.55 0-.85-.63-.51-1.07l2.89-3.68H9.72c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h4.94c.55 0 .85.63.51 1.07l-2.89 3.68h3.25c.41 0 .75.34.75.75z"/>
                        </svg> Zalo
                    </a>
                    <a href="{{ $system['contact_facebook'] ?? ($system['social_facebook'] ?? '#') }}" class="top-bar-btn btn-facebook" target="_blank">
                        <i class="fa fa-facebook-official"></i> Facebook
                    </a>
                    <a href="{{ url('lien-he') }}" class="top-bar-btn btn-quote">
                        <i class="fa fa-paper-plane"></i> Yêu cầu báo giá
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN HEADER -->
    <div class="header-main-bar">
        <div class="uk-container uk-container-center header-container">
            <div class="main-bar-container">
                <!-- Logo -->
                <div class="logo">
                    <a href="/" title="{{ $system['homepage_brand'] ?? 'VIREX' }}">
                        <img src="{{ $system['homepage_logo'] ?? '' }}" alt="{{ $system['homepage_brand'] ?? 'VIREX' }}">
                    </a>
                </div>

                <!-- Navigation Menu Desktop -->
                <nav class="desktop-navigation uk-visible-large">
                    <ul class="main-menu uk-flex uk-flex-middle uk-list uk-clearfix">
                        {!! $menu['main-menu'] ?? '' !!}
                    </ul>
                </nav>

                <!-- Right Utility: Download Document -->
                <div class="header-main-right uk-visible-large">
                    <a href="{{ $system['homepage_download_link'] ?? '#' }}" class="btn-download-doc" target="_blank">
                        <i class="fa fa-download"></i> Tải tài liệu
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <a class="mobile-menu-btn uk-hidden-large" href="#offcanvas" data-uk-offcanvas="{target:'#offcanvas'}">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu Offcanvas -->
<div id="offcanvas" class="uk-offcanvas">
    <div class="uk-offcanvas-bar mobile-menu-offcanvas">
        <button class="uk-offcanvas-close mobile-menu-close" type="button">
            <i class="fa fa-times"></i>
        </button>
        
        <div class="mobile-menu-header">
            <div class="mobile-menu-logo">
                <a href="/" title="Logo">
                    <img src="{{ $system['homepage_logo'] ?? '' }}" alt="Logo" />
                </a>
            </div>
        </div>

        <nav class="mobile-menu-nav">
            <ul class="uk-nav uk-nav-offcanvas mobile-menu-list">
                {!! $menu['mobile-menu-html'] ?? '' !!}
            </ul>
        </nav>
    </div>
</div>

<style>
/* CSS Styles for the updated header */
.tazen-header {
    width: 100%;
    z-index: 100;
    position: relative;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}
.tazen-header .header-top-bar {
    background-color: #eaeaea !important;
    background: #eaeaea !important;
    border-bottom: 1px solid #dcdcdc;
    padding: 8px 0;
    font-size: 13px;
}
.tazen-header .header-top-bar,
.tazen-header .header-top-bar a,
.tazen-header .header-top-bar .top-bar-info {
    color: #333 !important;
    text-decoration: none;
}
.top-bar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.top-bar-left {
    display: flex;
    gap: 20px;
    align-items: center;
}
.tazen-header .header-top-bar .top-bar-info {
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: color 0.2s;
}
.tazen-header .header-top-bar .top-bar-info:hover {
    color: #154284 !important;
}
.icon-blue {
    color: #154284 !important;
    font-size: 14px;
}
.top-bar-search {
    flex: 0 0 350px;
    position: relative;
}
.search-form {
    position: relative;
    width: 100%;
}
.search-input {
    width: 100%;
    height: 34px;
    padding: 0 40px 0 15px;
    border: 1px solid #ccc;
    border-radius: 20px;
    outline: none;
    font-size: 12.5px;
    color: #333;
    background-color: #fff;
    box-sizing: border-box;
    transition: border-color 0.2s;
}
.search-input:focus {
    border-color: #154284;
}
.search-submit {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 6px 10px;
    color: #888;
    font-size: 13px;
}
.search-submit:hover {
    color: #154284;
}
.top-bar-right {
    display: flex;
    gap: 10px;
    align-items: center;
}
.top-bar-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    height: 34px;
    padding: 0 15px;
    border-radius: 20px;
    font-size: 12.5px;
    font-weight: 600;
    text-decoration: none;
    box-sizing: border-box;
    transition: all 0.2s ease-in-out;
}
.btn-zalo {
    background: #fff;
    border: 1px solid #d1d5db;
    color: #0068ff !important;
}
.btn-zalo:hover {
    background: #f8fafc;
    border-color: #0068ff;
}
.zalo-img {
    width: 16px;
    height: 16px;
    object-fit: contain;
}
.btn-facebook {
    background: #fff;
    border: 1px solid #d1d5db;
    color: #1877f2 !important;
}
.btn-facebook:hover {
    background: #f8fafc;
    border-color: #1877f2;
}
.btn-facebook i {
    font-size: 16px;
}
.btn-quote {
    background: #034833;
    color: #fff !important;
    border: 1px solid #034833;
}
.btn-quote:hover {
    background: #023022;
    border-color: #023022;
    color: #fff !important;
}
.btn-quote i {
    font-size: 12px;
}

/* MAIN BAR styles */
.header-main-bar {
    background: #fff;
    padding: 10px 0;
}
.main-bar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.logo img {
    height: 50px;
    width: auto;
    object-fit: contain;
}
.desktop-navigation {
    flex-grow: 1;
    display: flex;
    justify-content: center;
    position: relative;
}
.main-menu {
    display: flex;
    gap: 15px;
    list-style: none;
    margin: 0;
    padding: 0;
}
.main-menu > li {
    position: relative;
    padding: 10px 0;
}
.main-menu > li > a {
    color: #475569 !important;
    font-weight: 600;
    text-decoration: none;
    font-size: 14.5px;
    padding: 8px 12px;
    text-transform: uppercase;
    transition: color 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.main-menu > li > a:hover,
.main-menu > li > a.active {
    color: #154284 !important;
}

/* Multi-Level Dropdown Styling */
.main-menu li.children {
    position: relative;
}

.main-menu > li.children > a::after {
    content: '\f107';
    font-family: 'FontAwesome';
    font-size: 12px;
    margin-left: 4px;
    color: #64748b;
    transition: transform 0.2s ease, color 0.2s ease;
}

.main-menu > li.children:hover > a::after {
    color: #154284;
    transform: rotate(180deg);
}

/* Dropdown Menu Container (Level 2 & Level 3) */
.main-menu .dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 230px;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.08);
    border: 1px solid #e2e8f0;
    padding: 6px 0;
    z-index: 99999;
    animation: dropdownFadeIn 0.2s ease-out;
}

.main-menu li:hover > .dropdown-menu {
    display: block;
}

.main-menu .dropdown-menu ul {
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
}

.main-menu .dropdown-menu li {
    position: relative;
    margin: 0 !important;
    padding: 0 !important;
    display: block;
    width: 100%;
}

.main-menu .dropdown-menu li a {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 10px 18px !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    color: #334155 !important;
    text-transform: none !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
    white-space: nowrap !important;
    background: transparent !important;
}

.main-menu .dropdown-menu li:hover > a {
    background-color: #f1f5f9 !important;
    color: #154284 !important;
    padding-left: 22px !important;
}

/* Level 2 Sub-item with Children (e.g., Các loại Van) */
.main-menu .dropdown-menu li.children > a::after {
    content: '\f105';
    font-family: 'FontAwesome';
    font-size: 13px;
    color: #94a3b8;
    margin-left: 15px;
    transition: transform 0.2s ease, color 0.2s ease;
}

.main-menu .dropdown-menu li.children:hover > a::after {
    color: #154284;
    transform: translateX(3px);
}

/* Level 3 Sub-menu (Pops out to the Right) */
.main-menu .dropdown-menu li.children > .dropdown-menu {
    top: -6px;
    left: 100%;
    margin-left: 4px;
    min-width: 220px;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.15);
}

.btn-download-doc {
    background: #154284;
    color: #fff;
    padding: 8px 18px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.2s;
}
.btn-download-doc:hover {
    background: #0e3061;
    color: #fff;
}
.btn-download-doc i {
    font-size: 14px;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .top-bar-search {
        flex: 0 0 250px;
    }
}
@media (max-width: 959px) {
    .header-top-bar {
        display: none; /* Hide top bar on mobile */
    }
}

/* Sticky Header styles for desktop */
@media (min-width: 960px) {
    .tazen-header.is-sticky {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        z-index: 9999 !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
        animation: headerSlideDown 0.3s ease-out !important;
    }
    .tazen-header.is-sticky .header-top-bar {
        display: none !important;
    }
    .mobile-menu-list .uk-parent > a::after {
        display: none !important;
    }
}

@keyframes dropdownFadeIn {
    from {
        opacity: 0;
        transform: translateY(6px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes headerSlideDown {
    from {
        transform: translateY(-100%);
    }
    to {
        transform: translateY(0);
    }
}
</style>

<script>
    $(document).ready(function() {
        var currentUrl = window.location.pathname;
        if (currentUrl.length > 1 && currentUrl.substr(-1) === '/') {
            currentUrl = currentUrl.substr(0, currentUrl.length - 1);
        }
        
        $('.main-menu > li > a').each(function() {
            var href = $(this).attr('href');
            if (href === '.' || href === '/' || href === window.location.origin || href === window.location.origin + '/') {
                if (currentUrl === '/' || currentUrl === '') {
                    $(this).addClass('active');
                }
            } else {
                var cleanHref = href;
                if (cleanHref.indexOf('/') !== 0 && cleanHref.indexOf('http') !== 0) {
                    cleanHref = '/' + cleanHref;
                }
                if (currentUrl === cleanHref || currentUrl.indexOf(cleanHref) === 0) {
                    $(this).addClass('active');
                }
            }
        });

        // Sticky Header scroll listener
        $(window).on('scroll', function() {
            if ($(window).scrollTop() > 100) {
                $('.tazen-header').addClass('is-sticky');
            } else {
                $('.tazen-header').removeClass('is-sticky');
            }
        });

        // Mobile submenu accordion toggle
        $('.mobile-menu-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var $parentLi = $(this).closest('li.mobile-parent-item');
            var $subMenu = $parentLi.children('.mobile-submenu-list');
            
            // Toggle submenu slide
            $subMenu.slideToggle(300);
            
            // Rotate chevron icon
            var $icon = $(this).find('i');
            if ($icon.hasClass('fa-chevron-down')) {
                $icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
                $(this).css('transform', 'rotate(180deg)');
            } else {
                $icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
                $(this).css('transform', 'rotate(0deg)');
            }
        });
    });
</script>