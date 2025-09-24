<script setup lang="ts">
import {computed, onMounted} from 'vue';
import {useNotificationStore} from '@/stores/notificationStore';
import {useAuthStore} from '@/stores/authStore';

const store = useNotificationStore();
const authStore = useAuthStore();
const notifications = computed(() => store.notifications?.data);

onMounted(() => {
  store.fetchNotifications();
  setInterval(() => {
    if (authStore.user) {
      store.fetchNotifications();
    }
  }, 5000);
});
</script>

<template>
  <router-link :to="{ name: 'notifications' }"
               class="bg-gray p-2 font-bold  shadow  max-w-md cursor-pointer rounded-xl">
    <span class="mb-2">Notifications </span>
    <span>{{ notifications?.length }}</span>
  </router-link>
</template>
