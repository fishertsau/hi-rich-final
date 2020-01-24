require('../../bootstrap');
import { getNewsCategory, getPublishedNews, mobilecheck } from "../../bootstrap";

const Vue = require('vue');
const vm = new Vue({
  el: '#container',
  data: {
    cats: [],
    activeCat: {},
    showCat: false,
    newsList: [],
    activeNewsList: [],
    activeNews: { published_since: '' },
    isMobile: false,
    showDetail: false
  },
  computed: {},
  beforeCreate: async function () {
    this.isMobile = await mobilecheck();

    Promise.all([getNewsCategory(), getPublishedNews()])
      .then(([catResult, newsResult]) => {
        this.cats = [...catResult.data];
        this.newsList = [...newsResult.data];
        this.activeNewsList = [...vm.newsList];
        this.activeNews = vm.newsList[0] || {};
      });
  },
  methods: {
    toggleShowCat: function () {
      this.showCat = !this.showCat;
    },
    isShowCat: (show) => {
      return {
        'is-open': show
      }
    },
    setActiveCat: async function (cat) {
      this.activeCat = { ...cat };
      this.showCat = false;
      this.showDetail = false;

      const localActiveNewsList = this.newsList
        .filter(n => n.cat_id === cat.id);

      this.activeNewsList = [...localActiveNewsList];
      this.activeNews = localActiveNewsList[0];
    },
    setActiveNews: function (news) {
      this.activeNews = { ...news };
      this.showDetail = true;
    },
    activeCatTitle: function (cat) {
      if (!cat.title) {
        return '全部連結';
      }

      return cat.title;
    }
  }
});
