
import {createStore} from "vuex";
import axiosClient from "@/axios";

const state = {
    user: {
        token:sessionStorage.getItem("TOKEN"),
        data: {}
    },
    project: {
        data: {}
    },
    notes: [],
    timestamps: []
}
const mutations = {
    setUser(state, userData) {
        state.user.token = userData.token;
        state.user.data = userData.user;
        sessionStorage.setItem('TOKEN', userData.token);
    },
    logout(state) {
        state.user.token = null;
        state.user.data = {};
        sessionStorage.removeItem("TOKEN")
    },
    setProject(state, project) {
        state.project = project
    },

    ADD_NOTE (state, payload) {
        let newNote = payload;
        state.notes.push(newNote);
    },
    ADD_TIMESTAMP (state, payload) {
        let newTimeStamp = payload;
        state.timestamps.push(newTimeStamp);
    },
    DELETE_NOTE (state) {
        state.notes.pop()
        state.timestamps.pop()
    }
}
const actions = {
    login({commit}, user) {
        return axiosClient.post('/login', user)
            .then(({data}) => {
                commit('setUser', data);
                return data;
            })
    },
    register({commit}, user) {
        return axiosClient.post('/register', user)
            .then(({data}) => {
                commit('setUser', data);
                return data;
            })
    },
    logout({commit}) {
        return axiosClient.post('/logout')
            .then((response) => {
                commit('logout')

                return response;
            })
    },
     // eslint-disable-next-line
    createProject({commit}, project) {
        if (project.image instanceof File) {
            const form = new FormData();
            form.append('user_id', project.user_id);
            form.append('project_name', project.project_name);
            form.append('image', project.image);
            form.append('description', project.description || '');
            form.append('start_date', project.start_date);
            form.append('end_date', project.end_date);
            project = form;
          }
          return axiosClient.post('/project', project)
        //   .then((res)=> {
        //     commit('setProject')
        //     return res.data
        //   })
    },
    addNote ({commit}, payload) {
       commit('ADD_NOTE', payload);
    },
    addTimestamp ({commit}, payload) {
        commit('ADD_TIMESTAMP', payload);
    },
    deleteNote ({commit}) {
        commit("DELETE_NOTE")
    }
}
const getters = {
    getUser: state => state.user.data.name,
    getNotes: state => state.notes,
    getTimestamps: state => state.timestamps,
    getNoteCount: state => state.notes.length
}

const store = createStore({
    state,
    mutations,
    actions,
    getters
})

export default store;
