<template>
  <div class="relative">
    <div
      class="
        absolute
        inset-y-0
        left-0
        flex
        items-center
        pl-3
        pointer-events-none
      "
    >
      <svg
        class="w-5 h-5 text-gray-700 dark:text-gray-400"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
          clip-rule="evenodd"
        ></path>
      </svg>
    </div>
    <input
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      type="text"
      id="table-search"
      class="
        focus:ring-0 focus:border-blue-500
        dark:focus:border-blue-400
        bg-white
        dark:bg-dark-new
        block
        sm:text-sm
        border-0 border-b-2 border-gray-300
        dark:border-gray-700 dark:text-gray-400
        pl-10
        p-2.5
        w-full
      "
      :placeholder="placeholder"
    />
  </div>
</template>
  
  <script setup>
const props = defineProps({
  modelValue: String,
  placeholder: String,
});
</script>
  
  <style lang="scss" scoped>
</style>