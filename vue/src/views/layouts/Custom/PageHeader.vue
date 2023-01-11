<template>
  <div class="px-4 sm:px-6 lg:px-0 mb-4">
    <nav class="flex text-sm font-semibold mb-6">
      <ol class="flex items-center space-x-2">
        <li>
          <div class="flex">
            <div v-if="getRole() === 'user'">
              <router-link :to="{ name: 'User' }"
                ><p class="text-blue-500 hover:text-blue-700 dark:text-white">
                  Dashboard |
                </p></router-link
              >
            </div>
            <div v-else>
              <router-link :to="{ name: 'Admin' }"
                ><p class="text-blue-500 hover:text-blue-700 dark:text-white">
                  Dashboard |
                </p></router-link
              >
            </div>
          </div>
        </li>
        <li>
          <div class="flex items-center">
            <span class="text-gray-600 dark:text-gray-400">{{ title }}</span>
          </div>
        </li>
      </ol>
    </nav>
    <div class="mt-2 sm:flex sm:items-center sm:justify-between">
      <div class="flex-1 min-w-0 dark:text-white">
        <h2 class="text-xl font-bold leading-7 sm:text-2xl sm:truncate">
          {{ title }}
        </h2>
        <h6 v-if="subtitle">{{ subtitle }}</h6>
      </div>
      <div class="mt-4 shrink-0 flex sm:mt-0 sm:ml-4 space-x-4">
        <slot></slot>
      </div>
    </div>
  </div>
</template>
  
  <script>
export default {
  name: "PageHeader",
};
</script>
  
  <script setup>
import jwt_decode from "jwt-decode";
const getToken = localStorage.getItem("token");
function getRole() {
  const token = jwt_decode(getToken);
  const userRole = token.user.roles[0].name;
  return userRole;
}
const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  subtitle: {
    type: String,
    default: "",
  },
});
</script>