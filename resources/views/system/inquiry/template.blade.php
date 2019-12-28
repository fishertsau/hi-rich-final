@extends('system.layouts.master')

@section('content')
    <!-- include libraries(bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <link href="/system/css/systemcss.css" rel="stylesheet" type="text/css"/>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>詢價單管理&gt;送出頁管理<br/>
            <img src="/system/images/empty.gif" width="10" height="10"/></div>

        <form action="/admin/inquiries/template" method="POST">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            送出頁(中文)：<br/>
            <textarea name="inquiry_info" cols="30"
                      rows="10"
                      class="textarea"
                      ckeditor="true"
            >{{$webConfig->inquiry_info}}</textarea>

            @ifEngEnabled()
            送出頁(英文)：<br/>
            <textarea name="inquiry_info_en"
                      cols="30"
                      rows="10"
                      class="textarea"
                      ckeditor="true"
            >{{$webConfig->inquiry_info_en}}</textarea>
            @endifEngEnabled


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