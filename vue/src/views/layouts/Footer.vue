<script setup>
const tanggal_sekarang = new Date();
const tahun_sekarang = tanggal_sekarang.getFullYear();
</script>
<template>
  <footer class="mt-10">
    <div class="container-fluid mx-auto">
      <BaseCard class="">
        <div class="flex justify-between items-center">
          <div>
            <p>All rights reserved © Copyright {{ tahun_sekarang }}</p>
          </div>
        </div>
      </BaseCard>
    </div>
  </footer>
</template>
