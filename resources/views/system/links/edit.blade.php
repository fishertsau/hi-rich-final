{{--todo: remove this--}}
@inject('carbonPresenter', 'App\Presenter\CarbonPresenter')

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
        <div id="site"><a href="/admin">首頁</a>>相關連結管理&gt;
            @if(isset($link))
                修改相關連結
            @else
                新增相關連結
            @endif
        </div>

        @if(!isset($link))
            <form action="/admin/links" method="POST">
                {{ csrf_field() }}
                @include('system.links._form')
            </form>
        @endif

        @if(isset($link))
            <form action="/admin/links/{{$link->id}}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">
                @include('system.links._form')
            </form>
        @endif
        <br />
    </div>
@endsection


@section('pageJS')
    @include('system.partials.ckeditor')
@endsection