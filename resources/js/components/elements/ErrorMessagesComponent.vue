<script setup lang="ts">
import {useErrorStore} from "@/stores/errorStore";
import {computed} from "vue";

const errorStore = useErrorStore();
const errors = computed(() => errorStore.errors);
</script>

<template>
  <div>
    <div v-if="errors.length" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
         role="alert">
      <strong class="font-bold">Whoops!</strong>
      <span class="block sm:inline">There were some problems with your input.</span>
      <ul class="mt-2 list-disc list-inside">
        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
      </ul>
    </div>
  </div>
</template>