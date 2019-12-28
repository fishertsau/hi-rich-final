<template>
    <div style="border: 1px solid grey">
        <button style="position:absolute;top:10px;left:10px;background: pink"
                @click.prevent="deletePhoto()">刪除
        </button>
        <img :src="'/storage/'+photo.photoPath" width="200" height="200"
             border="1"
             align="absmiddle"/>
        <div v-if="!editing" style="text-align: center">
            <p >{{photo.title}}</p>
            <button @click.prevent="editing = true">修改圖片標題</button>
        </div>

        <div v-if="editing">
            <input type="text" v-model="newPhotoTitle">
            <br>
            <button @click.prevent="onCancelEditPhotoTitle">取消</button>
            <button @click.prevent="onChangePhotoTitle">完成</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "photo",
        props: ['source_photo'],
        data() {
            return {
                photo: '',
                editing: false,
                newPhotoTitle: ''
            }
        },
        beforeMount() {
            this.photo = this.source_photo;
            this.newPhotoTitle = this.photo.title;
        },
        methods: {
            onCancelEditPhotoTitle() {
                this.editing = false;
                this.newPhotoTitle = this.photo.title;
            },
            onChangePhotoTitle() {
                this.editing = false;

                //method spoof
                let formInput = {};
                formInput._method = "patch";
                formInput.title = this.newPhotoTitle;

                let data = getFormData(formInput);

                //send request to the server
                axios.post(this.generateUri(), data)
                    .then(() => {
                        this.photo.title = this.newPhotoTitle;
                    });
            },
            deletePhoto() {

                if (!confirm('確定刪除')) {
                    return;
                }

                //method spoof
                let formInput = {};
                formInput._method = "delete";
                let data = getFormData(formInput);

                //send request to the server
                axios.post(this.generateUri(), data)
                    .then(() => {
                        console.log('deletePhoto');
                        this.$emit('photo-deleted', this.photo);
                    });
            },
            generateUri(){
                //generate uri
                let photoFilename = this.photo.photoPath.replace('images/', '');
                return '/admin/photos/' + photoFilename;
            },
        }
    }

    function getFormData(object) {
        const formData = new FormData();
        Object.keys(object).forEach(key => formData.append(key, object[key]));
        return formData;
    }
</script>