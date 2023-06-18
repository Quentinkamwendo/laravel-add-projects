<template>
  <div class="container">
    <form @submit.prevent="register" class="m-auto w-2/4">
      <input
          type="text"
          class="form-control my-2" name="name"
          v-model="user.name" id="username"
          placeholder="Enter Your Name"
      >
      <input type="email" class="form-control my-2" name="email" v-model="user.email" id="email" placeholder="Enter Your Email">
      <input
          type="password"
          class="form-control my-2" name="password"
          v-model="user.password"
          id="password"
          placeholder="Enter Your Password"
      >
      <input
          type="password"
          class="form-control my-2" name="password_confirmation"
          v-model="user.password_confirmation"
          placeholder="Confirm Your Password"
      >
        <button type="submit"
                :disabled="loading"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                :class="{
                  'cursor-not-allowed': loading,
                  'hover:bg-indigo-500': loading,
                }">
            <svg
                v-if="loading"
                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
            >
                <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                ></circle>
                <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
            </svg>
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true"/>
            </span>
            Sign Up
        </button>
    </form>
    <p class="font-semibold text-red-500">{{errorMsg}}</p>
  </div>
</template>

<script setup>
import {reactive, ref} from 'vue';
import { useRouter } from 'vue-router';
import {useStore} from "vuex";
import {useToast} from 'vue-toast-notification';

const $toast = useToast();
const router = useRouter();
const store = useStore();

const errorMsg = ref('');
const loading = ref(false);

document.title = "Registration"
$toast.success('Profile saved.', {
    position: 'top-right',
    duration: 3000,
    type: 'success'
})
$toast.open({
    message: 'Something went wrong!',
    type: 'error',
    // all of other options may go here
})

const user = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    remember: false
})

function register() {
    loading.value = true
    store.dispatch('register', user)
        .then(() => {
            loading.value = false
            $toast.success('Registered successfully', {
                position: 'top-right',
                duration: 3000
            })
            router.push({name: "dashboard"})
        })
        .catch(({response}) => {
            loading.value = false
            errorMsg.value = response.data.message;
        })
}


</script>

<style scoped>

</style>
