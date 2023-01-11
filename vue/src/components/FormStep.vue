<template>
  <div v-if="shouldShow">
    <slot></slot>
  </div>
</template>
  
  <script setup>
import { computed, inject } from "vue";
const currentIndex = inject("STEP_COUNTER").value++;
const formStepIndex = inject("CURRENT_STEP_INDEX");
const shouldShow = computed(() => {
  return currentIndex === formStepIndex.value;
});
</script>
  
  <style lang="scss" scoped>
</style>