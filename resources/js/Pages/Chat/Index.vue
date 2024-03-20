<template>
  <div class="flex">
    <div class="w-1/2 pr-4 mr-4 bg-white border border-gray-200">
      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates
      consectetur suscipit temporibus hic, veritatis saepe nulla ullam obcaecati
      accusamus at officiis expedita natus sit laudantium architecto ex
      consequatur molestiae numquam.
    </div>
    <div class="w-1/2 p-4 bg-white border border-gray-200">
      <h3 class="text-gray-700 mb-4 text-lg">Users</h3>
      <div v-if="users">
        <div
          v-for="user in users"
          class="flex items-center pb-4 mb-4 border-b border-gray-300"
        >
          <p class="mr-2">{{ user.id }}</p>
          <p class="mr-4">{{ user.name }}</p>
          <a
            @click.prevent="store(user.id)"
            class="inline-block bg-sky-400 text-white text-xs px-3 py-2 rounded-lg"
            href="#"
            >Message</a
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Main from "@/Layouts/Main.vue";
export default {
  name: "Index",
  props: ["users"],
  layout: Main,
  methods: {
    store(id) {
        this.$inertia.post('chats', { title: null, users: [id]})
    },
  },
};
</script>

<style scoped>
</style>