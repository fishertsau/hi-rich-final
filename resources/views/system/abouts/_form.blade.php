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
        <td align="right" bgcolor="#DEDEDE">標題：</td>
        <td><input name="title"
                   type="text" size="50"
                   @if(isset($about->title))
                   value="{{$about->title}}"
                    @endif
            /></td>
    </tr>

    <tr>
        <td align="right" bgcolor="#DEDEDE" class="border-sdown">主圖：</td>
        <td bgcolor="#FFFFFF" class="border-sdown">

            @if(isset($about) && !isset($copy))
                <input type="radio" name="photoCtrl"
                       value="originalFile"
                       v-model="formInput.photoCtrl"
                />
                維持原圖：
                @if(isset($about->photoPath) && ($about->photoPath<>''))
                    <img src="/storage/{{$about->photoPath}}" style="max-width:700px;height:auto;"
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
                {{--todo: change this--}}
            <span>（圖片尺寸：{{config('app.product_photo_size_note')}}　解析度72dpi）</span>
            <p style="color:red"
               v-show="viewCtrl.showSelectPhotoWarning"
               v-cloak>請選擇檔案</p>
        </td>
    </tr>

    <tr>
        <td align="right" valign="top" bgcolor="#DEDEDE">內文：</td>
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
