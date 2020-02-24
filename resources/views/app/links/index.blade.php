@extends('app.layouts.master')

@section('content')
    <div id="vueContainer">
        <div class="page-bg">
            <section class="links-box">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-12">

                            <div class="section-title">-相關連結-</div>

                            <div class="mobile-select"
                                 @click.prevent="toggleShowCat()">
                                <a class="item-active"> @{{ linkCatTitle }}</a>
                                <div v-show="showCat"
                                     class="item-list"
                                     style="display:block">
                                    <a v-for="cat in cats"
                                       class="item"
                                       @click.prevent="setActiveCat(cat)"
                                       v-cloak
                                       style="display:block">@{{cat.title}}</a>
                                </div>
                            </div>

                            <div class="side-bar">
                                <a v-for="cat in cats"
                                   class="item"
                                   :class="isActive(cat)"
                                   @click.prevent="setActiveCat(cat)"
                                   v-cloak>
                                    @{{ cat.title }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-8 col-12" v-cloak>
                            <div class="section-title" 
                                 v-if="!isMobile" v-cloak>@{{ linkCatTitle }}</div>
                            <div class="links-list set-height">
                                <div class="row">
                                    <div v-for="link in activeLinkList"
                                         class="col-md-4 col-sm-6 col-xs-12">
                                        <a :href="link.url" class="links-item" target="_blank">
                                            <img :src="'/storage/'+link.photoPath">
                                            <span class="text-links-name">@{{ link.title }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('pageJS')
    <script>
    </script>
    <script type="text/javascript" src="{{ asset('/js/app/links/index.js') }}"></script>
@endsection
