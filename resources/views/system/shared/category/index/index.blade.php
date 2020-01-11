@extends('system.layouts.master')

@section('content')
    <div id="container">
        <div id="site"><a href="/admin">首頁</a> &gt;{{$title}} &gt; {{$subTitle}}</div>

        @if(($tier3))
            @include('system.shared.category.index._3tierList')
        @elseif($tier2)
            @include('system.shared.category.index._2tierList')
        @else
            @include('system.shared.category.index._1tierList')
        @endif
        <br />

        {{--todo: remove this --}}
        <p style="color:red">*其他說明: 當大分類有設定時,點選前台"產品銷售",不管是否啟動分類圖,皆會顯示產品分類.</p>

        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <span class="border-right">
                        <input type="submit" value="儲存排序" @click="updateRanking" />
                    </span>
                </td>
            </tr>
        </table>
        <br />
    </div>
@endsection
