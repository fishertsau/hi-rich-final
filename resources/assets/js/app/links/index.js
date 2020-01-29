require('../../bootstrap');
import { getLinkCategory, getPublishedLinks, mobilecheck } from "../../bootstrap";

const Vue = require('vue');

new Vue({
  el: '#vueContainer',
  data: {
    cats: [],
    activeCat: {},
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
        this.cats = [...catResult.data];
        this.linkList = [...linkResult.data];
        this.activeLinkList = [...this.linkList];
      });
    
    this.isMobile = await mobilecheck();
  },
  methods: {
    isActive: function (cat) {
      return { 'is-active': this.activeCat === cat }
    },
    setAllCat: function () {
      this.activeCat = {};
      this.activeLinkList = [...this.linkList];
    },
    setActiveCat: function (cat) {
      this.activeCat = cat;

      const localActiveLinkList = this.linkList
        .filter(n => n.cat_id === cat.id);

      this.activeLinkList = [...localActiveLinkList];
    },
    toggleShowCat: function(){
      this.showCat = !this.showCat; 
    }
  }
});
