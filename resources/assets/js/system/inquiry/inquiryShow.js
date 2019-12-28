require('../../bootstrap');

window.Vue = require('vue');
Vue.component('cat-selector', require('../../components/categorySelector.vue'));

const app = new Vue({
    el: '#container',
    data: {
        inquiry: {
            processed: false,
            title: '',
            id: ''
        }
    },
    methods: {
        setProcessed(){
            axios.post('/admin/inquiries/' + this.inquiry.id + '/processed')
                .then(response => {
                    this.inquiry.processed = true;
                })
        }
    },
    mounted(){
        let inquiryInfo = document.querySelector('#inquiryInfo');
        if (inquiryInfo) {
            inquiryInfo = JSON.parse(inquiryInfo.value);
            this.inquiry.processed = inquiryInfo.processed;
            this.inquiry.title = inquiryInfo.title;
            this.inquiry.id = inquiryInfo.id;
        }
    }
});