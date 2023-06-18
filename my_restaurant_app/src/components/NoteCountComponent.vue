<template>
  <div class="bg-gray-200 mt-4">Note count: <strong>{{ noteCount }}</strong></div>
</template>

<script setup>
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore()
const noteCount = computed(()=> store.getters.getNoteCount)

</script>

<style scoped>

</style>
