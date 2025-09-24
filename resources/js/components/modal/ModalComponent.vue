<script setup lang="ts">

const props = defineProps<{
  show: boolean
  onClose: () => void
}>()
</script>

<template>
  <div
      v-if="show"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black-transparent bg-opacity-50">
    <div class="bg-gray-dark text-white rounded-xl shadow-lg max-w-md w-full p-6 relative overflow-y-auto max-h-[80vh]">
      <button
          @click="onClose"
          class="absolute top-2 right-2  hover:text-gray-800 cursor-pointer">
        ✕
      </button>
      <slot/>
    </div>
  </div>
</template>