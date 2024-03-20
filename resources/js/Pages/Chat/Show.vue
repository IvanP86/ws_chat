<template>
  <div class="flex">
    <div class="w-3/4 pr-4 mr-4 bg-white border border-gray-200">

    </div>
    <div class="w-1/4 p-4 bg-white border border-gray-200">

    </div>
  </div>
</template>

<script>
import Main from "@/Layouts/Main.vue";
export default {
  name: "Show",
  props: ["chat"],
  layout: Main,
};
</script>

<style scoped>
</style>