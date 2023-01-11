<template>
  <auth-header label="Atur Ulang Kata Sandi"></auth-header>

  <ParentTransition appear :visibility="true">
    <div class="space-y-6">
      <BaseInput
        type="text"
        name="email"
        label="Email"
        v-model="user.email"
        autofocus
      />

      <BaseButton
        type="submit"
        @click="onSubmitReset"
        block
        :disabled="modul.counting"
      >
        <vue-countdown
          v-if="modul.counting"
          :time="60000"
          @end="onCountdownEnd"
          v-slot="{ totalSeconds }"
          >Coba lagi dalam {{ totalSeconds }} detik</vue-countdown
        >
        <span v-else>Kirim Token Ke Email</span></BaseButton
      >
      <child-transition>
        <div class="space-y-6">
          <BaseInput
            type="text"
            name="token"
            label="Token"
            v-model="user.token"
          />
          <base-button type="submit" @click="validasiToken" block
            >Validasi Token</base-button
          >
        </div>
      </child-transition>
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
const { sendToken, validateToken } = useAuth();
const user = reactive({
  email: "",
  token: "",
});
const validasii = reactive({
  email: "",
  token: "",
});
const modul = reactive({
  button: false,
  counting: false,
});
const onSubmitReset = async (ev) => {
  ev.preventDefault();
  modul.counting = true;
  await sendToken({ ...user });
};
const validasiToken = async (ev) => {
  ev.preventDefault();
  await validateToken({ ...user });
};

function startCountdown() {
  modul.counting = true;
}
function onCountdownEnd() {
  modul.counting = false;
}
</script>