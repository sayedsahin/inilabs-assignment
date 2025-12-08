<template>
  <div
    v-if="visible"
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-base border w-full max-w-md shadow-sm relative">

      <h2 class="text-lg font-semibold mb-4">Task Details</h2>

      <!-- Spinner -->
      <div v-if="loading" class="text-center py-10">
        <svg
          class="animate-spin h-8 w-8 text-brand mx-auto"
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
            d="M4 12a8 8 0 018-8V0C5.373
              0 0 5.373 0 12h4z"
          ></path>
        </svg>
      </div>

      <!-- Task Details -->
      <div v-else>
        <p><b>Title:</b> {{ task.title }}</p>
        <p><b>Status:</b> {{ task.status_label }}</p>

        <p class="mt-2 whitespace-pre-wrap">
          <b>Description:</b><br />
          {{ task.description }}
        </p>
      </div>

      <div class="text-right mt-6">
        <button @click="close" class="px-4 py-2 border rounded-base">
          Close
        </button>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import api from "../api/axios";

const props = defineProps({
  visible: Boolean,
  taskId: Number,
});

const emit = defineEmits(["close"]);

const loading = ref(false);
const task = ref({});

// Load task from show API when modal opens
watch(
  () => props.visible,
  async (isOpen) => {
    if (isOpen && props.taskId) {
      loading.value = true;
      const res = await api.get(`/tasks/${props.taskId}`);
      task.value = res.data.data ?? res.data;
      loading.value = false;
    }
  }
);

function close() {
  emit("close");
}
</script>
