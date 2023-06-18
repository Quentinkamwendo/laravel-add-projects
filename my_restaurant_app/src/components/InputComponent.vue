<template>
  <input
      class="form-control mt-6"
      placeholder='Enter a note'
      v-model="input"
      @keyup.enter="monitorEnterKey"
      type="text"
  />
</template>

<script setup>
import {useStore} from "vuex";
import {ref} from "vue";

const store = useStore()

const input = ref('')
const monitorEnterKey = ()=> {
    store.dispatch('addNote', input.value);
    store.dispatch('addTimestamp', new Date().toLocaleString());
    input.value = '';
}

</script>

<style scoped>

</style>
