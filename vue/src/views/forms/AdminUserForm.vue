<template>
  <parent-transition appear :visibility="true">
    <pre>{{ model }}</pre>
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
                  <div class="grid xl:grid-cols-2 xl:gap-6">
                    <div class="col-span-1 mb-6">
                      <base-input
                        v-model="model.nama_camaba"
                        type="text"
                        name="nama_camaba"
                        label="Nama"
                        placeholder="Your Name..."
                      >
                        <span class="text-sm text-red-500">*Sesuai Ijazah</span>
                      </base-input>
                    </div>
                    <div class="col-span-1 mb-6">
                      <base-label Title="Jenis Kelamin"></base-label>
                      <Multiselect
                        v-model="model.jenis_kelamin"
                        placeholder="Jenis Kelamin "
                        :searchable="true"
                        :options="jenis_kelamin"
                        :classes="{
                          containerActive: 'ring ring-blue-500 ring-opacity-30',
                          tag: 'bg-blue-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1',
                          groupLabelSelected: 'bg-blue-600 text-white',
                          groupLabelSelectedPointed:
                            'bg-blue-600 text-white opacity-90',
                          groupLabelSelectedDisabled:
                            'text-blue-100 bg-purple-600 bg-opacity-50 cursor-not-allowed',
                          groupOptions: 'p-0 m-0',
                          optionSelected: 'text-white bg-blue-500',
                          optionDisabled: 'text-gray-300 cursor-not-allowed',
                          optionSelectedPointed:
                            'text-white bg-blue-500 opacity-90',
                          optionSelectedDisabled:
                            'text-blue-100 bg-blue-500 bg-opacity-50 cursor-not-allowed',
                        }"
                        valueProp="jenis_kelamin"
                      />
                    </div>
                  </div>
                  <div class="grid xl:grid-cols-2 xl:gap-6">
                    <div class="col-span-1 mb-6">
                      <base-input
                        v-model="model.tempat_lahir"
                        type="text"
                        name="tempat_lahir"
                        label="Tempat Lahir"
                        placeholder="Tempat Lahir...."
                      >
                        <span class="text-sm text-red-500">*Sesuai Ijazah</span>
                      </base-input>
                    </div>
                    <div class="col-span-1 mb-6">
                      <base-label
                        Title="Tanggal Lahir"
                        class="mb-1"
                      ></base-label>
                      <flat-pickr
                        v-model="model.tanggal_lahir"
                        placeholder="YYY-MM-DD"
                        name="tanggal_lahir"
                        class="
                          focus:ring-0 focus:border-blue-500
                          dark:focus:border-gray-200
                          bg-inherit
                          block
                          w-full
                          sm:text-sm
                          border-0 border-b-2 border-gray-300
                          dark:border-gray-700 dark:text-gray-200
                        "
                        :config="config"
                      ></flat-pickr>
                      <span class="text-sm text-red-500">*Sesuai Ijazah</span>
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
import Multiselect from "@vueform/multiselect";
import { reactive, watch, ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import useUtil from "../../composables/Util";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import useAdminUser from "../../composables/AdminUser";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
const { cekEmail, wilayah, getWilayah } = useUtil();
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
  nama_camaba: "",
  tempat_lahir: "",
  tanggal_lahir: "",
});
let kategori = ref(["Data Diri", "Berkas"]);
const jenis_kelamin = { L: "Laki-Laki", P: "Perempuan" };
const config = ref({
  wrap: true, // set wrap to true only when using 'input-group'
  dateFormat: "Y-m-d",
  allowInput: true,
});
onMounted(getWilayah);
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
<style src="@vueform/multiselect/themes/default.css"></style>
<style lang="scss" scoped>
</style>