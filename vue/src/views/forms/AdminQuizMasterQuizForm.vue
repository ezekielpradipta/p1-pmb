<template>
  <pre>{{ model }}</pre>
  <parent-transition appear :visibility="true">
    <page-header title="Tambah Data Master Quiz"> </page-header>
    <base-card>
      <form-master @submit="onSubmit" enctype="multipart/form-data">
        <form-step>
          <div class="grid xl:grid-cols-2 xl:gap-6 mb-8">
            <div class="col-span-1">
              <base-input
                v-model="model.nama_quiz"
                type="text"
                name="jenis_quiz"
                label="Judul Pertanyaan"
                placeholder="..."
              >
              </base-input>
            </div>
          </div>
          <div class="grid xl:grid-cols-2 xl:gap-6 mb-8">
            <div class="col-span-1">
              <base-label
                Title="Gambar Quiz (Optional)"
                class="mb-4"
              ></base-label>
              <file-pond
                name="test"
                ref="pond"
                label-idle="Drop files here..."
                v-bind:allow-multiple="false"
                accepted-file-types="image/jpeg, image/png"
                v-on:change="saveGambarQuiz"
                v-bind:files="model.gambar_quiz"
              />
            </div>
          </div>
          <div class="grid xl:grid-cols-2 xl:gap-6 mb-8">
            <div class="col-span-1">
              <base-label
                Title="Deskripsi Quiz(Optional)"
                class="mb-4"
              ></base-label>
              <textarea
                v-model="model.deskripsi_quiz"
                id="deskripsi_quiz"
                rows="3"
                class="
                  block
                  p-2.5
                  w-full
                  text-sm text-gray-900
                  bg-gray-50
                  rounded-lg
                  border border-gray-300
                  focus:ring-blue-500 focus:border-blue-500
                  dark:bg-dark-body-new
                  dark:border-gray-600
                  dark:placeholder-gray-400
                  dark:text-gray-300
                  dark:focus:ring-gray-50
                  dark:focus:border-gray-50
                "
                placeholder="Contoh: Permohonan Akun"
              ></textarea>
            </div>
          </div>
          <div class="grid xl:grid-cols-2 xl:gap-6 mb-8">
            <div class="col-span-1 h-auto">
              <base-label Title="Opsi 1" class="mb-4"></base-label>
              <QuillEditor theme="snow" toolbar="full" />
              <div class="flex items-center mt-4">
                <input type="checkbox" id="checkbox" @click="checkbox_1" />
                <label
                  for="checked-checkbox"
                  class="
                    ml-2
                    text-sm
                    font-medium
                    text-gray-900
                    dark:text-gray-300
                  "
                  >Jawaban Benar</label
                >
              </div>
            </div>
            <div class="col-span-1 h-auto">
              <base-label Title="Opsi 2" class="mb-4"></base-label>
              <QuillEditor theme="snow" toolbar="full" />
              <div class="flex items-center mt-4">
                <input type="checkbox" id="checkbox" @click="checkbox_2" />
                <label
                  for="checked-checkbox"
                  class="
                    ml-2
                    text-sm
                    font-medium
                    text-gray-900
                    dark:text-gray-300
                  "
                  >Jawaban Benar</label
                >
              </div>
            </div>
          </div>
        </form-step>
      </form-master>
    </base-card>
  </parent-transition>
</template>

<script setup>
import { reactive, watch, ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import useAdminQuiz from "../../composables/AdminQuiz";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import BaseButton from "../../components/BaseButton.vue";
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);

const route = useRoute();
const model = reactive({
  nama_quiz: "",
  id: null,
  is_update: false,
  gambar_quiz: null,
  gambar_quiz_url: null,
  jawaban_benar: [],
});
const saveGambarQuiz = async (ev) => {
  model.gambar_quiz = ev.target.files[0];
};
const checkbox_1 = async () => {
  model.jawaban_benar = "1";
};
const checkbox_2 = async () => {
  model.jawaban_benar = "2";
};
</script>

<style >
.ql-container.ql-snow {
  height: auto;
}
.ql-editor {
  height: 150px;
  overflow-y: scroll;
}
</style>