require('../../bootstrap');
import {
  getAllProductCategories,
  getCategory,
  getPublishedProducts,
  ifCategoryInPathname,
  isEmpty,
  mobilecheck
} from "../../bootstrap";

const Vue = require('vue');
Vue.component('pager', require('../../components/pager.vue'));

const initPager = {
  current_page: 1,
  first_result: 0,
  max_results: 15,
  qty_per_page: 12
}

new Vue({
  el: '#container',
  data: {
    pageTitle: '',
    cats: [],
    activeCat: {},
    activeSubCat: {},
    products: [],
    chosenProducts: [],
    visibleProducts: [],
    chosenProduct: {},
    pagination: initPager,
    showCat: false,
    isMobile: false
  },
  computed: {
    isAllCat: function () {
      return { 'is-active': isEmpty(this.activeCat) }
    }
  },
  watch: {
    activeCat: {
      deep: true,
      handler: async function (newVal) {
        await this.setChosenProducts(newVal);
        this.setPageTitle(this.activeCat);
        this.pagination = { ...initPager };
        this.setVisibleProducts({ ...initPager });
      }
    },
    pagination: {
      deep: true,
      handler: function (newVal) {
        this.setVisibleProducts(newVal);
      }
    },
  },
  beforeCreate: async function () {
    this.isMobile = await mobilecheck();
    
    Promise.all([getAllProductCategories(), getPublishedProducts()])
      .then(([catResult, productsResult]) => {
        this.cats = [...catResult.data];
        this.products = [...productsResult.data];

        const { uris, catIncluded } = ifCategoryInPathname();
        return catIncluded ? getCategory(uris[uris.length - 1]) : null;
      })
      .then(res => {
        if (!res) { return true; }

        // 如果有需要,抓取active類別
        const localActiveCat = { ...res.data };

        if (parseInt(localActiveCat.level, 0) === 1) {
          this.activeCat = localActiveCat;
        }

        if (parseInt(localActiveCat.level, 0) === 2) {
          this.activeCat = this.cats
            .find(c => parseInt(c.id, 0) === parseInt(localActiveCat.parent_id, 0));
          this.activeSubCat = localActiveCat;
        }
      })
      .then(() => {
        this.setChosenProducts(this.activeCat, this.activeSubCat);
      })
      .then(() => {
        this.setVisibleProducts(this.pagination);
      })
      .then(()=>{
        this.setPageTitle(this.activeCat);
      })
      .catch(console.error);
  },
  methods: {
    setActiveCat: async function (cat) {
      this.activeCat = { ...cat };
      this.activeSubCat = {};
      this.chosenProduct = {};
      this.showCat = false;
    },
    isActive: function (cat) {
      return { 'is-active': (this.activeCat.id || 0) === (cat.id || 0) }
    },
    setActiveProduct: function (product) {
      this.chosenProduct = { ...product };
    },
    chosenCatIds: function (activeCat = {}, activeSubCat = {}) {
      if (isEmpty(activeCat)) { return []; }

      if (activeSubCat.id) { return [activeSubCat.id]; }

      // only main cat
      const localActiveCat = this.cats.find(c => c.id === this.activeCat.id)
        || { child_categories: [] };

      return localActiveCat.child_categories.map(c => c.id);
    },
    setChosenProducts: function (activeCat = {}, activeSubCat = {}) {
      // 全部產品
      if (isEmpty(activeCat)) {
        this.chosenProducts = [...this.products];
        return;
      }

      const localCatIds = this.chosenCatIds(activeCat, activeSubCat);

      if (localCatIds.length === 0) {
        this.chosenProducts = [];
        return;
      }

      const filterCriteria = p => localCatIds.includes(p.cat_id);

      this.chosenProducts = this.products.filter(filterCriteria);
    },
    setVisibleProducts: function (pagination) {
      const localProducts = [...this.chosenProducts];
      const first = (pagination.current_page - 1) * (pagination.qty_per_page);
      const fetchQty = pagination.qty_per_page;
      this.visibleProducts = localProducts.splice(first, fetchQty);
    },
    setPageTitle: function (activeCat = {}) {
      const mainCatTitle = (isEmpty(activeCat)) ? '全部產品' : activeCat.title;
      this.pageTitle = `${mainCatTitle}`;
    },
    updateCurrentPage: function (newPage) {
      this.pagination.current_page = newPage;
    },
    activeCatTitle: function (cat) {
      if (!cat.title) {
        return '全部產品';
      }

      return cat.title;
    },
    toggleShowCat: function () {
      this.showCat = !this.showCat;
    },
    isShowCat: (show) => {
      return {
        'is-open': show
      }
    }
  }
})
