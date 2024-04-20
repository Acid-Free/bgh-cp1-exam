<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import Button from 'primevue/button'
import Column from 'primevue/column'
import DataTable from 'primevue/datatable'
import { ref } from 'vue'

const patients = ref([
  { id: 'P001', name: 'Patient 1', dateOfBirth: 'dateOfBirth A', address: 'Address here' },
  { id: 'P002', name: 'Patient 2', dateOfBirth: 'dateOfBirth B', address: 'Address here' },
  { id: 'P003', name: 'Patient 3', dateOfBirth: 'dateOfBirth A', address: 'Address here' },
  { id: 'P004', name: 'Patient 4', dateOfBirth: 'dateOfBirth C', address: 'Address here' }
])
</script>

<template>
  <Head title="Patient Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Patient Dashboard
      </h2>
    </template>

    <DataTable
      :value="patients"
      @row-click="(event) => console.log(event.data.id)"
      :pt="{ bodyRow: 'cursor-pointer' }"
    >
      <Column field="name" header="Name"></Column>
      <Column field="dateOfBirth" header="Date of Birth"></Column>
      <Column field="address" header="Address"></Column>
      <Column header="Actions" :pt="{ headerTitle: 'text-center w-full', headerCell: 'w-1/12' }">
        <template #body>
          <div class="flex justify-center gap-8">
            <Button v-tooltip.left="'Edit Patient'" icon="pi pi-pen-to-square" text @click="" />
            <Button
              v-tooltip.left="'Delete Patient'"
              icon="pi pi-trash"
              severity="danger"
              text
              @click=""
            />
          </div>
        </template>
      </Column>
    </DataTable>
  </AuthenticatedLayout>
</template>
