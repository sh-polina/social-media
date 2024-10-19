<script setup>
import {onBeforeMount, ref} from "vue";
import axios from "axios";
import PostHeader from "@/components/PostHeader.vue";
import Post from "@/components/Post.vue";
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

const posts = ref();
const isHomePage = ref(false);

onBeforeMount(async () => {
  await getPosts()
});

function getPosts( page = 1 ) {
  axios.get(`api/all-posts?page=${page}`)
      .then(function (response) {
        posts.value = response.data;
        console.log(posts.value);
      })
}

</script>

<template>
  <section v-if="posts && posts.data.length">
    <div class="col-md-6 container pb-3" v-for="post in posts.data" :key="'id' + post.id">
      <div class="card">
        <PostHeader :user="{name: post.user.name}" :profile-picture="post.user.profile.avatar_path"/>
        <Post :post="post" :isHomePage="isHomePage" @refresh="getPosts"/>
      </div>
    </div>
    <div class="col-md-6 container pb-3 d-flex justify-content-center">
      <Bootstrap5Pagination
          :data="posts"
          @pagination-change-page="getPosts"
      />
    </div>
  </section>
</template>

<style scoped>
:deep(.child-button) {
  display: none;
}
</style>
