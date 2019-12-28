require('../../bootstrap');

window.Vue = require('vue');
Vue.component('cat-selector', require('../../components/categorySelector.vue'));

const app = new Vue({
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
        'formInput.photoCtrl': () => {
            app.showSelectPhotoWarning();
        },

    },
    methods: {
        showSelectPhotoWarning() {
            let result = (this.formInput.photoCtrl == 'newFile') &
                (!document.querySelector("input[name='photo']").files.length);
            this.viewCtrl.showSelectPhotoWarning = result;
            document.querySelector("input[name='photo']").required = result;
        },
        enablePhotoCtrl() {
            if (document.querySelector("input[name='photo']").files.length) {
                this.formInput.photoCtrl = 'newFile';
            }
            this.showSelectPhotoWarning();
        },
        validatePublishedInHome() {
            // axios.get('/admin/services/publishedInHome')
            //     .then((res) => {
            //         if (res.data.length > 19) {
            //             alert('已有20個服務項目設定在首頁顯示!\n\n**您可將其他服務項目設定解除,並加入您要的項目**');
            //             this.formInput.published_in_home = 0;
            //         }
            //     });
        }
    }
});
