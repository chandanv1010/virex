@php
    // Chuẩn bị dữ liệu
    $prd_title = $product->name;
    $prd_code = $product->code;
    $prd_model = $product->model ?? '';

    $albumSource = is_array($product->album) ? $product->album : json_decode($product->album ?? '[]', true);
    $list_image = array_values(array_filter(is_array($albumSource) ? $albumSource : []));

    if (!empty($product->image)) {
        array_unshift($list_image, $product->image);
    }

    $list_image = array_values(array_unique($list_image));
    $prd_href = write_url($product->canonical ?? '');
    $prd_description = $product->description ?? '';
    $prd_extend_des = $product->content ?? '';
    $price = getPrice($product);
    $stockQuantity = (int) ($product->stock ?? 0);
    $wishlistItems = isset($wishlist) ? $wishlist : collect();
    $wishlistIds = $wishlistItems->pluck('id')->toArray();
    $isWishlisted = in_array($product->id, $wishlistIds);

@endphp


@extends('frontend.homepage.layout')

@section('content')

    <div id="prddetail" class="page-body" style="background:#fff;">
        <div class="cat-hero-section" style="background-image: url('/vendor/frontend/img/project/breadcrumb.png');">
            <div class="cat-hero-overlay"></div>
            <div class="cat-hero-shapes">
                <div class="shape shape-left"></div>
                <div class="shape shape-right"></div>
            </div>
            <div class="uk-container uk-container-center cat-hero-container">
                <h1 class="cat-hero-title">{{ $prd_title }}</h1>
                <ul class="uk-list uk-clearfix uk-flex uk-flex-middle uk-flex-center cat-hero-breadcrumbs">
                    <li><a href="/">Trang chủ</a></li>
                    @if(!is_null($breadcrumb))
                        @foreach($breadcrumb as $key => $val)
                            @php
                                $name = $val->languages->first()->pivot->name;
                                $canonical = write_url($val->languages->first()->pivot->canonical, true, true);
                            @endphp
                            <li class="separator">&raquo;</li>
                            <li><a href="{{ $canonical }}">{{ $name }}</a></li>
                        @endforeach
                    @endif
                    <li class="separator">&raquo;</li>
                    <li><a href="#" onclick="return false;">{{ \Illuminate\Support\Str::limit($prd_title, 40) }}</a></li>
                </ul>
            </div>
        </div>


        <section class="prddetail">
            <div class="uk-container uk-container-center">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-1-2">
                        <div class="product-gallery">
                            @if (isset($list_image) && !empty($list_image) && !is_null($list_image))
                                <div class="product-list_image">
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper big-pic">
                                            <?php foreach($list_image as $key => $val){  ?>
                                            <div class="swiper-slide" data-swiper-autoplay="2000">
                                                <a href="{{ $val }}"
                                                    class="image img-cover img-v">
                                                    <img src="{{ image($val) }}" alt="<?php echo $val; ?>">
                                                </a>
                                            </div>
                                            <?php }  ?>
                                        </div>
                                    </div>
                                    <div class="swiper-container-thumbs">
                                        <div class="swiper-wrapper pic-list">
                                            <?php foreach($list_image as $key => $val){  ?>
                                            <div class="swiper-slide">
                                                <span class="image img-cover"><img src="{{ image($val) }}"
                                                        alt="<?php echo $val; ?>"></span>
                                            </div>
                                            <?php }  ?>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="uk-width-large-1-2">
                        <div class="product-info">
                            <h1 class="prd-name">{{ $prd_title }}</h1>
                            <div class="rate-container" style="margin-bottom: 15px;">
                                <div class="uk-flex uk-flex-middle">
                                    <span class="uk-flex uk-flex-middle addToWishlist {{ $isWishlisted ? 'active' : '' }}"
                                        data-id="{{ $product->id }}" role="button" tabindex="0" style="padding-left: 0;">
                                        <i
                                            class="fa wishlist-icon {{ $isWishlisted ? 'fa-heart wishlist-icon--active' : 'fa-heart-o' }}"></i>
                                        <span class="number {{ $isWishlisted ? 'wishlist-active' : 'wishlist-inactive' }}">
                                            {{ $isWishlisted ? 'Đã yêu thích' : 'Thêm vào yêu thích' }}
                                        </span>
                                    </span>
                                </div>
                            </div>

                            {{-- Thông tin sản phẩm đẹp --}}
                            <div class="prd-info-box">
                                @if(!empty($product->code))
                                <div class="info-row">
                                    <span class="info-label"><i class="fa fa-barcode"></i> Mã sản phẩm</span>
                                    <span class="info-value">{{ $product->code }}</span>
                                </div>
                                @endif
                                @if(!empty($product->made_in))
                                <div class="info-row">
                                    <span class="info-label"><i class="fa fa-globe"></i> Xuất xứ</span>
                                    <span class="info-value">{{ $product->made_in }}</span>
                                </div>
                                @endif
                                @if(!empty($productCatalogue->name))
                                <div class="info-row">
                                    <span class="info-label"><i class="fa fa-tag"></i> Danh mục</span>
                                    <span class="info-value">{{ $productCatalogue->name }}</span>
                                </div>
                                @endif
                                @if($stockQuantity > 0)
                                <div class="info-row">
                                    <span class="info-label"><i class="fa fa-check-circle"></i> Tình trạng</span>
                                    <span class="info-value in-stock">Còn hàng</span>
                                </div>
                                @endif
                            </div>

                            <div class="description">
                                {!! $product->description !!}
                            </div>
    
    

    
    
                            <div class="prd-option">
                                <div class="option-block">
                                    <div class="product-stock">
                                        <div class="prd-actions-block">
                                            <a href="tel:{{ $system['contact_hotline'] ?? '0828 27 6666' }}" class="btn-action-detail btn-red-action">LIÊN HỆ NGAY</a>
                                            <a href="tel:{{ $system['contact_hotline'] ?? '0828 27 6666' }}" class="btn-action-detail btn-green-action">HOTLINE: {{ $system['contact_hotline'] ?? '0828 27 6666' }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Cam kết --}}
                            <div class="prd-commitment-row">
                                <div class="commitment-item">
                                    <i class="fa fa-shield"></i>
                                    <span>Bảo hành chính hãng</span>
                                </div>
                                <div class="commitment-item">
                                    <i class="fa fa-truck"></i>
                                    <span>Giao hàng toàn quốc</span>
                                </div>
                                <div class="commitment-item">
                                    <i class="fa fa-phone"></i>
                                    <span>Hỗ trợ 24/7</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="block-extend">
            <div class="uk-container uk-container-center">
                <div class="premium-detail-block">
                    <div class="detail-tab-header">
                        <h2 class="detail-tab-title">Thông tin chi tiết</h2>
                    </div>
                    <div class="detail-tab-body">
                        {!! $product->content !!}
                    </div>
                </div>

                {{-- Sản phẩm liên quan --}}
                @if (!is_null($productCatalogue->products))
                    <section class="categories-panel uk-margin-large-top">
                        <h2 class="heading-1">
                            <a href="#" onclick="return false;" title="Sản phẩm liên quan">Sản phẩm liên quan</a>
                        </h2>

                        <ul class="uk-list uk-clearfix uk-grid uk-grid-medium uk-grid-width-1-1 uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4">
                            @foreach ($productCatalogue->products as $key => $valPost)
                                @php
                                    if ($key > 7) {
                                        break;
                                    }
                                    $name = $valPost->languages->first()->pivot->name;
                                    $image = $valPost->image;
                                    $canonical = write_url($valPost->languages->first()->pivot->canonical);
                                    $price = getPrice($valPost);
                                    $ml = $valPost->ml;
                                    $percent = $valPost->percent;
                                    $madeIn = $valPost->made_in;
                                @endphp

                                <li class="uk-margin-bottom">
                                    <div class="premium-product-card" style="height: 380px;">
                                        <a href="{{ $canonical }}" class="card-image-link img-scaledown img-zoomin">
                                            <img src="{{ $image }}" alt="{{ $name }}" class="card-image">
                                        </a>
                                        <div class="card-overlay" style="padding: 16px;">
                                            <div class="card-info-left" style="padding-right: 8px;">
                                                <span class="card-category" style="font-size: 10px;">{{ $productCatalogue->name }}</span>
                                                <h3 class="card-title" style="font-size: 14px; margin-bottom: 4px;">
                                                    <a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a>
                                                </h3>
                                            </div>
                                            <div class="card-action-right">
                                                <a href="{{ $canonical }}" class="btn-contact" style="padding: 6px 12px; font-size: 11px;">
                                                    Liên hệ <span class="arrow">&rarr;</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const consultForm = document.getElementById('consult-submit-form');
                if (consultForm) {
                    consultForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(consultForm);
                        
                        fetch('/ajax/contact/advise', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.code === 10 || data.status === 200 || data.response) {
                                toastr.success('Đăng ký nhận tư vấn thành công! Chúng tôi sẽ liên hệ lại sớm nhất.');
                                consultForm.reset();
                            } else {
                                toastr.error(data.messages && data.messages.name ? data.messages.name : 'Có lỗi xảy ra, vui lòng thử lại.');
                            }
                        })
                        .catch(error => {
                            toastr.error('Có lỗi kết nối hệ thống, vui lòng thử lại sau.');
                        });
                    });
                }
            });
        </script>



    </div> {{-- #prddetail --}}

@endsection

<style>
    /* ===== PRODUCT DETAIL PAGE STYLES ===== */
    
    /* Price highlight */
    .price-highlight {
        color: #f27a24 !important;
        font-size: 22px;
        font-weight: 700;
        margin-left: 10px;
    }

    .product-info .price-sale {
        color: #f27a24 !important;
    }

    /* Product info box */
    .prd-info-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 16px 20px;
        margin: 16px 0;
        border-left: 4px solid #f27a24;
    }

    .info-row {
        display: flex;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #666;
        min-width: 140px;
        font-weight: 500;
    }

    .info-label i {
        color: #f27a24;
        width: 18px;
        margin-right: 6px;
    }

    .info-value {
        color: #222;
        font-weight: 600;
    }

    .info-value.in-stock {
        color: #27ae60;
    }

    /* Contact full-width button - Premium Styling */
    .btn-contact-full {
        width: 100%;
        margin-bottom: 16px;
    }

    .btn-contact-full a {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        width: 100%;
        background: linear-gradient(135deg, #f27a24 0%, #ff6f00 100%);
        color: #fff !important;
        text-decoration: none !important;
        border-radius: 12px;
        padding: 14px 28px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 4px 15px rgba(242, 122, 36, 0.35);
        position: relative;
        overflow: hidden;
        gap: 16px;
    }

    .btn-contact-full a::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transform: skewX(-20deg);
        animation: shine-effect 4s infinite;
    }

    @keyframes shine-effect {
        0% { left: -100%; }
        50% { left: 120%; }
        100% { left: 120%; }
    }

    .btn-contact-full a:hover {
        background: linear-gradient(135deg, #e65100 0%, #bf360c 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(242, 122, 36, 0.45);
        color: #fff !important;
    }

    .phone-icon-circle {
        background: rgba(255, 255, 255, 0.2);
        width: 44px !important;
        height: 44px !important;
        min-width: 44px !important;
        min-height: 44px !important;
        max-width: 44px !important;
        max-height: 44px !important;
        border-radius: 50% !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-shrink: 0 !important;
        align-self: center !important;
        transition: all 0.3s ease;
        box-sizing: border-box !important;
    }

    .btn-contact-full a:hover .phone-icon-circle {
        background: #fff;
    }

    .btn-contact-full a:hover .phone-icon-circle i {
        color: #f27a24;
    }

    .phone-icon-circle i {
        font-size: 18px;
        color: #fff;
        animation: phone-bounce 1.2s infinite alternate;
    }

    .btn-contact-text {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .btn-contact-full .title {
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin: 0;
    }

    .btn-contact-full .sub-title {
        font-size: 15px;
        font-weight: 700;
        opacity: 0.95;
        margin-top: 2px;
        background: rgba(255, 255, 255, 0.18);
        padding: 2px 8px;
        border-radius: 4px;
        letter-spacing: 1px;
    }

    @keyframes phone-bounce {
        0% { transform: rotate(-15deg); }
        100% { transform: rotate(15deg); }
    }

    @media (max-width: 480px) {
        .btn-contact-full a {
            padding: 12px 16px;
            gap: 12px;
        }
        .phone-icon-circle {
            width: 38px;
            height: 38px;
        }
        .phone-icon-circle i {
            font-size: 16px;
        }
        .btn-contact-full .title {
            font-size: 14px;
        }
        .btn-contact-full .sub-title {
            font-size: 13px;
        }
    }

    /* Out of stock */
    .btn-out-stock {
        width: 100%;
        border: none;
        border-radius: 6px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #d3d3d3;
        color: #4a4a4a;
        font-weight: 600;
        cursor: not-allowed;
    }

    .btn-out-stock .icon svg {
        stroke: #4a4a4a;
    }

    /* Commitment row */
    .prd-commitment-row {
        display: flex;
        gap: 12px;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #eee;
        flex-wrap: wrap;
    }

    .commitment-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #555;
        flex: 1;
        min-width: 100px;
    }

    .commitment-item i {
        color: #f27a24;
        font-size: 15px;
    }

    /* Product content title */
    .prd-content-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e4794;
        border-bottom: 3px solid #f27a24;
        padding-bottom: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .prd-content-title::before {
        content: '';
        display: inline-block;
        width: 5px;
        height: 24px;
        background: #f27a24;
        border-radius: 3px;
    }

    /* Description */
    .product-info .description {
        margin: 16px 0;
        font-size: 15px;
        line-height: 1.8;
        color: #444;
        margin-bottom: 30px;
        background: none;
        border: none;
    }

    /* Wishlist */
    .addToWishlist {
        cursor: pointer;
        gap: 6px;
    }

    .wishlist-active {
        color: #f27a24;
    }

    .wishlist-inactive {
        color: #1e4794;
    }

    .addToWishlist .wishlist-icon--active,
    .addToWishlist.active .wishlist-icon {
        color: #f27a24;
    }

    /* Star count, total reviews */
    .star-count {
        color: #f27a24;
        font-weight: 700;
        margin: 0 6px;
    }

    /* product name */
    .prd-name {
        font-size: 24px;
        font-weight: 700;
        color: #1e4794;
        margin-bottom: 12px;
        line-height: 1.3;
    }

    /* Hover on all a tags - orange */
    #prddetail a:hover {
        color: #f27a24 !important;
    }

    /* But not the buttons */
    .btn-contact-full a:hover {
        color: #fff !important;
    }

    /* Article content */
    .prd-shipping-policy {
        line-height: 1.9;
        font-size: 15px;
        color: #444;
        padding: 30px !important;
        background: #ffffff !important;
        border: 1px solid #eef2f6 !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02) !important;
        margin-top: 15px !important;
        box-sizing: border-box !important;
    }
    
    @media (max-width: 768px) {
        .prd-shipping-policy {
            padding: 20px 15px !important;
        }
    }

    .prd-shipping-policy h2,
    .prd-shipping-policy h3 {
        color: #1e4794;
        margin-top: 24px;
    }

    /* Fix list styling in product information */
    .prd-shipping-policy ul {
        list-style-type: disc !important;
        padding-left: 24px !important;
        margin: 12px 0 !important;
    }

    .prd-shipping-policy ol {
        list-style-type: decimal !important;
        padding-left: 24px !important;
        margin: 12px 0 !important;
    }

    .prd-shipping-policy li {
        margin-bottom: 8px !important;
        line-height: 1.6 !important;
        display: list-item !important;
        list-style: inherit !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .prd-commitment-row {
            gap: 8px;
        }

        .commitment-item {
            min-width: 45%;
        }

        .prd-info-box {
            padding: 12px 15px;
        }
    }
</style>
