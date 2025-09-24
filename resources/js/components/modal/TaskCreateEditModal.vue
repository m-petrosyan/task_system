<script setup lang="ts">
import ModalComponent from "@/components/modal/ModalComponent.vue";
import {useRoute} from "vue-router";
import {computed, onMounted, onUpdated, reactive, ref, watch} from "vue";
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

const setPageData = () => {
  pageName.value = route.name?.split('tasks-').pop();
  if (props.task_id) {
    taskStore.fetchGetTask(props.task_id);
  }
}

const statuses = ['pending', 'in_progress', 'completed'];

const props = defineProps<{
  task_id: number | null
  show: boolean
  onClose: () => void
}>()


onMounted(() => {
  setPageData();
});

onUpdated(() => {
  setPageData()
})

const taskData = reactive({
  title: '',
  description: '',
  status: 'pending',
  assigned_user_id: null,
  due_date: null,
});

watch(task, (newTask) => {
  if (props.task_id) {
    Object.assign(taskData, {
      title: newTask?.title || '',
      description: newTask?.description || '',
      status: newTask?.status || 'pending',
      assigned_user_id: newTask?.assigned_user_id || null,
      due_date: newTask?.due_date || null,
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
  if (!props.task_id) {
    taskStore.fetchCreateTask(taskData).then(() => props.onClose())
  } else {
    taskStore.fetchUpdateTask(props.task_id, taskData).then(() => props.onClose());
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
          <label for="description" class="block text-sm font-medium ">Description</label>
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
              v-if="users"
              id="assign"
              v-model="taskData.assigned_user_id"
              class="bg-gray-light block w-full p-2 rounded-md outline-none mt-2"
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