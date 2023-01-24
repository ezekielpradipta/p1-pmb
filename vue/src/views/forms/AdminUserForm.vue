<template>
  <parent-transition appear :visibility="true">
    <page-header title="Tambah Data User" subtitle="Menambah User Baru.">
    </page-header>
    <base-card>
      <form-master @submit="onSubmit" enctype="multipart/form-data">
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
                        : 'text-gray-700 dark:text-gray-400',
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
                          bg-white
                          dark:bg-dark-new
                          block
                          w-full
                          sm:text-sm
                          border-0 border-b-2 border-gray-300
                          dark:border-gray-700 dark:text-gray-400
                        "
                        :config="config"
                      ></flat-pickr>
                      <span class="text-sm text-red-500">*Sesuai Ijazah</span>
                    </div>
                  </div>
                  <div class="grid xl:grid-cols-2 xl:gap-6">
                    <div class="col-span-1">
                      <base-label Title="Wilayah" class="mb-1"></base-label>
                      <Multiselect
                        v-model="model.wilayah"
                        valueProp="id_kec"
                        :options="wilayah"
                        :searchable="true"
                        :infinite="true"
                        :limit="10"
                        label="nama_kec"
                        track-by="nama_kec"
                        placeholder="Kecamatan"
                        class=""
                      >
                        <template v-slot:singlelabel="{ value }">
                          <div class="multiselect-single-label">
                            {{ value.nama_prov }} - {{ value.nama_kab }} -
                            {{ value.nama_kec }}
                          </div>
                        </template>

                        <template v-slot:option="{ option }">
                          {{ option.nama_prov }} - {{ option.nama_kab }} -
                          {{ option.nama_kec }}
                        </template>
                      </Multiselect>
                    </div>
                  </div>
                </TabPanel>
                <TabPanel>
                  <div class="grid xl:grid-cols-3 xl:gap-6">
                    <div class="col-span-1">
                      <base-label Title="Upload File" class="mb-1"></base-label>
                      <file-pond
                        name="test"
                        ref="pond"
                        label-idle="Drop files here..."
                        v-bind:allow-multiple="false"
                        accepted-file-types="image/jpeg, image/png"
                        v-on:change="cobaaaaa"
                        v-bind:files="model.file_upload_url"
                        v-on:removefile="removeFile"
                      />
                    </div>
                  </div>
                </TabPanel>
              </TabPanels>
            </TabGroup>
          </div>
        </form-step> </form-master
    ></base-card>
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
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);
const { cekEmail, wilayah, getWilayah } = useUtil();
const { createUser, user, getUser } = useAdminUser();
const route = useRoute();
const model = reactive({
  email: "",
  validate: [],
  password: "",
  password_confirmation: "",
  id: null,
  is_update: false,
  nama_camaba: "",
  tempat_lahir: "",
  tanggal_lahir: "",
  wilayah: "",
  file_upload: null,
  file_upload_url: null,
  jenis_kelamin: "",
  user_id: "",
});
let kategori = ref(["Data Diri", "Berkas"]);
const jenis_kelamin = { L: "Laki-Laki", P: "Perempuan" };
const filter = reactive({
  filter_query: "",
});
const config = ref({
  wrap: true, // set wrap to true only when using 'input-group'
  dateFormat: "Y-m-d",
  allowInput: true,
});
const config_file = {
  headers: {
    "Content-Type": "multipart/form-data",
  },
};
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
const cobaaaaa = async (ev) => {
  model.file_upload = ev.target.files[0];
};
const removeFile = async (ev) => {
  model.file_upload = null;
};
const onSubmit = async () => {
  let data_form = new FormData();
  data_form.append("email", model.email);
  data_form.append("password", model.password);
  data_form.append("nama_camaba", model.nama_camaba);
  data_form.append("tempat_lahir", model.tempat_lahir);
  data_form.append("tanggal_lahir", model.tanggal_lahir);
  data_form.append("wilayah", model.wilayah);
  data_form.append("file_upload", model.file_upload);
  data_form.append("jenis_kelamin", model.jenis_kelamin);
  data_form.append("is_update", model.is_update);
  data_form.append("user_id", model.user_id);
  createUser(data_form, config_file);
};
if (route.params.id) {
  getUser(route.params.id);
  watch(user, (data) => {
    if (data) {
      Object.assign(model, data.data[0]);
      model.is_update = true;
    }
  });
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style lang="scss" scoped>
</style>