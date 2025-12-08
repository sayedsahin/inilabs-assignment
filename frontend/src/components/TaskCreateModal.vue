<template>
  <div
    v-if="visible"
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-base border w-full max-w-md shadow-sm">
      <h2 class="text-lg font-semibold mb-4">Add New Task</h2>

      <form @submit.prevent="submit">

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

        <div class="flex justify-end gap-2 mt-4">
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
            Save
          </button>
        </div>

      </form>

    </div>
  </div>
</template>

<script setup>
import { reactive } from "vue";
import api from "../api/axios";

const props = defineProps({
  visible: Boolean,
});

const emit = defineEmits(["close", "saved"]);

const form = reactive({
  title: "",
  description: "",
  status: 0,
});

async function submit() {
  await api.post("/tasks", form);
  emit("close");
  emit("saved");
}
</script>
