import {defineStore} from 'pinia';
import {ref} from 'vue';
import {useApi} from '@/stores/api.ts';

export const useTaskStore = defineStore('task', () => {
    const {GET, POST, PUT, DELETE} = useApi();
    const tasks = ref<object[]>([]);
    const task = ref<object>({});

    async function fetchGetTasks(
        {text = '', user_id = '', status = ''}: {
            text?: string;
            user_id?: number | string;
            status?: string
        } = {}
    ): Promise<void> {
        const res = await GET('/tasks', {text, user_id, status});
        tasks.value = res.data
    }

    async function fetchGetTask(id: number | string): Promise<object> {
        const res = await GET(`/tasks/${id}`);
        task.value = res.data
    }

    async function fetchCreateTask(data: object): Promise<object> {
        await POST(`/tasks`, data);
        await fetchGetTasks();
    }

    async function fetchUpdateTask(id: number | string, data: object): Promise<object> {
        await PUT(`/tasks/${id}`, data);
        await fetchGetTasks();
    }

    async function fetchUpdateTaskStatus(id: number | string, data: object): Promise<object> {
        await PUT(`/tasks/${id}/status`, data);
        await fetchGetTasks();
    }

    async function fetchDeleteTask(id: number): Promise<void> {
        const res = await DELETE(`/tasks/${id}`);
        await fetchGetTasks();
    }

    return {
        tasks,
        task,
        fetchGetTasks,
        fetchGetTask,
        fetchDeleteTask,
        fetchCreateTask,
        fetchUpdateTask,
        fetchUpdateTaskStatus
    };
});
