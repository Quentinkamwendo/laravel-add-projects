<template>
  <div class="container justify-center items-center">
    <div class="grid grid-cols-3">
      <div class="grid-cols-4 text-center">
        <strong>Notes</strong>
        <div v-for="(note, index) in notes" :key='index' class="notes">
          {{ note }}
        </div>
      </div>
      <div class="grid-cols-4 text-center">
        <strong>Timestamp</strong>
        <div v-for="(timestamp, ind) in timestamps" :key='ind' class="timestamps">
          {{ timestamp }}
        </div>
      </div>
      <div v-if="notes.length > 0" class="grid-cols-4">
        <button @click="deleteNotes" class="font-semibold text-red-400 hover:text-red-600">Delete</button>
      </div>
    </div>
    <InputComponent></InputComponent>
    <NoteCountComponent></NoteCountComponent>
  </div>
</template>

<script setup>
import InputComponent from "@/components/InputComponent";
import NoteCountComponent from "@/components/NoteCountComponent";
import {computed} from "vue";
import {useStore} from "vuex";

const store = useStore();
document.title = "Add Activity"
const notes = computed(()=> store.getters.getNotes)
const timestamps = computed(()=> store.getters.getTimestamps)

const deleteNotes = ()=> store.dispatch('deleteNote')

</script>

<style scoped>

</style>
