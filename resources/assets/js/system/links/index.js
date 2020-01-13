require('../../bootstrap');

window.Vue = require('vue');

new Vue({
  el: '#container',
  methods: {
    deleteLink(id) {
      if (!confirm('刪除後資料無法復原\n確定刪除?')) {
        return;
      }
      sendCommandToServer('/admin/links/' + id, {
        _method: 'DELETE',
      });
    },
  }
});

function sendCommandToServer(url, data) {
  axios
    .post(url, data)
    .then(function (response) {
      location.reload(true);
    })
}