<table width="100%" border="0">
    <tr>
        <td colspan="2" align="center" bgcolor="#DEDEDE">編輯資料</td>
    </tr>
    <tr>
        <td width="150" align="right" bgcolor="#DEDEDE">顯示：</td>
        <td>
            <input type="radio" name="published" value="1"
               @if(!isset($link))
                   checked
                @else
                {{$link->published?'checked':''}}
                    @endif
            />
            顯示
            <input type="radio" name="published" value="0"
            @if(isset($link))
                {{!$link->published?'checked':''}}
                    @endif
            />
            不顯示
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#DEDEDE">類別：</td>
        <td>
            <select name="cat_id">
                @foreach($cats as $cat)
                    <option value="{{$cat->id}}"
                            {{(isset($link) && $link->cat_id === $cat->id)?'selected':''}}>
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
                   @if(isset($link->title))
                   value="{{$link->title}}"
                    @endif/>
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#DEDEDE">連結網址：</td>
        <td>
            <input name="url"
                   type="text" size="100"
                   @if(isset($link->url))
                   value="{{$link->url}}"
                    @endif/>
        </td>
    </tr>

    <tr>
        <td align="right" bgcolor="#ECECEC" class="border-sdown">主圖：</td>
        <td bgcolor="#FFFFFF" class="border-sdown">

            @if(isset($link))
                <input type="radio" name="photoCtrl"
                       value="originalFile"
                       v-model="formInput.photoCtrl"
                />
                維持原圖：
                @if(isset($link->photoPath) && ($link->photoPath<>''))
                    <img src="/storage/{{$link->photoPath}}" width="400" height="300"
                         align="absmiddle" />
                @endif
                <br />
                <input type="radio" name="photoCtrl" value="deleteFile"
                       v-model="formInput.photoCtrl" />
                刪除圖檔<br />
            @endif

            <input type="radio" name="photoCtrl" value="newFile"
                   v-model="formInput.photoCtrl"
            />
            上傳檔案：
            <input type="file" name="photo"
                   @change="enablePhotoCtrl" />
            <span>（圖片尺寸：{{config('app.product_photo_size_note')}}　解析度72dpi）</span>
            <p style="color:red"
               v-show="viewCtrl.showSelectPhotoWarning"
               v-cloak>請選擇檔案</p>
        </td>
    </tr>

    <tr>
        <td align="right" bgcolor="#DEDEDE">建檔日期：</td>
        <td>
            @if(isset($link->created_at))
                {{$link->created_at}}
            @endif
        </td>
    </tr>
</table>

{{--todo: 圖片存檔--}}

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
