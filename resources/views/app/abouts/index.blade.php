@extends('app.layouts.master')

@section('content')
    {{-- todo: get content from db --}}
    <div class="page-bg">
        <section class="about-box">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-12">

                        <div class="section-title">-關於高豐-</div>

                        <!-- 小尺寸時才出現的下拉選單 -->
                        <div class="mobile-select">
                            <a class="item-active" tab-title>{{$abouts[0]->title}}</a>
                            <div class="item-list">
                                @foreach($abouts as $about)
                                    @if (!$loop->first)
                                        <a class="item"
                                           onclick="scrollToElem('#c-about-{{$about->id}}', true)">{{$about->title}}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="about-side-bar">
                            @foreach($abouts as $about)
                                <a href="javascript:;" class="item"
                                   onclick="scrollToElem('#c-about-{{$about->id}}', true)">
                                    <span>⊙</span>{{$about->title}}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-8 col-12">
                        <div class="about-content">
                            @foreach($abouts as $about)
                                <img src="/storage/{{$about->photoPath}}" class="img-full img-company">
                                <div class="about-title" id="c-about-{{$about->id}}">{{$about->title}}</div>
                                <div class="about-text">
                                    {!! $about->body !!}
                                </div>
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


