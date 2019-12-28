<table width="99%" border="0" cellpadding="5" cellspacing="0">
    <tr>
        <td width="130" align="right" bgcolor="#ECECEC" class="border-sdown">顯示：</td>
        <td bgcolor="#FFFFFF" class="border-sdown">
            <input type="radio" name="published" value="1"
                    {{!isset($product)?'checked':($product->published?'checked':'')}}
            >
            是(上架)　
            <input type="radio" name="published" value="0"
                    {{!isset($product)?'':(!$product->published?'checked':'')}}
            />
            否 (下架)
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#ECECEC" class="border-sdown">首頁：</td>
        <td bgcolor="#FFFFFF" class="border-sdown">
            <input type="radio" name="published_in_home" value="1"
                   {{!isset($product)?'':($product->published_in_home?'checked':'')}}
                   @change="validatePublishedInHome"
            />
            是　
            <input type="radio" name="published_in_home" value="0"
                    {{!isset($product)?'checked':(!$product->published_in_home?'checked':'')}}
            />
            否
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#ECECEC" class="border-sdown">分類：</td>
        <td bgcolor="#FFFFFF" class="border-sdown" id="catID-cell">
            <input type="number"
                   name="cat_id"
                   id="cat_id"
                   value="{{isset($product)?$product->cat_id:(isset($copyProduct)?$copyProduct->cat_id:'')}}"
                   hidden>
            <cat-selector
                    given_cat_id="{{isset($product)?$product->cat_id:(isset($copyProduct)?$copyProduct->cat_id:'')}}"
                    @catid-changed="handleCatIdChanged"
                    selection_depth='leafNode'
            >
            </cat-selector>
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#ECECEC" class="border-sdown">
            {{$localePresenter->ChinesePrefix()}}品名
        </td>
        <td bgcolor="#FFFFFF" class="border-sdown">
            <input name="title" type="text" size="100%"
                   @if(isset($product))
                   value="{{$product->title}}"
                   @endif

                   @if(isset($copyProduct))
                   value="{{$copyProduct->title}}"
                    @endif
            />
        </td>
    </tr>

    <tr style="display:none;">
        <td align="right" bgcolor="#ECECEC" class="border-sdown">產品主圖：</td>
        <td bgcolor="#FFFFFF" class="border-sdown">

            @if(isset($product))
                <input type="radio" name="photoCtrl"
                       value="originalFile"
                       v-model="formInput.photoCtrl"
                />
                維持原圖：
                @if(isset($product->photoPath) && ($product->photoPath<>''))
                    <img src="/storage/{{$product->photoPath}}" width="400" height="300"
                         align="absmiddle"/>
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
        <td align="right" bgcolor="#ECECEC" class="border-sdown" style="vertical-align: top; padding-top: 15px">
            <p>產品相關圖：</p>
            <p style="color:red">最多20張</p></td>
        <td bgcolor="#FFFFFF" class="border-sdown">
            <table width="100%" border="1">
                <tr style="border:1px solid black">
                    <td style="text-align: center;width:20%;border:1px solid black">原有圖檔</td>
                    <td style="width:80%;border:1px solid black;padding-bottom: 20px">
                        <div style="position:relative;display: inline-block;width:210px;height:270px"
                             v-for="photo in photosList">

                            <product-photo
                                    :source_photo="photo"
                                    @photo-deleted="onPhotoDeleted($event)"
                                    :key="photo.id">
                            </product-photo>

                        </div>
                    </td>
                </tr>
                <tr style="border:1px solid black">
                    <td style="text-align: center;border:1px solid black;vertical-align: top;padding-top: 20px">
                        <p>新增圖檔</p>
                        <button @click.prevent="moreNewPhotos">更多檔案</button>
                        <br>
                        <br>
                    </td>
                    <td style="border:1px solid black">
                        <br/>
                        <br/>
                        <span v-for="productPhoto in photos"> &nbsp;
                            <button style="color:red"
                                    @click.prevent="lessNewPhotos(productPhoto)">刪除</button>
                            <br>
                            <input type="text" placeholder="輸入圖片標題" name="photoTitles[]">
                            <br>
                            上傳檔案：<input type="file"
                                        name="photos[]"
                                        value="請選擇檔案"
                                        class="photos"/>
                            <hr>
                        </span>
                    </td>
                </tr>
            </table>
            <span class="textblue-small">（圖片尺寸：{{config('app.product_photo_size_note')}}　解析度72dpi）</span></td>
    </tr>
    <tr style="display: none">
        <td align="right" bgcolor="#ECECEC" class="border-sdown">PDF檔上傳：</td>
        <td bgcolor="#FFFFFF" class="border-sdown">
            @if(isset($product))
                <input type="radio" name="pdfCtrl"
                       value="originalPdfFile"
                       v-model="formInput.pdfCtrl"/>
                維持原檔案
                <br/>
                <input type="radio" name="pdfCtrl" value="deletePdfFile"
                       v-model="formInput.pdfCtrl"/>
                刪除檔案<br/>
                <input type="radio" name="pdfCtrl" value="newPdfFile"
                       v-model="formInput.pdfCtrl"
                       @change="showSelectPdfWarning"
                />
            @endif
            上傳檔案：
            <input type="file" name="pdfFile" value="請選擇檔案"
                   @change="enablePdfFileCtrl"/>
            <p style="color:red" v-show="viewCtrl.showSelectPdfWarning" v-cloak>請選擇檔案</p>
            <p style="color:red">*若沒有設定pdf檔,前台產品說明中 "PDF 下載"的按鈕不會顯示</p>
        </td>
    </tr>
    <tr style="display: none">
        <td align="right" bgcolor="#ECECEC" class="border-sdown">{{$localePresenter->ChinesePrefix()}}簡介</td>
        <td bgcolor="#FFFFFF" class="border-sdown">
            <textarea name="briefing" cols="105" rows="3">@if(isset($product)){{$product->briefing}}
                @endif @if(isset($copyProduct)){{$copyProduct->briefing}}@endif
            </textarea>
            <br>
            <strong>商品簡述區，只限文字，約390字，含符號、空白鍵，可斷行</strong>
        </td>
    </tr>
    <tr style="display: none">
        <td width="130" align="right" bgcolor="#ECECEC" class="border-sdown"
            valign="top">{{$localePresenter->ChinesePrefix()}}內文
        </td>
        <td bgcolor="#FFFFFF" class="border-sdown">
                <textarea name="body"
                          cols="105"
                          rows="10"
                          class="textarea"
                          ckeditor="true">
                    @if(isset($product))
                        {{$product->body}}
                    @endif

                    @if(isset($copyProduct))
                        {{$copyProduct->body}}
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
        <td align="right" bgcolor="#ECECEC" class="border-sdown" valign="top">英文品名</td>
        <td bgcolor="#FFFFFF" class="border-sdown">
            <input name="title_en" type="text" size="100%"
                   @if(isset($product))
                   value="{{$product->title_en}}"
                   @endif

                   @if(isset($copyProduct))
                   value="{{$copyProduct->title_en}}"
                    @endif
            />
        </td>
    </tr>
    <tr>
        <td align="right" bgcolor="#ECECEC" class="border-sdown">英文簡介</td>
        <td bgcolor="#FFFFFF" class="border-sdown">
            <textarea name="briefing_en" cols="105" rows="3">@if(isset($product)){{$product->briefing_en}}
                @endif @if(isset($copyProduct)){{$copyProduct->briefing_en}}@endif
            </textarea>
            <br>
            <strong>商品簡述區，只限文字，約390字，含符號、空白鍵，可斷行</strong>
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
                    @if(isset($product))
                        {{$product->body_en}}
                    @endif

                    @if(isset($copyProduct))
                        {{$copyProduct->body_en}}
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
