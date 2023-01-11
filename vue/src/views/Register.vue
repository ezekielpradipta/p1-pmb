<template>
  <loader :loading="loader.loading"></loader>
  <auth-header label="Daftar Baru"></auth-header>
  <ParentTransition appear :visibility="true">
    <div class="space-y-6">
      <BaseInput v-model="user.email" type="email" name="email" label="Email">
        <span class="text-danger" v-if="user.validate.email">{{
          user.validate.email
        }}</span></BaseInput
      >
      <BaseInput v-model="user.name" type="text" name="name" label="Username" />

      <BaseInput
        type="password"
        name="password"
        label="Password"
        v-model="user.password"
        autocomplete="current-password"
      />

      <BaseInput
        type="password"
        name="password_confirmation"
        label="Konfirmasi Password"
        autocomplete="current-password"
        v-model="user.password_confirmation"
      />
      <BaseButton type="submit" @click="onSubmitRegister" block
        ><span>Daftar</span></BaseButton
      >

      <div class="flex items-center justify-center">
        <BaseLink to="Login">Back to Login</BaseLink>
      </div>
    </div>
  </ParentTransition>
</template>
  
  <script setup>
import useAuth from "../composables/Auth";
import useUtil from "../composables/Util";
import Loader from "../views/layouts/Custom/Loader.vue";
import { onMounted, reactive, watch } from "vue";
const { register } = useAuth();
const { cekEmail } = useUtil();

const user = reactive({
  email: "",
  password: "",
  name: "",
  password_confirmation: "",
  validate: [],
});
const loader = reactive({
  loading: false,
});
watch(
  () => user.email,
  (newValue, oldValue) => {
    validateEmail(newValue);
  }
);
const validateEmail = async (value) => {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) {
    await cekEmail({ ...user }).then((response) => {
      if (response.data.message === "unique") {
        user.validate["email"] = "";
      } else {
        user.validate["email"] = "Email Sudah Terdaftar";
      }
    });
  } else {
    user.validate["email"] = "Bukan Format Email";
  }
};
const onSubmitRegister = async (ev) => {
  ev.preventDefault();
  loader.loading = true;
  await register({ ...user });
  loader.loading = false;
};
</script>