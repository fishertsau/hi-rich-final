@inject('localePresenter', 'App\Presenter\LocalePresenter')

@extends('system.layouts.master')

@section('content')

    <div id="container">
        <div id="site">
            <a href="/admin">首頁</a>>設定管理&gt;Google地圖與地址
        </div>

        <form action="/admin/settings/googleMap" method="post">
            <input type="hidden" name="_method" value="patch">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <table width="99%" border="0">
                <tr>
                    <td align="center" bgcolor="#DEDEDE">編輯資料</td>
                </tr>
            </table>

            <table width="99%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">
                        地址{{$localePresenter->ChinesePostfix()}}：
                    </td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="text" name="address" style="width: 75%"
                               value="{{$webConfig->address}}"/>
                    </td>
                </tr>
                <tr style="display: none">
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">
                        地址_2{{$localePresenter->ChinesePostfix()}}：
                    </td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="text" name="address2" style="width: 75%"
                               value="{{$webConfig->address2}}"/>
                    </td>
                </tr>


                @if(config('app.english_enabled'))
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">地址(英文)：</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <input type="text" name="address_en" style="width: 75%"
                                   value="{{$webConfig->address_en}}"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">地址2(英文)：</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <input type="text" name="address2_en" style="width: 75%"
                                   value="{{$webConfig->address2_en}}"/>
                        </td>
                    </tr>

                @endif
            </table>

            <br>
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
