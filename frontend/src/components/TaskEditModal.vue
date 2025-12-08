<template>
  <div
    v-if="visible"
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-base border w-full max-w-md shadow-sm">

      <h2 class="text-lg font-semibold mb-4">Edit Task</h2>

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

      <!-- Form Loaded -->
      <form v-else @submit.prevent="submit">

        <label class="block mb-1">Title</label>
        <input
          v-model="form.title"
          required
          class="w-full border rounded-base px-3 py-2 mb-3"
        />

        <label class="block mb-1">Description</label>
        <textarea
          v-model="form.description"
          class="w-full border rounded-base px-3 py-2 mb-3"
        ></textarea>

        <label class="block mb-1">Status</label>
        <select
          v-model="form.status"
          class="w-full border rounded-base px-3 py-2 mb-3"
        >
          <option value="0">Incomplete</option>
          <option value="1">Complete</option>
          <option value="2">Canceled</option>
        </select>

        <div class="flex justify-end mt-4 gap-2">
          <button
            @click="$emit('close')"
            type="button"
            class="px-4 py-2 border rounded-base"
          >
            Cancel
          </button>

          <button
            type="submit"
            class="px-4 py-2 bg-brand text-white rounded-base"
          >
            Update
          </button>
        </div>

      </form>

    </div>
  </div>
</template>

<script setup>
import { reactive, ref, watch } from "vue";
import api from "../api/axios";

const props = defineProps({
  visible: Boolean,
  taskId: Number,
});

const emit = defineEmits(["close", "saved"]);

const loading = ref(false);

const form = reactive({
  title: "",
  description: "",
  status: 0,
});

// Load task from show API when modal opens
watch(
  () => props.visible,
  async (isOpen) => {
    if (isOpen && props.taskId) {
      loading.value = true;

      const res = await api.get(`/tasks/${props.taskId}`);
      const task = res.data.data ?? res.data;

      form.title = task.title;
      form.description = task.description;
      form.status = task.status;

      loading.value = false;
    }
  }
);

async function submit() {
  await api.put(`/tasks/${props.taskId}`, form);
  emit("close");
  emit("saved");
}
</script>
