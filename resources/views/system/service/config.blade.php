@extends('system.layouts.master')

@section('content')

    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>產品管理&gt;前台筆數顯示設定</div>
        <table width="99%" border="0">
            <tr>
                <td align="center" bgcolor="#DEDEDE">編輯資料</td>
            </tr>
        </table>
        <form action="/admin/products/config" method="POST">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <table width="99%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="200" align="right" bgcolor="#ECECEC" class="border-sdown">產品每頁顯示數量：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="number" name="product_show_per_page" value="{{$webConfig->product_show_per_page}}" min="0" max="50"/></td>
                </tr>
                <tr>
                    <td width="150" align="right" bgcolor="#ECECEC" class="border-down">啟用分類圖：</td>
                    <td class="border-down">
                        <input type="radio" name="category_photo_enabled" value="1"
                                {{$webConfig->category_photo_enabled?'checked':''}}
                        />
                        啟用
                        <input type="radio" name="category_photo_enabled" value="0"
                                {{!$webConfig->category_photo_enabled?'checked':''}}
                        />
                        關閉
                    </td>
                </tr>
                <tr>
                    <td width="150" align="right" bgcolor="#ECECEC" class="border-down">分類描述：</td>
                    <td class="border-down">
                        <textarea name="category_description" cols="90" rows="10">{{$webConfig->category_description}}</textarea>
                    </td>
                </tr>
            </table>
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
