@extends('app.layouts.master')

@section('content')
    <!-- 輪播 -->
    <div class="banner-box">
        <div id="customize-controls" class="customize-controls" aria-label="Carousel Navigation" tabindex="0">
            <a href="javacsript:;" class="btn-controls prev" data-controls="prev" aria-controls="customize"
               tabindex="-1"><span class="img-arrow-left"></span></a>
            <a href="javacsript:;" class="btn-controls next" data-controls="next" aria-controls="customize"
               tabindex="-1"><span class="img-arrow-right"></span></a>
        </div>
        <div class="my-slider">
            @foreach($banners as $banner)
                <div class="banner-img"><img src="/storage/{{$banner->photoPath}}"></div>
            @endforeach
        </div>
    </div>

    <!-- 產品圖可連結到產品頁 -->
    <section class="home-product">
        <div class="container-fluid">
            <div class="row no-gutters">
                @foreach($products as $product)
                    <div class="col-sm-3 col-6">
                        <span class="img-home-product">
                           <img src="/storage/{{$product->photoPath}}" width="100%"> 
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="home-slogan">
            {{--todo: get content from backend --}}
            <div class="bg-slogan"></div>
            <div class="slogan-content">
                <span class="title-slogan">職人海鮮盡在高豐</span>
                <span class="text-slogan">
          集世界海洋風味之菁華，<br />
          溶烹飪鮮美食材於一體！
        </span>
            </div>
        </div>
    </section>

    <!-- 資訊 -->
    <section class="home-info">
        {{--todo: implement this--}}
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-12">
                    <div class="info-item">
                        <div class="info-symbol">
                            <span class="symbol-text">項</span>
                        </div>
                        <div class="info-content">
                            <div class="info-title">品項與產地</div>
                            <div class="info-text">
                                嚴選各國優質冷凍海鮮，產品類別有：蝦類、貝類、魚類、軟體類、甲殼類。
                                主要產地如下：加拿大、中美洲、智利、東南亞、台灣、日本、韓國、中國、俄羅斯。
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="info-item">
                        <div class="info-symbol">
                            <span class="symbol-text">銷</span>
                        </div>
                        <div class="info-content">
                            <div class="info-title">行銷通路與合作夥伴</div>
                            <div class="info-text">
                                行銷通路有：餐廳、飯店、外燴、各盤商、漁市場攤商、大賣場、超市....等等。
                                主要夥伴大多為團購業務及電子商務業者，竭誠歡迎異業商談合作與結盟。
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="info-item">
                        <div class="info-symbol">
                            <span class="symbol-text">點</span>
                        </div>
                        <div class="info-content">
                            <div class="info-title">營運據點</div>
                            <div class="info-text">
                                <span>台北營業所</span>
                                <span>TEL:02-22901180 FAX:02-22901070</span>
                                <span>高雄營業所</span>
                                <span>TEL:07-8154925 FAX:07-8155543</span>
                                <span>台中營業所</span>
                                <span>TEL:04-23158593 FAX:04-23158541</span>
                            </div>
                            <div class="more-box">
                                <a href="./contact.html" class="text-more">+ more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="info-item">
                        <div class="info-symbol">
                            <span class="symbol-text">時</span>
                        </div>
                        <div class="info-content">
                            <div class="info-title">服務時間</div>
                            <div class="info-text">
                                <span>星期一至星期五</span>
                                <span>上午8：30~12：30；下午1：30~5：30</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 聯絡我們 -->
    <section class="home-contact">
        <div class="container-fluid">
            <div class="row no-gutters">
                <div class="col-sm-6 col-12">
                    {{--todo: restore this--}}
                    <img src="/storage/{{$activity->photoPath}}" width="100%;">
                </div>
                <div class="col-sm-6 col-12">
                    <form action="/contact"
                          method="post"
                          onsubmit="return validateVerification()">
                        {{csrf_field()}}
                        <div class="contact-form">
                            <div class="input-box">
                                <input type="text" name="contact" placeholder="*您的姓名或公司行號" required="">
                            </div>
                            <div class="input-box">
                                <input type="tel" name="tel" placeholder="您的聯絡電話">
                            </div>
                            <div class="input-box">
                                <input type="email" name="email" placeholder="*您的EMAIL" required="">
                            </div>
                            <div class="input-box">
                                <textarea rows="6" 
                                          name="message"
                                          placeholder="*請留言" required
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
                        
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageJS')
    <script src="/asset/js/tiny-slider.js" type="text/javascript"></script>
    <script> initTns(); </script>

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
@endsection
