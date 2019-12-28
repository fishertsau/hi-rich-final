@extends('app.layouts.master')

@section('content')
    <div class="page-bg">
        <section class="product-box">
            <div class="container">
                <div class="row">
                    @include('app.products.categorySidebar')
                   
                    {{-- todo: get content from db --}}
                    <div class="col-md-9 col-sm-8 col-12 mobile-product-detail">
                        <div class="btn-box">
                            <a href="/news.html" class="link-back">回上頁<span class="img-back"></span></a>
                        </div>
                        <div class="product-content">
                            <div class="artical-title">
                                <span class="text-main">蘭花蚌-</span>
                                <span class="text-sub">Surf Clam Meat</span>
                            </div>
                            <div class="img-product">
                                <img src="/asset/images/products/product05.jpg">
                            </div>
                            <div class="product-form">
                                <div class="form-item">
                                    <span class="item-title">產地:</span>
                                    <span class="item-text">加拿大</span>
                                </div>
                                <div class="form-item">
                                    <span class="item-title">規格:</span>
                                    <span class="item-text">XXXXXXXXXX</span>
                                </div>
                            </div>

                            <!-- 編輯器開始 -->
                            <div class="editor-box set-height">
                                <p style="font-size:16px;color:#707070;">
                                    內文內文內文內文內文內文內文內文內文內文內文內文內文內文內文內文內文
                                </p>
                                <p style="font-size:16px;color:#707070;">
                                    內文內文內文內文內文內文內文內文內文內文內文內文
                                </p>
                                <p style="font-size:16px;color:#707070;">
                                    內文內文內文內文內文內文內文內文內文內文內文內文內文內文
                                </p>
                                <p style="font-size:16px;color:#707070;">
                                    內文內文內文內文內文內文內文內文內文內文內文內文內文
                                </p>
                            </div>
                            <!-- 編輯器結束 -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
