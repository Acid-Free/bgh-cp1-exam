<script setup lang="ts">
import AddPatientDialog from '@/Components/AddPatientDialog.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { useConfirm } from 'primevue/useconfirm'
import Button from 'primevue/button'
import Column from 'primevue/column'
import DataTable from 'primevue/datatable'
import { Ref, onMounted } from 'vue'
import { ref } from 'vue'
import ConfirmDialog from 'primevue/confirmdialog'
import UpdatePatientDialog from '@/Components/UpdatePatientDialog.vue'
import { Patient } from '@/types/patient'
import { formatName } from '@/Helpers/names'
import { formatDate } from '@/Helpers/time'
import { usePatientStore } from '@/stores/patient'
import { storeToRefs } from 'pinia'
import DatetimeTag from '@/Components/DatetimeTag.vue'
import Toast from 'primevue/toast'
import { useToast } from 'primevue/usetoast'
import { AxiosError } from 'axios'

const toast = useToast()

const patientStore = usePatientStore()
const { fetchPatients, deletePatient } = patientStore
const { patients } = storeToRefs(patientStore)

onMounted(() => {
  fetchPatients()
})

const addPatientToggled: Ref<boolean> = ref(false)
const toggleAddPatient = (): void => {
  addPatientToggled.value = !addPatientToggled.value
}

// patient info of last selected row for update in dashboard
const lastUpdatePatientInfo: Ref<Patient | {}> = ref({})
const updatePatientToggled: Ref<boolean> = ref(false)
// Only needs patientInfo argument if toggling on
const toggleUpdatePatient = (patientInfo?: Patient): void => {
  if (patientInfo) lastUpdatePatientInfo.value = patientInfo

  updatePatientToggled.value = !updatePatientToggled.value
}

const confirm = useConfirm()
const deletePatientConfirm = (patientId: number, acceptCallback: (id: number) => any): void => {
  const message = 'Are you sure you want to delete this patient?'

  confirm.require({
    message,
    header: 'Delete Confirmation',
    icon: 'pi pi-exclamation-triangle',
    rejectClass: 'p-button-secondary p-button-outlined',
    acceptClass: 'p-button-danger p-button-outlined',
    rejectLabel: 'Cancel',
    acceptLabel: 'Delete',
    accept: async () => {
      try {
        await acceptCallback(patientId)
        fetchPatients()
      } catch (error) {
        if (error instanceof AxiosError) {
          toast.add({
            severity: 'error',
            summary: 'Patient Deletion Error',
            detail: error?.response?.data.error,
            life: 5000
          })
        }
      }
    }
  })
}
</script>

<template>
  <Toast />
  <Head title="Patient Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Patient Dashboard
      </h2>
    </template>

    <Button label="Add Patient" icon="pi pi-plus" @click="toggleAddPatient" />

    <DataTable
      :value="patients"
      data-key="id"
      :pt="{
        root: 'mt-4'
      }"
      paginator
      :rows="10"
      :rows-per-page-options="[10, 50, 200, 1000]"
      paginator-template="PageLinks RowsPerPageDropdown"
    >
      <Column field="lastName" header="Name">
        <template #body="{ data }">
          {{ formatName(data.lastName, data.firstName, data.middleName, data.suffixName) }}
        </template>
      </Column>
      <Column field="dateOfBirth" header="Date of Birth">
        <template #body="{ data }">
          <DatetimeTag :date="formatDate(data.birthDate)" />
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
              class="h-6"
              @click="toggleUpdatePatient(data)"
            />
            <Button
              v-tooltip.left="'Delete Patient'"
              icon="pi pi-trash"
              severity="danger"
              text
              class="h-6"
              @click="
                () => {
                  deletePatientConfirm(data.id, deletePatient)
                }
              "
            />
          </div>
        </template>
      </Column>
    </DataTable>
  </AuthenticatedLayout>

  <ConfirmDialog />
  <AddPatientDialog
    v-model:visible="addPatientToggled"
    @added="
      () => {
        fetchPatients()
        toggleAddPatient()
      }
    "
  />
  <UpdatePatientDialog
    v-model:visible="updatePatientToggled"
    :update-patient-info="lastUpdatePatientInfo as Patient"
    @updated="
      () => {
        fetchPatients()
        toggleUpdatePatient()
      }
    "
  />
</template>
