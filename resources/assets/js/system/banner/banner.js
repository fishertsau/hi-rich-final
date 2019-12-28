require('../../bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#container',
    data: {
        bannerA_photoCtrl: 'originalFile',
        bannerA_photoEnCtrl: 'originalFile',
        bannerB_photoCtrl: 'originalFile',
        bannerB_photoEnCtrl: 'originalFile',
        viewCtrl: {
            showSelectPhotoAWarning: false,
            showSelectPhotoAEnWarning: false,
            showSelectPhotoBWarning: false,
            showSelectPhotoBEnWarning: false,
        }
    },
    watch: {
        bannerA_photoCtrl: () => {
            app.showSelectPhotoAWarning();
        },
        bannerA_photoEnCtrl: () => {
            app.showSelectPhotoAEnWarning();
        },
        bannerB_photoCtrl: () => {
            app.showSelectPhotoBWarning();
        },
        bannerB_photoEnCtrl: () => {
            app.showSelectPhotoBEnWarning();
        },
    },
    methods: {
        //photoA
        showSelectPhotoAWarning() {
            let result = (this.bannerA_photoCtrl == 'newFile') &
                (!document.querySelector("input[name='photoA']").files.length);
            this.viewCtrl.showSelectPhotoAWarning = result;
            document.querySelector("input[name='photoA']").required = result;
        },
        enablePhotoACtrl() {
            if (document.querySelector("input[name='photoA']").files.length) {
                this.bannerA_photoCtrl = 'newFile';
            }
            this.showSelectPhotoAWarning();
        },
        //PhotoA_en
        showSelectPhotoAEnWarning() {
            let result = (this.bannerA_photoEnCtrl == 'newFile') &
                (!document.querySelector("input[name='photoA_en']").files.length);
            this.viewCtrl.showSelectPhotoAEnWarning = result;
            document.querySelector("input[name='photoA_en']").required = result;
        },
        enablePhotoAEnCtrl() {
            if (document.querySelector("input[name='photoA_en']").files.length) {
                this.bannerA_photoEnCtrl = 'newFile';
            }
            this.showSelectPhotoAEnWarning();
        },

        //PhotoB
        showSelectPhotoBWarning() {
            let result = (this.bannerB_photoCtrl == 'newFile') &
                (!document.querySelector("input[name='photoB']").files.length);
            this.viewCtrl.showSelectPhotoBWarning = result;
            document.querySelector("input[name='photoB']").required = result;
        },
        enablePhotoBCtrl() {
            if (document.querySelector("input[name='photoB']").files.length) {
                this.bannerB_photoCtrl = 'newFile';
            }
            this.showSelectPhotoBWarning();
        },

        //PhotoB_en
        showSelectPhotoBEnWarning() {
            let result = (this.bannerB_photoEnCtrl == 'newFile') &
                (!document.querySelector("input[name='photoB_en']").files.length);
            this.viewCtrl.showSelectPhotoBEnWarning = result;
            document.querySelector("input[name='photoB_en']").required = result;
        },
        enablePhotoBEnCtrl() {
            if (document.querySelector("input[name='photoB_en']").files.length) {
                this.bannerB_photoEnCtrl = 'newFile';
            }
            this.showSelectPhotoBEnWarning();
        },
    }
});