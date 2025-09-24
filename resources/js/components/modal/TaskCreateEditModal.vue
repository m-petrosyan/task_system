<script setup lang="ts">
import ModalComponent from "@/components/modal/ModalComponent.vue";
import {useRoute} from "vue-router";
import {computed, onMounted, onUpdated, reactive, ref, watch} from "vue";
import {useAuthStore} from "@/stores/authStore";
import {useTaskStore} from "@/stores/taskStore";
import ErrorMessagesComponent from "@/components/elements/ErrorMessagesComponent.vue";

const userStore = useAuthStore();
const taskStore = useTaskStore();

const route = useRoute();
const user = computed(() => userStore.user);
const users = computed(() => userStore.availableUsers);
const task = computed(() => taskStore.task);
const pageName = ref('');

const setPageData = () => {
  pageName.value = route.name?.split('tasks-').pop();
  if (props.task_id) {
    taskStore.fetchGetTask(props.task_id);
  }
};

const statuses = ['pending', 'in_progress', 'completed'];

const props = defineProps<{
  task_id: number | null;
  show: boolean;
  onClose: () => void;
}>();

onMounted(() => {
  setPageData();
  userStore.fetchAvailability();
});

onUpdated(() => {
  setPageData();
});

const taskData = reactive({
  title: '',
  description: '',
  status: 'pending',
  assigned_user: {},
  assigned_user_id: null,
  due_date: '',
});

watch(task, (newTask) => {
  if (props.task_id && newTask) {
    const formattedDate = newTask.due_date ? new Date(newTask.due_date).toISOString().slice(0, 16) : '';
    Object.assign(taskData, {
      title: newTask.title || '',
      description: newTask.description || '',
      status: newTask.status || 'pending',
      assigned_user: newTask.assigned_user || null,
      assigned_user_id: newTask.assigned_user_id || null,
      due_date: formattedDate,
    });
  }
}, {immediate: true});

watch(
    () => route.name,
    () => {
      setPageData();
    },
    {immediate: true}
);

const submitForm = () => {
  const formattedData = {
    ...taskData,
    due_date: taskData.due_date ? new Date(taskData.due_date).toISOString() : null,
  };
  if (!props.task_id) {
    taskStore.fetchCreateTask(formattedData).then(() => props.onClose());
  } else {
    taskStore.fetchUpdateTask(props.task_id, formattedData).then(() => props.onClose());
  }
};
</script>

<template>
  <teleport to="body">
    <ModalComponent :show="show" :onClose="onClose">
      <h2 class="text-lg font-bold mb-4 capitalize">{{ pageName }}</h2>
      <ErrorMessagesComponent/>
      <form v-if="taskData" @submit.prevent="submitForm" class="space-y-4">
        <div>
          <label for="title" class="block text-sm font-medium">Title</label>
          <input
              v-model="taskData.title"
              type="text"
              id="title"
              class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2"
          />
        </div>
        <div>
          <label for="description" class="block text-sm font-medium">Description</label>
          <textarea
              v-model="taskData.description"
              id="description"
              rows="4"
              class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2"
          ></textarea>
        </div>
        <div>
          <label for="status" class="block text-sm font-medium">Status</label>
          <select
              id="status"
              v-model="taskData.status"
              class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2"
          >
            <option v-for="status in statuses" :key="status" :value="status">{{ status }}</option>
          </select>
        </div>
        <div>
          <label for="assign" class="block text-sm font-medium">Assign</label>
          <select
              v-if="users && users.length > 0"
              id="assign"
              v-model="taskData.assigned_user_id"
              class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2"
          >
            <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
          </select>
        </div>
        <div>
          <label for="due_date" class="block text-sm font-medium">Due Date</label>
          <input
              v-model="taskData.due_date"
              type="datetime-local"
              id="due_date"
              class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2"
          />
        </div>
        <div class="flex justify-end space-x-2 mt-10">
          <button
              type="button"
              @click="onClose"
              class="px-4 py-2 rounded bg-gray-light cursor-pointer"
          >
            Cancel
          </button>
          <button
              type="submit"
              class="px-4 py-2 rounded bg-gray-light cursor-pointer"
          >
            {{ pageName === 'create' ? 'Create' : 'Update' }} Task
          </button>
        </div>
      </form>
    </ModalComponent>
  </teleport>
</template>
