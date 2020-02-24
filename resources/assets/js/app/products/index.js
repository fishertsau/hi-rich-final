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

const initProdCat = { id: 0, title: '全部產品' }

new Vue({
  el: '#container',
  data: {
    cats: [],
    activeCat: initProdCat,
    activeSubCat: {},
    products: [],
    chosenProducts: [],
    visibleProducts: [],
    chosenProduct: {},
    pagination: initPager,
    showCat: false,
    isMobile: false
  },
  watch: {
    activeCat: {
      deep: true,
      handler: async function (newVal) {
        await this.setChosenProducts(newVal);
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
        this.cats = [{ id: 0, title: '全部產品' }, ...catResult.data];
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
      return { 'is-active': this.activeCat.id === cat.id }
    },
    setActiveProduct: function (product) {
      this.chosenProduct = { ...product };
    },
    chosenCatIds: function (activeCat = {}, activeSubCat = {}) {
      if (activeCat.id === 0) {return []}

      if (activeSubCat.id) { return [activeSubCat.id]; }

      // only main cat
      const localActiveCat = this.cats.find(c => c.id === this.activeCat.id)
        || { child_categories: [] };

      return localActiveCat.child_categories.map(c => c.id);
    },
    setChosenProducts: function (activeCat = {}, activeSubCat = {}) {
      // 全部產品
      if (activeCat.id === 0) {
        this.chosenProducts = [...this.products];
        return;
      }

      const localCatIds = this.chosenCatIds(activeCat, activeSubCat);

      const byCatIds = p => localCatIds.length === 0
        ? () => false
        : localCatIds.includes(p.cat_id);

      this.chosenProducts = this.products.filter(byCatIds);
    },
    setVisibleProducts: function (pagination) {
      const localProducts = [...this.chosenProducts];
      const first = (pagination.current_page - 1) * (pagination.qty_per_page);
      const fetchQty = pagination.qty_per_page;
      this.visibleProducts = localProducts.splice(first, fetchQty);
    },
    updateCurrentPage: function (newPage) {
      this.pagination.current_page = newPage;
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
