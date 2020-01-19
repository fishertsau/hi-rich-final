@extends('app.layouts.master')

@section('content')
    {{-- todo: get content from db --}}
    <div class="page-bg">
        <section class="news-box">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">-最新動態-</div>

                        {{-- todo: change this? --}}
                        <div class="mobile-select">
                            <a class="item-active" tab-title>全部連結</a>
                            <div class="item-list">
                                <a class="item">產品訊息</a>
                                <a class="item">活動訊息</a>
                                <a class="item">公司訊息</a>
                                <a class="item">媒體訊息</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 mobile-news-detail">
                        <div class="btn-box">
                            {{-- todo: changet this--}}
                            <a href="/news" class="link-back">回上頁<span class="img-back"></span></a>
                        </div>
                        <div class="news-content">
                            <div class="artical-title">
                                <span class="text-main">{{$news->title}}-</span>

                                <span class="text-sub">{{$news->published_since->toDateString()}}</span>
                            </div>
                            <!-- 編輯器開始 -->
                            <div class="editor-box set-height">
                                {!! $news->body !!}
                            </div>
                            <!-- 編輯器結束 -->
                        </div>
                    </div>
                    
                    {{--todo: 這一段的作用??--}}
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
        </section>
    </div>
@endsection

