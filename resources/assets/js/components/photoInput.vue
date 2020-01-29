<!--
input/props:
 - input_ctrl_name: 上傳控制欄位名稱
 - input_name: 上傳欄位名稱
 - photo_path: 原有圖片路徑 
-->

<template>
    <div>
        <div v-show="photo_path !== ''">
            <input type="radio"
                   :name="input_ctrl_name"
                   value="originalFile"
                   v-model="photoCtrl"
            /> 維持原圖：
            <img :src="`/storage/${photo_path}`"
                 style="max-width: 400px; height: auto; background-color: lightgrey"
                 align="absmiddle" />
            <br />
            <input type="radio"
                   :name="input_ctrl_name"
                   value="deleteFile"
                   v-model="photoCtrl" />
            刪除圖檔<br />
        </div>

        <input type="radio"
               :name="input_ctrl_name"
               value="newFile"
               v-model="photoCtrl" />
        上傳檔案：
        <input type="file"
               :name="input_name"
               @change="updatePhotoCtrl()" />
        <!--todo: keep size note -->
        <!--<span>（圖片尺寸：{{// config('app.logo_size_note')}}　解析度72dpi）</span>-->
        <p style="color:red"
           v-show="showWarning"
           v-cloak>請選擇檔案</p>
    </div>
</template>

<script>
  export default {
    props: {
      input_name: {
        type: String,
        required: true
      },
      input_ctrl_name: {
        type: String,
        required: true
      },
      photo_path: {
        type: String,
        required: false,
        default: null
      },
    },
    data() {
      return {
        photoCtrl: 'originalFile',
        showWarning: false,
        inputElement: null
      }
    },
    methods: {
      updatePhotoCtrl: function () {
        if (this.inputElement.files.length) {
          this.photoCtrl = 'newFile';
        }
        this.handleShowWarning();
      },
      handleShowWarning: function () {
        const hasFile = this.inputElement === null
          ? false
          : this.inputElement.files.length > 0;

        this.showWarning = this.photoCtrl === 'newFile' && !hasFile;
      }
    },
    watch: {
      photoCtrl: function () {
        this.handleShowWarning();
      }
    },
    mounted: function () {
      this.inputElement = document.querySelector(`input[name='${this.input_name}']`);
    }
  }
</script>
