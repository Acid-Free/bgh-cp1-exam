<script setup lang="ts">
import AddPatientDialog from '@/Components/AddPatientDialog.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { useConfirm } from 'primevue/useconfirm'
import Button from 'primevue/button'
import Column from 'primevue/column'
import DataTable from 'primevue/datatable'
import { Ref } from 'vue'
import { ref } from 'vue'
import ConfirmDialog from 'primevue/confirmdialog'

const patients = ref([
  { id: 'P001', name: 'Patient 1', dateOfBirth: 'dateOfBirth A', address: 'Address here' },
  { id: 'P002', name: 'Patient 2', dateOfBirth: 'dateOfBirth B', address: 'Address here' },
  { id: 'P003', name: 'Patient 3', dateOfBirth: 'dateOfBirth A', address: 'Address here' },
  { id: 'P004', name: 'Patient 4', dateOfBirth: 'dateOfBirth C', address: 'Address here' }
])

const editPatientToggled: Ref<boolean> = ref(false)
const toggleEditPatient = (): void => {
  editPatientToggled.value = !editPatientToggled.value
}

const confirm = useConfirm()
const deletePatientConfirm = (acceptCallback: () => void): void => {
  const message = 'Are you sure you want to delete this patient?'

  confirm.require({
    message,
    header: 'Delete Confirmation',
    icon: 'pi pi-exclamation-triangle',
    rejectClass: 'p-button-secondary p-button-outlined',
    acceptClass: 'p-button-danger p-butotn-outlined',
    rejectLabel: 'Cancel',
    acceptLabel: 'Save',
    accept: () => {
      acceptCallback()
    }
  })
}

const deletePatient = (): void => {
  // TODO: Add delete functionality
  console.log('Delete patient')
}
</script>

<template>
  <Head title="Patient Dashboard" />

  <ConfirmDialog />
  <AddPatientDialog v-model:visible="editPatientToggled" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Patient Dashboard
      </h2>
    </template>

    <Button label="Add Patient" icon="pi pi-plus" class="mb-2" @click="toggleEditPatient" />

    <DataTable :value="patients">
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
              @click="
                () => {
                  deletePatientConfirm(deletePatient)
                }
              "
            />
          </div>
        </template>
      </Column>
    </DataTable>
  </AuthenticatedLayout>
</template>
