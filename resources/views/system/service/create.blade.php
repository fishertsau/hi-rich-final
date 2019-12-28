@inject('localePresenter', 'App\Presenter\LocalePresenter')

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

    @if(isset($service))
        <input type="text" id="servicePhotos" value="{{$service->photos}}" hidden>
    @endif


    <div id="container">
        <div id="site">
            <a href="/admin">首頁</a>&gt;服務管理&gt;<a href="/admin/services">服務上架管理</a>&gt;
            @if(isset($copyService))
                複製服務
            @elseif(isset($service))
                修改服務
            @else
                新增服務
            @endif
        </div>

        <table width="99%" border="0">
            <tr>
                <td align="center" bgcolor="#DEDEDE">
                    @if(isset($copyService))
                        複製服務
                    @elseif(isset($service))
                        修改服務
                    @else
                        新增服務
                    @endif
                </td>
            </tr>
        </table>

        @if(!isset($service))
            <form action="/admin/services" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                @include('system.service._form')
            </form>
        @endif

        @if(isset($service))
            <form action="/admin/services/{{$service->id}}"
                  method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">
                @include('system.service._form')
            </form>
        @endif
    </div>
@endsection


@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/service/serviceCreate.js') }}"></script>
    @include('system.partials.ckeditor')
@endsection