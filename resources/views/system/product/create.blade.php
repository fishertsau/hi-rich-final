@extends('system.layouts.master')

@section('content')
    <!-- include libraries(bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <style>
        td {
            border: 2px solid white;
            padding-left: 3px;
        }
    </style>

    @if(isset($product))
        <input type="text" id="productPhotos" value="{{$product->photos}}" hidden>
    @endif


    <div id="container">
        <div id="site">
            <a href="/admin">首頁</a>&gt;產品管理&gt;<a href="/admin/products">產品上架管理</a>&gt;
            @if(isset($copyProduct))
                複製產品
            @elseif(isset($product))
                修改產品
            @else
                新增產品
            @endif
        </div>

        <table width="99%" border="0">
            <tr>
                <td align="center" bgcolor="#DEDEDE">
                    @if(isset($copyProduct))
                        複製產品
                    @elseif(isset($product))
                        修改產品
                    @else
                        新增產品
                    @endif
                </td>
            </tr>
        </table>

        @if(!isset($product))
            <form action="/admin/products" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                @include('system.product._form')
            </form>
        @endif

        @if(isset($product))
            <form action="/admin/products/{{$product->id}}"
                  method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">
                @include('system.product._form')
            </form>
        @endif
    </div>
@endsection


@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/product/productCreate.js') }}"></script>
    @include('system.partials.ckeditor')
@endsection