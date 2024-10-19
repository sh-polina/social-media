<script setup>
import {defineProps, defineEmits, ref, useTemplateRef, computed } from "vue";
import axios from "axios";

const props = defineProps({
  postId: Number,
  text: String
})

const editedText = ref(null);

const emit = defineEmits(['updatePosts']);

async function handleEdit() {
  await axios.put(`/api/post/${props.postId}`, {text: editedText.value.value})
      .then(function () {
        document.getElementById('close').click();
        emit('updatePosts');
      })
}

</script>

<template>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header justify-content-between">
          <h5 class="modal-title" id="exampleModalLabel">Edit your post</h5>
          <button type="button" class="close" data-bs-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

          <form @submit.prevent="handleEdit">
            <div class="modal-body">
            <div class="form-group">
              <label for="message-text" class="col-form-label">Post:</label>
              <textarea class="form-control" id="message-text" ref="editedText" :value="text"></textarea>
            </div>

        </div>
        <div class="modal-footer">
          <button id="close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</template>