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
