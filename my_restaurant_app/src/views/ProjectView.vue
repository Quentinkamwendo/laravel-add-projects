<template>
    <div>
        <form @submit.prevent="createProject">
            <input type="number" v-model="project.user_id" name="user_id" class="form-control mb-2">
            <label>Project Name</label>
            <input type="text" v-model="project.project_name" class="form-control mb-2">
            <textarea v-model="project.description" name="description" class="form-control mb-2" rows="3"></textarea>
            <input type="date"
            name="start_date"
            v-model="project.start_date"
            class="form-control mb-2"
            >
            <input type="date"
            name="end_date"
            v-model="project.end_date"
            class="form-control mb-2"
            >
            <input type="file"
            name="image"
            @change="onImageChoose"
            class="form-control mb-2"
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
              <!-- <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true"/> -->
            </span>
            Create Project
            </button>
        </form>
    </div>
</template>

<script setup>
import {reactive, ref} from "vue";
import {useStore} from "vuex";
import {useRouter} from "vue-router";
import {useToast} from 'vue-toast-notification';

const $toast = useToast();

const store = useStore();
const router = useRouter();

const error = ref('')
const loading = ref(false)

const project = reactive({
    user_id: null,
    project_name: '',
    description: '',
    start_date: '',
    end_date: '',
    image: null
})

// function onImageChoose(ev) {
//     project.image.file = ev.target.file;
// }

function onImageChoose(ev) {
    const file = ev.target.files[0];
    const reader = new FileReader();
    reader.onload = ()=> {
        project.image = reader.result
    }
    reader.readAsDataURL(file)

}

function createProject() {
    loading.value = true
    store.dispatch('createProject', project)
        .then(() => {
            loading.value = false
            $toast.success('Project Created Successfully', {
                position: 'bottom-right',
                duration: 3000
            })
            router.push({name: "dashboard"})
        })
        .catch(({response}) => {
            loading.value = false
            $toast.error(error.value = response.data.message, {
                position: 'bottom-left',
                duration: 3000
            })
            // error.value = response.data.message;
        })
}
</script>
