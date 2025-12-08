<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../stores/auth";

const auth = useAuthStore();
const router = useRouter();
const isOpen = ref(false);

function toggleMenu() {
  isOpen.value = !isOpen.value;
}

async function logout() {
  await auth.logout();
  router.push("/login");
}
</script>

<template>
  <nav class="bg-neutral-primary  w-full z-20 border-b border-default">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

      <!-- Logo -->
      <router-link to="/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="@/assets/logo.png" class="h-7" alt="Logo" />
        <span class="self-center text-xl text-heading font-semibold whitespace-nowrap">
          Tasks
        </span>
      </router-link>

      <!-- Mobile Menu Button -->
      <button
        @click="toggleMenu"
        type="button"
        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden
               hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary"
        aria-controls="navbar-default"
      >
        <span class="sr-only">Open main menu</span>
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
            d="M5 7h14M5 12h14M5 17h14" />
        </svg>
      </button>

      <!-- Menu Items -->
      <div
        :class="['w-full md:w-auto', isOpen ? 'block' : 'hidden', 'md:block']"
        id="navbar-default"
      >
        <ul
          class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft
                 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-neutral-primary"
        >

          <!-- Login & Register (Guest Only) -->
          <template v-if="!auth.isAuthenticated">
            <li>
              <router-link
                to="/login"
                class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary
                       md:hover:bg-transparent md:hover:text-fg-brand md:p-0"
              >
                Login
              </router-link>
            </li>
            <li>
              <router-link
                to="/register"
                class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary
                       md:hover:bg-transparent md:hover:text-fg-brand md:p-0"
              >
                Register
              </router-link>
            </li>
          </template>

          <!-- Logout (Only Auth Users) -->
          <li v-else>
            <button
              @click="logout"
              class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary
                     md:hover:bg-transparent md:hover:text-fg-brand md:p-0"
            >
              Logout
            </button>
          </li>

        </ul>
      </div>
    </div>
  </nav>
</template>


