@extends('system.layouts.master')


@section('content')
    <div id="container">
        <div id="site">
            <a href="/admin">首頁</a>>Banner管理
        </div>
        <form action="/admin/banner"
              method="POST"
              enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <h4>中文版 Banner </h4>
            <table width="100%" border="0">
                {{--banner1--}}
                <tr class="border-down">
                    <td width="100" align="center" bgcolor="#ECECEC" class="border-down">Banner-1</td>

                    <td class="border-down">
                        {{--主標/副標--}}
                        <table width="100%" border="0" style="display: none">
                            <tr>
                                <td width="40">主標</td>
                                <td><input name="titleA" type="text" id="" size="52"
                                           value="{{isset($bannerA->title)?$bannerA->title:'' }}"
                                           maxlength="10"
                                    />
                                    (建議10字以內含空格、符號)
                                </td>
                            </tr>
                            <tr>
                                <td>副標</td>
                                <td>
                                    <input name="subTitleA" type="text" size="52"
                                           value="{{isset($bannerA->subTitle)?$bannerA->subTitle:''}}"
                                           maxlength="15"
                                    />
                                    (建議15字內含空格、符號)
                                </td>
                            </tr>
                        </table>
                        <br/>
                        圖片上傳：<br/>
                        <input type="radio" name="bannerA_photoCtrl"
                               value="originalFile"
                               v-model="bannerA_photoCtrl"
                        @if(isset($bannerA->photoPath))
                            {{($bannerA->photoPath<>'')?'checked':''}}
                                @endif
                        />
                        維持原圖：
                        @if(isset($bannerA->photoPath) && ($bannerA->photoPath<>''))
                            <img src="/storage/{{$bannerA->photoPath}}" width="200" height="55" align="absmiddle"/>
                        @else
                            <img src="" width="200" height="55" align="absmiddle" alt="展示圖檔"/>
                        @endif
                        <br/>
                        <input type="radio" name="bannerA_photoCtrl" value="deleteFile"
                               v-model="bannerA_photoCtrl"/>
                        刪除圖檔：xxxxx.jpg<br/>
                        <input type="radio" name="bannerA_photoCtrl" value="newFile"
                               {{!isset($bannerA->photoPath)?'checked':''}}
                               v-model="bannerA_photoCtrl"
                        />
                        上傳檔案：
                        <input type="file" name="photoA"
                               @change="enablePhotoACtrl"/>
                        <p style="color:red"
                           v-show="viewCtrl.showSelectPhotoAWarning"
                           v-cloak>請選擇檔案</p>
                        <br/>
                        <br/>
                    </td>
                </tr>
                {{--banner2--}}
                <tr>
                    <td align="center" bgcolor="#ECECEC" class="border-down">Banner-2</td>
                    <td class="border-down">
                        {{--主標/副標--}}
                        <table width="100%" border="0" style="display: none">
                            <tr>
                                <td width="40">主標</td>
                                <td><input name="titleB" type="text" id="" size="52"
                                           value="{{isset($bannerB->title)?$bannerB->title:'' }}"
                                           maxlength="10"
                                    />
                                    (建議10字以內含空格、符號)
                                </td>
                            </tr>
                            <tr>
                                <td>副標</td>
                                <td>
                                    <input name="subTitleB" type="text" size="52"
                                           value="{{isset($bannerB->subTitle)?$bannerB->subTitle:''}}"
                                           maxlength="15"
                                    />
                                    (建議15字內含空格、符號)
                                </td>
                            </tr>
                        </table>
                        <br/>
                        圖片上傳：<br/>
                        <label for="radio6"></label>
                        <input type="radio" name="bannerB_photoCtrl" value="originalFile"
                               v-model="bannerB_photoCtrl"
                                {{isset($bannerB->photoPath)?'checked':''}}
                        />
                        維持原圖：
                        @if(isset($bannerB->photoPath) && ($bannerB->photoPath<>''))
                            <img src="/storage/{{$bannerB->photoPath}}" width="200" height="55" align="absmiddle"/>
                        @else
                            <img src="" width="200" height="55" align="absmiddle" alt="展示圖檔"/>
                        @endif
                        <br/>
                        <input type="radio" name="bannerB_photoCtrl" value="deleteFile"
                               v-model="bannerB_photoCtrl"/>
                        刪除圖檔：xxxxx.jpg<br/>
                        <input type="radio" name="bannerB_photoCtrl" value="newFile"
                               v-model="bannerB_photoCtrl"
                                {{!isset($bannerB->photoPath)?'checked':''}}/>
                        上傳檔案：
                        <input type="file" name="photoB" @change="enablePhotoBCtrl"/>
                        <p style="color:red"
                           v-show="viewCtrl.showSelectPhotoBWarning"
                           v-cloak>請選擇檔案</p>
                        <br/>
                        <br/>
                    </td>
                </tr>
            </table>
            <span class="textblue-smallblack">註： 圖片製作尺寸皆為寬1920 x 高848px，解析度72dpi。</span><br/>

            <br>
            <hr>


            @if(config('app.english_enabled'))
                <h4>英文版 Banner </h4>
                <table width="100%" border="0">
                    {{--banner1--}}
                    <tr class="border-down">
                        <td width="100" align="center" bgcolor="#ECECEC" class="border-down">Banner-1</td>
                        <td class="border-down">
                            圖片上傳：<br/>
                            <input type="radio" name="bannerA_photoEnCtrl"
                                   value="originalFile"
                                   v-model="bannerA_photoEnCtrl"
                            @if(isset($bannerA->photoPath_en))
                                {{($bannerA->photoPath_en<>'')?'checked':''}}
                                    @endif
                            />
                            維持原圖：
                            @if(isset($bannerA->photoPath_en) && ($bannerA->photoPath_en<>''))
                                <img src="/storage/{{$bannerA->photoPath_en}}" width="200" height="55"
                                     align="absmiddle"/>
                            @else
                                <img src="" width="200" height="55" align="absmiddle" alt="展示圖檔"/>
                            @endif
                            <br/>
                            <input type="radio" name="bannerA_photoEnCtrl" value="deleteFile"
                                   v-model="bannerA_photoEnCtrl"/>
                            刪除圖檔：xxxxx.jpg<br/>
                            <input type="radio" name="bannerA_photoEnCtrl" value="newFile"
                                   {{!isset($bannerA->photoPath_en)?'checked':''}}
                                   v-model="bannerA_photoEnCtrl"
                            />
                            上傳檔案：
                            <input type="file" name="photoA_en"
                                   @change="enablePhotoAEnCtrl"/>
                            <p style="color:red"
                               v-show="viewCtrl.showSelectPhotoAEnWarning"
                               v-cloak>請選擇檔案</p>
                            <br/>
                            <br/>
                        </td>
                    </tr>
                    {{--banner2--}}
                    <tr>
                        <td align="center" bgcolor="#ECECEC" class="border-down">Banner-2</td>
                        <td class="border-down">
                            圖片上傳：<br/>
                            <input type="radio" name="bannerB_photoEnCtrl"
                                   value="originalFile"
                                   v-model="bannerB_photoEnCtrl"
                            @if(isset($bannerB->photoPath_en))
                                {{($bannerB->photoPath_en<>'')?'checked':''}}
                                    @endif
                            />
                            維持原圖：
                            @if(isset($bannerB->photoPath_en) && ($bannerB->photoPath_en<>''))
                                <img src="/storage/{{$bannerB->photoPath_en}}" width="200" height="55"
                                     align="absmiddle"/>
                            @else
                                <img src="" width="200" height="55" align="absmiddle" alt="展示圖檔"/>
                            @endif
                            <br/>
                            <input type="radio" name="bannerB_photoEnCtrl" value="deleteFile"
                                   v-model="bannerB_photoEnCtrl"/>
                            刪除圖檔：xxxxx.jpg<br/>
                            <input type="radio" name="bannerB_photoEnCtrl" value="newFile"
                                   {{!isset($bannerB->photoPath_en)?'checked':''}}
                                   v-model="bannerB_photoEnCtrl"
                            />
                            上傳檔案：
                            <input type="file" name="photoB_en"
                                   @change="enablePhotoBEnCtrl"/>
                            <p style="color:red"
                               v-show="viewCtrl.showSelectPhotoBEnWarning"
                               v-cloak>請選擇檔案</p>
                            <br/>
                            <br/>
                        </td>
                    </tr>
                </table>
                <span class="textblue-smallblack">註： 圖片製作尺寸皆為寬1920 x 高503px，解析度72dpi。</span><br/>
            @endif

            <br/>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <span class="border-right">
                            <input type="submit" value="確定修改"/>
                            <img src="/system/images/empty.gif" width="50" height="10"/>
                            @include('system.partials.gobackBtn')
                        </span>
                    </td>
                </tr>
            </table>
        </form>
        <br/>
    </div>
@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('/js/system/banner/banner.js') }}"></script>
@endsection