require('../../bootstrap');

window.Vue = require('vue');

const app = new Vue({
  el: '#container',
  data: {
    formInput: {
      photoCtrl: 'originalFile',
      pdfCtrl: 'originalPdfFile',
    },
    viewCtrl: {
      showSelectPhotoWarning: false,
      showSelectPdfWarning: false,
    }
  },
  watch: {
    'formInput.photoCtrl': () => {
      app.showSelectPhotoWarning();
    },
    'formInput.pdfCtrl': () => {
      app.showSelectPdfWarning();
    }
  },
  methods: {
    showSelectPhotoWarning() {
      let result = (this.formInput.photoCtrl == 'newFile') &
        (!document.querySelector("input[name='photo']").files.length);
      this.viewCtrl.showSelectPhotoWarning = result;
      document.querySelector("input[name='photo']").required = result;
    },
    showSelectPdfWarning() {
      let result = (this.formInput.pdfCtrl == 'newPdfFile') &
        (!document.querySelector("input[name='pdfFile']").files.length);
      this.viewCtrl.showSelectPdfWarning = result;
      document.querySelector("input[name='pdfFile']").required = result;
    },
    enablePhotoCtrl() {
      if (document.querySelector("input[name='photo']").files.length) {
        this.formInput.photoCtrl = 'newFile';
      }
      this.showSelectPhotoWarning();
    },
    enablePdfFileCtrl() {
      if (document.querySelector("input[name='pdfFile']").files.length) {
        this.formInput.pdfCtrl = 'newPdfFile';
      }
      this.showSelectPdfWarning();
    },
  }
});

