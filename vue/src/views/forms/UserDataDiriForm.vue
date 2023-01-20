<template>
  <pre>{{ model }}</pre>
  <parent-transition appear :visibility="true">
    <page-header
      title="Data Diri"
      subtitle="Inputkan Data Diri Calon Mahasiswa."
    >
    </page-header>
    <base-card>
      <div class="p-5">
        <form-master @submit="onSubmit" enctype="multipart/form-data">
          <form-step>
            <div class="grid xl:grid-cols-2 xl:gap-6">
              <div class="col-span-1 mb-6">
                <base-input
                  v-model="model.nama_camaba"
                  type="text"
                  name="nama_camaba"
                  label="Nama (Sesuai Ijazah)"
                  placeholder="Your Name..."
                  required
                >
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
                  required
                />
              </div>
            </div>
            <div class="grid xl:grid-cols-2 xl:gap-6">
              <div class="col-span-1 mb-6">
                <base-input
                  v-model="model.tempat_lahir"
                  type="text"
                  name="tempat_lahir"
                  label="Tempat Lahir (Sesuai Ijazah)"
                  placeholder="Tempat Lahir...."
                  required
                >
                </base-input>
              </div>
              <div class="col-span-1 mb-6">
                <base-label
                  Title="Tanggal Lahir (Sesuai Ijazah)"
                  class="mb-1"
                ></base-label>
                <flat-pickr
                  v-model="model.tanggal_lahir"
                  placeholder="YYY-MM-DD "
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
                  required
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
          </form-step>
          <form-step>
            <div class="grid xl:grid-cols-3 xl:gap-6">
              <div class="col-span-1">
                <base-label Title="Upload File" class="mb-1"></base-label>
                <img
                  v-if="model.file_upload_url"
                  :src="model.file_upload_url"
                  :alt="model.nama_camaba"
                  class="w-64 h-48 object-cover"
                />
                <span
                  v-else
                  class="
                    flex
                    items-center
                    justify-center
                    h-12
                    w-12
                    rounded-full
                    overflow-hidden
                    bg-gray-100
                  "
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-[80%] w-[80%] text-gray-300"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </span>
                <input
                  class="
                    block
                    w-full
                    text-sm text-gray-900
                    border border-gray-300
                    rounded-lg
                    cursor-pointer
                    bg-gray-50
                    dark:text-gray-400
                    focus:outline-none
                    dark:bg-dark-body-new
                    dark:border-gray-600
                    dark:placeholder-gray-400
                  "
                  aria-describedby="file_input_help"
                  id="file_upload"
                  type="file"
                  v-on:change="onUploadFile"
                />
              </div>
            </div>
          </form-step>
        </form-master>
      </div>
    </base-card>
  </parent-transition>
</template>
  
  <script setup>
import Multiselect from "@vueform/multiselect";
import { reactive, watch, ref, onMounted } from "vue";
import useUtil from "../../composables/Util";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import useUser from "../../composables/User";
const { save, getDetailUser, user } = useUser();
const { wilayah, getWilayah } = useUtil();
onMounted(getWilayah);
onMounted(getDetailUser);
const model = reactive({
  is_update: false,
  nama_camaba: "",
  tempat_lahir: "",
  tanggal_lahir: "",
  wilayah: "",
  file_upload: null,
  file_upload_url: null,
  jenis_kelamin: "",
});
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
watch(
  () => model,
  (val) => {
    sessionStorage.setItem("model", JSON.stringify(val));
  },
  { deep: true }
);
watch(user, (data) => {
  if (data) {
    Object.assign(model, data.data[0]);
    model.is_update = true;
  }
});
onMounted(() => {
  const storedModel = JSON.parse(sessionStorage.getItem("model"));
  if (storedModel) {
    Object.assign(model, storedModel);
  }
});
const onUploadFile = async (ev) => {
  // model.file_upload = ev.target.files[0];
  const file = ev.target.files[0];
  const reader = new FileReader();
  reader.onload = () => {
    model.file_upload = reader.result;
    model.file_upload_url = reader.result;
    ev.target.value = "";
  };
  reader.readAsDataURL(file);
};
const onSubmit = async () => {
  let data_form = new FormData();
  data_form.append("nama_camaba", model.nama_camaba);
  data_form.append("tempat_lahir", model.tempat_lahir);
  data_form.append("tanggal_lahir", model.tanggal_lahir);
  data_form.append("wilayah", model.wilayah);
  data_form.append("file_upload", model.file_upload);
  data_form.append("jenis_kelamin", model.jenis_kelamin);
  data_form.append("is_update", model.is_update);
  save(data_form, config_file);
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>