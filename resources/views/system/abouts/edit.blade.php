@extends('system.layouts.master')

@section('content')
    <!-- include libraries(bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <div id="container">
        <div id="site"><a href="/admin">首頁</a>><a href="/admin/abouts">公司簡介</a>&gt;新增/修改資料</div>
        @if(isset($about) && !isset($copy))
            <form action="/admin/abouts/{{$about->id}}" method="POST"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">
                @include('system.abouts._form')
            </form>
        @endif

        @if(!isset($about) || isset($copy))
            <form action="/admin/abouts" method="POST"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('system.abouts._form')
            </form>
        @endif
    </div>
    </br>
@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/abouts/edit.js') }}"></script>
    @include('system.partials.ckeditor')
@endsection
