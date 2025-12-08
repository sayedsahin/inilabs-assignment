import './assets/input.css'
// import './assets/main.css'


import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import { useAuthStore } from "./stores/auth"

const app = createApp(App)

app.use(createPinia())
app.use(router)

const auth = useAuthStore()
// Wait for fetchUser() before mounting the app
await auth.fetchUser()

app.mount('#app')
