<script setup lang="ts">
import ModalComponent from "@/components/modal/ModalComponent.vue"
import {computed, onMounted} from "vue";
import {useAuthStore} from "@/stores/authStore";

const store = useAuthStore()
const users = computed(() => store.availableUsers)


defineProps<{
  show: boolean
  onClose: () => void
}>()

onMounted(async () => {
  await store.fetchAvailability();
})
</script>

<template>
  <teleport to="body">
    <ModalComponent :show="show" :onClose="onClose">
      <h2 class="text-lg font-bold mb-4">Users</h2>
      <ul v-if="users?.length">
        <li
            v-for="(user, i) in users"
            :key="i"
            class="border-b py-2 text-sm"
            :class="user.is_available ? 'text-blue' : 'text-red'"
        >
          {{ user.name }} - {{ user.email }}
        </li>
      </ul>
    </ModalComponent>
  </teleport>
</template>
