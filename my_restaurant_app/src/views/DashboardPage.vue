<template>
  <div class="container">
    <h3 class="text-teal-500 font-semibold">{{ name }}</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 p-8">
      <div
        v-for="(project, i) in projects"
        :key="i"
        class="bg-white shadow rounded-xl"
      >
        <img
          :src="project.attributes.image"
          class="rounded-t-xl w-full h-48 object-cover"
        />
        <h3 class="font-bold">{{ project.attributes.project_name }}</h3>
        <p>{{ project.attributes.description }}</p>
        <strong>{{ project.attributes.start_time }}</strong>
      </div>
    </div>
    <div class="flex justify-center mt-4">
      <button
        @click="fetchData(paginatedLinks.prev)"
        :disabled="!paginatedLinks.prev"
        class="px-4 py-2 mr-2 bg-blue-500 text-white"
      >
        Previous
      </button>

      <template
        v-for="pageNumber in paginatedLinks.last_page"
        :key="pageNumber"
      >
        <button
          @click="fetchData(`/project?page=${pageNumber}`)"
          :class="{
            'px-4 py-2 bg-blue-500 text-white':
            projects.meta.current_page !== pageNumber.last_page,
            'px-4 py-2 bg-gray-300 text-gray-500':
            projects.meta.current_page === pageNumber.last_page,
          }"
        >
          {{ pageNumber }}
        </button>
      </template>

      <button
        @click="fetchData(paginatedLinks.next)"
        :disabled="!paginatedLinks.next"
        class="px-4 py-2 mr-2 bg-blue-500 text-white"
      >
        Next
      </button>
    </div>
    <router-link
      to="/"
      class="border-2 p-2 rounded border-violet-500 bg-gray-100 text-violet-500 w-2/4 hover:bg-purple-500 hover:text-white hover:border-transparent"
      >Back to HomePage</router-link
    >
  </div>
</template>

<script setup>
import axiosClient from "@/axios";
import { computed, onMounted, ref } from "vue";
import { useStore } from "vuex";

const store = useStore();
const name = computed(() => store.state.user.data.name);
const projects = ref([]);
const paginatedLinks = ref({});
onMounted(() => fetchData());
const fetchData = async (url = "/project") => {
  try {
    const response = await axiosClient.get(url);
    projects.value = response.data.data;
    paginatedLinks.value = response.data.links;
  } catch (error) {
    console.log(error);
  }
};

// const getImagePath = (image) => {
//   if (image.startsWith('http')) {
//     return image;
//   } else {
//     return `/storage/${image}`;
//   }
// };
// function fetchData() {
//   axiosClient
//     .get("/project")
//     .then((response) => {
//       projects.value = response.data;
//       paginatedLinks.value = response.data.links;
//     })
//     .catch((error) => {
//       console.log(error);
//     });
// }

document.title = "Dashboard";
</script>

<style scoped>
</style>
