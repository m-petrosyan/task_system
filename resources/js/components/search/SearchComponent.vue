<script setup lang="ts">
import {computed, reactive, watch} from "vue";
import SearchIcon from "@/components/icons/SearchIcon.vue";
import {useTaskStore} from "@/stores/taskStore";
import {useAuthStore} from "@/stores/authStore";
import {formatStatusText} from "@/Helpers/textHelper";

const taskStore = useTaskStore();
const userStore = useAuthStore();

const user = computed(() => userStore.user);
const users = computed(() => userStore.availableUsers);

const search = reactive({
  text: '',
  user_id: '',
  status: ''
})

const statuses = ['pending', 'in_progress', 'completed']

interface search {
  text: string
}

const searchTask = () => {
  taskStore.fetchGetTasks({
    text: search.text,
    user_id: search.user_id,
    status: search.status
  })
}

watch(
    () => user,
    () => {
      userStore.fetchAvailability(1)
    },
    {immediate: true}
)
</script>

<template>
  <div>
    <div class="group flex justify-end items-center gap-x-2 border-gray px-2 p-2 rounded-xl">
      <input
          v-model="search.text"
          type="search"
          placeholder="Search"
          autofocus
          class="bg-gray rounded-md outline-none px-2"
      />
      <button @click="searchTask" class="cursor-pointer">
        <SearchIcon/>
      </button>
    </div>

    <select v-if="users"
            v-model="search.user_id"
            @change="searchTask"
            class="bg-gray p-2 rounded-md outline-none mt-2">
      <option value="">All Users</option>
      <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
    </select>

    <select v-if="users"
            v-model="search.status"
            @change="searchTask"
            class="bg-gray p-2 rounded-md outline-none mt-2 ml-2">
      <option value="">All Statuses</option>
      <option v-for="status in statuses" :key="status" :value="status">{{ formatStatusText(status) }}</option>
    </select>
  </div>
</template>