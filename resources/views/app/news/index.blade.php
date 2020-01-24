@extends('app.layouts.master')

@section('content')
    <div id="container">
        <div class="page-bg">
            <section class="news-box">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-5 col-sm-5 col-12">
                            <div class="section-title">-最新動態-</div>

                            <div class="mobile-select" v-cloak>
                                <a class="item-active"
                                   @click.prevent="toggleShowCat()"
                                   v-cloak
                                >@{{ activeCatTitle(activeCat) }}</a>
                                <div class="item-list"
                                     :class="isShowCat(showCat)">
                                    <a class="item"
                                       v-for="cat in cats"
                                       @click.prevent="setActiveCat(cat)"
                                       v-cloak>
                                        @{{ cat.title }}
                                    </a>
                                </div>
                            </div>

                            <div class="news-list scroll-bar" v-cloak>
                                <!-- 手機裝置瀏覽 點擊連到news-detail頁面-->
                                <a v-for="(news,index) in activeNewsList"
                                   class="item"
                                   :class="{'active': news.id === activeNews.id }"
                                   v-show="!isMobile || !showDetail"
                                   href="javascript:;"
                                   @click.prevent="setActiveNews(news)">
                                    <span class="text-num">@{{ index +1 }}</span>
                                    <span class="text-title">@{{news.title}}</span>
                                    <span class="text-news"></span>
                                    <span class="text-date">2019/06/15</span>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-7 col-sm-7 col-12 hidden-xs">
                            <div class="news-content" v-cloak>
                                <div class="artical-title">
                                    <span class="text-main">@{{ activeNews.title }}-</span>
                                    <span class="text-sub">@{{ activeNews.published_since.substring(0,11).replace(/-/g,'/') }}</span>
                                </div>
                                <!-- 編輯器開始 -->
                                <div class="editor-box set-height">
                                   
                                    <span v-html="activeNews.body"></span>
                                    </div>
                                </div>
                                <!-- 編輯器結束 -->
                            </div>
                        </div>

                        {{--mobile device 顯示--}}
                        <div v-show="isMobile && showDetail"
                             class="col-12 mobile-news-detail"
                             v-cloak >
                            <div class="btn-box">
                                <a href="javascript:;"
                                   @click.prevent="showDetail = false"
                                   class="link-back">回上頁
                                    <span class="img-back"></span></a>
                            </div>
                            <div class="news-content">
                                <div class="artical-title">
                                    <span class="text-main">@{{activeNews.title}}-</span>
                                    <span class="text-sub">@{{ activeNews.published_since.substring(0,11).replace(/-/g,'/') }}</span>
                                </div>
                                <!-- 編輯器開始 -->
                                <div class="editor-box set-height">
                                    <span v-html="activeNews.body"></span>
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
    <script type="text/javascript" src="{{ asset('/js/app/news/index.js') }}"></script>
@endsection