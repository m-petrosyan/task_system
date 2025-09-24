<script setup lang="ts">
import {useAuthStore} from '@/stores/authStore'
import {onBeforeMount} from "vue";

const authStore = useAuthStore()

onBeforeMount(async () => {
  if (localStorage.getItem('access_token')) {
    await authStore.auth()
  }
})
</script>

<template>
  <router-view class="min-h-screen"/>
</template>
