<template>
  <section class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-lg shadow dark:border dark:bg-gray-800 dark:border-gray-700">
      <div class="p-6 space-y-6">

        <h1 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
          Create an account
        </h1>

        <form class="space-y-4" @submit.prevent="submit">

          <!-- Name -->
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Full name</label>
            <input v-model="name"
              type="text"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg
                     focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5
                     dark:bg-gray-700 dark:border-gray-600 dark:text-white"
              placeholder="John Doe"
              required />
          </div>

          <!-- Email -->
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <input v-model="email"
              type="email"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg
                     focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5
                     dark:bg-gray-700 dark:border-gray-600 dark:text-white"
              placeholder="name@example.com"
              required />
          </div>

          <!-- Password -->
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
            <input v-model="password"
              type="password"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg
                     focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5
                     dark:bg-gray-700 dark:border-gray-600 dark:text-white"
              placeholder="••••••••"
              required />
          </div>

          <!-- Error -->
          <p v-if="error" class="text-red-500 text-sm">{{ error }}</p>

          <!-- Submit -->
          <button
            type="submit"
            :disabled="loading"
            class="w-full text-white bg-blue-600 hover:bg-blue-700
                   focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium
                   rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700"
          >
            <span v-if="loading">Creating account...</span>
            <span v-else>Sign up</span>
          </button>

          <p class="text-sm font-light text-gray-500 dark:text-gray-400">
            Already have an account?
            <router-link to="/login" class="font-medium text-blue-600 hover:underline">
              Sign in
            </router-link>
          </p>

        </form>

      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import api from "../api/axios";

const name = ref("");
const email = ref("");
const password = ref("");
const loading = ref(false);
const error = ref(null);

const router = useRouter();

async function submit() {
  loading.value = true;
  error.value = null;

  try {
    await api.post("/register", {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password.value,
    });

    router.push("/login");
  } catch (e) {
    error.value = "Registration failed.";
  }

  loading.value = false;
}
</script>
