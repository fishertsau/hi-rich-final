@extends('system.layouts.master')

@section('content')
    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>服務項目管理</div>
        <br/>
        <img src="/system/images/icon_arrowdown.gif" width="15" height="19"/><a href="/admin/services/create"><img
                    src="/system/images/new.gif" width="75" height="19"/></a><br/>
        <img src="/system/images/empty.gif" width="10" height="10"/>
        <table width="99%" border="0" cellpadding="5" cellspacing="1">
            <tr>
                <td width="20" align="center" bgcolor="#DEDEDE">
                    <input type="checkbox"
                           @change="toggleSelectAll()"
                           id="selectAll"/>
                </td>
                <td width="80" align="center" bgcolor="#DEDEDE">編號</td>
                <td width="50" align="center" bgcolor="#DEDEDE">首頁</td>
                <td width="50" align="center" bgcolor="#DEDEDE">顯示</td>
                <td align="center" bgcolor="#DEDEDE">品名</td>
                <td width="165" align="center" bgcolor="#DEDEDE">建檔日期</td>
                <td width="60" align="center" bgcolor="#DEDEDE">排序</td>
                <td width="60" align="center" bgcolor="#DEDEDE">修改</td>
                <td width="60" align="center" bgcolor="#DEDEDE">複製</td>
                <td width="60" align="center" bgcolor="#DEDEDE">刪除</td>
            </tr>
            @foreach($services as $service)
                <tr>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <input type="checkbox"
                               name="id[]"
                               class="chosenId id"
                               value="{{$service->id}}"/></td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">{{$loop->index+1}}</td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        @if($service->published_in_home)
                            <img src="/system/images/ok.gif" width="11" height="11"/>
                        @else
                            <img src="/system/images/notok.gif" width="11"
                                 height="11"/>
                        @endif
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        @if($service->published)
                            <img src="/system/images/ok.gif" width="11" height="11"/>
                        @else
                            <img src="/system/images/notok.gif" width="11"
                                 height="11"/>
                        @endif
                    </td>
                    <td align="left" bgcolor="#ECECEC" class="border-sdown">
                        <a href="/admin/services/{{$service->id}}/edit">
                            {{$service->title}}
                            @ifEngEnabled() | {{$service->title_en}} @endifEngEnabled
                        </a>
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        {{$service->created_at}}
                    </td>
                    <td align="center" bgcolor="#F5F5F1" class="border-sdown">
                        <input name="ranking[]" type="text" class="ranking"
                               value="{{$service->ranking}}"
                               size="2"/>
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <a href="/admin/services/{{$service->id}}/edit">
                            <img src="/system/images/bt-revise.gif" width="23" height="23"/>
                        </a>
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <a href="/admin/services/{{$service->id}}/copy">
                            <img src="/system/images/copy.gif" width="23" height="23"/>
                        </a>
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <button type='submit'
                                style="border:none;background:transparent;cursor: pointer"
                                @click="deleteProduct({{$service->id}})">
                            <img src="/system/images/bt-delete.png"
                                 width="23" height="23"/>
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>
        <img src="/system/images/empty.gif" width="10" height="10"/><br/>
        <table width="99%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="left">功能：
                    <select id="action">
                        <option value="noAction" selected="selected">請選擇</option>
                        <option value="setToShowAtHome">首頁</option>
                        <option value="setToNoShowAtHome">取消首頁</option>
                        <option value="setToShow">顯示</option>
                        <option value="setToNoShow">取消顯示</option>
                        <option value="delete">刪除資料</option>
                    </select>
                    <input type="submit" @click="doAction" value="確定"/>
                </td>
                <td align="right">
                    {{ $services->links('vendor.pagination.system') }}
                </td>
            </tr>
        </table>
        <br/>

        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                        <span class="border-right">
                          <input type="submit" value="確定修改" @click="updateRanking"/>
                          <img src="/system/images/empty.gif" width="50" height="10"/>
                            @include('system.partials.gobackBtn')
                        </span>
                </td>
            </tr>
        </table>
        <br/>
    </div>
@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/service/serviceIndex.js') }}"></script>
@endsection