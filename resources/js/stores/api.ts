import {useErrorStore} from "@/stores/errorStore";

interface ApiOptions {
    headers?: Record<string, string>;
    params?: Record<string, string | number>;
    body?: any;

    [key: string]: any;
}

interface ApiResponse<T = any> {
    data?: T;
    message?: string;
    status?: number;
}

export const useApi = () => {
    const errorStore = useErrorStore();
    const api = async <T = any>(
        method: 'GET' | 'POST' | 'PUT' | 'DELETE',
        endpoint: string,
        options: ApiOptions = {}
    ): Promise<ApiResponse<T>> => {
        try {
            const {params, body, headers, ...restOptions} = options;
            const url = new URL(`/api${endpoint.startsWith('/') ? endpoint : `/${endpoint}`}`, window.location.origin);

            if (method === 'GET' && params) {
                Object.entries(params).forEach(([key, value]) => {
                    url.searchParams.append(key, String(value));
                });
            }

            const response = await fetch(url.toString(), {
                method,
                headers: {
                    Accept: 'application/json',
                    'Content-Type': body ? 'application/json' : undefined,
                    Authorization: localStorage.getItem('access_token') ? `Bearer ${localStorage.getItem('access_token')}` : undefined,
                    ...headers,
                },
                body: body ? JSON.stringify(body) : undefined,
                ...restOptions,
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw {message: `HTTP Error: ${response.status} ${response.statusText}`, data: errorData};
            }
            if (endpoint !== '/notifications') {
                errorStore.setErrors({message: '', fields: {}});
            }

            const contentType = response.headers.get('content-type');
            if (contentType?.includes('application/json')) {
                return await response.json();
            }

            return {data: undefined, status: response.status};
        } catch (error: any) {
            // alert(error.data?.message || error.message || 'Произошла ошибка');
            errorStore.setErrors({
                message: error.data?.message || error.message || 'An unexpected error occurred',
                fields: error.data?.errors || {}
            });
            throw error;
        }
    };

    return {
        GET: <T = any>(endpoint: string, params?: Record<string, string | number>) =>
            api<T>('GET', endpoint, {params}),
        POST: <T = any>(endpoint: string, body?: any, options: ApiOptions = {}) =>
            api<T>('POST', endpoint, {...options, body}),
        PUT: <T = any>(endpoint: string, body?: any, options: ApiOptions = {}) =>
            api<T>('PUT', endpoint, {...options, body}),
        DELETE: <T = any>(endpoint: string, options: ApiOptions = {}) =>
            api<T>('DELETE', endpoint, options),
    };
};