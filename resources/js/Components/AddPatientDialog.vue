<script setup lang="ts">
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import FloatLabel from 'primevue/floatlabel'
import Calendar from 'primevue/calendar'
import { Ref } from 'vue'
import { Patient } from '@/types/patient'
import { ref } from 'vue'
import { usePatientStore } from '@/stores/patient'

const patientStore = usePatientStore()
const { addPatient } = patientStore

const visible = defineModel<boolean>('visible')

const emptyPatientData = {
  lastName: null,
  firstName: null,
  middleName: null,
  suffixName: null,
  birthDate: null,
  address: null
}
const patientData: Ref<Patient> = ref({ ...emptyPatientData })

const resetPatientData = (): void => {
  patientData.value = { ...emptyPatientData }
}

const cancelPatientCreation = (): void => {
  visible.value = false
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
    @hide="resetPatientData"
  >
    <span class="text-[--surface-500]">Provide complete patient Information.</span>
    <div class="flex flex-col gap-2 pt-2 sm:flex-row">
      <FloatLabel class="mt-6">
        <InputText v-model="patientData.lastName" class="w-full" name="lastName" autofocus />
        <label for="lastName">Last Name</label>
      </FloatLabel>
      <FloatLabel class="mt-6">
        <InputText v-model="patientData.firstName" class="w-full" name="firstName" autofocus />
        <label for="firstName">First Name</label>
      </FloatLabel>
      <FloatLabel class="mt-6">
        <InputText v-model="patientData.middleName" class="w-full" name="middleName" autofocus />
        <label for="middleName">Middle Name</label>
      </FloatLabel>
      <FloatLabel class="mt-6">
        <InputText v-model="patientData.suffixName" class="w-32" name="suffixName" autofocus />
        <label for="suffixName">Suffix Name</label>
      </FloatLabel>
    </div>

    <div class="mt-4 flex flex-col gap-2 sm:flex-row [&>*]:flex-1">
      <FloatLabel class="mt-6">
        <Calendar v-model="patientData.birthDate" class="w-full" name="birthDate" autofocus />
        <label for="birthDate">Date of Birth</label>
      </FloatLabel>

      <FloatLabel class="mt-6">
        <InputText v-model="patientData.address" class="w-full" name="address" autofocus />
        <label for="address">Address</label>
      </FloatLabel>
    </div>

    <template #footer>
      <Button label="Cancel" type="button" severity="secondary" @click="cancelPatientCreation" />
      <Button label="Save" type="submit" severity="success" @click="addPatient(patientData)" />
    </template>
  </Dialog>
</template>
