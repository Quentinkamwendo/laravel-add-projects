import { createRouter, createWebHistory } from "vue-router";
import HomePage from "../views/HomePage"
import AddingActivities from "../views/AddingActivities"
import LoginPage from "../views/LoginPage"
import RegisterPage from "../views/RegisterPage"
import DashboardPage from "../views/DashboardPage"
import AuthPage from "../views/AuthPage"
import ProjectView from "../views/ProjectView"
import store from "@/stores/store";

const routes = [

    {
        path: '/',
        redirect: '/dashboard',
        component: HomePage,
        meta: {
            requiresAuth: true
        },
        children: [
            {path: '/dashboard', name: 'dashboard', component: DashboardPage},
            {path: '/add', name: 'activities', component: AddingActivities},
            {path: '/project', name: 'project', component: ProjectView}
        ]
    },
    {
        path: '/auth',
        redirect: '/login',
        component: AuthPage,
        meta: {
            isAuth: true
        },
        children: [
            {path: '/login', name: 'login', component: LoginPage},
            {path: '/register', name: 'register', component: RegisterPage}
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({name: 'login'})
    } else if(to.meta.isAuth && store.state.user.token) {
        next({name: 'dashboard'})
    } else {
        next()
    }

})

export default router;
