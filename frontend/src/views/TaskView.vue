<template>
  <div>
    <!-- Nav Bar -->
     <NavigationBar/>
    <div class="p-6 max-w-5xl mx-auto">

      <!-- Table Header -->
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-heading">Tasks</h2>

        <button
          @click="openCreateModal"
          class="text-white bg-brand px-4 py-2 rounded-base"
        >
          + Add Task
        </button>
      </div>

      <!-- Table -->
      <div class="relative overflow-x-auto bg-neutral-primary-soft border border-default rounded-base shadow-xs">
        <table class="w-full text-sm text-left text-body">
          <thead class="bg-neutral-secondary-medium border-b border-default-medium">
            <tr>
              <th class="px-6 py-3">Title</th>
              <th class="px-6 py-3">Status</th>
              <th class="px-6 py-3">Created</th>
              <th class="px-6 py-3">Actions</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="task in tasks.data"
              :key="task.id"
              class="border-b border-default hover:bg-neutral-secondary-medium"
            >
              <td class="px-6 py-4">{{ task.title }}</td>

              <td class="px-6 py-4">
                {{ task.status_label }}
              </td>

              <td class="px-6 py-4">
                {{ task.created_at }}
              </td>

              <td class="px-6 py-4 space-x-3">
                <button
                  class="text-blue-600 hover:underline"
                  @click="openViewModal(task)"
                >
                  View
                </button>

                <button
                  class="text-green-600 hover:underline"
                  @click="openEditModal(task)"
                >
                  Edit
                </button>

                <button
                  class="text-red-600 hover:underline"
                  @click="deleteTask(task.id)"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-if="loading" class="p-4 text-center">Loading...</div>
      </div>

      <!-- Pagination -->
      <div v-if="tasks.meta" class="flex justify-between items-center mt-5">

        <span>
          Showing <b>{{ tasks.meta.from }}</b> - <b>{{ tasks.meta.to }}</b> of
          <b>{{ tasks.meta.total }}</b>
        </span>

        <ul class="flex items-center gap-1">

          <!-- Loop Laravel Meta Links -->
          <li
            v-for="(link, i) in tasks.meta.links"
            :key="i"
          >
            <button
              v-if="link.page"
              @click="load(link.page)"
              class="px-3 h-9 rounded-base border"
              :class="link.active
                ? 'bg-brand-softer text-fg-brand border-brand'
                : 'bg-neutral-secondary-medium hover:bg-neutral-tertiary-medium'"
            >
              {{ stripHtml(link.label) }}
            </button>

            <!-- Disabled buttons (Prev/Next when null page) -->
            <button
              v-else
              disabled
              class="px-3 h-9 rounded-base border bg-neutral-secondary-medium opacity-50"
            >
              {{ stripHtml(link.label) }}
            </button>
          </li>

        </ul>
      </div>


      <!-- Modals -->
      <TaskViewModal
        :visible="showViewModal"
        :taskId="selectedTaskId"
        @close="showViewModal = false"
      />

      <TaskCreateModal
        :visible="showCreateModal"
        @close="showCreateModal = false"
        @saved="reload"
      />

      <TaskEditModal
        :visible="showEditModal"
        :taskId="selectedTaskId"
        @close="showEditModal = false"
        @saved="reload"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../api/axios";

import NavigationBar from "../components/NavigationBar.vue";
import TaskViewModal from "../components/TaskViewModal.vue";
import TaskCreateModal from "../components/TaskCreateModal.vue";
import TaskEditModal from "../components/TaskEditModal.vue";

const tasks = ref({});
const loading = ref(true);
const selectedTaskId = ref(null);


// Modal states
const showViewModal = ref(false);
const showCreateModal = ref(false);
const showEditModal = ref(false);

function stripHtml(label) {
  return label.replace('&laquo; Previous', "Prev").replace('&raquo;', "").replace(/<[^>]*>?/gm, "");
}

async function load(page = 1) {
  loading.value = true;
  const res = await api.get(`/tasks?page=${page}`);
  tasks.value = res.data;
  loading.value = false;
}

function reload() {
  load(tasks.value.meta.current_page);
}

function openViewModal(task) {
  selectedTaskId.value = task.id;
  showViewModal.value = true;
}

function openCreateModal() {
  showCreateModal.value = true;
}

function openEditModal(task) {
  selectedTaskId.value = task.id;
  showEditModal.value = true;
}

async function deleteTask(id) {
  if (!confirm("Delete this task?")) return;
  await api.delete(`/tasks/${id}`);
  reload();
}

onMounted(load);
</script>
