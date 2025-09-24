<script setup lang="ts">
defineProps({
  route: {
    type: String,
    required: false,
  },
  label: {
    type: String,
    required: true,
  },
})
</script>

<template>
  <router-link :to="{ name: route }"
               class="border-1 px-2 py-1 border-gray rounded-md cursor-pointer">
    <span class="mb-2">{{ label }} </span>
  </router-link>
</template>