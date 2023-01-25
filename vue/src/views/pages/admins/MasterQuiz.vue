<template>
  <parent-transition appear :visibility="true">
    <page-header title="Jenis Quiz">
      <base-button
        size="lg"
        @click="router.push({ name: 'AdminQuizMasterQuizForm' })"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 mr-2 -ml-1"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 4v16m8-8H4"
          />
        </svg>
        <span>Tambah Master Quiz</span></base-button
      >
    </page-header>
  </parent-transition>
</template>

<script setup>
import { inject, onMounted, reactive, watch } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();
</script>

<style lang="scss" scoped>
</style>