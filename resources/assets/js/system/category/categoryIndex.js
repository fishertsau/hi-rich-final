require('../../bootstrap');

window.Vue = require('vue');
Vue.component('cat-selector', require('../../components/categorySelector.vue'));

const app = new Vue({
    el: '#container',
    methods: {
        updateRanking(){
            sendCommandToServer('/admin/product/categories/ranking', {
                _method: 'PATCH',
                id: getElementIds('.id'),
                ranking: getElementIds('.ranking')
            });
        },
        deleteCategory(id){
            if (!confirm('刪除後資料無法復原\n確定刪除?')) {
                return;
            }

            sendCommandToServer('/admin/product/categories/' + id, {
                _method: 'DELETE',
            });
        },
    }
});


function getValueList(elements) {
    let numbers = [];
    Array.from(elements).forEach(element => {
        numbers.push(element.value)
    });
    return numbers;
}


function getElementIds(selector) {
    let rankings = document.querySelectorAll(selector);
    return getValueList(rankings);
}


function sendCommandToServer(url, data) {
    axios
        .post(url, data)
        .then(function (response) {
            location.reload(true);
        })
}