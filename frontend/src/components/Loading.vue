<template>
  <div class="h-screen loading-container">
    <div class="spinner"></div>
    <p class="text-sm text-black" v-if="message">{{ message }}</p>
  </div>
</template>

<script lang="ts">
import { defineComponent, type PropType } from 'vue';

export default defineComponent({
  name: 'Loading',
  props: {
    message: {
      type: String as PropType<string>,
      default: 'Chargement...'
    }
  }
});
</script>

<style scoped>
.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 150px;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid rgba(0, 0, 0, 0.2);
  border-top-color: #0ce6ee; 
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 10px;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
