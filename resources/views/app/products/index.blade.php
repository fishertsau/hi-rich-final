@extends('app.layouts.master')

@section('content')
    <div id="container">
        <div class="page-bg">
            <section class="product-box">
                <div class="container">
                    <div class="row">
                        @include('app.products.categorySidebar')

                        <div v-show="!chosenProduct.title" v-cloak
                             class="col-md-9 col-sm-8 col-12">
                            <div class="section-title">
                                @{{ pageTitle }} <span @click.prevent="more()">more</span>
                            </div>
                            <div class="links-list set-height">
                                <div class="row">
                                    <div v-for="product in chosenProducts"
                                         class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                        <a href="javascript:;"
                                           @click.prevent="setActiveProduct(product)"
                                           class="links-item">
                                            <img :src="'/storage/'+product.photoPath">
                                            <span class="text-links-name">@{{product.title}}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{--todo: implement this --}}
                            {{$products->links('vendor.pagination.app')}}
                        </div>

                        {{-- todo: get content from db --}}
                        <div v-show="chosenProduct.id" v-cloak
                             class="col-md-9 col-sm-8 col-12 mobile-product-detail">
                            {{--todo: change this--}}
                            <div class="btn-box">
                                {{--todo: implement this--}}
                                <a href="/products" class="link-back">回上頁<span class="img-back"></span></a>
                            </div>
                            <div class="product-content">
                                <div class="artical-title">
                                    <span class="text-main">蘭花蚌- @{{ chosenProduct.title }}</span>
                                    <span class="text-sub">Surf Clam Meat</span>
                                </div>
                                <div class="img-product">
                                    <img src="/asset/images/products/product05.jpg">
                                </div>
                                <div class="product-form">
                                    {{--每個產品都要有這些嗎?--}}
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
                                    {{--@{{ activeProduct.body }}--}}
                                </div>
                                <!-- 編輯器結束 -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>


    </div>
@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/app/products/index.js') }}"></script>
@endsection
