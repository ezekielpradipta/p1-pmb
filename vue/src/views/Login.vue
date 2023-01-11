<template>
  <auth-header label="Masuk Ke Aplikasi"></auth-header>

  <ParentTransition appear :visibility="true">
    <div class="space-y-6">
      <BaseInput
        type="text"
        v-model="user.email"
        name="email"
        label="Email"
        autofocus
      />

      <BaseInput
        type="password"
        v-model="user.password"
        name="password"
        label="Password"
      />

      <div class="flex items-center justify-between">
        <BaseLink to="ResetPassword">Lupa Password?</BaseLink>
      </div>

      <BaseButton @click="onSubmitLogin" block>
        <svg
          class="h-5 w-5 text-white group-hover:text-indigo-400"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
          aria-hidden="true"
        >
          <path
            fill-rule="evenodd"
            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
            clip-rule="evenodd"
          />
        </svg>
        <span>Masuk</span>
      </BaseButton>
      <div class="flex items-center justify-center">
        <BaseLink to="Register"
          >Belum Punya Akun? Daftar Terlebih Dahulu!</BaseLink
        >
      </div>
    </div>
  </ParentTransition>
</template>
  
  <script setup>
import useAuth from "../composables/Auth";
import { watch } from "vue";
const { login } = useAuth();
const user = {
  email: "",
  password: "",
};
const onSubmitLogin = async (ev) => {
  ev.preventDefault();
  await login({ ...user });
};
</script>
  