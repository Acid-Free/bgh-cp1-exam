<script setup lang="ts">
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import FloatLabel from 'primevue/floatlabel'
import Calendar from 'primevue/calendar'
import { Ref } from 'vue'
import { Patient } from '@/types/patient'
import { ref } from 'vue'

const visible = defineModel<boolean>('visible')

const emptyPatientInfo = {
  lastName: null,
  firstName: null,
  middleName: null,
  suffixName: null,
  birthDate: null,
  address: null
}
const patientInfo: Ref<Patient> = ref({ ...emptyPatientInfo })

const resetPatientInfo = (): void => {
  patientInfo.value = { ...emptyPatientInfo }
}

const cancelPatientCreation = (): void => {
  visible.value = false
}

const savePatient = (): void => {
  // TODO: Save patient
  console.log('Save patient')
}
</script>

<template>
  <Dialog
    v-model:visible="visible"
    header="Add Patient"
    modal
    closable
    close-on-escape
    dismissable-mask
    @hide="resetPatientInfo"
  >
    <span class="text-[--surface-500]">Provide complete patient information.</span>
    <div class="flex flex-col gap-2 pt-2 sm:flex-row">
      <FloatLabel class="mt-6">
        <InputText v-model="patientInfo.lastName" class="w-full" name="lastName" autofocus />
        <label for="lastName">Last Name</label>
      </FloatLabel>
      <FloatLabel class="mt-6">
        <InputText v-model="patientInfo.firstName" class="w-full" name="firstName" autofocus />
        <label for="firstName">First Name</label>
      </FloatLabel>
      <FloatLabel class="mt-6">
        <InputText v-model="patientInfo.middleName" class="w-full" name="middleName" autofocus />
        <label for="middleName">Middle Name</label>
      </FloatLabel>
      <FloatLabel class="mt-6">
        <InputText v-model="patientInfo.suffixName" class="w-32" name="suffixName" autofocus />
        <label for="suffixName">Suffix Name</label>
      </FloatLabel>
    </div>

    <div class="flex flex-col gap-2 sm:flex-row [&>*]:flex-1">
      <FloatLabel class="mt-6">
        <Calendar v-model="patientInfo.birthDate" class="w-full" name="birthDate" autofocus />
        <label for="birthDate">Date of Birth</label>
      </FloatLabel>

      <FloatLabel class="mt-6">
        <InputText v-model="patientInfo.address" class="w-full" name="address" autofocus />
        <label for="address">Address</label>
      </FloatLabel>
    </div>

    <template #footer>
      <Button label="Cancel" type="button" severity="secondary" @click="cancelPatientCreation" />
      <Button label="Save" type="submit" severity="success" @click="savePatient" />
    </template>
  </Dialog>
</template>
