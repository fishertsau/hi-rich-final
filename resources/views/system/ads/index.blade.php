@extends('system.layouts.master')

@section('content')
    <div id="container">
        <div id="ad"><a href="/admin">首頁</a>>廣告/圖片清單</div>
        <a href="/admin/ads/create"><img src="/system/images/new.gif" width="75" height="19" /></a><br />
        <img src="/system/images/empty.gif" width="10" height="10" />

        <form action="/admin/ads/ranking" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PATCH">
            <table width="99%" border="0" cellpadding="5" cellspacing="1">
                <tr>
                    <td width="80" align="center" bgcolor="#DEDEDE">編號</td>
                    <td width="80" align="center" bgcolor="#DEDEDE">顯示</td>
                    <td width="80" align="center" bgcolor="#DEDEDE">位置</td>
                    <td width="80" align="center" bgcolor="#DEDEDE">顯示排序</td>
                    <td align="left" bgcolor="#DEDEDE">名稱</td>
                    <td width="165" align="center" bgcolor="#DEDEDE">簡圖</td>
                    <td width="165" align="center" bgcolor="#DEDEDE">建檔日期</td>
                    <td width="60" align="center" bgcolor="#DEDEDE">修改</td>
                    <td width="60" align="center" bgcolor="#DEDEDE">刪除</td>
                </tr>

                <tr v-for="(item,index) in items" v-cloak>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">@{{ item.id }}
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <img v-if="item.published" src="/system/images/ok.gif" width="11" height="11" />
                        <img v-else src="/system/images/notok.gif" width="11" height="11" />
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                       @{{ item.location_title  }} 
                    </td>
                    <td align="center" bgcolor="#F5F5F1" class="border-sdown">
                        <input type="hidden"
                               name="id[]"
                               v-model="item.id" />
                        <input name="ranking[]" type="text" class="ranking"
                               v-model="item.ranking"
                               size="2" />
                    </td>
                    <td align="left" bgcolor="#ECECEC" class="border-sdown">
                        <a :href="'/admin/ads/' +  item.id +'/edit'"> @{{item.title}} </a>
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <img v-if="item.photoPath" 
                                :src="'/storage/' + item.photoPath " style="max-height: 60px;">
                        <span v-else>無圖片</span>
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        @{{item.created_at}}
                    </td>

                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <a :href="'/admin/ads/' +  item.id +'/edit'">
                            <img src="/system/images/bt-revise.gif" width="23" height="23" />
                        </a>
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <button type='submit'
                                style="border:none;background:transparent;cursor: pointer"
                                @click.prevent="deleteItem(item.id)">
                            <img src="/system/images/bt-delete.png"
                                 width="23" height="23" />
                        </button>
                    </td>
                </tr>

            </table>
            <img src="/system/images/empty.gif" width="10" height="10" /><br />
            <table width="99%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left">功能：
                        <input type="submit" value="確定修改顯示排序" />
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

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/ads/index.js') }}"></script>
@endsection
