import {defineStore} from 'pinia';
import {ref} from 'vue';
import {useApi} from '@/stores/api.ts';

export const useNotificationStore = defineStore('notification', () => {
    const {GET, PUT} = useApi();
    const notifications = ref<object[]>([]);

    async function fetchNotifications() {
        notifications.value = await GET('/notifications')
    }

    async function fetchReadNotifications() {
        await PUT('/notifications')
        notifications.value = {data: []};
    }

    return {notifications, fetchNotifications, fetchReadNotifications};
});
