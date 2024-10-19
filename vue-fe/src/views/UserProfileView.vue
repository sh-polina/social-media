<script setup>
import {ref, reactive, onMounted, watch, onBeforeMount} from "vue";
import axios from 'axios';
import UserPosts from "@/components/UserPosts.vue";
import useAuthStore from "../stores/auth"

getUserImage();

// const user = reactive({
//   email: '',
//   name: ''
// });

const authStore = useAuthStore();

onBeforeMount(async () => {
  //const response = await axios.get('/api/user');
  await authStore.getUser();

  //user.name = response.data.name;
  //user.email = response.data.email;
});

const profilePictureUrl = ref('http://localhost:5173/src/assets/img/noimage.png');

async function getUserImage() {
  await axios.get('api/get-profile-picture')
      .then(function (response) {
        if (!response.data.avatar_path) {
          return;
        }

        profilePictureUrl.value = response.data.avatar_path;
      })
}

const fileInput = ref(null);
const openFileInput = () => {
  fileInput.value.click();
}

const handleFileChange = async (event) => {
  const file = event.target.files[0];
  const formData = new FormData();

  formData.append('profile-picture', file);
  await axios.post(`api/upload-profile-picture`, formData, {headers: {'Content-Type': 'multipart/form-data'}})
      .then(function (response) {
        console.log('SUCCESS!!');
        profilePictureUrl.value = response.data;
      })
      .catch(function () {
        console.log('FAILURE!!');
      });
}


</script>

<template>
  <div class="container py-5 h-100">
    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
      <div class="col p-4 d-flex flex-column position-static">
        <h1 class="mb-0">{{ authStore.user.name }}</h1>
        <p class="card-text mb-auto">{{ authStore.user.email }}</p>
      </div>
      <div class="col-auto d-none d-lg-block">
        <div class="image-wrapper">
          <input @change="handleFileChange" style="display:none" type="file" ref="fileInput">
          <img @click="openFileInput" class="profile-user-img" :src="profilePictureUrl">
        </div>
      </div>
    </div>
  </div>
  <UserPosts :profilePicture="profilePictureUrl"/>
</template>

<style>

/*.moduleItemIntrotext {*/
/*  overflow: hidden;*/
/*  position: relative;*/
/*}*/
.image-wrapper img {
  position: relative;
  margin: -50% auto;
  width: 100%;
  height: auto;
  vertical-align: middle;
}

.image-wrapper {
  cursor: pointer;
  display: block;
  height: 200px;
  width: 250px;
  line-height: 200px;
  overflow: hidden;
}

/*.profile-user-img {*/
/*  cursor: pointer;*/
/*  width: 100%;*/
/*  height: 249px;*/
/*  overflow: hidden;*/
/*}*/

/*.image-wrapper{*/
/*  width: 202px;*/
/*  height: 249px;*/
/*}*/
</style>
