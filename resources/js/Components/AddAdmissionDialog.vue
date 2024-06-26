<script setup lang="ts">
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import FloatLabel from 'primevue/floatlabel'
import Calendar from 'primevue/calendar'
import Stepper from 'primevue/stepper'
import StepperPanel from 'primevue/stepperpanel'
import { Ref } from 'vue'
import { ref } from 'vue'
import { AdmissionFormData } from '@/types/admission'
import { formatName } from '@/Helpers/names'
import { formatDate } from '@/Helpers/time'
import Column from 'primevue/column'
import { usePatientStore } from '@/stores/patient'
import { storeToRefs } from 'pinia'
import { FilterMatchMode } from 'primevue/api'
import IconField from 'primevue/iconfield'
import InputIcon from 'primevue/inputicon'
import { useAdmisionStore } from '@/stores/admission'
import { DataTableRowClickEvent } from 'primevue/datatable'
import { AxiosError } from 'axios'
import Message from 'primevue/message'

const patientStore = usePatientStore()
const { fetchPatients } = patientStore
const { patients } = storeToRefs(patientStore)
const patientFilters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS }
})

const admissionStore = useAdmisionStore()
const { addAdmission } = admissionStore

// Loading flag for form process
const formProcessing = ref(false)

// Used by Message component for showing errors
const errorMessages = ref([])

const visible = defineModel<boolean>('visible')
const emits = defineEmits(['admission-added'])

const emptyAdmission = {
  patientId: null,
  ward: null,
  admissionDatetime: null
}
const admission: Ref<AdmissionFormData> = ref(emptyAdmission)

const refreshAdmissionData = (): void => {
  admission.value.admissionDatetime = new Date()

  fetchPatients()
}

const selectPatientProceed = (
  event: DataTableRowClickEvent,
  nextCallback: (event: Event) => void
): void => {
  // Assign selected patient for admission
  admission.value.patientId = event.data.id

  // Proceed to next page
  nextCallback(event.originalEvent)
}

const resetAdmission = (): void => {
  errorMessages.value = []
  admission.value = { ...emptyAdmission }
}

const cancelAdmissionCreation = (): void => {
  visible.value = false
}

const attemptAddAdmission = async (): Promise<void> => {
  try {
    errorMessages.value = []
    formProcessing.value = true

    await addAdmission(admission.value)

    emits('admission-added')
  } catch (error: unknown) {
    if (error instanceof AxiosError) {
      errorMessages.value = error?.response?.data.errors ?? [error?.response?.data.error]
    }
  } finally {
    formProcessing.value = false
  }
}
</script>

<template>
  <Dialog
    v-model:visible="visible"
    header="Add Admission"
    modal
    closable
    close-on-escape
    dismissable-mask
    @show="refreshAdmissionData"
    @hide="resetAdmission"
  >
    <Stepper orientatsion="vertical" linear>
      <StepperPanel header="Select Patient">
        <template #content="{ nextCallback }">
          <DataTable
            v-model:filters="patientFilters"
            :value="patients"
            :globalFilterFields="['lastName', 'firstName', 'middleName', 'suffixName', 'address']"
            data-key="id"
            scrollable
            scrollHeight="400px"
            :pt="{
              root: 'mt-4',
              bodyRow: 'cursor-pointer hover:bg-blue-600/[.05]',
              header: 'p-0 pb-2 flex justify-end'
            }"
            @row-click="(event) => selectPatientProceed(event, nextCallback)"
          >
            <template #header>
              <div class="justify-content-end flex">
                <IconField iconPosition="left">
                  <InputIcon>
                    <i class="pi pi-search" />
                  </InputIcon>
                  <InputText
                    v-model="patientFilters['global'].value"
                    placeholder="Keyword Search"
                  />
                </IconField>
              </div>
            </template>
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
          </DataTable>
        </template>
      </StepperPanel>
      <StepperPanel header="Provide admission details" :pt="{ content: 'ds' }">
        <template #content="{ prevCallback }">
          <div class="flex flex-col gap-2 sm:flex-row [&>*]:flex-1">
            <FloatLabel class="mt-6">
              <Calendar
                v-model="admission.admissionDatetime"
                class="w-full"
                name="admissionDatetime"
                autofocus
                show-time
                hour-format="12"
              />
              <label for="admissionDatetime">Admission Datetime</label>
            </FloatLabel>

            <FloatLabel class="mt-6">
              <InputText v-model="admission.ward" class="w-full" name="ward" autofocus />
              <label for="ward">Ward</label>
            </FloatLabel>
          </div>
          <Button
            label="Go Back"
            icon="pi pi-arrow-left"
            class="absolute mt-10"
            severity="primary"
            text
            @click="prevCallback"
          ></Button>
        </template>
      </StepperPanel>
    </Stepper>

    <Message v-for="(message, index) of errorMessages" :key="index" severity="error">
      {{ message }}
    </Message>

    <template #footer>
      <Button label="Cancel" type="button" severity="secondary" @click="cancelAdmissionCreation" />
      <Button label="Save" type="submit" severity="success" @click="attemptAddAdmission" />
    </template>
  </Dialog>
</template>
