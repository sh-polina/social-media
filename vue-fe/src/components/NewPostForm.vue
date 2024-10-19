<script setup>
import {ref} from "vue";
import axios from "axios";

const emit = defineEmits(['updatePosts'])


const post = ref({
  text: ''
});

async function handlePost() {
  await axios.post('/api/create-post', {text: post.value.text})
      .then(function () {
        emit('updatePosts');
        post.value.text = '';
      });
}

</script>

<template>
  <div class="col-md-6 container pb-3">
    <div class="card">
      <div class="card-body">
        <form v-on:submit.prevent="handlePost">
          <div class="form-group">
            <label class="sr-only" for="message"></label>
            <textarea v-model="post.text" class="form-control" id="message" rows="3" placeholder="What are you thinking?"></textarea>
          </div>
          <div class="btn-toolbar justify-content-between pt-3">
            <div class="btn-group">
              <button type="submit" class="btn btn-primary">share</button>
            </div>
            <div class="btn-group">
              <button id="btnGroupDrop1" type="button" class="btn btn-link" aria-haspopup="true" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-paperclip" viewBox="0 0 16 16">
                  <path
                      d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
                </svg>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>