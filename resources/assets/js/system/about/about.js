require('../../bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#container',
    methods: {
        updateRanking(){
            sendCommandToServer('/admin/abouts/ranking', {
                _method: 'PATCH',
                id: getElementIds('.id'),
                ranking: getElementIds('.ranking')
            });
        },
        deleteAbout(id){
            if (!confirm('刪除後資料無法復原\n確定刪除?')) {
                return;
            }

            sendCommandToServer('/admin/abouts/' + id, {
                _method: 'DELETE',
            });
        },
        doAction(){
            let action = document.querySelector('#action').value;

            if (action === 'noAction') {
                console.clear();
                console.log('noaction');
                return;
            }

            if (action === 'delete') {
                if (!confirm('刪除後資料無法復原\n確定刪除?')) {
                    return;
                }
            }

            sendCommandToServer('/admin/abouts/action', {
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