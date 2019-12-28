@if(isset($webConfig) && $webConfig->category_photo_enabled)
    <br/>
    <table width="99%" border="0" cellpadding="5" cellspacing="0" class="border">
        <tr>
            <td align="right" bgcolor="#ECECEC">分類圖：</td>
            <td>
                <input type="radio" name="photoCtrl"
                       value="originalFile"
                       v-model="formInput.photoCtrl"
                />
                維持原圖：
                @if(isset($category->photoPath) && ($category->photoPath<>''))
                    <img src="/storage/{{$category->photoPath}}" width="220" height="220"
                         align="absmiddle"/>
                @else
                    <img src="" width="220" height="220" align="absmiddle" alt="展示圖檔"/>
                @endif
                <br/>
                <input type="radio" name="photoCtrl" value="deleteFile"
                       v-model="formInput.photoCtrl"/>
                刪除圖檔：xxxxx.jpg<br/>
                <input type="radio" name="photoCtrl" value="newFile"
                       v-model="formInput.photoCtrl"/>
                上傳檔案：
                <input type="file" name="photo" @change="enablePhotoCtrl"/>
                <span>（圖片尺寸：{{config('app.product_photo_size_note')}}　解析度72dpi）</span>
                <p style="color:red" v-show="formInput.photoCtrl=='newFile'" v-cloak>請選擇檔案</p>
            </td>
        </tr>
    </table>
@endif