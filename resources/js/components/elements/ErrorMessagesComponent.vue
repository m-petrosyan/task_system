<script setup lang="ts">
import {useErrorStore} from "@/stores/errorStore";
import {computed} from "vue";

const errorStore = useErrorStore();
const errors = computed(() => errorStore.errors);
</script>

<template>
  <div>

    <div v-if="errors.message" class="bg-gray-light    px-4 py-3 rounded relative mb-4"
         role="alert">
      <strong class="font-bold">Whoops!</strong>
      <p class="text-wrap"> {{ errors.message }}</p>
    </div>
  </div>
</template>