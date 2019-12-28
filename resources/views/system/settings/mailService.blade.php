@extends('system.layouts.master')

@section('content')

    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>設定管理&gt;信件設定</div>
        <table width="99%" border="0">
            <tr>
                <td align="center" bgcolor="#DEDEDE">信件設定</td>
            </tr>
        </table>
        <form action="/admin/settings/mailService" method="POST">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <table width="99%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">系統服務名稱：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input name="mail_service_provider" type="text"
                               value="{{$webConfig->mail_service_provider}}" size="100%"/>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#ECECEC" class="border-sdown">郵件服務接收信箱：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input name="mail_receivers" type="text" value="{{$webConfig->mail_receivers}}"
                               size="100%"/>
                    </td>
                </tr>
            </table>
            <span class="textblue-medium">註：新增多筆郵件時，請以 , 號分隔中間請勿空格。(如:abc@gmail.com,123@gmail.com)</span> <img
                    src="/system/images/empty.gif" width="10" height="30"/><br/>
            <br/>
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
