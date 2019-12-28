<table width="100%" border="0">
    <tr>
        <td colspan="2" align="center" bgcolor="#DEDEDE">編輯資料</td>
    </tr>
    <tr>
        <td width="150" align="right" bgcolor="#DEDEDE">顯示：</td>
        <td>
            <input type="radio" name="published" value="1"
                   @if(!isset($about))
                   checked
            @else
                {{$about->published?'checked':''}}
                    @endif
            />
            顯示
            <input type="radio" name="published" value="0"
            @if(isset($about))
                {{!$about->published?'checked':''}}
                    @endif
            />
            不顯示
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#DEDEDE">建檔日期：</td>
        <td>
            @if(isset($about->created_at))
                {{$about->created_at}}
            @endif
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#DEDEDE">標題{{$localePresenter->ChinesePostfix()}}：</td>
        <td><input name="title"
                   type="text" size="50"
                   @if(isset($about->title))
                   value="{{$about->title}}"
                    @endif
            /></td>
    </tr>
    <tr>
        <td align="right" valign="top" bgcolor="#DEDEDE">內文{{$localePresenter->ChinesePostfix()}}：</td>
        <td>
            <textarea name="body"
                      rows="4" cols="50"
                      class="textarea form-control"
                      ckeditor="true"
                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                    @if(isset($about->body))
                    {{$about->body}}
                @endif
                </textarea>
        </td>
    </tr>

    @ifEngEnabled()
    {{--英文內容--}}
    <tr>
        <td align="right" bgcolor="#DEDEDE">標題(英文)：</td>
        <td><input name="title_en"
                   type="text" size="50"
                   @if(isset($about->title_en))
                   value="{{$about->title_en}}"
                    @endif
            /></td>
    </tr>
    <tr>
        <td align="right" valign="top" bgcolor="#DEDEDE">內文(英文)：</td>
        <td>
            <textarea name="body_en"
                      rows="4" cols="50"
                      class="textarea form-control"
                      ckeditor="true"
                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                    @if(isset($about->body_en))
                    {{$about->body_en}}
                @endif
                </textarea>
        </td>
    </tr>
    @endifEngEnabled
</table>
<br/>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <span class="border-right">
              <input type="submit" name="選擇檔案4" id="選擇檔案4" value="確定修改"/>
              <img src="/system/images/empty.gif" width="50" height="10"/>
                @include('system.partials.gobackBtn')
            </span>
        </td>
    </tr>
</table>

