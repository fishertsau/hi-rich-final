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
        <td align="right" bgcolor="#DEDEDE">地址：</td>
        <td>
            <input name="address"
                   type="text" size="100"
                   @if(isset($site->address)) value="{{$site->address}}" @endif/>
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#DEDEDE">Google Map位置：</td>
        <td>
            <input name="google_map"
                   type="text" size="100"
                   @if(isset($site->google_map)) value="{{$site->google_map}}" @endif/>
            <p>輸入內容說明:</p>
            <p>(1)Google Map上顯示地址(<span style="color:red">只輸入到門號即可</span>,不需樓層或其他如室等)</p>
            <p>(2)Google我的商家上商家名稱 <a href="https://www.google.com/business/?gmbsrc=us-en-et-gs-z-gmb-l-z-h~pl|redirect|u&ppsrc=GMBLR&utm_campaign=us-en-et-gs-z-gmb-l-z-h~pl|redirect|u&utm_source=gmb&utm_medium=et&dialog=places-transition">相關連結
                </a>
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

