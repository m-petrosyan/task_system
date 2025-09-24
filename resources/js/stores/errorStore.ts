import {defineStore} from 'pinia';
import {reactive} from 'vue';

type ErrorFields = Record<string, string[]>;

interface Errors {
    message: string;
    fields: ErrorFields;
}

interface NewErrors {
    message?: string;
    fields?: ErrorFields;
}

export const useErrorStore = defineStore('errorStore', () => {
    const errors = reactive<Errors>({
        message: '',
        fields: {}
    });

    function setErrors(newErrors: NewErrors) {
        errors.message = newErrors.message || '';
        errors.fields = {...newErrors.fields};
    }

    function clearErrors() {
        errors.message = '';
        errors.fields = {};
    }

    return {errors, setErrors, clearErrors};
});
