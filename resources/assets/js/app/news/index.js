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
  beforeCreate: async () => {
    const result = await getNewsCategory();
    vm.cats = [...result.data];
    vm.activeCat = vm.cats[0] || {};

    const result2 = await getPublishedNews();
    vm.newsList = [...result2.data];
    vm.activeNewsList = [...vm.newsList];
    vm.activeNews = vm.newsList[0] || {};
  },
  methods: {
    toggleShowCat: () => {
      vm.showCat = !vm.showCat;
    },
    isShowCat: (show) => {
      return {
        'is-open': show
      }
    },
    setActiveCat: (cat) => {
      vm.activeCat = cat;
      vm.showCat = false;

      const localActiveNewsList = vm.newsList
        .filter(n => n.cat_id === cat.id);

      vm.activeNewsList = [...localActiveNewsList];
    }
  }
});
