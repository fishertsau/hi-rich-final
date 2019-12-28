require('../../bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#app',
    data: {
        formInput: {
            photoCtrl: 'originalFile',
        },
        photos: [],
        photosList: [],
        viewCtrl: {
            showSelectPhotoWarning: false,
        }
    },
    watch: {
        'formInput.photoCtrl': () => {
            app.showSelectPhotoWarning();
        },
    },
    methods: {
        showSelectPhotoWarning(){
            let result = (this.formInput.photoCtrl == 'newFile') &
                (!document.querySelector("input[name='photo']").files.length);
            this.viewCtrl.showSelectPhotoWarning = result;
            document.querySelector("input[name='photo']").required = result;
        },
        enablePhotoCtrl(){
            if (document.querySelector("input[name='photo']").files.length) {
                this.formInput.photoCtrl = 'newFile';
            }
            this.showSelectPhotoWarning();
        },
    },
});
