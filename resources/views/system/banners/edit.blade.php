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
        <div id="banner"><a href="/admin">首頁</a>> <a href="/admin/banners">跑馬燈清單&gt;</a>
            @if(isset($banner))
                修改跑馬燈
            @else
                新增跑馬燈
            @endif</div>

        {{--新增--}}
        @if(!isset($banner))
            {{--todo: add multi/... for photo input--}}
            <form action="/admin/banners" method="POST"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('system.banners._form')
            </form>
        @endif

        {{--修改--}}
        @if(isset($banner))
            <form action="/admin/banners/{{$banner->id}}" method="POST"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">
                @include('system.banners._form')
            </form>
        @endif
        <br />
    </div>
@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/banners/edit.js') }}"></script>
@endsection
