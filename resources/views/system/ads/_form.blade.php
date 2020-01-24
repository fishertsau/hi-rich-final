<table width="100%" border="0">
    <tr>
        <td colspan="2" align="center" bgcolor="#DEDEDE">編輯資料</td>
    </tr>
    <tr>
        <td width="150" align="right" bgcolor="#DEDEDE">顯示：</td>
        <td>
            <input type="radio" name="published" value="1"
                   {{(!isset($ad) || $ad->published)? 'checked' : '' }} /> 顯示
            <input type="radio" name="published" value="0"
                    {{(isset($ad) && !$ad->published)? 'checked' : '' }} /> 不顯示
        </td>
    </tr>

    <tr>
        <td width="150" align="right" bgcolor="#DEDEDE">位置：</td>
        <td>
            <select name="location">
                @foreach(array_keys($locations) as $key)
                    <option value="{{$key}}"
                            {{isset($ad) && $ad->location === $key ? 'selected':''}}>
                        {{$locations[$key]}}
                    </option>
                @endforeach
            </select>
        </td>
    </tr>
    
    <tr>
        <td align="right" bgcolor="#DEDEDE">名稱：</td>
        <td>
            <input name="title" type="text" size="50" required
                   @if(isset($ad->title)) value="{{$ad->title}}" @endif/>
        </td>
    </tr>


    <tr>
        <td align="right" bgcolor="#ECECEC" class="border-sdown">主圖：</td>
        <td bgcolor="#FFFFFF" class="border-sdown">

            @if(isset($ad))
                <input type="radio" name="photoCtrl"
                       value="originalFile"
                       v-model="formInput.photoCtrl"
                />
                維持原圖：
                @if(isset($ad->photoPath) && ($ad->photoPath<>''))
                    <img src="/storage/{{$ad->photoPath}}" width="400" height="300"
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
            @if(isset($ad->created_at)) {{$ad->created_at}} @endif
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

