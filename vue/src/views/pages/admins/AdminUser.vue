<template>
  <parent-transition appear :visibility="true">
    <page-header
      title="User List"
      subtitle="List Data User Yang Sudah Mendaftar."
    >
      <base-button size="lg" @click="router.push({ name: 'AdminUserForm' })">
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
        <span>Tambah User</span></base-button
      >
    </page-header>
    <base-card>
      <div class="grid xl:grid-cols-4 gap-6 mb-4 mt-4">
        <div class="col-span-1">
          <search
            placeholder="Filter Email/Username"
            v-model="filter.email"
            v-on:keyup="filter_email"
          ></search>
        </div>
        <div class="col-span-1">
          <Multiselect
            v-model="filter.valid"
            placeholder="Filter Status "
            :searchable="true"
            :options="validasi_opt"
            valueProp="validasi_opt"
            @select="filter_status()"
            @clear="clear_filter_status()"
          />
        </div>
      </div>
      <base-table
        :headers="headers"
        :items="data_table.data"
        :pages="data_table.page"
        :pageSize="data_table.pageSize"
        :total-pages="data_table.totalPages"
        @pagechanged="onPageChange"
        @valid="validID"
        @delete="deleteID"
      ></base-table>
    </base-card>
  </parent-transition>
</template>

<script setup>
import { inject, onMounted, reactive, watch } from "vue";
import { useRouter } from "vue-router";
import Multiselect from "@vueform/multiselect";
import useAdminUser from "../../../composables/AdminUser";

const router = useRouter();
const { users, getUsers, deleteData, validData } = useAdminUser();
const swal = inject("$swal");
const filter = reactive({
  email: "",
  valid: "",
});
const headers = [
  { key: "email", label: "Email" },
  { key: "nama_camaba", label: "Nama" },
  {
    key: "user_is_valid",
    label: "Status",
    moreView: "Validasi",
    prkey: "user_id",
  },
  {
    key: "user_id",
    label: "Aksi",
    route: "AdminUserView",
    moreView: "Aksi-Full",
  },
];

const data_table = reactive({
  data: [],
  page: 1,
  pageSize: 5,
  totalPages: 0,
});
const validasi_opt = { 0: "Belum Valid", 1: "Valid" };
onMounted(getUsers);
watch(users, (data) => {
  data_table.data = data.data;
  data_table.totalPages = data.meta.last_page;
});
const onPageChange = async (page) => {
  data_table.page = page;
  await getUsers(data_table.page, { ...filter });
};
const filter_email = async () => {
  data_table.page = 1;
  await getUsers(data_table.page, { ...filter });
};
const filter_status = async () => {
  data_table.page = 1;
  await getUsers(data_table.page, { ...filter });
};
const clear_filter_status = async () => {
  data_table.page = 1;
  filter.valid = "";
  await getUsers(data_table.page, { ...filter });
};
const validID = async (id) => {
  await swal({
    title: "Apakah Anda Yakin?",
    text: "User akan divalidasi.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya!",
  }).then((result) => {
    if (result.isConfirmed) {
      swal("Berhasil!", "User Tervalidasi", "success");
      validData(id);
      getUsers(data_table.page, { ...filter });
    }
  });
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
      deleteData(id);
      getUsers(data_table.page, { ...filter });
    }
  });
};
</script>
<!-- <style src="@vueform/multiselect/themes/default.css"></style> -->
<style lang="scss" src="../../../multiselect.css"></style>

