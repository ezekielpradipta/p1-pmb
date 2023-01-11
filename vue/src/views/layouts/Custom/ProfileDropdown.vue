<template>
  <Menu as="div" class="relative inline-block text-left">
    <div v-if="display == 'dark'">
      <MenuButton
        class="btn btn-sm rounded w-full px-4 py-2 text-sm font-medium"
        @click="setDisplay('light')"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="white"
          class="w-6 h-6"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
          />
        </svg>
      </MenuButton>
    </div>
    <div v-if="display == 'light'">
      <MenuButton
        class="
          btn btn-sm
          hover:bg-gray-100
          rounded
          w-full
          px-4
          py-2
          text-sm
          font-medium
        "
        @click="setDisplay('dark')"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-6 h-6"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"
          />
        </svg>
      </MenuButton>
    </div>
  </Menu>
  <Menu>
    <MenuButton class="inline-flex items-center justify-center">
      <img class="h-8 w-8 rounded-full" src="/images/male.png" alt="" />
    </MenuButton>
    <MenuItems
      class="
        overflow-hidden
        top-12
        right-0
        mx-2
        absolute
        w-48
        mt-1
        rounded-md
        z-20
        bg-white
        dark:border-gray-700 dark:bg-dark-body-new
        divide-y divide-gray-200
        dark:divide-gray-600
      "
    >
      <MenuItem>
        <li>
          <a
            @click="logoutButton"
            href="#"
            class="
              block
              px-4
              py-2
              text-sm text-gray-700
              hover:bg-gray-100
              dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white
            "
            >Log Out</a
          >
        </li>
      </MenuItem>
    </MenuItems>
  </Menu>
</template>
  
  <script>
export default {
  name: "ProfileDropdown",
};
</script>
  
  <script setup>
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { useRouter } from "vue-router";
import { computed } from "vue";
import { useStore } from "vuex";

import useAuth from "../../../composables/Auth";
const { logout } = useAuth();
const logoutButton = async () => {
  logout();
};
const store = useStore();
const display = computed(() => store.getters.getDisplay);
const setDisplay = (display) => {
  store.dispatch("setDisplay", display);
};

const changeColor = async () => {
  console.log("AAAAAAA");
};
const router = useRouter();
</script>