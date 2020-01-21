@inject('localePresenter', 'App\Presenter\LocalePresenter')

@extends('system.layouts.master')

@section('content')
    <div id="container">
        <div id="site">
            <a href="/admin">首頁</a>>各項設定&gt;網站內容
        </div>

        <form action="/admin/settings/companyInfo" method="post">
            <input type="hidden" name="_method" value="patch">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <table width="99%" border="0">
                <tr>
                    <td align="center" bgcolor="#DEDEDE">編輯資料</td>
                </tr>
            </table>

            <table width="99%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" 
                        class="border-sdown">公司名稱：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="text" name="company_name" 
                               style="width: 75%"
                               value="{{$webConfig->company_name}}"/>
                    </td>
                </tr>
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" 
                        class="border-sdown">電話：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="tel" name="tel" style="width: 75%"
                               value="{{$webConfig->tel}}"/>
                    </td>
                </tr>
                
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">傳真：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="tel" name="fax" style="width: 75%"
                               value="{{$webConfig->fax}}"/>
                    </td>
                </tr>

                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">地址：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="text" name="address" style="width: 75%"
                               value="{{$webConfig->address}}"/>
                    </td>
                </tr>

                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">電子信箱：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="email" name="email" style="width: 75%"
                               value="{{$webConfig->email}}"/>
                    </td>
                </tr>
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" 
                        class="border-sdown">版權提示：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="text" name="copyright_declare" style="width: 75%"
                               value="{{$webConfig->copyright_declare}}"/>
                    </td>
                </tr>
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
