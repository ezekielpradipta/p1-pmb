<template>
  <button
    type="button"
    class="
      relative
      inline-flex
      items-center
      justify-start
      overflow-hidden
      rounded-md
      font-medium
    "
    :class="{
      'w-full flex justify-center': block === true,
      'inline-flex items-center': block === false,
      'px-2.5 py-1.5 text-xs': size === 'xs',
      'px-3 py-2 text-sm leading-4': size === 'sm',
      'px-4 py-2 text-sm': size === 'md',
      'px-4 py-2 text-base': size === 'lg',
      'px-6 py-3 text-base': size === 'xl',
      'bg-white hover:bg-gray-200 dark:bg-dark-header dark:hover:bg-neutral-700 text-gray-600 dark:text-gray-400 focus:ring-white':
        design === 'white',
      'text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900':
        design === 'primary',
      'bg-secondary hover:bg-dark-secondary dark:bg-dark-body dark:hover:bg-neutral-700 text-primary dark:text-gray-400 focus:ring-secondary dark:focus:ring-dark-body':
        design === 'secondary',
      'bg-success hover:bg-dark-success text-secondary focus:ring-success':
        design === 'success',
      'bg-[#3b5998] hover:bg-[#1f4494] text-white focus:ring-[#3b5998]':
        design === 'facebook',
      'bg-info hover:bg-dark-info text-secondary focus:ring-info':
        design === 'info',
      'text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900':
        design === 'warning',
      'bg-danger hover:bg-dark-danger text-secondary focus:ring-danger':
        design === 'danger' || design === 'error',
      'text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800':
        design === 'green' || design === 'green',
      'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900':
        design === 'red',
      'text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-dark-body-new  dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700':
        design === 'gray',
    }"
  >
    <slot></slot>
  </button>
</template>
  
  <script>
export default {
  name: "BaseButton",
};
</script>
  
  <script setup>
const props = defineProps({
  size: {
    type: String,
    default: "md",
  },
  block: Boolean,
  design: {
    type: String,
    default: "primary",
  },
});
</script>
  