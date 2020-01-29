@extends('app.layouts.master')

@section('content')
    <div id="container">
        <section class="contact-box">
            <div class="map-box">
                <div v-for="site in sites" v-cloak>
                    <iframe v-show="site === activeSite"
                            class="my-map"
                            :src="'https://www.google.com/maps/embed/v1/place?q='+ site.google_map + '&key=AIzaSyDJ5an-s6QDM1525riFKTstEbiMex0iq-U'"
                            allowfullscreen></iframe>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-12">
                        <div class="section-title">-聯絡資訊-</div>
                        <div class="contact-info-box">
                            <div class="company-title">高豐海產股份有限公司</div>

                            <div class="company-box" v-for="site in sites" v-cloak>
                                <a class="company-item"
                                   :class="isActive(site)"
                                   @click.prevent="setActiveSite(site)">
                                    @{{site.name}}
                                    <span class="text-map">-MAP</span>
                                </a>
                                <div class="text-address"
                                     v-show="!_.isEmpty(site.address)">
                                    地址：@{{ site.address}}
                                </div>
                                <div class="text-phone"
                                     v-show="!_.isEmpty(site.tel)">
                                    TEL：@{{site.tel}}
                                </div>
                                <div class="text-fax"
                                     v-show="!_.isEmpty(site.fax)">
                                    FAX：@{{site.fax}}
                                </div>
                                <div class="text-mail"
                                     v-show="!_.isEmpty(site.email)">
                                    Email：@{{site.email}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-sm-8 col-12">
                        <form action="/contact"
                              method="post"
                              onsubmit="return validateVerification()">
                            {{csrf_field()}}
                            <div class="section-title">聯絡我們</div>
                            <div class="home-contact">
                                <div class="contact-form">
                                    <div class="input-box">
                                        <input type="text" name="title" placeholder="*相關事宜" required="">
                                    </div>
                                    <div class="input-box">
                                        <input type="text" name="contact" placeholder="*您的姓名或公司行號" required>
                                    </div>
                                    <div class="input-box">
                                        <input type="text" name="tel" placeholder="您的聯絡電話">
                                    </div>
                                    <div class="input-box">
                                        <input type="text" name="email" placeholder="*您的EMAIL" required>
                                    </div>
                                    <div class="input-box">
                                    <textarea rows="6" placeholder="*請留言" name="message" required
                                              class="form-style form-textarea"></textarea>
                                    </div>
                                    <div class="input-box">
                                        <input name="verification"
                                               type="text"
                                               placeholder="* 輸入右方數字"
                                               onfocus="this.value = '';"
                                               required
                                               style="width:50%;margin-right:2%">
                                        <span id="securityCode"></span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-need">*必填</span>
                                        <button class="btn-submit">送出</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@section('pageJS')
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function (event) {
        generateVerificationCode();
      });

      function generateVerificationCode() {
        document.querySelector('#securityCode').innerText = randomFixedInteger(5);
      }

      const randomFixedInteger = function (length) {
        return Math.floor(Math.pow(10, length - 1) + Math.random() * (Math.pow(10, length) - Math.pow(10, length - 1) - 1));
      }

      function validateVerification() {
        let inputVerification = document.querySelector("input[name='verification']").value;

        let generatedVerification = document.querySelector('#securityCode').innerText;

        if (!(inputVerification.toString() === generatedVerification)) {
          alert('驗證號碼錯誤,請重新輸入');
          document.querySelector("input[name='verification']").value = '';
          document.querySelector("input[name='verification']").focus();
          return false;
        }
        return true;
      }
    </script>

    <script type="text/javascript" src="{{ asset('/js/app/contact/index.js') }}"></script>
@endsection
