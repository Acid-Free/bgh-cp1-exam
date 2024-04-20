<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Admission } from '@/types/admission'
import { Head } from '@inertiajs/vue3'
import Column from 'primevue/column'
import ConfirmDialog from 'primevue/confirmdialog'
import DataTable from 'primevue/datatable'
import { useConfirm } from 'primevue/useconfirm'
import { ref } from 'vue'
import { Ref } from 'vue'
import { formatName } from '@/Helpers/names'
import { formatDate, formatDatetime } from '@/Helpers/time'
import Calendar from 'primevue/calendar'
import AddAdmissionDialog from '@/Components/AddAdmissionDialog.vue'

const dashboardAdmissionDate: Ref<Date> = ref(new Date())
const admissions: Ref<Admission[]> = ref([
  {
    id: 3,
    patientLastName: 'Patient 2',
    patientFirstName: 'Bob',
    patientMiddleName: 'Test',
    patientSuffixName: 'III',
    ward: 'Random Ward Name',
    admissionDatetime: new Date(),
    dischargeDatetime: null
  },
  {
    id: 4,
    patientLastName: 'Patient 21',
    patientFirstName: 'Bob',
    patientMiddleName: 'Test',
    patientSuffixName: 'IV',
    ward: 'Random Ward Name',
    admissionDatetime: new Date(),
    dischargeDatetime: new Date()
  }
])

const addAdmissionToggled: Ref<boolean> = ref(false)
const toggleAddAdmission = (): void => {
  addAdmissionToggled.value = !addAdmissionToggled.value
}

const confirm = useConfirm()
const deleteAdmissionConfirm = (acceptCallback: () => void): void => {
  const message = 'Are you sure you want to delete this admission?'

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
const deleteAdmission = (): void => {
  // TODO: Add delete functionality
}
</script>

<template>
  <Head title="Admission Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Admission Dashboard
      </h2>
    </template>
    <div class="flex flex-col gap-4 sm:flex-row sm:justify-between">
      <Button label="Add Admission" icon="pi pi-plus" @click="toggleAddAdmission" />
      <Calendar v-model="dashboardAdmissionDate" />
    </div>
    <DataTable :value="admissions" data-key="id" :pt="{ root: 'mt-4' }">
      <Column field="patientLastName" header="Name">
        <template #body="{ data }">
          {{
            formatName(
              data.patientLastName,
              data.patientFirstName,
              data.patientMiddleName,
              data.patientSuffixName
            )
          }}
        </template>
      </Column>
      <Column field="ward" header="Ward"></Column>
      <Column field="admissionDatetime" header="Admission Datetime">
        <template #body="{ data }"> {{ formatDate(data.admissionDatetime) }}</template>
      </Column>
      <Column field="dischargeDatetime" header="Status">
        <template #body="{ data }">
          {{
            data.dischargeDatetime === null
              ? 'Active'
              : `Discharged on ${formatDatetime(data.dischargeDatetime)}`
          }}
        </template>
      </Column>
      <Column header="Action" :pt="{ headerTitle: 'text-center w-full', headerCell: 'w-1/12' }">
        <template #body>
          <div class="flex justify-center gap-8">
            <Button
              v-tooltip.left="'Delete Patient'"
              icon="pi pi-trash"
              severity="danger"
              text
              @click="deleteAdmissionConfirm(deleteAdmission)"
            />
          </div>
        </template>
      </Column>
    </DataTable>
  </AuthenticatedLayout>

  <ConfirmDialog />
  <AddAdmissionDialog v-model:visible="addAdmissionToggled" />
</template>
