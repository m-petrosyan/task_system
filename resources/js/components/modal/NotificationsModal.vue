<script setup lang="ts">
import {useNotificationStore} from '@/stores/notificationStore'
import ModalComponent from "@/components/modal/ModalComponent.vue"
import {computed, onUnmounted} from "vue";

const store = useNotificationStore()
const notifications = computed(() => store.notifications?.data);

defineProps<{
  show: boolean
  onClose: () => void
}>()

onUnmounted(async () => {
  await store.fetchReadNotifications();
})
</script>

<template>
  <teleport to="body">
    <ModalComponent :show="show" :onClose="onClose">
      <h2 class="text-lg font-bold mb-4">Notifications</h2>
      <ul v-if="notifications?.length">
        <li
            v-for="(notifications, i) in notifications"
            :key="i"
            class="border-b py-2 text-sm"
        >
          <router-link
              :to="{name: 'tasks-show', params: {id: notifications.task_id}}">
            {{ notifications.message }}
          </router-link>
        </li>
      </ul>
      <p v-else class="text-gray-500 text-sm">No notifications yet.</p>
    </ModalComponent>
  </teleport>
</template>
