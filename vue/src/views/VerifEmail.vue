<template></template>

<script setup>
import { useRoute } from "vue-router";
import useAuth from "../composables/Auth";
const { verifEmail } = useAuth();
const route = useRoute();
if (route.params.id) {
  verifEmail(route.params.id);
}
</script>

<style lang="scss" scoped>
</style>