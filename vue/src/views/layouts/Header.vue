<script setup>
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { createToaster } from "@meforma/vue-toaster";

import { computed } from "vue";
const toaster = createToaster({
  position: "top-right",
});
let store = useStore();
let router = useRouter();
const sideBarToggle = () => {
  let sidenav = store.state.largeSidebar.sidebarToggleProperties.isSideNavOpen;
  let secondnav =
    store.state.largeSidebar.sidebarToggleProperties.isSecondarySideNavOpen;
  if (sidenav == false) {
    store.commit("largeSidebar/toggleSidebarProperties");
  } else {
    store.commit("largeSidebar/toggleSidebarProperties");
  }
  if (secondnav == true) {
    store.dispatch(
      "largeSidebar/changeSecondarySidebarPropertiesViaMenuItem",
      false
    );
  }
};
</script>

<template>
  <div
    class="header-wrapper flex bg-white justify-between px-4 dark:bg-dark-new"
  >
    <div class="flex items-center">
      <div class="logo flex justify-center">
        <img class="h-16 w-auto" src="/images/icon.png" alt="" />
      </div>
      <div class="mx-0 sm:mx-3">
        <button
          @click="sideBarToggle"
          class="
            menu-toggle
            cursor-pointer
            text-gray-500
            align-middle
            focus:outline-none
          "
          type="button"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            />
          </svg>
        </button>
      </div>
    </div>
    <div class="flex items-center">
      <ProfileDropdown />
    </div>
  </div>
</template>

<style lang="scss" scoped>
.header-wrapper {
  position: fixed;
  top: 0;
  width: 100%;
  height: 80px;
  z-index: 100;
  box-shadow: 0 1px 15px #0000000a, 0 1px 6px #0000000a;
}
.mega-menu {
  width: 1200px;
}
ul.links {
  column-count: 2;
  li {
    margin-bottom: 8px;
  }
}
</style>
