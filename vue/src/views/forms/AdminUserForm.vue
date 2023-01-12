<template>
  <parent-transition appear :visibility="true">
    <page-header title="Tambah Data User" subtitle="Menambah User Baru.">
    </page-header>
    <base-card>
      <form-master @submit="onSubmit">
        <form-step>
          <div class="grid xl:grid-cols-2 xl:gap-6 mb-6">
            <div class="col-span-1">
              <div v-if="model.is_update">
                <base-input
                  v-model="model.email"
                  type="email"
                  name="email"
                  label="Email"
                  placeholder="example@domain.com"
                >
                </base-input>
              </div>
              <div v-else>
                <base-input
                  v-model="model.email"
                  type="email"
                  name="email"
                  label="Email"
                  placeholder="example@domain.com"
                >
                  <span
                    class="text-sm text-red-500"
                    v-if="model.validate.email"
                    >{{ model.validate.email }}</span
                  >
                </base-input>
              </div>
            </div>
          </div>
          <div class="grid xl:grid-cols-2 xl:gap-6 mb-6">
            <div class="col-span-1">
              <base-input
                v-model="model.password"
                type="password"
                id="password"
                label="Password"
                placeholder="Your Password...."
              ></base-input>
            </div>
            <div class="col-span-1">
              <base-input
                v-model="model.password_confirmation"
                type="password"
                id="password_confirmation"
                label="Konfirmasi Password"
              ></base-input>
            </div>
          </div>
        </form-step> </form-master
    ></base-card>
  </parent-transition>
</template>

<script setup>
import { reactive, watch } from "vue";
import { useRoute } from "vue-router";
import useUtil from "../../composables/Util";
import useAdminUser from "../../composables/AdminUser";
const { cekEmail } = useUtil();
const { createUser, user, getUser } = useAdminUser();
const route = useRoute();
const model = reactive({
  email: "",
  name: "",
  validate: [],
  password: "",
  password_confirmation: "",
  id: null,
  is_update: false,
});
const validateEmail = async (value) => {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) {
    await cekEmail({ ...model }).then((response) => {
      if (response.data.message === "unique") {
        model.validate["email"] = "";
      } else {
        model.validate["email"] = "Email Sudah Terdaftar";
      }
    });
  } else {
    model.validate["email"] = "Bukan Format Email";
  }
};

watch(
  () => model.email,
  (newValue, oldValue) => {
    validateEmail(newValue);
  }
);
const onSubmit = async () => {
  await createUser({ ...model });
};
if (route.params.id) {
  getUser(route.params.id);
  watch(user, (data) => {
    if (data) {
      Object.assign(model, data);
      model.id = route.params.id;
      model.is_update = true;
    }
  });
}
</script>

<style lang="scss" scoped>
</style>