<script setup>
import {defineProps, defineEmits, ref} from "vue";
import axios from "axios";

const props = defineProps({
  post: {
    type: Object,
    default() {
      return {
        text: '',
        created_at: '',
        is_liked: null
      }
    }
  },
  profilePicture: {
    type: String,
    default: 'http://localhost:5173/src/assets/img/noimage.png'
  }
});

const emit = defineEmits(['editPost', 'refresh']);

let isLiked = ref(false)

async function toggleLike(id) {
  axios.post(`/api/posts/${id}/toggle-like`)
      .then(function (response) {
        isLiked.value = response.data.isLiked;
      })
      .catch(function (response) {
        alert(response.message)
      })
}

async function deletePost(id) {
  await axios.delete(`/api/delete-post/${id}`).then(function () {
    emit('refresh');
  });
}

</script>

<template>
      <div class="card-body">
        <div class="btn-toolbar justify-content-between">
          <div class="text-muted h7 mb-2">{{ post.created_at }}</div>
          <button
              type="button"
              @click="$emit('editPost', post.id, post.text)"
              class="btn btn-link text-decoration-none child-button"
              data-bs-toggle="modal" data-bs-target="#exampleModal">
            <p>
              Edit
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen"
                   viewBox="0 0 16 16">
                <path
                    d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"></path>
              </svg>
            </p>
          </button>
        </div>
        <p class="card-text">
          {{
            post.text
          }}
        </p>
      </div>
      <div class="card-footer">
        <a href="#" @click.prevent="toggleLike(post.id)" class="card-link text-decoration-none">
          <div v-if="isLiked || post.is_liked">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill"
                 viewBox="0 0 16 16">
              <path fill-rule="evenodd"
                    d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"></path>
            </svg>
            Like
          </div>
          <div v-else>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart"
                 viewBox="0 0 16 16">
              <path
                  d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"></path>
            </svg>
            Like
          </div>
        </a>
        <a @click="deletePost(post.id)" href="#" class="card-link child-button"><i class="fa fa-mail-forward"></i>Delete</a>
      </div>

</template>

<style>
.rounded-circle{
  border-radius:100%;
  width:100%;
  height: 100%;
  object-fit: cover;
  object-position: top center;
}

.container-fit{
  height: 50px;
  width: 50px;
  display: block;
  overflow: hidden;
}
</style>