<template>
  <loader :loading="state.loading"></loader>
  <parent-transition appear :visibility="true">
    <page-header title="Home"> </page-header>
    <base-card>
      <div v-if="!data_t.isvalid">
        <div
          class="
            flex
            p-4
            mb-4
            text-sm text-red-700
            bg-red-100
            rounded-lg
            dark:bg-red-200 dark:text-red-800
          "
          role="alert"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="flex-shrink-0 inline w-5 h-5 mr-3"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
            />
          </svg>

          <span class="sr-only">Info</span>
          <div>
            <span class="font-medium">Perhatian! </span>
            <span
              >Akun Anda Belum Diaktifkan, Silahkan Cek Email atau Klik </span
            ><a
              href="#"
              v-on:click="kirimEmail()"
              class="
                font-semibold
                underline
                hover:text-blue-800
                dark:hover:text-blue-900
              "
              >untuk mengirimkan link ulang</a
            >.
          </div>
        </div>
      </div>
    </base-card>
  </parent-transition>
</template>

<script setup>
import { onBeforeMount, onMounted, reactive, watch } from "vue";
import Loader from "../../layouts/Custom/Loader.vue";
import useUser from "../../../composables/User";
const { getUser, user, sendEmail } = useUser();

const state = reactive({
  loading: true,
});
const data_t = reactive({
  user: [],
  isvalid: null,
});

onMounted(getUser);
watch(user, (data) => {
  data_t.user = data.data;
  if (data_t.user.is_valid === "0") {
    data_t.isvalid = false;
  } else {
    data_t.isvalid = true;
  }
  state.loading = false;
});
const kirimEmail = async () => {
  await sendEmail();
};
</script>

<style lang="scss" scoped>
</style>