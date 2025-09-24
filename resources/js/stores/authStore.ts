import {defineStore} from 'pinia';
import {ref} from 'vue';
import {useApi} from '@/stores/api';

interface User {
    id: number
    name: string
    email: string
}

interface LoginResponse {
    token?: string
    user?: User
    message?: string
}

interface AuthResponse {
    user?: User
    message?: string
}

export const useAuthStore = defineStore('auth', () => {
    const {GET, POST, PUT} = useApi();
    const user = ref<User | null>(null);
    const availableUsers = ref<User[]>([]);

    async function login(email: string, password: string): Promise<void> {
        const res = await POST<LoginResponse>('/login', {email, password});
        localStorage.setItem('access_token', res.data.access_token);
        await auth();
    }

    async function auth(): Promise<void> {
        const response = await GET<AuthResponse>('/auth');
        user.value = response.data
    }

    async function fetchAvailability(available: number | null = null): Promise<void> {
        const params = available !== null ? {is_available: available} : {};
        const response = await GET<AuthResponse>('/availability', params);
        availableUsers.value = response.data;
    }

    async function fetchUpdateAvailability(is_available: number): Promise<void> {
        await PUT<AuthResponse>('/availability', {is_available});
        await auth()
    }

    async function logout(): Promise<void> {
        localStorage.removeItem('access_token');
        user.value = null;
    }

    return {auth, login, fetchAvailability, fetchUpdateAvailability, user, availableUsers, logout};
});