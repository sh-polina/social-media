<script setup>
import {defineProps} from "vue";

defineProps({
  user: {
    type: Object,
    default() {
      return {
        name: ''
      }
    }
  },
  profilePicture: {
    type: String,
    default: 'http://localhost:5173/src/assets/img/noimage.png'
  }
})
</script>

<template>
  <div class="card-header">
    <div class="d-flex justify-content-between align-items-center">
      <div class="d-flex justify-content-between align-items-center">
        <div class="mr-2 container-fit">
          <img class="rounded-circle" :src="profilePicture" alt="">
        </div>
        <div class="ml-2">
          <div class="h5 m-0">@{{ user.name }}</div>
          <!--              <div class="h7 text-muted">Miracles Lee Cross</div>-->
        </div>
      </div>
    </div>
  </div>
</template>