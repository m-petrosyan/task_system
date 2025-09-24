<script setup lang="ts">
import NotificationsList from "@/components/nav/NotificationsList.vue";
import SearchComponent from "@/components/search/SearchComponent.vue";
import UserInfoComponent from "@/components/nav/UserInfoComponent.vue";
import {useAuthStore} from "@/stores/authStore";
import {computed, ref, watch} from "vue";
import {useRoute, useRouter} from 'vue-router'
import NotificationsModal from "@/components/modal/NotificationsModal.vue";
import TaskCreateEditModal from "@/components/modal/TaskCreateEditModal.vue";
import TaskShowModal from "@/components/modal/TaskShowModal.vue";
import UserListModal from "@/components/modal/UserListModal.vue";
import Button from "@/components/elements/Button.vue";

const authStore = useAuthStore()

const route = useRoute()
const router = useRouter()
const showModal = ref(false)
const modalTaskId = ref<number | null>(null)

const modalComponent = computed(() => {
  if (route.name === 'notifications') return NotificationsModal;
  else if (route.name === 'tasks-create' || route.name === 'tasks-edit') return TaskCreateEditModal;
  else if (route.name === 'tasks-show') return TaskShowModal;
  else if (route.name === 'users') return UserListModal;
  return null;
});

watch(
    () => route.name,
    (name) => {
      if (name === 'tasks-create') {
        modalTaskId.value = null;
        showModal.value = true;
      } else if (name === 'tasks-show' || name === 'tasks-edit') {
        modalTaskId.value = Number(route.params.id);
        showModal.value = true;
      } else if (name === 'users') {
        showModal.value = true;
      } else showModal.value = name === 'notifications';
    },
    {immediate: true}
);

function closeModal() {
  showModal.value = false
  router.push({name: 'dashboard'})
}
</script>

<template>
  <div class="bg-dark text-white p-4">
    <section>
      <main class="mx-auto w-8/12 ">
        <div class="flex items-center justify-between w-full">
          <UserInfoComponent/>
          <SearchComponent/>
          <NotificationsList/>
        </div>
        <div v-if="authStore.user?.role === 'manager'"
             class="flex justify-between mt-10 ">
          <Button label="Users list" route="users"/>
          <Button label="Create" route="tasks-create"/>
        </div>
        <router-view/>
        <component
            v-if="modalComponent && showModal"
            :is="modalComponent"
            :onClose="closeModal"
            :task_id="modalTaskId"
            :show="showModal"
        />
      </main>
    </section>
  </div>
</template>