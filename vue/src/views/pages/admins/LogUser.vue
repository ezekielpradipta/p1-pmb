<template>
  <parent-transition appear :visibility="true">
    <page-header title="Log User"> </page-header>
    <base-card>
      <div class="grid xl:grid-cols-4 gap-6 mb-4 mt-4">
        <div class="col-span-1">
          <search
            placeholder="Filter Email.."
            v-model="filter.email"
            v-on:keyup="filter_email"
          ></search>
        </div>
        <div class="col-span-1">
          <Datepicker
            ref="dp"
            v-model="filter.date"
            range
            multi-calendars
            format="yyyy-MM-dd"
            placeholder="Filter Tanggal"
            @cleared="clear_date"
          >
            <template #action-select>
              <p class="custom-select" @click="selectDate">Select</p>
            </template></Datepicker
          >
        </div>
      </div>
      <div class="grid xl:grid-cols-4 gap-6 mb-4 mt-4">
        <div class="col-span-1">
          <Multiselect
            v-model="filter.status"
            placeholder="Filter Status "
            :searchable="true"
            :options="status"
            :classes="{
              containerActive: 'ring ring-blue-500 ring-opacity-30',
              tag: 'bg-blue-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1',
              groupLabelSelected: 'bg-blue-600 text-white',
              groupLabelSelectedPointed: 'bg-blue-600 text-white opacity-90',
              groupLabelSelectedDisabled:
                'text-blue-100 bg-purple-600 bg-opacity-50 cursor-not-allowed',
              groupOptions: 'p-0 m-0',
              optionSelected: 'text-white bg-blue-500',
              optionDisabled: 'text-gray-300 cursor-not-allowed',
              optionSelectedPointed: 'text-white bg-blue-500 opacity-90',
              optionSelectedDisabled:
                'text-blue-100 bg-blue-500 bg-opacity-50 cursor-not-allowed',
            }"
            valueProp="status"
            @select="filter_status()"
            @clear="clear_filter_status()"
          />
        </div>
        <div class="col-span-1">
          <Multiselect
            v-model="filter.filter"
            placeholder="Filter List "
            :searchable="true"
            :options="filterList"
            :classes="{
              containerActive: 'ring ring-blue-500 ring-opacity-30',
              tag: 'bg-blue-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1',
              groupLabelSelected: 'bg-blue-600 text-white',
              groupLabelSelectedPointed: 'bg-blue-600 text-white opacity-90',
              groupLabelSelectedDisabled:
                'text-blue-100 bg-purple-600 bg-opacity-50 cursor-not-allowed',
              groupOptions: 'p-0 m-0',
              optionSelected: 'text-white bg-blue-500',
              optionDisabled: 'text-gray-300 cursor-not-allowed',
              optionSelectedPointed: 'text-white bg-blue-500 opacity-90',
              optionSelectedDisabled:
                'text-blue-100 bg-blue-500 bg-opacity-50 cursor-not-allowed',
            }"
            label="filter"
            track-by="filter"
            valueProp="filter"
            @select="filter_list()"
            @clear="clear_filter_list()"
          />
        </div>
        <div class="col-span-1">
          <base-button design="gray" @click="exportNow">
            <svg
              class="-ml-1 mr-2 h-6 w-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <label>Export</label>
          </base-button>
        </div>
      </div>
      <base-table
        :headers="headers"
        :items="data_table.data"
        :pages="data_table.page"
        :pageSize="data_table.pageSize"
        :total-pages="data_table.totalPages"
        @pagechanged="onPageChange"
      ></base-table>
    </base-card>
  </parent-transition>
</template>

<script setup>
import { inject, onMounted, reactive, ref, watch } from "vue";

import Multiselect from "@vueform/multiselect";
import useLogsUser from "../../../composables/LogUser";
import moment from "moment";
const swal = inject("$swal");
const { logs, getLogs, filterList, getFilter, exportLog } = useLogsUser();
onMounted(getLogs);
onMounted(getFilter);
const dp = ref();

const filter = reactive({
  email: "",
  filter: "",
  status: "",
  tanggal_awal: "",
  tanggal_akhir: "",
  date: [],
});
const data_table = reactive({
  data: [],
  page: 1,
  pageSize: 5,
  totalPages: 0,
});
const headers = [
  { key: "ip", label: "User IP" },
  { key: "email", label: "Email" },
  { key: "filter", label: "Filter" },
  { key: "status", label: "Status" },
  { key: "keterangan", label: "Keterangan" },
  { key: "created_at", label: "Waktu" },
];
const status = { SUKSES: "SUKSES", GAGAL: "GAGAL" };
watch(logs, (data) => {
  data_table.data = data.data;
  data_table.totalPages = data.meta.last_page;
});
const onPageChange = async (page) => {
  data_table.page = page;
  await getLogs(data_table.page, { ...filter });
};
const filter_email = async () => {
  data_table.page = 1;
  await getLogs(data_table.page, { ...filter });
};
const filter_list = async () => {
  data_table.page = 1;
  await getLogs(data_table.page, { ...filter });
};
const clear_filter_list = async () => {
  data_table.page = 1;
  filter.filter = "";
  await getLogs(data_table.page, { ...filter });
};
const filter_status = async () => {
  data_table.page = 1;
  await getLogs(data_table.page, { ...filter });
};
const clear_filter_status = async () => {
  data_table.page = 1;
  filter.status = "";
  await getLogs(data_table.page, { ...filter });
};
const clear_date = async () => {
  data_table.page = 1;
  filter.tanggal_awal = "";
  filter.tanggal_akhir = "";
  await getLogs(data_table.page, { ...filter });
};
const selectDate = async () => {
  dp.value.selectDate();
  let tAawl = moment(filter.date[0]).format("yyyy-MM-DD");
  let tAkh = moment(filter.date[1]).format("yyyy-MM-DD");
  filter.tanggal_awal = tAawl;
  filter.tanggal_akhir = tAkh;
  await getLogs(data_table.page, { ...filter });
};
const exportNow = async () => {
  await exportLog();
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style lang="scss" scoped>
</style>