<div class="col-md-3 col-sm-4 col-12">

    <div class="section-title">-產品項目-</div>

    <!-- 小尺寸時才出現的下拉選單 -->
    <div class="mobile-select">
        <a class="item-active"
           @click.prevent="toggleShowCat()">
            @{{ activeCatTitle(activeCat)}}
        </a>
        <div class="item-list"
             :class="isShowCat(showCat)" 
             v-cloak>
            <a v-for="cat in cats"
               @click.prevent="setActiveCat(cat)"
               href="javascript:;"
               class="item">
                @{{ cat.title }}</a>
        </div>
    </div>

    <div class="side-bar">
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
