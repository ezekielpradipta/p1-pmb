<template>
  <parent-transition appear :visibility="true">
    <page-header title="Home"> </page-header>
    <div class="grid xl:grid-cols-4 xl:gap-6">
      <div class="col-span-1">
        <base-card>
          <div
            class="w-full text-blue-400 rounded-lg flex items-center xl:mb-0"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-16 h-16 mr-4 hidden lg:block"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="1"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
              />
            </svg>

            <div class="m-auto">
              <p class="font-semibold text-3xl text-blue-500">0</p>
              <p class="text-gray-600 dark:text-gray-400">Jumlah User</p>
            </div>
          </div>
        </base-card>
      </div>
    </div>
  </parent-transition>
</template>

<script setup>
</script>

<style lang="scss" scoped>
</style>