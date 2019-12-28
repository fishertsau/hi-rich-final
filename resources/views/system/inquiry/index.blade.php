@extends('system.layouts.master')

@section('content')
    <div id="container">
        <div id="site"><a href="index.php">首頁</a>>詢價單管理&gt;詢價信件管理
            <br/>
            <img src="/system/images/empty.gif" width="10" height="10"/></div>
        <table width="99%" border="0" cellpadding="5" cellspacing="1">
            <tr>
                <td width="50" align="center" bgcolor="#DEDEDE">項次</td>
                <td align="center" bgcolor="#DEDEDE">公司名稱</td>
                <td align="center" bgcolor="#DEDEDE">姓名</td>
                <td width="100" align="center" bgcolor="#DEDEDE">詢問日期</td>
                <td width="100" align="center" bgcolor="#DEDEDE">處理情形</td>
                <td width="50" align="center" bgcolor="#DEDEDE">修改</td>
                <td width="50" align="center" bgcolor="#DEDEDE">刪除</td>
            </tr>

            @foreach($inquiries as $inquiry)
                <tr>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">{{$loop->index+1}}</td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">{{$inquiry->company_name}}</td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">{{$inquiry->contact}}</td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">{{$inquiry->created_at}}</td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">{{$inquiry->processedStatus}}</td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown"><a
                                href="/admin/inquiries/{{$inquiry->id}}"><img
                                    src="/system/images/bt-revise.gif" width="23" height="23"/></a></td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <form action="/admin/inquiries/{{$inquiry->id}}" method="POST"
                              onsubmit="return confirm('資料刪除後,無法回復\n確定刪除資料?')">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" style="cursor: pointer;background:transparent;border: none">
                                <img src="/system/images/bt-delete.png" width="23" height="23"/></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        <img src="/system/images/empty.gif" width="10" height="10"/><br/>
        <table width="99%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="right">
                    {{ $inquiries->links('vendor.pagination.system') }}
                </td>
            </tr>
        </table>
        <br/>
    </div>
@endsection
