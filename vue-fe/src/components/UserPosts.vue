<script setup>

import axios from "axios";
import {reactive, ref, defineProps} from "vue";
import NewPostForm from "@/components/NewPostForm.vue";
import EditPostModal from "@/components/EditPostModal.vue";
import Post from "@/components/Post.vue";
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import useAuthStore from "../stores/auth"
import PostHeader from "@/components/PostHeader.vue";

const authStore = useAuthStore();

defineProps({
  // user: {
  //   type: Object,
  //   default() {
  //     return {
  //       name: ''
  //     }
  //   }
  // },
  profilePicture: {
    type: String,
    default: 'http://localhost:5173/src/assets/img/noimage.png'
  }
})

getPosts();

const posts = ref();
const editModalData = reactive({
  postId: null,
  text: null
})

async function getPosts( page = 1 ) {
  await axios.get(`api/get-user-posts?page=${page}`)
      .then(function (response) {
        posts.value = response.data;
      })
}

function setEditModalData(id, text) {
  editModalData.postId = id;
  editModalData.text = text

  console.log(text);
}

</script>

<template>
  <NewPostForm @update-posts="getPosts"/>
  <section v-if="posts && posts.data.length">
    <div class="col-md-6 container pb-3" v-for="post in posts.data" :key="'id' + post.id">
      <div class="card">
        <PostHeader :user="authStore.user" :profilePicture="profilePicture"/>
        <Post
            :post="post"
            @edit-post="setEditModalData"
            @refresh="getPosts"
        ></Post>
        <EditPostModal v-bind="editModalData" @update-posts="getPosts"/>
      </div>
    </div>
    <div class="col-md-6 container pb-3 d-flex justify-content-center">
      <Bootstrap5Pagination
          :data="posts"
          @pagination-change-page="getPosts"
      />
    </div>
  </section>
  <div v-else class="container col-md-6">
    <h1> Создайте свой первый пост </h1>
  </div>
</template>