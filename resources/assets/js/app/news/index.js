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
    activeNews: {},
    isMobile: false,
    showDetail: false
  },
  computed: {},
  beforeCreate: async function () {
    this.isMobile = await mobilecheck(); 
    
    Promise.all([getNewsCategory(), getPublishedNews()])
      .then(([catResult, newsResult]) => {
        this.cats = [...catResult.data];
        this.activeCat = vm.cats[0] || {};

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
      this.activeCat = {...cat};
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
    }
  }
});
