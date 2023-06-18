<template>
  <div class="container">
    <h3 class="text-teal-500 font-semibold">{{name}}</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 p-8">
      <div class="bg-white shadow rounded-xl">
        <img src="../../public/newcreate.png" class="rounded-t-xl w-full h-48 object-cover">
        <h3 class="font-bold">my titles</h3>
      </div>
    </div>

    <router-link to="/" class="border-2 p-2 rounded border-violet-500 bg-gray-100 text-violet-500 w-2/4 hover:bg-purple-500 hover:text-white hover:border-transparent">Back to HomePage</router-link>
  </div>
</template>

<script setup>
import {computed} from "vue";
import {useStore} from "vuex";

const store = useStore();
const name = computed(()=> store.state.user.data.name);

document.title = "Dashboard"
</script>

<style scoped>

</style>
