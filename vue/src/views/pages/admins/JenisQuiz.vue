<template>
  <parent-transition appear :visibility="true">
    <page-header title="Jenis Quiz">
      <base-button
        size="lg"
        @click="router.push({ name: 'AdminQuizJenisQuizForm' })"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 mr-2 -ml-1"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 4v16m8-8H4"
          />
        </svg>
        <span>Tambah Jenis Quiz</span></base-button
      >
    </page-header>
    <base-card>
      <base-table
        :headers="headers"
        :items="data_table.data"
        :pages="data_table.page"
        :pageSize="data_table.pageSize"
        :total-pages="data_table.totalPages"
        @pagechanged="onPageChange"
        @delete="deleteID"
      ></base-table>
    </base-card>
  </parent-transition>
</template>

<script setup>
import { inject, onMounted, reactive, watch } from "vue";
import { useRouter } from "vue-router";
import useAdminQuiz from "../../../composables/AdminQuiz";
const { jenisQuizs, getJenisQuizs, deleteJenisQuiz } = useAdminQuiz();
const router = useRouter();
const swal = inject("$swal");
const headers = [
  { key: "jenis_quiz", label: "Jenis Quiz" },
  {
    key: "id",
    label: "Aksi",
    route: "AdminQuizJenisQuizView",
    moreView: "Aksi-Full",
  },
];
const data_table = reactive({
  data: [],
  page: 1,
  pageSize: 5,
  totalPages: 0,
});
onMounted(getJenisQuizs);
watch(jenisQuizs, (data) => {
  data_table.data = data.data;
  data_table.totalPages = data.meta.last_page;
});
const onPageChange = async (page) => {
  data_table.page = page;
  await getJenisQuizs(data_table.page);
};
const deleteID = async (id) => {
  await swal({
    title: "Apakah Anda Yakin?",
    text: "Data Tidak Bisa dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya!",
  }).then((result) => {
    if (result.isConfirmed) {
      swal("Deleted!", "Data Berhasil Terhapus", "success");
      deleteJenisQuiz(id);
      getJenisQuizs(data_table.page);
    }
  });
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>