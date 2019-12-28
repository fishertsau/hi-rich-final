@extends('system.layouts.master')

@section('content')
    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>設定管理&gt;修改密碼</div>
        <table width="99%" border="0">
            <tr>
                <td align="center" bgcolor="#DEDEDE">重設密碼</td>
            </tr>
        </table>
        <form action="/password/reset" method="post">
            {{csrf_field()}}
            <table width="99%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">帳號：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">{{auth()->user()->name}}</td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#ECECEC" class="border-sdown">重設新密碼：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="password" name="password"/>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#ECECEC" class="border-sdown">再次確認新密碼：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="password" name="password_confirmation"/>
                    </td>
                </tr>
            </table>
            <img src="/system/images/empty.gif" width="10" height="30"/><br/>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                    <span class="border-right">
                        <button type="submit" style="height: 25px">確定修改</button>
                        <img src="/system/images/empty.gif" width="50" height="10"/>
                        <button onclick="goBack()" style="height: 25px">回上一頁</button>
                    </span>
                    </td>
                </tr>
            </table>
        </form>
        <br/>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection