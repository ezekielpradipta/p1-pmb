<template>
  <div>
    <BaseLabel v-if="label">{{ label }}</BaseLabel>
    <div class="mt-1">
      <input
        v-bind="$attrs"
        :placeholder="placeholder || label"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="
          focus:ring-0 focus:border-blue-500
          dark:focus:border-gray-200
          bg-white
          dark:bg-dark-new
          block
          w-full
          sm:text-sm
          border-0 border-b-2 border-gray-300
          dark:border-gray-700 dark:text-gray-400
        "
      />
      <slot></slot>
    </div>
  </div>
</template>
  
  <script>
export default {
  name: "BaseInput",
  inheritAttrs: false,
};
</script>
  
  <script setup>
const props = defineProps({
  label: {
    type: String,
    default: "",
  },
  placeholder: {
    type: String,
    default: "",
  },
  error: {
    type: String,
    default: "",
  },
  modelValue: {
    type: String,
    default: "",
  },
});
</script>
  
  