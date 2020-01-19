require('../../bootstrap');
import {
  getAllProductCategories,
  getCategory,
  getPublishedProducts,
  ifCategoryInPathname,
  isEmpty
} from "../../bootstrap";

const Vue = require('vue');
Vue.component('pager', require('../../components/pager.vue'));

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
    pagination: {
      current_page: 1,
      first_result: 0,
      max_results: 3,
      qty_per_page: 3
    }
  },
  computed: {
    isAllCat: function () {
      return { 'is-active': isEmpty(this.activeCat) }
    },
    products_qty: function () {
      return this.chosenProducts.length;
    }
  },
  watch: {
    activeCat: function () {
      this.setChosenProducts(this.activeCat, this.activeSubCat);
      this.setPageTitle(this.activeCat, this.activeSubCat);
    },
    pagination: {
      deep: true,
      handler: function (newVal, oldVal) {
        this.setChosenProducts(this.activeCat, this.activeSubCat);
      }
    },
    chosenProducts: function () {
      this.setVisibleProducts();
    }
  },
  beforeCreate: async function () {
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
        this.setPageTitle(this.activeCat, this.activeSubCat);
      })
      .catch(console.error);
  },
  methods: {
    setActiveCat: function (cat) {
      this.activeCat = { ...cat };
      this.activeSubCat = {};
      this.chosenProduct = {};
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
      const localCatIds = this.chosenCatIds(activeCat, activeSubCat);

      const filterCriteria = p => localCatIds.includes(p.cat_id);

      this.chosenProducts = localCatIds.length === 0
        ? [...this.products]
        : this.products.filter(filterCriteria);
    },
    setVisibleProducts: function () {
      const localProducts = [...this.chosenProducts];
      const first = (this.pagination.current_page - 1) * (this.pagination.qty_per_page);
      const fetchQty = this.pagination.qty_per_page;
      this.visibleProducts = localProducts.splice(first, fetchQty);
    },
    setPageTitle: function (activeCat = {}, activeSubCat = {}) {
      const mainCatTitle = (isEmpty(activeCat)) ? '全部產品' : activeCat.title;
      const subCatTitle = (isEmpty(activeSubCat)) ? '' : activeSubCat.title;

      this.pageTitle = `${mainCatTitle} ${subCatTitle}`;
    },
    updateCurrentPage: function (newPage) {
      this.pagination.current_page = newPage;
    }
  }
})
