@inject('categoryPresenter', 'App\Presenter\CategoryPresenter')
@inject('localePresenter', 'App\Presenter\LocalePresenter')

@extends('system.layouts.master')

@section('content')
    @if(isset($category))
        <input type="text" id="catInfo" value="{{$category}}" hidden>
    @endif

    <div id="container">
        <div id="site">
            <a href="/admin">首頁</a>>產品管理&gt;產品分類管理&gt;{{$categoryPresenter->pageTitle(isset($category)?$category:null)}}
        </div>

        @if(isset($category))
            <form action="/admin/product/categories/{{$category->id}}"
                  method="POST"
                  enctype="multipart/form-data">
                <input type="hidden" name="_method" value="patch">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @include('system.shared.category._form')
                @include('system.shared.category._photoInput')
                <br/>
                @include('system.shared.category._formCtrl')
            </form>
        @endif

        @if(!isset($category))
            <form action="/admin/product/categories"
                  method="post"
                  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @include('system.shared.category._form')
                @include('system.shared.category._photoInput')
                <br/>
                @include('system.shared.category._formCtrl')
            </form>
        @endif
        <br/>
    </div>
@endsection
