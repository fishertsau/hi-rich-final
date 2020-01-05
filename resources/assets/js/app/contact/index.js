require('../../bootstrap');
import { getPublishedSites } from "../../bootstrap";

const Vue = require('vue');

const vm = new Vue({
  el: '#container',
  data: {
    sites: [],
    activeSite: {}
  },
  beforeCreate: async () => {
    const result = await getPublishedSites();
    vm.sites = [...result.data];
    vm.activeSite = vm.sites[0] || {};
  },
  methods: {
    setActiveSite: (site) => {
      vm.activeSite = site;
    },
    isActive: (site) => {
      const isActive =
        vm.activeSite.id
          ? site.id === vm.activeSite.id
          : false;

      return {
        'is-active': isActive
      }
    }
  }
});
