<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import DataTable from 'primevue/datatable'
</script>

<template>
  <Head title="Admission Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Admission Dashboard
      </h2>
    </template>
    <DataTable> </DataTable>
  </AuthenticatedLayout>
</template>
