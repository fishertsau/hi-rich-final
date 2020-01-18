require('../../bootstrap');
import {
  getAllProductCategories,
  getPublishedProducts,
  getCategory,
  ifCategoryInPathname,
  isEmpty
} from "../../bootstrap";

const Vue = require('vue');

new Vue({
  el: '#container',
  data: {
    pageTitle: '',
    cats: [],
    activeCat: {},
    activeSubCat: {},
    products: [],
    chosenProducts: [],
    chosenProduct: {},
    pagination: {
      first_result: 0,
      max_results: 10
    }
  },
  computed: {
    isAllCat: function () {
      return { 'is-active': isEmpty(this.activeCat) }
    },
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

      const localProducts = localCatIds.length === 0
        ? [...this.products]
        : this.products.filter(filterCriteria);

      this.chosenProducts = localProducts.splice(this.pagination.first_result, this.pagination.max_results);
    },
    setPageTitle: function (activeCat = {}, activeSubCat = {}) {
      const mainCatTitle = (isEmpty(activeCat)) ? '全部產品' : activeCat.title;
      const subCatTitle = (isEmpty(activeSubCat)) ? '' : activeCat.title;

      this.pageTitle = `${mainCatTitle} ${subCatTitle}`;
    },
    more: function () {
      this.pagination.max_results++;
    }
  }
})
