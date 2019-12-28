@inject('localePresenter', 'App\Presenter\LocalePresenter')

@extends('system.layouts.master')

@section('content')
    <!-- include libraries(bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>



    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>公司簡介管理&gt;修改資料</div>
        <form action="/admin/abouts/{{$about->id}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PATCH">
            @include('system.about._form')
        </form>
        <br/>
    </div>
@endsection

@section('pageJS')
    @include('system.partials.ckeditor')
@endsection
