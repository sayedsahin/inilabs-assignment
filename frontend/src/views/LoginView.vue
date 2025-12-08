<template>
  <section class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-lg shadow dark:border dark:bg-gray-800 dark:border-gray-700">
      <div class="p-6 space-y-6">

        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">
          Sign in to your account
        </h1>

        <form class="space-y-4" @submit.prevent="submit">

          <!-- Email -->
          <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Your email
            </label>
            <input
              v-model="email"
              type="email"
              id="email"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg
                     focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5
                     dark:bg-gray-700 dark:border-gray-600 dark:text-white"
              placeholder="name@example.com"
              required
            />
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Password
            </label>
            <input
              v-model="password"
              type="password"
              id="password"
              placeholder="••••••••"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg
                     focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5
                     dark:bg-gray-700 dark:border-gray-600 dark:text-white"
              required
            />
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
            <span v-if="loading">Signing in...</span>
            <span v-else>Sign in</span>
          </button>

          <p class="text-sm font-light text-gray-500 dark:text-gray-400">
            Don’t have an account yet?
            <router-link to="/register" class="font-medium text-blue-600 hover:underline">
              Sign up
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
import { useAuthStore } from "../stores/auth";

const email = ref("test@example.com");
const password = ref("password");
const loading = ref(false);
const error = ref(null);

const router = useRouter();
const auth = useAuthStore();

async function submit() {
  loading.value = true;
  error.value = null;

  try {
    await auth.login({
      email: email.value,
      password: password.value,
    });

    router.push("/"); // redirect to tasks page
  } catch (e) {
    error.value = "Invalid email or password.";
  }

  loading.value = false;
}
</script>
