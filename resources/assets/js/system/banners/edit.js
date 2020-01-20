require('../../bootstrap');

window.Vue = require('vue');

new Vue({
  el: '#container',
  data: {
    formInput: {
      photoCtrl: 'originalFile',
    },
    viewCtrl: {
      showSelectPhotoWarning: false,
    }
  },
  watch: {
    'formInput.photoCtrl': function () {
      this.showSelectPhotoWarning();
    },
  },
  methods: {
    showSelectPhotoWarning() {
      let result = (this.formInput.photoCtrl === 'newFile') &
        (!document.querySelector("input[name='photo']").files.length);
      this.viewCtrl.showSelectPhotoWarning = result;
      document.querySelector("input[name='photo']").required = result;
    },
    enablePhotoCtrl() {
      if (document.querySelector("input[name='photo']").files.length) {
        this.formInput.photoCtrl = 'newFile';
      }
      this.showSelectPhotoWarning();
    }
  },
});

