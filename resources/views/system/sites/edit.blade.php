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
        <div id="site"><a href="/admin">首頁</a>> <a href="/admin/sites">據點清單&gt;</a>
            @if(isset($site))
                修改據點
            @else
                新增據點
            @endif</div>

        {{--新增--}}
        @if(!isset($site))
            <form action="/admin/sites" method="POST">
                {{ csrf_field() }}
                @include('system.sites._form')
            </form>
        @endif

        {{--修改--}}
        @if(isset($site))
            <form action="/admin/sites/{{$site->id}}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">
                @include('system.sites._form')
            </form>
        @endif
        <br />
    </div>
@endsection
