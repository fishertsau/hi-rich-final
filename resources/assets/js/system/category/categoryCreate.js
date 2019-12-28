require('../../bootstrap');

window.Vue = require('vue');

Vue.component('cat-selector', require('../../components/categorySelector.vue'));

const app = new Vue({
    el: '#container',
    data: {
        catInfo: {},
        formInput: {
            parent_id: '',
            id: '',
            activated: 1,
            title: '',
            title_en: '',
            description: '',
            description_en: '',
            photoCtrl: 'originalFile',
            photoPath: ''
        },
        viewCtrl: {
            showSelectPhotoWarning: false,
        }
    },
    watch: {
        'formInput.photoCtrl': () => {
            app.showSelectPhotoWarning();
        }
    },
    methods: {
        showSelectPhotoWarning() {
            let result = (this.formInput.photoCtrl == 'newFile') &
                (!document.querySelector("input[name='photo']").files.length);
            this.viewCtrl.showSelectPhotoWarning = result;
            document.querySelector("input[name='photo']").required = result;
        },
        handleCatIdChanged(catId) {
            this.formInput.parent_id = catId;
        },
        enablePhotoCtrl() {
            if (document.querySelector("input[name='photo']").files.length) {
                this.formInput.photoCtrl = 'newFile';
            }
            this.showSelectPhotoWarning();
        },
        initData() {
            let catInfo = JSON.parse(document.querySelector('#catInfo').value);

            for (let key in this.formInput) {
                this.formInput[key] = (catInfo[key] !== null) ? catInfo[key] : '';
            }

            this.formInput.activated = (catInfo.activated) ? 1 : 0;
            this.formInput.photoCtrl = 'originalFile';
        }
    },
    mounted() {
        this.initData();
    }
});