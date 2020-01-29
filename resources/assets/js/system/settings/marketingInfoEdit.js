require('../../bootstrap');

Vue = require('vue');
Vue.component('photo-input', require('../../components/photoInput'));

const app = new Vue({
  el: '#container',
  data: {
    formInput: {
      logoA_photoCtrl: 'originalFile',
      logoB_photoCtrl: 'originalFile',
      pdfCtrl: 'originalPdfFile',
    },
    viewCtrl: {
      showSelectPhotoWarningA: false,
      showSelectPdfWarning: false,
    }
  },
  watch: {
    'formInput.logoA_photoCtrl': () => {
      app.showSelectPhotoWarningA();
    },

    'formInput.pdfCtrl': () => {
      app.showSelectPdfWarning();
    }
  },
  methods: {
    showSelectPhotoWarningA() {
      let result = (this.formInput.logoA_photoCtrl === 'newFile') &
        (!document.querySelector("input[name='logoA_photo']").files.length);
      this.viewCtrl.showSelectPhotoWarningA = result;
      document.querySelector("input[name='logoA_photo']").required = result;
    },
    enablePhotoCtrlA() {
      if (document.querySelector("input[name='logoA_photo']").files.length) {
        this.formInput.logoA_photoCtrl = 'newFile';
      }
      this.showSelectPhotoWarning('logoA_photo', 'logoA_photo');
    },

    enablePdfFileCtrl() {
      if (document.querySelector("input[name='pdfFile']").files.length) {
        this.formInput.pdfCtrl = 'newPdfFile';
      }
      this.showSelectPdfWarning();
    },
    showSelectPdfWarning() {
      let result = (this.formInput.pdfCtrl == 'newPdfFile') &
        (!document.querySelector("input[name='pdfFile']").files.length);
      this.viewCtrl.showSelectPdfWarning = result;
      document.querySelector("input[name='pdfFile']").required = result;
    },
  }
});

