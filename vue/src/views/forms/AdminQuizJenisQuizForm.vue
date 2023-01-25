<template>
  <parent-transition appear :visibility="true">
    <page-header title="Tambah Data Jenis Quiz"> </page-header>
    <base-card>
      <form-master @submit="onSubmit" enctype="multipart/form-data">
        <form-step>
          <div class="grid xl:grid-cols-2 xl:gap-6 mb-8">
            <div class="col-span-1">
              <base-input
                v-model="model.jenis_quiz"
                type="text"
                name="jenis_quiz"
                label="Nama Jenis Quiz"
                placeholder="..."
              >
              </base-input>
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
const route = useRoute();
const { createJenisQuiz, jenisQuiz, getJenisQuiz } = useAdminQuiz();
const model = reactive({
  jenis_quiz: "",
  id: null,
  is_update: false,
});
const onSubmit = async () => {
  await createJenisQuiz({ ...model });
};
if (route.params.id) {
  getJenisQuiz(route.params.id);
  watch(jenisQuiz, (data) => {
    if (data) {
      Object.assign(model, data.data[0]);
      model.is_update = true;
    }
  });
}
</script>

<style lang="scss" scoped>
</style>