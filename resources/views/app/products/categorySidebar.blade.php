<div class="col-md-3 col-sm-4 col-12">

    <div class="section-title">-產品項目-</div>

    <!-- 小尺寸時才出現的下拉選單 -->
    <div class="mobile-select">
        {{--todo: get from db --}}
        <a class="item-active" tab-title>全部產品</a>
        <div class="item-list">
            <a class="item">蝦類</a>
            <a class="item">貝類</a>
            <a class="item">魚類</a>
            <a class="item">軟體類</a>
            <a class="item">甲殼類</a>
        </div>
    </div>

    <div class="side-bar">
        {{--todo: change this--}}
        <a href="javascript:;"
           class="item"
           :class="isAllCat"
           @click="setActiveCat({})"
        >全部產品</a>
        <a v-for="cat in cats"
           @click.prevent="setActiveCat(cat)"
           :class="isActive(cat)"
           href="javascript:;" class="item"
           v-cloak>@{{ cat.title }}
        </a>
    </div>
</div>
