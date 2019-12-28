@extends('system.layouts.master')

@section('content')
    <!-- include libraries(bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <div id="container">
        <div id="site"><a href="index.php">首頁</a>>詢價單管理&gt;聯絡資訊管理<br/>
            <img src="/system/images/empty.gif" width="10" height="10"/></div>

        <form action="/admin/inquiries/config" method="POST">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table width="100%" border="0">
                <tr>
                    <td width="100" valign="top">Ｇoogle map</td>
                    <td><textarea name="google_map" cols="70">{{$webConfig->google_map}}</textarea>
                        <p style="color:red">請填上完整地址. 務必填上省分</p>
                    </td>
                </tr>
                <tr>
                    <td width="100" valign="top">Query Information</td>
                    <td>
                        <textarea name="inquiry_info" cols="70" class="textarea">{{$webConfig->inquiry_info}}</textarea>
                    </td>
                </tr>
            </table>
            <br/>

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
    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
    <script src="{{ asset('vendors/summernote/lang/summernote-zh-TW.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            $('.textarea').summernote({
                height: 1500,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                lang: 'zh-TW'
            });
        });
    </script>
@endsection