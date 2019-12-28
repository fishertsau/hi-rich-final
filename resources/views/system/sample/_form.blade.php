<style>
    td {
        border: 2px solid white;
        padding-left: 3px;
    }
</style>
<span id="app">
    <table width="100%" class="app-table">
        <tr>
            <td colspan="2" align="center" bgcolor="#DEDEDE">編輯資料</td>
        </tr>
        <tr>
            <td width="150" align="right" bgcolor="#DEDEDE" padding="1px">顯示：</td>
            <td>
                <input type="radio" name="published" value="1"
                       @if(!isset($sample))
                       checked
                @else
                    {{$sample->published?'checked':''}}
                        @endif
                />
                顯示
                <input type="radio" name="published" value="0"
                @if(isset($sample))
                    {{!$sample->published?'checked':''}}
                        @endif
                />
                不顯示
            </td>
        </tr>
        <tr>
            <td align="right" bgcolor="#DEDEDE">建檔日期：</td>
            <td>
                @if(isset($sample->created_at))
                    {{$sample->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td align="right" bgcolor="#DEDEDE">標題：</td>
            <td><input name="title"
                       type="text" size="50"
                       @if(isset($sample->title))
                       value="{{$sample->title}}"
                       @endif
                       
                /></td>
        </tr>
        <tr>
            <td align="right" bgcolor="#DEDEDE">簡述：</td>
            <td><textarea name="description"
                          type="text" cols="60" rows="5"
                >{{isset($sample->description)?$sample->description:''}}</textarea>
            </td>
        </tr>
        <tr>
            <td align="right" bgcolor="#DEDEDE">代表圖：</td>
            <td>
                @if(isset($sample))
                <input type="radio" name="photoCtrl"
                       value="originalFile"
                       v-model="formInput.photoCtrl"
                />
                    維持原圖：
                    @if(isset($sample->photoPath) && ($sample->photoPath<>''))
                        <img src="/storage/{{$sample->photoPath}}" width="200" height="200"
                             align="absmiddle"/>
                    @else
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
                <span>（圖片尺寸：1,000x750px　解析度72dpi）</span>

                <p style="color:red"
                   v-show="viewCtrl.showSelectPhotoWarning"
                   v-cloak>請選擇檔案</p>
            </td>
        </tr>
    </table>

<table>
    <tr>
        <td width="150" align="right" valign="top" bgcolor="#DEDEDE">內文：</td>
        <td>
            <textarea name="body"
                      rows="4" cols="50"
                      class="textarea form-control"
                      id="summernote"
                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                    {{isset($sample->body)?$sample->body:''}}
                </textarea>
        </td>
    </tr>
</table>
</span>
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

