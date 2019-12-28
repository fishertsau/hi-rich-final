@inject('carbonPresenter', 'App\Presenter\CarbonPresenter')
@inject('localePresenter', 'App\Presenter\LocalePresenter')

@extends('system.layouts.master')

@section('content')
    <!-- include libraries(bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <style>
        td {
            border: 2px solid white;
            padding-left: 3px;
        }
    </style>


    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>最新消息管理&gt;
            @if(isset($copyNews))
                複製消息
            @elseif(isset($news))
                修改消息
            @else
                新增消息
            @endif</div>

        @if(!isset($news) | isset($copyNews))
            <form action="/admin/news" method="POST">
                {{ csrf_field() }}
                @include('system.news._form')
            </form>
        @endif

        @if(isset($news) && !isset($copyNews))
            <form action="/admin/news/{{$news->id}}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">
                @include('system.news._form')
            </form>
        @endif
        <br/>
    </div>
@endsection


@section('pageJS')
    @include('system.partials.ckeditor')

    <script type="text/javascript">
        function showForever(e) {
            document.querySelector('#published_until').value = '';
        }
    </script>
@endsection