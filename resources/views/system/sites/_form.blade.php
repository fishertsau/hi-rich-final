<table width="100%" border="0">
    <tr>
        <td colspan="2" align="center" bgcolor="#DEDEDE">編輯資料</td>
    </tr>
    <tr>
        <td width="150" align="right" bgcolor="#DEDEDE">顯示：</td>
        <td>
            <input type="radio" name="published" value="1"
                   {{(!isset($site) || $site->published)? 'checked' : '' }} /> 顯示
            <input type="radio" name="published" value="0"
                    {{(isset($site) && !$site->published)? 'checked' : '' }} /> 不顯示
        </td>
    </tr>

    <tr>
        <td align="right" bgcolor="#DEDEDE">據點名稱：</td>
        <td>
            <input name="name" type="text" size="50" required
                   @if(isset($site->name)) value="{{$site->name}}" @endif/>
        </td>
    </tr>

    <tr>
        <td align="right" bgcolor="#DEDEDE">電話：</td>
        <td>
            <input name="tel"
                   type="text" size="50"
                   @if(isset($site->tel)) value="{{$site->tel}}" @endif/>
        </td>
    </tr>

    <tr>
        <td align="right" bgcolor="#DEDEDE">傳真：</td>
        <td>
            <input name="fax"
                   type="text" size="50"
                   @if(isset($site->fax)) value="{{$site->fax}}" @endif/>
        </td>
    </tr>

    <tr>
        <td align="right" bgcolor="#DEDEDE">電子信箱：</td>
        <td>
            <input name="email"
                   type="text" size="100"
                   @if(isset($site->email)) value="{{$site->email}}" @endif/>
        </td>
    </tr>
    
    <tr>
        <td align="right" bgcolor="#DEDEDE">據點地址：</td>
        <td>
            <input name="address"
                   type="text" size="100"
                   @if(isset($site->address)) value="{{$site->address}}" @endif/>
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#DEDEDE">Google Map訊息：</td>
        <td>
            <input name="google_map"
                   type="text" size="100"
                   @if(isset($site->google_map)) value="{{$site->google_map}}" @endif/>
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#DEDEDE">建檔日期：</td>
        <td>
            @if(isset($site->created_at)) {{$site->created_at}} @endif
        </td>
    </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <span class="border-right">
              <input type="submit" name="選擇檔案4" id="選擇檔案4" value="確定修改" />
              <img src="/system/images/empty.gif" width="50" height="10" />
                @include('system.partials.gobackBtn')
            </span>
        </td>
    </tr>
</table>

