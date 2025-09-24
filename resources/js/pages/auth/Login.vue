<script setup lang="ts">
import {reactive} from "vue";
import {useAuthStore} from "@/stores/authStore";
import {useRouter} from "vue-router";

const store = useAuthStore();
const router = useRouter();

const form = reactive({
  email: '',
  password: '',
})

const submitForm = () => {
  store.login(form.email, form.password)
      .then(() => router.push("/dashboard"))
}
</script>

<template>
  <div class="flex justify-center items-center h-screen ">
    <form @submit.prevent="submitForm" class="space-y-4 bg-gray-dark px-10 py-8">
      <h3>Sign In</h3>
      <div>
        <label for="email" class="block text-sm font-medium">Email</label>
        <input
            v-model="form.email"
            type="text"
            id="email"
            class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2"
        />
      </div>
      <div>
        <label for="password" class="block text-sm font-medium ">Password</label>
        <input
            v-model="form.password"
            type="password"
            id="password"
            class="mt-1 block w-full bg-gray-light rounded-md shadow-sm p-2"/>
      </div>

      <button
          class="rounded bg-gray-light cursor-pointer w-full px-2 py-2"
      >
        Sign in
      </button>
    </form>
  </div>
</template>