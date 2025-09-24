<script setup lang="ts">
import ModalComponent from "@/components/modal/ModalComponent.vue";
import {useRoute} from "vue-router";
import {computed, ref, watch} from "vue";
import {useAuthStore} from "@/stores/authStore";
import {useTaskStore} from "@/stores/taskStore";
import ErrorMessagesComponent from "@/components/elements/ErrorMessagesComponent.vue";

const userStore = useAuthStore()
const taskStore = useTaskStore();

const route = useRoute()
const user = computed(() => userStore.user);
const users = computed(() => userStore.availableUsers);
const task = computed(() => taskStore.task);
const pageName = ref('')
const statuses = ['pending', 'in_progress', 'completed'];
const status = ref(task.value?.status);

const setPageData = () => {
  pageName.value = route.name?.split('tasks-').pop();
  if (props.task_id) {
    taskStore.fetchGetTask(props.task_id);
  }
}

const props = defineProps<{
  task_id: number | null
  show: boolean
  onClose: () => void
}>()

watch(
    () => route.name,
    () => {
      setPageData();
    },
    {immediate: true}
);

const deleteTask = async () => {
  await taskStore.fetchDeleteTask(props.task_id).then(() => {
    props.onClose();
  });
}

const updateStatus = async () => {
  await taskStore.fetchUpdateTaskStatus(task.value.id, {status: status.value})
      .then(() => {
        props.onClose();
      });
}
</script>

<template>
  <teleport to="body">
    <ModalComponent :show="show" :onClose="onClose">
      <h2 class="text-lg font-bold mb-4 capitalize">{{ pageName }}</h2>
      <ErrorMessagesComponent/>
      <form v-if="task" @submit.prevent="updateStatus" class="space-y-4">
        <div>
          <label class="block text-sm font-medium">Title</label>
          <h3 class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2">{{ task.title }}</h3>
        </div>
        <div>
          <label class="block text-sm font-medium">Description</label>
          <p class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2">{{ task.description }}</p>
        </div>

        <div v-if="task.is_assigned">
          <label for="status" class="block text-sm font-medium">Status</label>
          <select
              id="status"
              v-model="status"
              class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2"
          >
            <option v-for="status in statuses" :key="status" :value="status">{{ status }}</option>
          </select>
        </div>
        <div v-else>
          <label class="block text-sm font-medium">Status</label>
          <p class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2">{{ task.status }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium">Assigned</label>
          <p class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2">{{ task.assigned_user?.name }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium">Deadline</label>
          <p class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2">
            {{ new Date(task.due_date).toLocaleDateString() }}</p>
        </div>
        <div class="flex justify-end space-x-2 mt-10">
          <template v-if="task.is_owner">
            <button @click="deleteTask" class="px-4 py-2 rounded bg-gray-light cursor-pointer">
              Delete Task
            </button>
            <router-link
                :to="{name: 'tasks-edit', params: {id: task.id}}"
                class="px-4 py-2 rounded bg-gray-light cursor-pointer">
              Edit Task
            </router-link>
          </template>
          <button v-if="task.is_assigned"
                  type="submit"
                  class="px-4 py-2 rounded bg-gray-light cursor-pointer"
          >
            Update Status
          </button>
        </div>
      </form>
    </ModalComponent>
  </teleport>
</template>