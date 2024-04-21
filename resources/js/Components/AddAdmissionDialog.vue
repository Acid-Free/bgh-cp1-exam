<script setup lang="ts">
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import FloatLabel from 'primevue/floatlabel'
import Calendar from 'primevue/calendar'
import Stepper from 'primevue/stepper'
import StepperPanel from 'primevue/stepperpanel'
import { Ref, onMounted, reactive } from 'vue'
import { ref } from 'vue'
import { Admission, AdmissionFormData } from '@/types/admission'
import { Patient } from '@/types/patient'
import { formatName } from '@/Helpers/names'
import { formatDate } from '@/Helpers/time'
import Column from 'primevue/column'
import { usePatientStore } from '@/stores/patient'
import { storeToRefs } from 'pinia'
import { FilterMatchMode } from 'primevue/api'
import IconField from 'primevue/iconfield'
import InputIcon from 'primevue/inputicon'

const patientStore = usePatientStore()
const { fetchPatients } = patientStore
const { patients } = storeToRefs(patientStore)
const patientFilters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS }
})

onMounted(() => {
  fetchPatients()
})

const visible = defineModel<boolean>('visible')

const emptyAdmission = {
  patientId: null,
  ward: null,
  admissionDatetime: null
}
const admission: Ref<AdmissionFormData> = ref(emptyAdmission)

const refreshAdmissionDatetimeAutofill = (): void => {
  admission.value.admissionDatetime = new Date()
}

const resetAdmission = (): void => {
  admission.value = { ...emptyAdmission }
}

const cancelAdmissionCreation = (): void => {
  visible.value = false
}

const saveAdmission = (): void => {
  // TODO: Save admission
  console.log('Save admission')
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
    @show="refreshAdmissionDatetimeAutofill"
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
            @row-click="
              (event) => {
                console.log(event.data)
                nextCallback(event.originalEvent)
              }
            "
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

    <template #footer>
      <Button label="Cancel" type="button" severity="secondary" @click="cancelAdmissionCreation" />
      <Button label="Save" type="submit" severity="success" @click="saveAdmission" />
    </template>
  </Dialog>
</template>
