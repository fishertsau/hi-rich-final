require('../../bootstrap');

window.Vue = require('vue');
Vue.component('cat-selector', require('../../components/categorySelector.vue'));
Vue.component('product-photo', require('./Photo.vue'));

const app = new Vue({
    el: '#container',
    data: {
        formInput: {
            photoCtrl: 'originalFile',
            pdfCtrl: 'originalPdfFile',
        },
        photos: [],
        photosList: [],
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
            let result = (this.formInput.photoCtrl === 'newFile') &
                (!document.querySelector("input[name='photo']").files.length);
            this.viewCtrl.showSelectPhotoWarning = result;
            document.querySelector("input[name='photo']").required = result;
        },
        showSelectPdfWarning() {
            let result = (this.formInput.pdfCtrl === 'newPdfFile') &
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
        handleCatIdChanged(selectedId) {
            document.querySelector('#cat_id').value = selectedId;
        },
        moreNewPhotos() {
            let totalPhotosLength =
                this.photosList.length + this.photos.length;

            let maxPhotosAllowed = 20;

            if (totalPhotosLength > (maxPhotosAllowed - 1)) {
                alert('最多可以上傳' + maxPhotosAllowed + '張產品相關圖');
                return;
            }

            this.photos.push(this.photos.length);
        },
        lessNewPhotos(key) {
            let index = this.photos.indexOf(key);
            if (index > -1) {
                this.photos.splice(index, 1);
            }
        },
        onPhotoDeleted(event) {
            let index = this.photosList.indexOf(event);
            this.photosList.splice(index, 1);
        },

        validatePublishedInHome() {
            axios.get('/admin/product/publishedInHome')
                .then((res) => {
                    if (res.data.length > 19) {
                        alert('已有20個產品設定在首頁顯示!\n\n**您可將其他產品設定解除,並加入您要的產品**');
                        this.formInput.published_in_home = 0;
                    }
                });
        }
    },
    mounted() {
        elem = document.querySelector('#productPhotos');
        if (elem) {
            this.photosList = JSON.parse(elem.value);
        }
    }
});

