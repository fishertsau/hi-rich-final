<!--
input/props:
 - given_cat_id: initial selected category id
 - selection_depth:
      'any': . return main cat id, sub cat id, sus-sub cat id whichever is selected
            . no error msg is shown

      'leafNode':
        - return the leaf node cat id
        - error msg is shown until leaf node is selected

      '1':
        - return the selected main cat id
        - error msg is shown if no main cat selected

      '2':
        - return the selected sub cat id
        - error msg is shown if no sub cat selected


  - clear_setting
     - clear up all selected category
     - the calling element should have a variable "clearSetting"
     - send the "clear_setting=true" from the calling party, it can work

  - applied_model
     - 指定類別的所屬model
     
events
  - catid-changed
       . payload: (int) selected cat id
-->

<template>
    <div>
        <span>
            <select v-model="selectedMain"
                    id="mainCat">
                <option value="">請選擇</option>
                <option v-for="item in mainCat" :value="item">{{ item.title}}</option>
            </select>
        </span>
        <span v-show="subCat.length">&nbsp;&gt;&nbsp;
            <select v-model="selectedSub"
                    id="subCat">
                <option disabled value="">請選擇</option>
                <option v-for="item in subCat" :value="item">{{ item.title}}</option>
            </select>
        </span>
        <span v-show="subSubCat.length">&nbsp;&gt;&nbsp;
            <select v-model="selectedSubSub"
                    id="subSubCat">
                <option disabled value="">請選擇</option>
                <option v-for="item in subSubCat" :value="item">{{ item.title}}</option>
            </select>
        </span>
        <br>
        <span v-show="showCatError">
            <p style="color:red">{{errorMsg}}</p>
        </span>
    </div>
</template>

<script>
    export default {
        props: {
          applied_model: {
            type: [String],
            required: true 
          },
          given_cat_id: {
                type: [String, Number],
                required: false
            },
            selection_depth: {
                type: [String, Number],
                required: false
            },
            clear_setting: {
                type: Boolean,
                required: false
            }
        },
        data() {
            return {
                clearSetting: false,
                selectionDepth: 'leafNode',
                givenCatId: null,
                givenCat: null,
                givenMainCat: null,
                givenSubCat: null,
                givenSubSubCat: null,
                selectedMain: '',
                selectedSub: '',
                selectedSubSub: '',
                mainCat: [],
                subCat: [],
                subSubCat: []
            }
        },
        computed: {
            errorMsg: function () {
                return returnForActiveSelector(
                    this,
                    () => {
                        return "請選擇次次分類"
                    },
                    () => {
                        return "請選擇次分類"
                    },
                    () => {
                        return "請選擇大分類"
                    });
            },
            selectedCatId: function () {

                if (this.selectionDepth === 0 || this.selectionDepth === '0') {
                    return null;
                }

                if (this.selectionDepth === 1 || this.selectionDepth === '1') {
                    return this.selectedMain.id;
                }

                if (this.selectionDepth === 2 || this.selectionDepth === '2') {
                    return this.selectedSub.id;
                }

                if (this.selectionDepth === 'any') {
                    if (this.selectedSubSub) {
                        return this.selectedSubSub.id;
                    }

                    if (this.selectedSub) {
                        return this.selectedSub.id;
                    }

                    return this.selectedMain.id;
                }

                if (this.selectionDepth === 'leafNode') {
                    const handle_3rd = () => {
                        return this.selectedSubSub.id;
                    };

                    const handle_2nd = () => {
                        return this.selectedSub.id;
                    };

                    const handle_first = () => {
                        return this.selectedMain.id;
                    };

                    return returnForActiveSelector(this, handle_3rd, handle_2nd, handle_first);
                }
            },
            showCatError: function () {
                return !this.selectedCatId &&
                    !(this.selectionDepth === 'any') &&
                    !(this.selectionDepth === '0');
            }
        },
        methods: {
            putGivenCatInSelection() {
                axios.get('/api/categories/' + this.givenCatId)
                    .then(response => {
                        this.givenCat = response.data;
                    })
                    .then(() => {
                        if ((this.givenCat.level === 1) || (this.givenCat.level === '1')) {
                            this.selectedMain = this.givenMainCat = this.givenCat;
                        }
                        if ((this.givenCat.level === 2) || (this.givenCat.level === '2')) {
                            let tempMainCat = axios.get(`/api/categories/${this.givenCatId}/parent`)
                                .then(response => {
                                    return response.data;
                                });

                            tempMainCat.then(data => {
                                this.givenSubCat = this.givenCat;
                                this.selectedMain = this.givenMainCat = data;
                            });
                        }

                        if ((this.givenCat.level === 3) || (this.givenCat.level === '3')) {
                            let tempSubCat =
                                axios.get(`/api/categories/${this.givenCatId}/parent`)
                                    .then(response => {
                                        return response.data;
                                    });

                            tempSubCat.then(subCat => {
                                let tempMainCat =
                                    axios.get(`/api/categories/${subCat.id}/parent`)
                                        .then(response => {
                                            return response.data;
                                        });

                                tempMainCat.then(main => {
                                    this.givenSubSubCat = this.givenCat;
                                    this.givenSubCat = subCat;
                                    this.selectedMain = this.givenMainCat = main;
                                })
                            });
                        }
                    });
            },
            clearSelection() {
                this.subCat = [];
                this.subSubCat = [];
                this.selectedSubSub = '';
                this.selectedSub = '';
                this.selectedMain = '';
                this.clearSetting = false;
            },
            initialize() {
                this.givenCatId = this.given_cat_id;
                this.selectionDepth = this.selection_depth;
                axios.get(`/api/categories/main/${this.applied_model}`)
                    .then(response => {
                        this.mainCat = response.data;
                    })
                    .then(() => {
                        if (this.givenCatId) {
                            this.putGivenCatInSelection();
                        }
                    });
            },
        },
        watch: {
            selectedCatId() {
                this.$emit('catid-changed', this.selectedCatId);
            },
            selectedMain() {
                if (this.selectedMain === '') {
                    this.clearSelection();
                }

                if (this.selectionDepth > 1
                    || this.selectionDepth === 'any'
                    || this.selectionDepth === 'leafNode') {
                    axios.get(`/api/categories/${this.selectedMain.id}/children`)
                        .then(response => {
                            this.subCat = response.data;

                            //clear selectedSubCat
                            if (this.givenSubCat) {
                                this.selectedSub = this.givenSubCat;
                                this.givenSubCat = '';
                            } else {
                                this.selectedSub = '';
                            }

                            //clear subSubCat and selectedSubSub
                            this.subSubCat = [];
                            this.selectedSubSub = '';
                        });
                }
            },
            selectedSub() {
                if (this.selectionDepth > 2
                    || this.selectionDepth === 'any'
                    || this.selectionDepth === 'leafNode') {
                    axios.get(`/api/categories/${this.selectedSub.id}/children`)
                        .then(response => {
                            this.subSubCat = response.data;
                            if (this.givenSubSubCat) {
                                this.selectedSubSub = this.givenSubSubCat;
                                this.givenSubSubCat = '';
                            } else {
                                this.selectedSubSub = '';
                            }
                        });
                }
            },
            clear_setting() {
                this.clearSetting = this.clear_setting;
                if (this.clearSetting) {
                    this.clearSelection();
                }
                this.$emit('update:clear_setting', this.clearSetting)
            },
        },
        beforeMount() {
            this.initialize();
        },
    }

    function returnForActiveSelector(app, handle_3rd, handle_2nd, handle_first) {
        if (app.subSubCat.length) {
            return handle_3rd();
        }

        if (app.subCat.length) {
            return handle_2nd();
        }

        return handle_first();
    }
</script>


