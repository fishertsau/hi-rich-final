@extends('app.layouts.master')

@section('content')
    {{-- todo: get content from db --}}
    <div class="page-bg">
        <section class="about-box">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-12">

                        <div class="section-title">-關於高豐-</div>

                        <!-- 小尺寸時才出現的下拉選單 -->
                        <div class="mobile-select">
                            <a class="item-active" tab-title>公司簡介</a>
                            <div class="item-list">
                                <a class="item" onclick="scrollToElem('#c-idea', true)">公司理念</a>
                                <a class="item" onclick="scrollToElem('#c-history', true)">公司沿革</a>
                                <a class="item" onclick="scrollToElem('#c-future', true)">未來展望</a>
                            </div>
                        </div>

                        <div class="about-side-bar">
                            <a href="javascript:;" class="item is-active"
                               onclick="scrollToElem('#c-introduction', true)"><span>⊙</span>公司簡介</a>
                            <a href="javascript:;" class="item" onclick="scrollToElem('#c-idea', true)"><span>⊙</span>公司理念</a>
                            <a href="javascript:;" class="item"
                               onclick="scrollToElem('#c-history', true)"><span>⊙</span>公司沿革</a>
                            <a href="javascript:;" class="item" onclick="scrollToElem('#c-future', true)"><span>⊙</span>未來展望</a>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-8 col-12">
                        <div class="about-content">

                            <!-- 公司簡介 -->
                            <img src="./asset/images/about/c01.jpg" class="img-full img-company">
                            <div class="about-title" id="c-introduction">公司簡介</div>
                            <div class="about-text">
                                <p>高豐海產股份有限公司是由一群專業海產的熱誠團隊在2002年創立於台北。</p>
                                <br />
                                <p>豐富的海產經驗及誠信面對每個客戶；高豐與國外廠商及客戶之間建立良好的信譽，</p>
                                <p>歷經幾年來各界的支持，高豐團隊整合成立台北、台中和高雄地區營業據點，</p>
                                <p>以更廣親切的服務範圍行銷產品於全省各市場。</p>
                                <br />
                                <p>高豐海產以專業的眼光從世界各國進口數十種新鮮海產來符合各層級市場需求</p>
                                <p>每年更持續研發多種新產品來提升市場競爭力，</p>
                                <p>以各合理的價格成本創造雙贏互利合作關係。</p>
                            </div>

                            <!-- 公司理念 -->
                            <img src="./asset/images/about/c02.jpg" class="about-img">
                            <div class="about-title" id="c-idea">公司理念</div>
                            <div class="about-text">
                                <p>高豐嚴厲控管海產品質，從國外源頭至消費者手中，</p>
                                <p>每個環節小心且謹慎精選確保產品的品質加上專業的物流服務配合客戶要求，</p>
                                <p>以最有效益的時間送達目的地高豐本著<span style="color:#e88f13">「誠信、穩健、超越分享」</span>的經營理念，</p>
                                <p>以客戶至上的承諾為目標，以誠信合理的價格為原則，</p>
                                <p>供應穩定的貨源，持續為客戶創造更大的商機及美食的世界。</p>
                            </div>

                            <!-- 公司沿革 -->
                            <img src="./asset/images/about/c03.jpg" class="about-img">
                            <div class="about-title" id="c-history">公司沿革</div>
                            <div class="about-text">
                                <p>2002年 高豐海產股份有限公司在2002年創立於台北，開始經營冷凍海鮮產品。</p>
                                <p>2002年 高豐成立南部營業據點--高雄營業所。</p>
                                <p>2002年 高豐開始進口第一項冷凍海鮮--草蝦。</p>
                                <p>2005年 高豐成立中部營業據點--台中營業所。</p>
                                <p>2010年 開始進口東南亞冷凍海鮮。</p>
                                <p>2010年 開始進口中美洲冷凍海鮮。</p>
                                <p>2019年 第一次參加食品展舉辦相關活動宣傳，成功打響高豐品牌並獲得廠商與消費者青睞。</p>
                                <p></p>
                                <p></p>
                            </div>

                            <!-- 未來展望 -->
                            <img src="./asset/images/about/c04.jpg" class="about-img">
                            <div class="about-title" id="c-future">未來展望</div>
                            <div class="about-text">
                                <p>未來展望未來展望未來展望未來展望未來展望未來展望未來展望未來展望</p>
                                <p>未來展望未來展望未來展望未來展望未來展望未來展望未來展望未來展望</p>
                                <p>未來展望未來展望未來展望未來展望未來展望未來展望未來展望未來展望</p>
                                <p>未來展望未來展望未來展望未來展望未來展望未來展望未來展望未來展望</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
