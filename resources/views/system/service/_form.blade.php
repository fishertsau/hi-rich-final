<table width="99%" border="0" cellpadding="5" cellspacing="0">
    <tr>
        <td width="130" align="right" bgcolor="#ECECEC" class="border-sdown">顯示：</td>
        <td bgcolor="#FFFFFF" class="border-sdown">
            <input type="radio" name="published" value="1"
                    {{!isset($service)?'checked':($service->published?'checked':'')}}
            >
            是(上架)　
            <input type="radio" name="published" value="0"
                    {{!isset($service)?'':(!$service->published?'checked':'')}}
            />
            否 (下架)
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#ECECEC" class="border-sdown">首頁：</td>
        <td bgcolor="#FFFFFF" class="border-sdown">
            <input type="radio" name="published_in_home" value="1"
                   {{!isset($service)?'':($service->published_in_home?'checked':'')}}
                   @change="validatePublishedInHome"
            />
            是　
            <input type="radio" name="published_in_home" value="0"
                    {{!isset($service)?'checked':(!$service->published_in_home?'checked':'')}}
            />
            否
        </td>
    </tr>
    
    <tr>
        <td align="right" bgcolor="#ECECEC" class="border-sdown">服務主圖：</td>
        <td bgcolor="#FFFFFF" class="border-sdown">

            @if(isset($service))
                <input type="radio" name="photoCtrl"
                       value="originalFile"
                       v-model="formInput.photoCtrl"
                />
                維持原圖：
                @if(isset($service->photoPath) && ($service->photoPath<>''))
                    <img src="/storage/{{$service->photoPath}}" width="400" height="300"
                         align="absmiddle"/>
                    <img src="" width="200" height="55" align="absmiddle" alt="展示圖檔"/>
                @endif
                <br/>
                <input type="radio" name="photoCtrl" value="deleteFile"
                       v-model="formInput.photoCtrl"/>
                刪除圖檔：xxxxx.jpg<br/>
            @endif

            <input type="radio" name="photoCtrl" value="newFile"
                   v-model="formInput.photoCtrl"
            />
            上傳檔案：
            <input type="file" name="photo"
                   @change="enablePhotoCtrl"/>
            <span>（圖片尺寸：{{config('app.product_photo_size_note')}}　解析度72dpi）</span>
            <p style="color:red"
               v-show="viewCtrl.showSelectPhotoWarning"
               v-cloak>請選擇檔案</p>
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#ECECEC" class="border-sdown">
            {{$localePresenter->ChinesePrefix()}}主題</td>
        <td bgcolor="#FFFFFF" class="border-sdown">
            <input name="title" type="text" size="100%"
                   @if(isset($service))
                   value="{{$service->title}}"
                   @endif

                   @if(isset($copyService))
                   value="{{$copyService->title}}"
                   @endif
            />
        </td>
    </tr>
    <tr>
        <td width="130" align="right" bgcolor="#ECECEC" class="border-sdown" valign="top">{{$localePresenter->ChinesePrefix()}}內文</td>
        <td bgcolor="#FFFFFF" class="border-sdown">
                <textarea name="body"
                          cols="105"
                          rows="10"
                          class="textarea"
                          ckeditor="true">
                    @if(isset($service))
                        {{$service->body}}
                    @endif

                    @if(isset($copyService))
                        {{$copyService->body}}
                    @endif
                </textarea>
            <br/>
            <br/>
        </td>
    </tr>
    <tr></tr>
    <tr></tr>

    @ifEngEnabled()
    {{--英文內容--}}
    <tr>
        <td align="right" bgcolor="#ECECEC" class="border-sdown" valign="top">英文主題</td>
        <td bgcolor="#FFFFFF" class="border-sdown">
            <input name="title_en" type="text" size="100%"
                   @if(isset($service))
                   value="{{$service->title_en}}"
                   @endif

                   @if(isset($copyService))
                   value="{{$copyService->title_en}}"
                   @endif
            />
        </td>
    </tr>
    <tr>
        <td width="130" align="right" bgcolor="#ECECEC" class="border-sdown" valign="top">英文內文</td>
        <td bgcolor="#FFFFFF" class="border-sdown">
                <textarea name="body_en"
                          cols="105"
                          rows="10"
                          class="textarea"
                          ckeditor="true">
                    @if(isset($service))
                        {{$service->body_en}}
                    @endif

                    @if(isset($copyService))
                        {{$copyService->body_en}}
                    @endif
                </textarea>
            <br/>
            <br/>
        </td>
    </tr>
    @endifEngEnabled()

</table>
<img src="/system/images/empty.gif" width="10" height="30"/><br/>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <span class="border-right">
                <input type="submit"
                       value="確定修改"/>

                <img src="/system/images/empty.gif" width="50" height="10"/>
                @include('system.partials.gobackBtn')
            </span>
        </td>
    </tr>
</table>