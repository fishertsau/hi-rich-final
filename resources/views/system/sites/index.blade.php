@extends('system.layouts.master')

@section('content')
    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>據點清單</div>
        <img src="/system/images/icon_arrowdown.gif" width="15" height="19" />
        <a href="/admin/sites/create"><img src="/system/images/new.gif" width="75" height="19" /></a><br />
        <img src="/system/images/empty.gif" width="10" height="10" />

        <form action="/admin/sites/ranking" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PATCH">

            <table width="99%" border="0" cellpadding="5" cellspacing="1">
                <tr>
                    <td width="80" align="center" bgcolor="#DEDEDE">編號</td>
                    <td width="80" align="center" bgcolor="#DEDEDE">顯示</td>
                    <td width="80" align="center" bgcolor="#DEDEDE">顯示排序</td>
                    <td align="left" bgcolor="#DEDEDE">據點名稱</td>
                    <td width="165" align="center" bgcolor="#DEDEDE">建檔日期</td>
                    <td width="60" align="center" bgcolor="#DEDEDE">修改</td>
                    <td width="60" align="center" bgcolor="#DEDEDE">刪除</td>
                </tr>
                @foreach ($sites as $site)
                    <tr>
                        <td align="center" bgcolor="#ECECEC" class="border-sdown">{{$loop->index+1}}
                        </td>
                        <td align="center" bgcolor="#ECECEC" class="border-sdown">
                            @if($site->published)
                                <img src="/system/images/ok.gif" width="11" height="11" />
                            @else
                                <img src="/system/images/notok.gif" width="11"
                                     height="11" />
                            @endif
                        </td>
                        <td align="center" bgcolor="#F5F5F1" class="border-sdown">
                            <input type="hidden"
                                   name="id[]"
                                   value="{{$site->id}}" />
                            <input name="ranking[]" type="text" class="ranking"
                                   value="{{$site->ranking}}"
                                   size="2" />
                        </td>
                        <td align="left" bgcolor="#ECECEC" class="border-sdown"><a
                                    href="/admin/sites/{{$site->id}}/edit"> {{$site->name}}
                            </a>
                        </td>
                        <td align="center" bgcolor="#ECECEC" class="border-sdown">
                            {{$site->created_at->toDateString()}}</td>

                        <td align="center" bgcolor="#ECECEC" class="border-sdown">
                            <a href="/admin/sites/{{$site->id}}/edit">
                                <img src="/system/images/bt-revise.gif" width="23" height="23" />
                            </a>
                        </td>
                        <td align="center" bgcolor="#ECECEC" class="border-sdown">
                            <button type='submit'
                                    style="border:none;background:transparent;cursor: pointer"
                                    @click="deleteNews({{$site->id}})">
                                <img src="/system/images/bt-delete.png"
                                     width="23" height="23" />
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
            <img src="/system/images/empty.gif" width="10" height="10" /><br />
            <table width="99%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left">功能：
                        <input type="submit" value="確定修改排序" />
                    </td>
                </tr>
            </table>
        </form>
        <br />
        <br />
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                        <span class="border-right">
                          <img src="/system/images/empty.gif" width="50" height="10" />
                            @include('system.partials.gobackBtn')
                        </span>
                </td>
            </tr>
        </table>
        <br />
    </div>
@endsection
