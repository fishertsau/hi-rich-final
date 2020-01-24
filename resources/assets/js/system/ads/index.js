require('../../bootstrap');
import { getData, deleteItem } from "../../bootstrap";

const Vue = require('vue');

const vm = new Vue({
  el: '#container',
  data: {
    items: [],
  },
  beforeCreate: async () => {
    const result = await getData('/api/ads/list');
    vm.items = [...result.data];
  },
  methods: {
    deleteItem: async (id) => {
      const confirmed = await confirm('刪除後資料無法復原\n確定刪除?');

      if (confirmed) {
        deleteItem(`/admin/ads/${id}`)
          .then(() => {
            return getData('/api/ads/list');
          })
          .then(res => {
            vm.items = [...res.data];
          });
      }
    },
  }
});
