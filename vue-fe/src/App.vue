<script setup>
import { RouterLink, RouterView } from 'vue-router'
import AppHeader from "@/components/AppHeader.vue";

</script>

<template>

<AppHeader/>

<RouterView/>

<RouterLink /> <!--  https://router.vuejs.org/guide/ - используется для навигации-->

</template>


