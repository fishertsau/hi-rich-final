@inject('localePresenter', 'App\Presenter\LocalePresenter')

@extends('system.layouts.master')

@section('content')

    <div id="container">
        <div id="site">
            <a href="/admin">首頁</a>>設定管理&gt;網頁頁底(宣告區)
        </div>

        <form action="/admin/settings/siteFooter" method="post">
            <input type="hidden" name="_method" value="patch">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <table width="99%" border="0">
                <tr>
                    <td align="center" bgcolor="#DEDEDE">編輯資料</td>
                </tr>
            </table>

            <table width="99%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">電話：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="tel" name="tel" style="width: 75%"
                               value="{{$webConfig->tel}}"/>
                    </td>
                </tr>
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">電子信箱：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="email" name="email" style="width: 75%"
                               value="{{$webConfig->email}}"/>
                    </td>
                </tr>
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">電子信箱2：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="email" name="email2" style="width: 75%"
                               value="{{$webConfig->email2}}"/>
                    </td>
                </tr>
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">傳真：</td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <input type="tel" name="fax" style="width: 75%"
                               value="{{$webConfig->fax}}"/>
                    </td>
                </tr>
                <tr>
                    <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">
                        公司簡介{{$localePresenter->ChinesePostfix()}}:
                        <br>(110中文字以內)
                    </td>
                    <td bgcolor="#FFFFFF" class="border-sdown">
                        <textarea name="declare" rows="3" style="width: 75%" maxlength="220">{{$webConfig->declare}}</textarea>
                    </td>
                </tr>

                @if(config('app.english_enabled'))
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>

                    <tr>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">宣告區(英文):</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <textarea name="declare_en" rows="3"
                                      style="width: 75%">{{$webConfig->declare_en}}</textarea>
                        </td>
                    </tr>
                @endif
            </table>

            @if(config('app.admin.settings.siteFooter.socialLink'))
                <h3>社群連結</h3>
                <table width="99%" border="0" cellpadding="5" cellspacing="0">

                    {{--lineId--}}
                    <tr @if(!config('app.admin.settings.siteFooter.socialLinkItems.line')) style='display:none' @endif>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">Line Id</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <input type="text" name="line_id" style="width: 75%"
                                   value="{{$webConfig->line_id}}"/>
                        </td>
                    </tr>


                    {{--blog--}}
                    <tr @if(!config('app.admin.settings.siteFooter.socialLinkItems.blog')) style='display:none' @endif>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">Line Id</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <input type="text" name="blog_url" style="width: 75%"
                                   value="{{$webConfig->blog_url}}"/>
                        </td>
                    </tr>
                    {{--facebook--}}
                    <tr @if(!config('app.admin.settings.siteFooter.socialLinkItems.facebook')) style='display:none' @endif>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">FB</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <input type="url" name="fb_url" style="width: 75%"
                                   value="{{$webConfig->fb_url}}"/>
                        </td>
                    </tr>

                    {{--pikebon--}}
                    <tr @if(!config('app.admin.settings.siteFooter.socialLinkItems.pikebon')) style='display:none' @endif>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">痞客邦</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <input type="url" name="pikebon_url" style="width: 75%"
                                   value="{{$webConfig->pikebon_url}}"/>
                        </td>
                    </tr>

                    {{--twitter--}}
                    <tr @if(!config('app.admin.settings.siteFooter.socialLinkItems.twitter')) style='display:none' @endif>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">推特(Twitter)</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <input type="url" name="twitter_url" style="width: 75%"
                                   value="{{$webConfig->twitter_url}}"/>
                        </td>
                    </tr>

                    {{--google+--}}
                    <tr @if(!config('app.admin.settings.siteFooter.socialLinkItems.google_plus')) style='display:none' @endif>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">Google+</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <input type="url" name="google_plus_url" style="width: 75%"
                                   value="{{$webConfig->google_plus_url}}"/>
                        </td>
                    </tr>

                    {{--Pinterest--}}
                    <tr @if(!config('app.admin.settings.siteFooter.socialLinkItems.pinterest')) style='display:none' @endif>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">Pinterest</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <input type="url" name="pinterest_url" style="width: 75%"
                                   value="{{$webConfig->pinterest_url}}"/>
                        </td>
                    </tr>

                    {{--YouTube--}}
                    <tr @if(!config('app.admin.settings.siteFooter.socialLinkItems.youtube')) style='display:none' @endif>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">YouTube</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <input type="url" name="youtube_url" style="width: 75%"
                                   value="{{$webConfig->youtube_url}}"/>
                        </td>
                    </tr>

                    {{--Instagram--}}
                    <tr @if(!config('app.admin.settings.siteFooter.socialLinkItems.instagram')) style='display:none' @endif>
                        <td width="180" align="right" bgcolor="#ECECEC" class="border-sdown">Instagram</td>
                        <td bgcolor="#FFFFFF" class="border-sdown">
                            <input type="url" name="instagram_url" style="width: 75%"
                                   value="{{$webConfig->instagram_url}}"/>
                        </td>
                    </tr>
                </table>
            @endif

            <br>
            <img src="/system/images/empty.gif" width="10" height="30"/><br/>
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
