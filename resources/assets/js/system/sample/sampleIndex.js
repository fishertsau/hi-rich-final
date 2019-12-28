require('../../bootstrap');

window.Vue = require('vue');
Vue.component('cat-selector', require('../../components/categorySelector.vue'));

const app = new Vue({
    el: '#container',
    methods: {
        updateRanking(){
            sendCommandToServer('/admin/samples/ranking', {
                _method: 'PATCH',
                id: getElementIds('.id'),
                ranking: getElementIds('.ranking')
            });
        },
        deleteSample(id){
            if (!confirm('刪除後資料無法復原\n確定刪除?')) {
                return;
            }

            sendCommandToServer('/admin/samples/' + id, {
                _method: 'DELETE',
            });
        },
        doAction(){
            let action = document.querySelector('#action').value;

            if (action === 'noAction') {
                return;
            }

            if (action === 'delete') {
                if (!confirm('刪除後資料無法復原\n確定刪除?')) {
                    return;
                }
            }

            sendCommandToServer('/admin/samples/action', {
                _method: 'PATCH',
                chosen_id: getElementIds(".chosenId:checked"),
                action: document.querySelector('#action').value
            });
        },
        toggleSelectAll(){
            Array.from(document.querySelectorAll('.chosenId'))
                .forEach(element => {
                    element.checked = document.querySelector('#selectAll').checked;
                });
        },
        handleCatIdChanged(catId){
            this.catId = catId;
        },
        resetCatSelector(){
            this.clear_setting = true;
        }
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