<template>
  <auth-header label="Masukan Password Baru"></auth-header>

  <ParentTransition appear :visibility="true">
    <div class="space-y-6">
      <BaseInput
        type="password"
        name="password"
        label="Password"
        v-model="user.password"
        autofocus
      />
      <base-button type="submit" @click="onSubmit" block>Simpan</base-button>
      <div class="flex items-center justify-center">
        <BaseLink to="Register"> Daftar Baru!</BaseLink>
      </div>
      <div class="flex items-center justify-center">
        <BaseLink to="Login"> Sudah Punya Akun ? Login!</BaseLink>
      </div>
    </div>
  </ParentTransition>
</template>
  
  <script setup>
import { onMounted, reactive, ref, watch } from "vue";
import useAuth from "../composables/Auth";
import { useRoute } from "vue-router";
const { resetPassword, newPassword } = useAuth();
const route = useRoute();
const user = reactive({
  password: "",
});
if (route.params.id) {
  resetPassword(route.params.id);
}
const onSubmit = async (ev) => {
  ev.preventDefault();

  await newPassword({ ...user }, route.params.id);
};
</script>