require('../../bootstrap');
import { getLinkCategory, getPublishedLinks } from "../../bootstrap";

const Vue = require('vue');
alert('he')

new Vue({
  el: '#vueContainer',
  data: {
    cats: [],
    activeCat: {},
    linkList: [],
    activeLinkList: [],
    activeLink: {},
    showCat: false 
  },
  computed: {
    linkCatTitle: function () {
      return this.activeCat.title || '全部連結';
    },
    isAllCat: function () {
      return { 'is-active': !!!this.activeCat.title }
    },
  },
  beforeCreate: function () {
    Promise.all([getLinkCategory(), getPublishedLinks()])
      .then(([catResult, linkResult]) => {
        this.cats = [...catResult.data];
        this.linkList = [...linkResult.data];
        this.activeLinkList = [...this.linkList];
      });
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
