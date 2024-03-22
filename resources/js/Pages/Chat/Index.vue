<template>
  <div class="flex">
    <div class="w-1/2 pr-4 mr-4 bg-white border border-gray-200">
      <h3 class="text-gray-700 mb-4 text-lg">Chats</h3>
      <div v-if="chats">
        <div
          v-for="chat in chats"
          class="flex items-center pb-4 mb-4 border-b border-gray-300"
        >
          <Link :href="route('chats.show', chat.id)" class="flex">
            <p class="mr-2">{{ chat.id }}</p>
            <p class="mr-4">{{ chat.title ?? "Your chat" }}</p>
          </Link>
          <!-- <a
            @click.prevent="store(user.id)"
            class="inline-block bg-sky-400 text-white text-xs px-3 py-2 rounded-lg"
            href="#"
            >Message</a
          > -->
        </div>
      </div>
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
import {Link} from "@inertiajs/vue3";
import Main from "@/Layouts/Main.vue";
export default {
  name: "Index",
  props: ["users", "chats"],
  components: {
    Link
  },
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