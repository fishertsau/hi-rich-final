
@extends('system.layouts.master')

@section('content')
    <!-- include libraries(bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <div id="container">
        <div id="site"><a href="/admin">首頁</a> >公司簡介 > 首頁簡介<br/>
            <img src="/system/images/empty.gif" width="10" height="10"/></div>

        <form action="/admin/intro" method="POST">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h4>標題</h4>
            <input type="text" name="intro_title" style="width: 80%" value="{{$webConfig->intro_title}}">

            <h4>副標題</h4>
            <input type="text" name="intro_subTitle" style="width: 80%" value="{{$webConfig->intro_subTitle}}">

            <h4>內容</h4>
            <textarea name="intro" cols="130" rows="6" class="textarea">{{$webConfig->intro}}</textarea>


            @if(config('app.english_enabled'))
                <h3>英文內容</h3>
                <textarea name="intro_en" cols="30" rows="10" class="textarea">{{$webConfig->intro_en}}</textarea>

            @endif
            <img src="/system/images/empty.gif" width="10" height="30"/><br/>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <span class="border-right">
                              <input type="submit" name="選擇檔案4" id="選擇檔案4" value="確定修改"/>
                              <img src="/system/images/empty.gif" width="50" height="10"/>
                            @include('system.partials.gobackBtn')
                        </span>
                    </td>
                </tr>
            </table>
        </form>
        <br/>
    </div>
@endsection

@section('pageJS')
    @include('system.partials.ckeditor')
@endsection
