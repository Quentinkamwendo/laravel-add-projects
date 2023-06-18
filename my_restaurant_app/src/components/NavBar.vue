<template>
  <div class="container-fluid">
    <header class="container">
      <nav class="flex bg-emerald-600 justify-between h-full items-stretch items-center gap-2">
        <router-link class="justify-start items-center hover:bg-indigo-500 hover:text-white p-2" to="/">
            Home
        </router-link>
        <div class="items-end gap-2" v-if="!token">
          <router-link :to="{ name: 'login' }" class="inline-flex h-full items-center hover:bg-blue-400 hover:text-white p-2">Login</router-link>
          <router-link :to="{ name: 'register' }" class="inline-flex h-full items-center hover:bg-blue-400 hover:text-white p-2">Register</router-link>
        </div>
        <div class="items-end gap-2" v-else>
          <router-link :to="{ name: 'dashboard' }" class="inline-flex h-full items-center hover:bg-blue-400 hover:text-white p-2">Dashboard</router-link>
          <router-link :to="{ name: 'activities' }" class="inline-flex h-full items-center hover:bg-blue-400 hover:text-white p-2">Add</router-link>
          <button @click="logout" class="inline-flex h-full items-center hover:bg-blue-400 hover:text-white p-2">Logout</button>
        </div>


      </nav>
    </header>
  </div>

</template>

<script setup>
import {useRouter} from "vue-router";
import store from "@/stores/store";

const router = useRouter()

const token = store.state.user.token

const logout = () => {
    store.dispatch('logout').then(()=> {
        router.push('/login')
    })
}

</script>

<style scoped>

</style>
