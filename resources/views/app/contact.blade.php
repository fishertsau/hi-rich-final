@extends('app.layouts.master')

@section('content')
    <section class="contact-box">
        <div class="map-box">
            {{--todo: get the content from db --}}
            <iframe class="my-map"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3613.9231898020207!2d121.4472412510532!3d25.070592383876583!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442a89e93374c43%3A0xe64ac385b37fed80!2z6auY6LGQ5rW355Si6IKh5Lu95pyJ6ZmQ5YWs5Y-4!5e0!3m2!1szh-TW!2stw!4v1572092925554!5m2!1szh-TW!2stw"
                    frameborder="0" allowfullscreen=""></iframe>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-12">
                    <div class="section-title">-聯絡資訊-</div>
                    <div class="contact-info-box">
                        <div class="company-title">高豐海產股份有限公司</div>

                        <div class="company-box">
                            <!-- 點擊時上方map要換成對應的營業所地址 並切換class: is-active -->
                            {{-- todo: see if this should be implemented --}}
                            <a href="javascript:;" class="company-item is-active">
                                台北總公司<span class="text-map">-MAP</span>
                            </a>
                            <div class="text-address">地址：新北市五股區五工一路131號5樓</div>
                            <div class="text-phone">TEL：02-22901180</div>
                            <div class="text-fax">FAX：02-22901070</div>
                            <div class="text-mail">Email：hi.rich@msa.hinet.net</div>
                        </div>

                        <div class="company-box">
                        {{-- todo: see if this should be implemented --}}
                        <!-- 點擊時上方map要換成對應的營業所地址 並切換class: is-active -->
                            <a href="javascript:;" class="company-item">
                  <span class="link-map">
                    高雄營業所<span class="text-map">-MAP</span>
                  </span>
                            </a>
                            <div class="text-address">地址：高雄市前鎮區漁港東二路3號327室</div>
                            <div class="text-phone">TEL：07-8154925</div>
                            <div class="text-fax">FAX：07-8155543</div>
                        </div>

                        <div class="company-box">
                            <!-- 點擊時上方map要換成對應的營業所地址 並切換class: is-active -->
                            <a href="javascript:;" class="company-item">
                  <span class="link-map">
                    台中營業所<span class="text-map">-MAP</span>
                  </span>
                            </a>
                            <div class="text-address">地址：台中市西屯區大河街77號5樓</div>
                            <div class="text-phone">04-23158593</div>
                            <div class="text-fax">FAX：04-23158541</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-sm-8 col-12">
                    {{--todo: create a from here --}}
                    {{--todo: add in the validation field --}}
                    <form action="/contact"
                          method="post"
                          onsubmit="return validateVerification()">

                        {{csrf_field()}}

                        <div class="section-title">聯絡我們</div>
                        <div class="home-contact">
                            <div class="contact-form">
                                <div class="input-box">
                                    <input type="text" name="email" placeholder="*您的姓名或公司行號" required="">
                                </div>
                                <div class="input-box">
                                    <input type="text" name="phone" placeholder="您的聯絡電話" required="">
                                </div>
                                <div class="input-box">
                                    <input type="text" name="name" placeholder="*您的EMAIL" required="">
                                </div>
                                <div class="input-box">
                                    <textarea rows="6" placeholder="*請留言" required
                                              class="form-style form-textarea"></textarea>
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
@endsection
