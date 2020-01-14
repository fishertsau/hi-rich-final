@extends('app.layouts.master')

@section('content')
    <div id="vueContainer">
        <div class="page-bg">
            <section class="links-box">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-12">

                            <div class="section-title">-相關連結-</div>

                        {{--todo: implement this--}}
                        <!-- 小尺寸時才出現的下拉選單 -->
                            <div class="mobile-select">
                                <a class="item-active" tab-title>全部連結</a>
                                <div class="item-list">
                                    <a class="item">配合廠商</a>
                                    <a class="item">異業結盟</a>
                                    <a class="item">政府/政策</a>
                                    <a class="item">其他連結</a>
                                </div>
                            </div>

                            <div class="side-bar">
                                <a href="#" class="item"
                                   :class="isAllCat"
                                   @click.prevent="setAllCat()">全部連結</a>
                                <a v-for="cat in cats"
                                   class="item"
                                   :class="isActive(cat)"
                                   @click.prevent="setActiveCat(cat)">
                                    @{{ cat.title }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-8 col-12">
                            <div class="section-title">@{{ linkCatTitle }}</div>
                            <div class="links-list set-height">
                                <div class="row">
                                    <div v-for="link in activeLinkList"
                                         class="col-md-4 col-sm-6 col-xs-12">
                                        <a :href="link.url" class="links-item" target="_blank">
                                            <img :src="'/storage/'+link.photoPath">
                                            <span class="text-links-name">@{{ link.title }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/app/links/index.js') }}"></script>
@endsection
