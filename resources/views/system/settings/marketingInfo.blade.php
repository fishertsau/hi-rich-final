@inject('localePresenter', 'App\Presenter\LocalePresenter')

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
                            <input type="radio" name="photoCtrl"
                                   value="originalFile"
                                   v-model="formInput.photoCtrl"
                            />
                            維持原圖：
                            @if($webConfig->photoPath<>'')
                                <img src="/storage/{{$webConfig->photoPath}}" 
                                     width="400" height="300"
                                     align="absmiddle"/>
                            @endif
                            <br/>
                            <input type="radio" name="photoCtrl" value="deleteFile"
                                   v-model="formInput.photoCtrl"/>
                            刪除圖檔<br/>

                        <input type="radio" name="photoCtrl" value="newFile"
                               v-model="formInput.photoCtrl"
                        />
                        上傳檔案：
                        <input type="file" name="photo"
                               @change="enablePhotoCtrl"/>
                        <span>（圖片尺寸：{{config('app.logo_size_note')}}　解析度72dpi）</span>
                        <p style="color:red"
                           v-show="viewCtrl.showSelectPhotoWarning"
                           v-cloak>請選擇檔案</p>
                    </td>
                </tr> 
                <tr>
                    <td align="right" bgcolor="#ECECEC" class="border-sdown">PDF檔上傳：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
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
                        上傳檔案：
                        <input type="file" name="pdfFile" value="請選擇檔案"
                               @change="enablePdfFileCtrl"/>
                        <p style="color:red" v-show="viewCtrl.showSelectPdfWarning" v-cloak>請選擇檔案</p>
                        {{--<p style="color:red">*若沒有設定pdf檔,前台產品說明中 "PDF 下載"的按鈕不會顯示</p>--}}
                    </td>
                </tr>
                
                <tr>
                    <td align="right" valign="top" bgcolor="#ECECEC">"項" 內文：</td>
                    <td>
                        <textarea name="product"
                                  rows="2" cols="30"
                                  class="textarea"
                                  id="froala-editor"
                                  ckeditor="true"
                                  style="width: 100%; height: 200px; font-size: 14px; 
                                  line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                            {{$webConfig->product}}
                            </textarea>
                    </td>
                </tr>

                <tr>
                    <td align="right" valign="top" bgcolor="#ECECEC">"銷" 內文：</td>
                    <td>
                        <textarea name="place"
                                  rows="2" cols="30"
                                  class="textarea"
                                  id="froala-editor"
                                  ckeditor="true"
                                  style="width: 100%; height: 200px; font-size: 14px; 
                                  line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                            {{$webConfig->place}}
                            </textarea>
                    </td>
                </tr>

                <tr>
                    <td align="right" valign="top" bgcolor="#ECECEC">"點" 內文：</td>
                    <td>
                        <textarea name="location"
                                  rows="2" cols="30"
                                  class="textarea"
                                  id="froala-editor"
                                  ckeditor="true"
                                  style="width: 100%; height: 200px; font-size: 14px; 
                                  line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                            {{$webConfig->location}}
                            </textarea>
                    </td>
                </tr>

                <tr>
                    <td align="right" valign="top" bgcolor="#ECECEC">"時" 內文：</td>
                    <td>
                        <textarea name="service_hour"
                                  rows="2" cols="30"
                                  class="textarea"
                                  id="froala-editor"
                                  ckeditor="true"
                                  style="width: 100%; height: 200px; font-size: 14px; 
                                  line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                            {{$webConfig->service_hour}}
                            </textarea>
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
    @include('system.partials.ckeditor_small')
@endsection


