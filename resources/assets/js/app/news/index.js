require('../../bootstrap');
import { getNewsCategory, getPublishedNews } from "../../bootstrap";

const Vue = require('vue');

const vm = new Vue({
  el: '#container',
  data: {
    cats: [],
    activeCat: {},
    showCat: false,
    newsList: [],
    activeNewsList: [],
    activeNews: {}
  },
  computed: {},
  beforeCreate: async function () {

    const [catResult, newsResult] = await Promise.all([getNewsCategory(), getPublishedNews()]);

    this.cats = [...catResult.data];
    this.activeCat = vm.cats[0] || {};

    this.newsList = [...newsResult.data];
    this.activeNewsList = [...vm.newsList];
    this.activeNews = vm.newsList[0] || {};
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
    setActiveCat: function (cat) {
      this.activeCat = cat;
      this.showCat = false;

      const localActiveNewsList = this.newsList
        .filter(n => n.cat_id === cat.id);

      this.activeNewsList = [...localActiveNewsList];
    }
  }
});
