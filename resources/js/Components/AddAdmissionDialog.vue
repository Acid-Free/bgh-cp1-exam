<script setup lang="ts">
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import FloatLabel from 'primevue/floatlabel'
import Calendar from 'primevue/calendar'
import Stepper from 'primevue/stepper'
import StepperPanel from 'primevue/stepperpanel'
import { Ref, reactive } from 'vue'
import { ref } from 'vue'
import { Admission } from '@/types/admission'
import { Patient } from '@/types/patient'
import { formatName } from '@/Helpers/names'
import { formatDate } from '@/Helpers/time'
import Column from 'primevue/column'

const visible = defineModel<boolean>('visible')

const emptyAdmission = {
  patientLastName: null,
  patientFirstName: null,
  patientMiddleName: null,
  patientSuffixName: null,

  ward: null,
  admissionDatetime: null,
  dischargeDatetime: null
}
const admission: Ref<Admission> = ref({ ...emptyAdmission })

const resetAdmission = (): void => {
  admission.value = { ...emptyAdmission }
}

const cancelAdmissionCreation = (): void => {
  visible.value = false
}

type AdmissionFormData = {
  patientId: number | null
  ward: string | null
  admissionDatetime: Date | null
}
const admissionFormData: AdmissionFormData = reactive({
  patientId: null,
  ward: null,
  admissionDatetime: new Date()
})

const saveAdmission = (): void => {
  // TODO: Save admission
  console.log('Save admission')
}

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
</script>

<template>
  <Dialog
    v-model:visible="visible"
    header="Add Admission"
    modal
    closable
    close-on-escape
    dismissable-mask
    @hide="resetAdmission"
  >
    <Stepper orientatsion="vertical" linear>
      <StepperPanel header="Select Patient">
        <template #content="{ nextCallback }">
          <DataTable
            :value="patients"
            data-key="id"
            :pt="{ root: 'mt-4', bodyRow: 'cursor-pointer hover:bg-blue-600/[.05]' }"
            @row-click="
              (event) => {
                console.log(event.data)
                nextCallback(event.originalEvent)
              }
            "
          >
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
