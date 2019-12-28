@extends('app.layouts.master')

@section('content')
    <div class="page-bg">
        <section class="product-box">
            <div class="container">
                <div class="row">
                    @include('app.products.categorySidebar')
                    <div class="col-md-9 col-sm-8 col-12">
                        <div class="section-title">全部產品</div>
                        <div class="links-list set-height">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <a href="/products/1" class="links-item">
                                        <img src="/asset/images/products/product03.jpg">
                                        <span class="text-links-name">鮑魚</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <a href="/product-detail.html" class="links-item">
                                        <img src="/asset/images/products/product04.jpg">
                                        <span class="text-links-name">櫛恐貝</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <a href="/product-detail.html" class="links-item">
                                        <img src="/asset/images/products/product01.jpg">
                                        <span class="text-links-name">北寄貝</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <a href="/product-detail.html" class="links-item">
                                        <img src="/asset/images/products/product02.jpg">
                                        <span class="text-links-name">帆立貝</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <a href="/product-detail.html" class="links-item">
                                        <img src="/asset/images/products/product03.jpg">
                                        <span class="text-links-name">鮑魚</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <a href="/product-detail.html" class="links-item">
                                        <img src="/asset/images/products/product04.jpg">
                                        <span class="text-links-name">櫛恐貝</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <a href="/product-detail.html" class="links-item">
                                        <img src="/asset/images/products/product01.jpg">
                                        <span class="text-links-name">北寄貝</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <a href="/product-detail.html" class="links-item">
                                        <img src="/asset/images/products/product02.jpg">
                                        <span class="text-links-name">帆立貝</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <a href="/product-detail.html" class="links-item">
                                        <img src="/asset/images/products/product03.jpg">
                                        <span class="text-links-name">鮑魚</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <a href="/product-detail.html" class="links-item">
                                        <img src="/asset/images/products/product04.jpg">
                                        <span class="text-links-name">櫛恐貝</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{--todo: implemet this --}}
                        <ul class="pagination">
                            <li><a href="#" aria-label="Previous"><span aria-hidden="true">&larr;</span></a></li>
                            <li class="active"><a href="#">1</a>
                            </li>
                            <li><a href="#">2</a>
                            </li>
                            <li><a href="#">3</a>
                            </li>
                            <li><a href="#">4</a>
                            </li>
                            <li><a href="#">5</a>
                            </li>
                            <li><a href="#" aria-label="Next"><span aria-hidden="true">&rarr;</span></a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
