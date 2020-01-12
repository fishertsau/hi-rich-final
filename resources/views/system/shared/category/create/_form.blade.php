<table width="99%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr>
        <td width="150" align="right" bgcolor="#ECECEC" class="border-down">啟用：</td>
        <td class="border-down">
            <input type="radio" name="activated" value="1"
                   v-model="formInput.activated" />
            啟用
            <input type="radio" name="activated" value="0"
                   v-model="formInput.activated" />
            關閉
        </td>
    </tr>

    <tr>
        <td width="150" align="right" bgcolor="#ECECEC" class="border-down">類別型態</td>
        <td class="border-down">
            {{$categoryPresenter->catType(isset($category)?$category:null,isset($parent)?$parent:null)}}
        </td>
    </tr>

    <tr>
        <td align="right" bgcolor="#ECECEC" class="border-down">父分類：</td>
        <td class="border-down" id="cat-selector">
            <span style="display: none">
                {{$givenCatId = $categoryPresenter->givenCatId(isset($category)?$category:null,isset($parent)?$parent:null)}}
                {{$selectionLevel = $categoryPresenter->selectionLevel(isset($category)?$category:null,isset($parent)?$parent:null)}}
            </span>

            <input type="text" v-model="formInput.parent_id" name="parent_id" hidden>
            @if($selectionLevel>0)
                <cat-selector
                        applied_model = "{{$appliedModel}}"
                        given_cat_id="{{$givenCatId}}"
                        selection_depth="{{$selectionLevel}}"
                        @catid-changed="handleCatIdChanged">
                </cat-selector>
            @else
                <p> - 無父分類</p>
            @endif
        </td>
    </tr>

    <tr>
        <td align="right" bgcolor="#ECECEC" class="border-down"> 名稱： </td>
        <td class="border-down">
            <input name="title" type="text" size="100%"
                   v-model="formInput.title" />
            <p style="color:red" v-show="!formInput.title.length" v-cloak>請輸入名稱</p>
        </td>
    </tr>

    <tr>
        <td align="right" valign="top" bgcolor="#ECECEC">描述：</td>
        <td>
            <textarea name="description"
                      cols="100%" rows="5"
                      v-model="formInput.description">
            </textarea>
            <br />
            <br />
        </td>
    </tr>
</table>