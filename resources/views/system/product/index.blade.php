@extends('system.layouts.master')

@section('content')
    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>產品管理&gt;產品上架管理</div>
        @if(isset($queryTerm))
            <input type="hidden"
                   name="queryTerm"
                   id="queryTermInput"
                   value="{{json_encode($queryTerm)}}">
        @endif
        <form action="/admin/products/list" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="newSearch" value="1" hidden>

            <table width="99%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="100" rowspan="4" align="center" class="border-down">搜尋：</td>
                    <td width="140" align="left">依分 類 搜 尋 <img src="/system/images/icon_5.jpg" width="11" height="11" />
                    </td>
                    <td width="550" align="left">
                        <input type="text" name="cat_id" hidden v-model="catId">
                        <div style="display: flex">
                            <div style="flex: 3">
                                <cat-selector
                                        :given_cat_id="queryTerm.catId"
                                        selection_depth="any"
                                        :clear_setting.sync="clear_setting"
                                        @catid-changed="handleCatIdChanged"
                                        applied_model="product"
                                >
                                </cat-selector>
                            </div>
                            &nbsp;
                            <div style="flex: 1.3">
                                <button @click.prevent="resetCatSelector">清除類別</button>
                            </div>
                        </div>
                    </td>
                    <td rowspan="3" align="left">
                        <button type="submit">立即查詢</button>
                    </td>
                </tr>
                <tr>
                    <td align="left">依產品關鍵字 <img src="/system/images/icon_5.jpg" width="11" height="11" /></td>
                    <td align="left">
                        <input name="keyword"
                               type="text"
                               size="50%"
                               v-model="queryTerm.keyword"
                        />
                    </td>
                </tr>
                <tr>
                    <td align="left">依產 品 狀 態 <img src="/system/images/icon_5.jpg" width="11" height="11" /></td>
                    <td align="left">
                        <input type="radio" name="published" value="" v-model="queryTerm.published" />
                        全部　
                        <input type="radio" name="published" value="1" v-model="queryTerm.published" />
                        上架　
                        <input type="radio" name="published" value="0" v-model="queryTerm.published" />
                        下架
                    </td>
                </tr>
                <tr class="border-downright">
                    <td align="left" class="border-down">
                    </td>
                    <td align="left" class="border-down"></td>
                    <td align="left" class="border-down"></td>
                </tr>
            </table>
        </form>
        <br />
        <img src="/system/images/icon_arrowdown.gif" width="15" height="19" /><a href="/admin/products/create"><img
                    src="/system/images/new.gif" width="75" height="19" /></a><br />
        <img src="/system/images/empty.gif" width="10" height="10" />

        <table width="99%" border="0" cellpadding="5" cellspacing="1">
            <tr>
                <td width="20" align="center" bgcolor="#DEDEDE">
                    <input type="checkbox"
                           @change="toggleSelectAll()"
                           id="selectAll" />
                </td>
                <td width="80" align="center" bgcolor="#DEDEDE">編號</td>
                <td width="50" align="center" bgcolor="#DEDEDE">顯示</td>
                <td align="center" bgcolor="#DEDEDE">類別</td>
                <td align="center" bgcolor="#DEDEDE">品名</td>
                <td width="165" align="center" bgcolor="#DEDEDE">建檔日期</td>
                <td width="60" align="center" bgcolor="#DEDEDE">修改</td>
                <td width="60" align="center" bgcolor="#DEDEDE">複製</td>
                <td width="60" align="center" bgcolor="#DEDEDE">刪除</td>
            </tr>
            @foreach($products as $product)
                <tr>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <input type="checkbox"
                               name="id[]"
                               class="chosenId id"
                               value="{{$product->id}}" /></td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">{{$loop->index+1}}</td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        @if($product->published)
                            <img src="/system/images/ok.gif" width="11" height="11" />
                        @else
                            <img src="/system/images/notok.gif" width="11"
                                 height="11" />
                        @endif
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        @if(isset($product->category))
                            {{$product->category->parentCategory->title}} /
                            {{$product->category->title}}
                        @else
                            <span style="color:red;">'未設定'</span>
                        @endif
                    </td>
                    <td align="left" bgcolor="#ECECEC" class="border-sdown">
                        <a href="/admin/products/{{$product->id}}/edit">
                            {{$product->title}}
                        </a>
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        {{$product->created_at}}
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <a href="/admin/products/{{$product->id}}/edit">
                            <img src="/system/images/bt-revise.gif" width="23" height="23" />
                        </a>
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <a href="/admin/products/{{$product->id}}/copy">
                            <img src="/system/images/copy.gif" width="23" height="23" />
                        </a>
                    </td>
                    <td align="center" bgcolor="#ECECEC" class="border-sdown">
                        <button type='submit'
                                style="border:none;background:transparent;cursor: pointer"
                                @click="deleteProduct({{$product->id}})">
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
                    <select id="action">
                        <option value="noAction" selected="selected">請選擇</option>
                        <option value="setToShowAtHome">首頁</option>
                        <option value="setToNoShowAtHome">取消首頁</option>
                        <option value="setToShow">顯示</option>
                        <option value="setToNoShow">取消顯示</option>
                        <option value="delete">刪除資料</option>
                    </select>
                    <input type="submit" @click="doAction" value="確定" />
                </td>
                <td align="right">
                    {{ $products->links('vendor.pagination.system') }}
                </td>
            </tr>
        </table>
        <br />

        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                        <span class="border-right">
                          <input type="submit" value="確定修改" @click="updateRanking" />
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
    <script type="text/javascript" src="{{ asset('/js/system/product/productIndex.js') }}"></script>
@endsection