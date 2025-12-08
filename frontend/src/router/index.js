import { createRouter, createWebHistory } from 'vue-router'
import TaskView from '../views/TaskView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import { useAuthStore } from '@/stores/auth';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: TaskView,
      meta: { requiresAuth: true },
    },
    {
      path: "/login",
      name: "login",
      component: LoginView,
      meta: { guestOnly: true },
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView,
      meta: { guestOnly: true },
    }
  ],
});

// Global router guard
router.beforeEach((to, from, next) => {
    const auth = useAuthStore();

    // Auth protected pages
    if (to.meta.requiresAuth && !auth.isAuthenticated) {
        return next("/login");
    }

    // “guest only” pages (login/register)
    if (to.meta.guestOnly && auth.isAuthenticated) {
        return next("/");
    }

    next();
});

export default router
