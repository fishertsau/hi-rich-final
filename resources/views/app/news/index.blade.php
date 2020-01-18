@extends('app.layouts.master')

@section('content')
    <div id="container">
        <div class="page-bg">
            <section class="news-box">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-5 col-sm-5 col-12">
                            <div class="section-title">-最新動態-</div>

                            <div class="mobile-select">
                                <a class="item-active" @click.prevent="toggleShowCat()">全部連結</a>
                                <div class="item-list" 
                                     :class="isShowCat(showCat)">
                                    <a class="item" v-for="cat in cats" @click.prevent="setActiveCat(cat)">
                                        @{{ cat.title }}</a>
                                </div>
                            </div>

                            <div class="news-list scroll-bar">
                                <!-- 尺寸576以下時 點擊連到news-detail頁面-->
                                {{--todo: 實作此功能--}}
                                <a class="item active" href="#" v-for="(news,index) in activeNewsList">
                                    <span class="text-num">@{{ index +1 }}</span>
                                    <span class="text-title">@{{news.title}}</span>
                                    <span class="text-news"></span>
                                    <span class="text-date">2019/06/15</span>
                                </a>
                            </div>
                        </div>

                        {{--todo: change this --}}
                        <div class="col-lg-8 col-md-7 col-sm-7 col-12 hidden-xs">
                            <div class="news-content">
                                <div class="artical-title">
                                    <span class="text-main">2019台北國際食品展-</span>
                                    <span class="text-sub">2019/06/15</span>
                                </div>
                                <!-- 編輯器開始 -->
                                <div class="editor-box set-height">
                                    <img src="/asset/images/news.jpg" style="width:100%;height:auto">
                                    <div style="color:#be2120;font-size:22px;margin:25px 0 20px 0;">高豐海產誠摯邀請您</div>
                                    <div style="font-size:16px;color:#707070;line-height: 24px;">
                                        職人海鮮盡在高豐<br />
                                        展出日期：2019/06/19~06/22 ｜ 攤位位置•B0336（由B出入口進入.面對台北101金融中心<br />
                                        展場資訊：台北世貿展覽一館（地址: 臺北市信義路五段五號<br />
                                        聯絡我們：<br />
                                        +886-2-22901180<br />
                                        http://www.hi-rich.com.tw<br />
                                        hi.rich@msa.hinet.net<br />
                                    </div>
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