<script setup lang="ts">
import {useAuthStore} from '@/stores/authStore'
import UserStatusIcon from "@/components/icons/UserStatusIcon.vue";
import {computed} from "vue";
import LogoutIcon from "@/components/icons/LogoutIcon.vue";
import {useRouter} from "vue-router";

const router = useRouter()
const authStore = useAuthStore()
const user = computed(() => authStore.user)

const toggleAvailability = async () => {
  if (user.value) {
    await authStore.fetchUpdateAvailability();
  }
}

const logout = async () => {
  await authStore.logout().then(() => {
    router.push({name: 'login'});
  });
}
</script>

<template>
  <div class="text-nowrap">
    <div v-if="user" class="flex items-center gap-x-2">
      <p>{{ user?.name }}</p>
      <button v-if="user.role === 'user'" @click="toggleAvailability" class="cursor-pointer">
        <UserStatusIcon :status="user.is_available"/>
      </button>
    </div>
    <p class="text-sm text-gray-400">{{ user?.role }}</p>
    <button class="cursor-pointer mt-2" @click="logout">
      <LogoutIcon/>
    </button>
  </div>
</template>