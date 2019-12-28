@extends('system.layouts.master')

@section('content')

    @if(isset($contact))
        <input type="text" value="{{$contact}}"
               id="contactInfo" hidden>
    @endif

    <div id="container">
        <div id="site"><a href="/admin">首頁</a>>聯絡表單管理&gt;聯絡信件管理&gt;信件內容<br/>
            <img src="/system/images/empty.gif" width="10" height="10"/></div>

        <table width="99%" border="0" cellpadding="8" cellspacing="0" class="text-14">
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">主旨</td>
                <td align="left" class="border-sdown">{{$contact->title}}</td>
            </tr>
            <tr>
                <td width="200" align="right" valign="top" bgcolor="#DADADA" class="border-sdown">*連絡人</td>
                <td align="left" class="border-sdown">{{$contact->contact}}</td>
            </tr>
            <tr>
                <td align="right" bgcolor="#DADADA" class="border-sdown">*電話</td>
                <td align="left" class="border-sdown">{{$contact->tel}}</td>
            </tr>
            <tr>
                <td align="right" bgcolor="#DADADA" class="border-sdown">傳真</td>
                <td align="left" class="border-sdown">{{$contact->fax}}</td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">地址<span class="text-13"></span>
                </td>
                <td align="left" class="border-sdown">{{$contact->address}}&nbsp;</td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">E-MAIL</td>
                <td align="left" class="border-sdown">      {{$contact->email}}</td>
            </tr>
            <tr>
                <td align="right" valign="top" bgcolor="#DADADA" class="border-sdown">內容</td>
                <td align="left" class="border-sdown">{{$contact->message}}</td>
            </tr>
        </table>
        <br>
        <img src="/system/images/empty.gif" width="10" height="30"/>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <span class="border-right">
                            <input type="submit" value="已完成" @click="setProcessed" v-show="!contact.processed" v-cloak/>
                      <img src="/system/images/empty.gif" width="50" height="10"/>
                       <a href="/admin/contacts"><button>回信件管理</button></a>
                    </span>
                </td>
            </tr>
        </table>
        <br/>
    </div>
@endsection