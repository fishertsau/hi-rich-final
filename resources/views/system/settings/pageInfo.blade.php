@extends('system.layouts.master')

@section('content')
    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>設定管理&gt;網站設定</div>

        <table width="99%" border="0">
            <tr>
                <td align="center" bgcolor="#DEDEDE">編輯資料</td>
            </tr>
        </table>

        <form action="/admin/settings/pageInfo" method="post">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @if(config('app.english_enabled'))
                <h4>中文內容</h4>
            @endif

            <table width="99%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">網站頁面標題 title：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input name="title" type="text" size="100%"
                               value="{{$webConfig->title}}"/>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#ECECEC" class="border-sdown">網站頁面關鍵字 keywords：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <textarea name="keywords" cols="100%" rows="5">{{$webConfig->keywords}}</textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#ECECEC" class="border-sdown">網站頁面描述 description：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <textarea name="description" cols="100%" rows="5">{{$webConfig->description}}</textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#ECECEC" class="border-sdown">Meta：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <textarea name="meta" cols="100%" rows="5">{{$webConfig->meta}}</textarea>
                    </td>
                </tr>
            </table>

            @if(config('app.english_enabled'))
                <hr>
                <h4>英文內容</h4>
                <table width="99%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">網站頁面標題 title：</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <input name="title_en" type="text" size="100%"
                                   value="{{$webConfig->title_en}}"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#ECECEC" class="border-sdown">網站頁面關鍵字 keywords：</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <textarea name="keywords_en" cols="100%" rows="5">{{$webConfig->keywords_en}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#ECECEC" class="border-sdown">網站頁面描述 description：</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <textarea name="description_en" cols="100%"
                                      rows="5">{{$webConfig->description_en}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#ECECEC" class="border-sdown">Meta：</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <textarea name="meta_en" cols="100%" rows="5">{{$webConfig->meta_en}}</textarea>
                        </td>
                    </tr>
                </table>
            @endif

            <img src="/system/images/empty.gif" width="10" height="30"/><br/>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <span class="border-right">
                          <input type="submit" value="確定修改"/>
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
