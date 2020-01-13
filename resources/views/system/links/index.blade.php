@extends('system.layouts.master')

@section('content')
    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>相關連結清單</div>
        <a href="/admin/links/create"><img src="/system/images/new.gif" width="75" height="19" /></a><br />
        <img src="/system/images/empty.gif" width="10" height="10" />

        <table width="99%" border="0" cellpadding="5" cellspacing="1">
            <tr>
                <td width="80" align="center" bgcolor="#DEDEDE">編號</td>
                <td width="50" align="center" bgcolor="#DEDEDE">顯示</td>
                <td align="center" bgcolor="#DEDEDE">類別</td>
                <td align="center" bgcolor="#DEDEDE">標題</td>
                <td align="center" bgcolor="#DEDEDE">連結</td>
                <td width="165" align="center" bgcolor="#DEDEDE">建檔日期</td>
                <td width="60" align="center" bgcolor="#DEDEDE">修改</td>
                <td width="60" align="center" bgcolor="#DEDEDE">刪除</td>
            </tr>
            @foreach ($links as $link)
                <tr>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">{{$loop->index+1}}
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        @if($link->published)
                            <img src="/system/images/ok.gif" width="11" height="11" />
                        @else
                            <img src="/system/images/notok.gif" width="11"
                                 height="11" />
                        @endif
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        {{$link->category->title}}
                    </td>
                    <td align="left" bgcolor="#ECECEC" class="border-sdown"><a
                                href="/admin/links/{{$link->id}}/edit"> {{$link->title}}
                        </a>
                    </td>
                    <td align="left" bgcolor="#ECECEC" class="border-sdown">
                        {{$link->url}}
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        {{$link->created_at}}
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <a href="/admin/links/{{$link->id}}/edit">
                            <img src="/system/images/bt-revise.gif" width="23" height="23" />
                        </a>
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <button type='submit'
                                style="border:none;background:transparent;cursor: pointer"
                                @click="deleteLink({{$link->id}})">
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
                <td align="left">
                </td>
                <td align="right">
                    {{ $links->links('vendor.pagination.system') }}
                </td>
            </tr>
        </table>
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


@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/links/index.js') }}"></script>
@endsection