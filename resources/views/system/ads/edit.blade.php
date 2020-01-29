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
        <div id="ad"><a href="/admin">首頁</a>> <a href="/admin/ads">廣告清單&gt;</a>
            @if(isset($ad))
                修改廣告
            @else
                新增廣告
            @endif</div>

        {{--新增--}}
        @if(!isset($ad))
            <form action="/admin/ads" method="POST"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('system.ads._form')
            </form>
        @endif

        {{--修改--}}
        @if(isset($ad))
            <form action="/admin/ads/{{$ad->id}}" method="POST"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">
                @include('system.ads._form')
            </form>
        @endif
        <br />
    </div>
@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/ads/edit.js') }}"></script>
@endsection
