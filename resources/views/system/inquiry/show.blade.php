@extends('system.layouts.master')

@section('content')

    @if(isset($inquiry))
        <input type="text" value="{{$inquiry}}"
               id="inquiryInfo" hidden>
    @endif

    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>詢價單管理&gt;詢價信件管理&gt;信件內容<br/>
            <img src="/system/images/empty.gif" width="10" height="10"/></div>
        <strong>詢價內容：</strong><br/>

        <table width="99%" border="0" cellpadding="8" cellspacing="0" class="text-14">
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">公司名稱</td>
                <td align="left" class="border-sdown">{{$inquiry->company_name}}</td>
            </tr>
            <tr>
                <td width="200" align="right" valign="top" bgcolor="#DADADA" class="border-sdown">連絡人</td>
                <td align="left" class="border-sdown">{{$inquiry->contact}}</td>
            </tr>
            <tr>
                <td align="right" bgcolor="#DADADA" class="border-sdown">電話</td>
                <td align="left" class="border-sdown">{{$inquiry->tel}}</td>
            </tr>
            <tr>
                <td align="right" bgcolor="#DADADA" class="border-sdown">傳真</td>
                <td align="left" class="border-sdown">{{$inquiry->fax}}</td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">E-MAIL</td>
                <td align="left" class="border-sdown">      {{$inquiry->email}}</td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">地址<span class="text-13"></span>
                </td>
                <td align="left" class="border-sdown">{{$inquiry->address}}&nbsp;</td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">材質</td>
                <td align="left" class="border-sdown">{{$inquiry->material}}</td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">規格</td>
                <td align="left" class="border-sdown">{{$inquiry->spec}} </td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">用途<span class="text-13"></span>
                </td>
                <td align="left" class="border-sdown">{{$inquiry->purpose}}</td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">預定張數</td>
                <td align="left" class="border-sdown">{{$inquiry->estimated_qty}}</td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">黏度</td>
                <td align="left" class="border-sdown">{{$inquiry->viscosity}}</td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">表面處理</td>
                <td align="left" class="border-sdown">{{$inquiry->surface_treatment}}</td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">包裝</td>
                <td align="left" class="border-sdown">{{$inquiry->packing}}</td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">出標方式</td>
                <td align="left" class="border-sdown">{{$inquiry->print_out}}</td>
            </tr>
        </table>
        <br>
        <img src="/system/images/empty.gif" width="10" height="30"/>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <span class="border-right">
                            <input type="submit" value="已完成" @click="setProcessed" v-show="!inquiry.processed" v-cloak/>
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
    <script type="text/javascript" src="{{ asset('/js/system/inquiry/inquiryShow.js') }}"></script>
@endsection