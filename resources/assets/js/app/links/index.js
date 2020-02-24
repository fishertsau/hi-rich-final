require('../../bootstrap');
import { getLinkCategory, getPublishedLinks, mobilecheck } from "../../bootstrap";

const Vue = require('vue');

new Vue({
  el: '#vueContainer',
  data: {
    cats: [],
    activeCat: { id: 0, title: '全部連結' },
    linkList: [],
    activeLinkList: [],
    activeLink: {},
    showCat: false,
    isMobile: false
  },
  computed: {
    linkCatTitle: function () {
      return this.activeCat.title || '全部連結';
    },
    isAllCat: function () {
      return { 'is-active': !!!this.activeCat.title }
    },
  },
  beforeCreate: async function () {
    Promise.all([getLinkCategory(), getPublishedLinks()])
      .then(([catResult, linkResult]) => {
        this.cats = [{ id: 0, title: '全部連結' }, ...catResult.data];
        this.linkList = [...linkResult.data];
        this.activeLinkList = [...this.linkList];
      });

    this.isMobile = await mobilecheck();
  },
  methods: {
    isActive: function (cat) {
      return { 'is-active': this.activeCat.id === cat.id }
    },
    setActiveCat: function (cat) {
      this.activeCat = cat;

      const byCat = cat => cat.id === 0
        ? () => true
        : n => n.cat_id === cat.id;

      const localActiveLinkList = this.linkList
        .filter(byCat(cat));

      this.activeLinkList = [...localActiveLinkList];
    },
    toggleShowCat: function () {
      this.showCat = !this.showCat;
    }
  }
});
