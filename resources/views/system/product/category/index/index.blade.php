@extends('system.layouts.master')

@section('content')
    <div id="container">
        <div id="site"><a href="/admin">首頁</a> &gt;產品管理 &gt;產品分類管理</div>

        @if(config('app.3tier_category_enabled'))
            @include('system.product.category.index._3tierList')
        @else
            @include('system.product.category.index._1tierList')
        @endif
        <br/>

        <p style="color:red">*其他說明: 當大分類有設定時,點選前台"產品銷售",不管是否啟動分類圖,皆會顯示產品分類.</p>

        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <span class="border-right">
                        <input type="submit" value="儲存排序" @click="updateRanking"/>
                    </span>
                </td>
            </tr>
        </table>
        <br/>
    </div>
@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/category/categoryIndex.js') }}"></script>
@endsection