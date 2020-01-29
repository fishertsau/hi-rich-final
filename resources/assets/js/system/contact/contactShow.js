require('../../bootstrap');

window.Vue = require('vue');

new Vue({
    el: '#container',
    data: {
        contact: {
            processed: false,
            title: '',
            id: ''
        }
    },
    methods: {
        setProcessed(){
            axios.post('/admin/contacts/' + this.contact.id + '/processed')
                .then(response => {
                    this.contact.processed = true;
                })
        }
    },
    mounted(){
        let contactInfo = document.querySelector('#contactInfo');
        if (contactInfo) {
            contactInfo = JSON.parse(contactInfo.value);
            this.contact.processed = contactInfo.processed;
            this.contact.title = contactInfo.title;
            this.contact.id = contactInfo.id;
        }
    }
});