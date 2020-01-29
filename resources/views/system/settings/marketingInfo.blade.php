@extends('system.layouts.master')

@section('content')
    <div id="container">
        <div id="site">
            <a href="/admin">首頁</a>>各項設定&gt;行銷內容
        </div>

        <form action="/admin/settings/marketingInfo" method="post"
              enctype="multipart/form-data">
            <input type="hidden" name="_method" value="patch">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <table width="99%" border="0">
                <tr>
                    <td align="center" bgcolor="#DEDEDE">編輯資料</td>
                </tr>
            </table>

            <table width="99%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC"
                        class="border-sdown">主標語：
                    </td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="text" name="slogan"
                               style="width: 75%"
                               value="{{$webConfig->slogan}}" />
                    </td>
                </tr>
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC"
                        class="border-sdown">副標語：
                    </td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="tel" name="slogan_sub" style="width: 75%"
                               value="{{$webConfig->slogan_sub}}" />
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#ECECEC" class="border-sdown">公司logo：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <p>Logo1</p>
                        <photo-input
                                input_name="logoA_photo"
                                input_ctrl_name="logoA_photoCtrl"
                                photo_path="{{$webConfig->logoA_photoPath}}"
                        >
                        </photo-input>
                        <hr>
                        <p>Logo2</p>
                        <photo-input
                                input_name="logoB_photo"
                                input_ctrl_name="logoB_photoCtrl"
                                photo_path="{{$webConfig->logoB_photoPath}}"
                        >
                        </photo-input>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#ECECEC" class="border-sdown">產品型錄檔上傳：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <p style="color:red;">建議pdf,其他格式檔案在傳輸時,可能會出現非預期的問題</p>
                        <input type="radio" name="pdfCtrl"
                               value="originalPdfFile"
                               v-model="formInput.pdfCtrl" />
                        維持原檔案
                        <br />
                        <input type="radio" name="pdfCtrl" value="deletePdfFile"
                               v-model="formInput.pdfCtrl" />
                        刪除檔案<br />
                        <input type="radio" name="pdfCtrl" value="newPdfFile"
                               v-model="formInput.pdfCtrl"
                               @change="showSelectPdfWarning"
                        />
                        上傳檔案：
                        <input type="file" name="pdfFile" value="請選擇檔案"
                               @change="enablePdfFileCtrl" />
                        <p style="color:red" v-show="viewCtrl.showSelectPdfWarning" v-cloak>請選擇檔案</p>
                    </td>
                </tr>

                <tr>
                    <td align="right" valign="top" bgcolor="#ECECEC">
                        <p>品項/通路/營運據點/服務時間內文：</p>
                    </td>
                    <td>
                        <p>品項與產地</p>
                        <textarea name="product"
                                  rows="1" cols="30"
                                  style="width: 100%; height: 100px; font-size: 14px;">{{$webConfig->product}}</textarea>
                        <hr>
                        <p>行銷通路與合作夥伴</p>
                        <textarea name="place"
                                  rows="1" cols="30"
                                  id="froala-editor"
                                  style="width: 100%; height: 100px; font-size: 14px; 
                                  line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$webConfig->place}}</textarea>
                        <hr>
                        <p>服務時間</p>

                        <p>
                            週&nbsp;<input type="text" name="service_week"
                                          style="width: 75%"
                                          value="{{$webConfig->service_week}}"
                                          placeholder="範例: 週一到週五" />
                        </p>
                        <p>
                            時間&nbsp;<input type="text" name="service_hour"
                                           style="width: 75%"
                                           placeholder="範例: 9:00 - 12:00; 13:00-18:00 "
                                           value="{{$webConfig->service_hour}}" />
                        </p>
                    </td>
                </tr>
            </table>

            <br>
            <img src="/system/images/empty.gif" width="10" height="30" /><br />
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <span class="border-right">
                          <input type="submit" value="確定修改" />
                          <img src="/system/images/empty.gif" width="50" height="10" />
                            @include('system.partials.gobackBtn')
                        </span>
                    </td>
                </tr>
            </table>
        </form>
        <br />
    </div>
@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/settings/marketingInfoEdit.js') }}"></script>
@endsection
