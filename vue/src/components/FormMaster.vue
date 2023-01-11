<template>
  <form @submit="onSubmit">
    <slot></slot>
    <div class="mb-4">
      <div class="px-4 py-3 text-center sm:px-6">
        <base-button
          size="lg"
          v-if="hasPrevious"
          @click="goToPrev"
          class="mr-6"
        >
          <span>Sebelumnya</span></base-button
        >
        <base-button size="lg" type="submit">
          <span> {{ isLastStep ? "Simpan" : "Selanjutnya" }}</span>
        </base-button>
      </div>
    </div>
  </form>
</template>
  
  <script setup>
import { ref, computed, provide } from "vue";
import { useForm } from "vee-validate";
const FormData = ref({});
const currentStepIndex = ref(0);
const emit = defineEmits(["next", "submit"]);
const stepCounter = ref(0);
provide("STEP_COUNTER", stepCounter);
provide("CURRENT_STEP_INDEX", currentStepIndex);

const isLastStep = computed(() => {
  return currentStepIndex.value === stepCounter.value - 1;
});
const hasPrevious = computed(() => {
  return currentStepIndex.value > 0;
});
const { resetForm, handleSubmit } = useForm();
const onSubmit = handleSubmit((value) => {
  FormData.value = {
    ...FormData.value,
    ...value,
  };
  resetForm({
    values: {
      ...FormData.value,
    },
  });
  if (!isLastStep.value) {
    currentStepIndex.value++;
    emit("next", FormData.value);
    return;
  }
  emit("submit", FormData.value);
});
function goToPrev() {
  if (currentStepIndex.value === 0) {
    return;
  }
  currentStepIndex.value--;
  resetForm({
    values: {
      ...FormData.value,
    },
  });
}
</script>
  
  <style lang="scss" scoped>
</style>