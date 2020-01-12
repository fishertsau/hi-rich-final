<table width="100%" border="0">
    <tr>
        <td colspan="2" align="center" bgcolor="#DEDEDE">編輯資料</td>
    </tr>
    <tr>
        <td width="150" align="right" bgcolor="#DEDEDE">顯示：</td>
        <td>
            <input type="radio" name="published" value="1"
                   @if(!isset($news))
                   checked
            @else
                {{$news->published?'checked':''}}
                    @endif
            />
            顯示
            <input type="radio" name="published" value="0"
            @if(isset($news))
                {{!$news->published?'checked':''}}
                    @endif
            />
            不顯示
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#DEDEDE">建檔日期：</td>
        <td>
            @if(isset($news->created_at))
                {{$news->created_at}}
            @endif
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#DEDEDE">發佈日期：</td>
        <td>
            <input type="date" name="published_since"
                   @if(isset($news->published_since))
                   value="{{$news->published_since->toDateString()}}"
                   @else
                   value="{{$carbonPresenter->today()}}"
                    @endif

            ><span style="color:red">*發佈日期必填,顯示由發佈日期起算.</span>
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#DEDEDE">結束日期：</td>
        <td>
            <input type="date" name="published_until" id="published_until"
                   @if(isset($news))
                   value="{{isset($news->published_until)?$news->published_until->toDateString():''}}"
                   @else
                   value="{{$carbonPresenter->monthsFromNow(2)}}"
                    @endif
            > <span onclick="showForever()" style="border: 1px solid red;background: yellow">永久顯示</span>
            <span style="color:red">*結束日期若未設定,表示永久顯示.</span>
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#DEDEDE">類別：</td>
        <td>
            <select name="cat_id">
                @foreach($cats as $cat)
                    <option value="{{$cat->id}}"
                            {{(isset($news) && $news->cat_id === $cat->id)?'selected':''}}>
                        {{$cat->title}}</option>
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#DEDEDE">標題：</td>
        <td>
            <input name="title"
                   type="text" size="50"
                   @if(isset($news->title))
                   value="{{$news->title}}"
                    @endif/>
        </td>
    </tr>
    <tr>
        <td align="right" valign="top" bgcolor="#DEDEDE">內文：</td>
        <td>
            <textarea name="body"
                      rows="4" cols="50"
                      class="textarea"
                      id="froala-editor"
                      ckeditor="true"
                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                {{isset($news->body)?$news->body:''}}
                </textarea>
        </td>
    </tr>

    @if(config('app.english_enabled'))
        <tr>
            <td align="right" bgcolor="#DEDEDE">標題(英文)：</td>
            <td><input name="title_en"
                       type="text" size="50"
                       @if(isset($news->title_en))
                       value="{{$news->title_en}}"
                        @endif
                /></td>
        </tr>
        <tr>
            <td align="right" valign="top" bgcolor="#DEDEDE">內文(英文)：</td>
            <td>
            <textarea name="body_en"
                      rows="4" cols="50"
                      class="textarea"
                      id="froala-editor"
                      ckeditor="true"
                      style="width: 100%; height: 200px; font-size: 14px;
                      line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                    {{isset($news->body_en)?$news->body_en:''}}
                </textarea>
            </td>
        </tr>
    @endif
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
