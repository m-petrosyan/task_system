<script setup lang="ts">
import {useTaskStore} from '@/stores/taskStore';
import {computed, onMounted} from "vue";
import TextIcon from "@/components/icons/TextIcon.vue";
import TimeIcon from "@/components/icons/TimeIcon.vue";
import {formatStatusText} from "@/Helpers/textHelper";
import {useAuthStore} from "@/stores/authStore";

const taskStore = useTaskStore();
const userStore = useAuthStore();

const tasks = computed(() => taskStore.tasks)
const user = computed(() => userStore.user)

onMounted(() => {
  taskStore.fetchGetTasks();
});
</script>

<template>
  <div>
    <div v-if="tasks" class="flex justify-between gap-x-10 mt-10 rounded-xl">
      <div v-for="(statusGroup, index) in tasks" :key="statusGroup.status" class="w-4/12 bg-gray-dark p-2">
        <h3 class="text-md mb-4 text-gray-300">
          {{ formatStatusText(statusGroup.status) }}
        </h3>
        <router-link :to="{name: 'tasks-show', params: {id: task.id}}" v-for="task in statusGroup.data" :key="task.id"
                     class=" p-4 mb-4 rounded block"
                     :class="task.is_owner ? 'bg-blue-dark': 'bg-gray'">
          <div>
            <div>
              <div>
                <p class="font-semibold">{{ task.title }}</p>
              </div>
              <div class="flex justify-between mt-4">
                <div class="flex items-center gap-x-2">
                  <TextIcon v-if="task.description"/>
                  <div v-if="task.due_date" class="flex items-center gap-x-1">
                    <TimeIcon/>
                    <p class="text-sm">{{ new Date(task.due_date).toLocaleDateString() }}</p>
                  </div>
                </div>
                <div>
                  <p class="text-sm"
                     :class="{'text-blue bg-blue-dark px-2 rounded-md': task.is_assigned,'text-red': !task.assigned_user?.is_available}">
                    {{ task.assigned_user.name }}</p>
                </div>
              </div>
            </div>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>
