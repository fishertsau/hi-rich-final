@extends('app.layouts.master')

@section('content')
    <section class="contact-box">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-12">
                    <div class="section-title">-聯絡資訊-</div>
                    <div class="contact-info-box">
                        <div class="company-title">高豐海產股份有限公司</div>

                        <div>
                            {{--todo: add in success content--}}
                            <p>成功送出</p>
                        </div>
                        
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
                    </div>
                </div>

                <hr>

            </div>
        </div>
    </section>
@endsection
