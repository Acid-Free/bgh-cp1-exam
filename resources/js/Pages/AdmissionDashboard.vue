<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Admission } from '@/types/admission'
import { Head } from '@inertiajs/vue3'
import Column from 'primevue/column'
import ConfirmDialog from 'primevue/confirmdialog'
import DataTable from 'primevue/datatable'
import { onMounted, ref, watch } from 'vue'
import { Ref } from 'vue'
import { formatName } from '@/Helpers/names'
import { formatDate, formatDatetime } from '@/Helpers/time'
import Calendar from 'primevue/calendar'
import AddAdmissionDialog from '@/Components/AddAdmissionDialog.vue'
import DischargeAdmissionDialog from '@/Components/DischargeAdmissionDialog.vue'
import { useAdmisionStore } from '@/stores/admission'
import { storeToRefs } from 'pinia'

const admissionStore = useAdmisionStore()
const { fetchAdmissions } = admissionStore
const { admissions } = storeToRefs(admissionStore)
const dashboardAdmissionDate: Ref<Date> = ref(new Date())
onMounted(() => {
  fetchAdmissions(dashboardAdmissionDate.value)
})

watch(dashboardAdmissionDate, () => {
  fetchAdmissions(dashboardAdmissionDate.value)
})

const addAdmissionToggled: Ref<boolean> = ref(false)
const toggleAddAdmission = (): void => {
  addAdmissionToggled.value = !addAdmissionToggled.value
}

// Last selected admission entry id
const lastAdmissionId: Ref<number | null> = ref(null)
const dischargeAdmissionToggled: Ref<boolean> = ref(false)
// Only needs admissionId argument when toggling on
const toggleDischargeAdmission = (admissionId?: number): void => {
  if (admissionId) lastAdmissionId.value = admissionId

  dischargeAdmissionToggled.value = !dischargeAdmissionToggled.value
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
        <template #body="{ data }"> {{ formatDatetime(data.admissionDatetime) }}</template>
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
        <template #body="{ data }">
          <div class="flex justify-center gap-8">
            <Button
              v-if="data.dischargeDatetime === null"
              v-tooltip.left="'Discharge Admission'"
              icon="pi pi-receipt"
              severity="danger"
              text
              class="h-6"
              @click="toggleDischargeAdmission(data.id)"
            />
          </div>
        </template>
      </Column>
    </DataTable>
  </AuthenticatedLayout>

  <ConfirmDialog />
  <AddAdmissionDialog
    v-model:visible="addAdmissionToggled"
    @admission-added="
      () => {
        fetchAdmissions(dashboardAdmissionDate)
        toggleAddAdmission()
      }
    "
  />
  <DischargeAdmissionDialog
    v-model:visible="dischargeAdmissionToggled"
    :admission-id="lastAdmissionId"
    @admission-discharged="
      () => {
        fetchAdmissions(dashboardAdmissionDate)
        toggleDischargeAdmission()
      }
    "
  />
</template>
