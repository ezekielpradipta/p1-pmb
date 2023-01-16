<template>
  <parent-transition appear :visibility="true">
    <page-header title="Tambah Data User" subtitle="Menambah User Baru.">
    </page-header>
    <base-card>
      <form-master @submit="onSubmit">
        <form-step>
          <div class="grid xl:grid-cols-2 xl:gap-6 mb-8">
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
            <div class="col-span-1">
              <base-input
                v-model="model.password"
                type="password"
                id="password"
                label="Password"
                placeholder="Your Password...."
              ></base-input>
            </div>
          </div>
          <div class="w-16 h-16 mx-auto my-8">
            <img class="w-auto" src="/images/icon.png" alt="" />
          </div>
          <div class="p-5">
            <TabGroup>
              <TabList
                class="flex bg-white justify-center mb-6 dark:bg-dark-new"
              >
                <Tab
                  v-for="menu in kategori"
                  as="template"
                  :key="menu"
                  v-slot="{ selected }"
                >
                  <button
                    class="font-semibold"
                    :class="[
                      'px-3 py-1 text-sm leading-5 ',
                      'focus:outline-none',
                      selected
                        ? 'text-blue-500 border-b-2 border-blue-500'
                        : 'text-gray-600',
                    ]"
                  >
                    {{ menu }}
                  </button>
                </Tab>
              </TabList>
              <TabPanels>
                <TabPanel>
                  <div class="grid xl:grid-cols-2 xl:gap-6 mb-6">
                    <div class="col-span-1">
                      <base-input
                        v-model="model.email"
                        type="email"
                        name="email"
                        label="Nama"
                        placeholder="Your Name..."
                      >
                        <span class="text-sm text-red-500">*Sesuai Ijazah</span>
                      </base-input>
                    </div>
                  </div>
                </TabPanel>
              </TabPanels>
            </TabGroup>
          </div>
        </form-step>
      </form-master></base-card
    >
  </parent-transition>
</template>

<script setup>
import { reactive, watch, ref } from "vue";
import { useRoute } from "vue-router";
import useUtil from "../../composables/Util";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
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
let kategori = ref(["Data Diri", "Berkas"]);
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