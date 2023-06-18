<template>
  <div class="container">
    <div>
      <table class="table">
          <thead>
            <tr>
                <th>#</th>
                <th>Notes</th>
                <th>Timestamp</th>
            </tr>
          </thead>
          <tbody>

            <tr v-for="(note, ind) in notes" :key="ind">
                <td>{{ind}}</td>
                <td>{{note}}</td>
<!--                <td>{{time}}</td>-->
            </tr>
            <tr v-for="(time, i) in timeStamp" :key="i">
                <td>{{time}}</td>
            </tr>

          </tbody>
      </table>
      <h4>Welcome {{name}}</h4>
      <router-link :to="{name: 'project'}" class="font-semibold text-green-500">Add Project</router-link>
      <router-view></router-view>

    </div>


    <router-link :to="{name: 'login' }" class="btn rounded text-white bg-indigo-500 hover:bg-indigo-700">Log in first</router-link>
    <router-link :to="{name: 'activities' }" class="btn rounded m-2 text-white bg-indigo-500 hover:bg-indigo-700">Add Task</router-link>
    <button @click="logout" class="btn rounded m-2 text-white bg-indigo-500 hover:bg-indigo-700">Logout</button>
  </div>

</template>

<script setup>
import {useStore} from "vuex";
import {computed} from "vue";
import {useRouter} from "vue-router";
// import store from "../stores/store";

const store = useStore()
const router = useRouter();

document.title = "HomePage"

function logout (){
    store.dispatch('logout')
    .then(() => {
            router.push({name: "login"})
        })
}

const timeStamp = computed(()=> store.getters.getTimestamps)
const name = computed(()=> store.getters.getUser)

const notes = computed(() => store.getters.getNotes)

</script>

<style scoped>

</style>
