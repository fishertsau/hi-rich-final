@extends('app.layouts.master')

@section('content')
    {{--todo: get from db --}}
    <div class="page-bg">
        <section class="links-box">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-12">

                        <div class="section-title">-相關連結-</div>

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
                            <a href="/links" class="item is-active">全部連結</a>
                            <a href="javascript:;" class="item">配合廠商</a>
                            <a href="javascript:;" class="item">異業結盟</a>
                            <a href="javascript:;" class="item">政府/政策</a>
                            <a href="javascript:;" class="item">其他連結</a>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-8 col-12">
                        <div class="section-title">全部連結</div>
                        <div class="links-list set-height">
                            <div class="row">
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <a href="https://www.1111.com.tw/" class="links-item" target="_blank">
                                        <img src="/asset/images/links/1111.jpg">
                                        <span class="text-links-name">1111人力銀行</span>
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <a href="https://www.momoshop.com.tw/main/Main.jsp" class="links-item"
                                       target="_blank">
                                        <img src="/asset/images/links/MOMO.jpg">
                                        <span class="text-links-name">MOMO購物</span>
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <a href="https://www.oac.gov.tw/" class="links-item" target="_blank">
                                        <img src="/asset/images/links/SEA.jpg">
                                        <span class="text-links-name">海洋委員會</span>
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <a href="https://www.1111.com.tw/" class="links-item" target="_blank">
                                        <img src="/asset/images/links/1111.jpg">
                                        <span class="text-links-name">1111人力銀行</span>
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <a href="https://www.momoshop.com.tw/main/Main.jsp" class="links-item"
                                       target="_blank">
                                        <img src="/asset/images/links/MOMO.jpg">
                                        <span class="text-links-name">MOMO購物</span>
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <a href="https://www.oac.gov.tw/" class="links-item" target="_blank">
                                        <img src="/asset/images/links/SEA.jpg">
                                        <span class="text-links-name">海洋委員會</span>
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <a href="https://www.1111.com.tw/" class="links-item" target="_blank">
                                        <img src="/asset/images/links/1111.jpg">
                                        <span class="text-links-name">1111人力銀行</span>
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <a href="https://www.momoshop.com.tw/main/Main.jsp" class="links-item"
                                       target="_blank">
                                        <img src="/asset/images/links/MOMO.jpg">
                                        <span class="text-links-name">MOMO購物</span>
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <a href="https://www.oac.gov.tw/" class="links-item" target="_blank">
                                        <img src="/asset/images/links/SEA.jpg">
                                        <span class="text-links-name">海洋委員會</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
