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
import UpdatePatientDialog from '@/Components/UpdatePatientDialog.vue'
import { Patient } from '@/types/patient'
import { formatName } from '@/Helpers/names'
import { formatDate } from '@/Helpers/time'

const patients: Ref<Patient[]> = ref([
  {
    id: 1,
    lastName: 'Patient 1',
    firstName: 'Bob',
    middleName: null,
    suffixName: null,
    birthDate: new Date(),
    address: 'Address here 1'
  },
  {
    id: 2,
    lastName: 'Patient 2',
    firstName: 'Bob',
    middleName: 'Yo',
    suffixName: 'sr',
    birthDate: new Date(),
    address: 'Address here 2'
  },
  {
    id: 5,
    lastName: 'Patient 3',
    firstName: 'Bob',
    middleName: 'Yo',
    suffixName: 'jr',
    birthDate: new Date(),
    address: 'Address here 3'
  },
  {
    id: 6,
    lastName: 'Patient 4',
    firstName: 'Bob',
    middleName: 'Yo',
    suffixName: 'jr',
    birthDate: new Date(),
    address: 'Address here 4'
  }
])

const addPatientToggled: Ref<boolean> = ref(false)
const toggleAddPatient = (): void => {
  addPatientToggled.value = !addPatientToggled.value
}

// patient info of last selected row for update in dashboard
const lastUpdatePatientInfo: Ref<Patient | {}> = ref({})
const updatePatientToggled: Ref<boolean> = ref(false)
const toggleUpdatePatient = (patientInfo: Patient): void => {
  lastUpdatePatientInfo.value = patientInfo

  updatePatientToggled.value = !updatePatientToggled.value
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
    acceptLabel: 'Delete',
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

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Patient Dashboard
      </h2>
    </template>

    <Button label="Add Patient" icon="pi pi-plus" @click="toggleAddPatient" />

    <DataTable :value="patients" data-key="id" :pt="{ root: 'mt-4' }">
      <Column field="lastName" header="Name">
        <template #body="{ data }">
          {{ formatName(data.lastName, data.firstName, data.middleName, data.suffixName) }}
        </template>
      </Column>
      <Column field="dateOfBirth" header="Date of Birth">
        <template #body="{ data }">
          {{ formatDate(data.birthDate) }}
        </template>
      </Column>
      <Column field="address" header="Address"></Column>
      <Column header="Actions" :pt="{ headerTitle: 'text-center w-full', headerCell: 'w-1/12' }">
        <template #body="{ data }">
          <div class="flex justify-center gap-8">
            <Button
              v-tooltip.left="'Update Patient'"
              icon="pi pi-pen-to-square"
              text
              @click="toggleUpdatePatient(data)"
            />
            <Button
              v-tooltip.left="'Delete Patient'"
              icon="pi pi-trash"
              severity="danger"
              text
              @click="deletePatientConfirm(deletePatient)"
            />
          </div>
        </template>
      </Column>
    </DataTable>
  </AuthenticatedLayout>

  <ConfirmDialog />
  <AddPatientDialog v-model:visible="addPatientToggled" />
  <UpdatePatientDialog
    v-model:visible="updatePatientToggled"
    :update-patient-info="lastUpdatePatientInfo as Patient"
  />
</template>
