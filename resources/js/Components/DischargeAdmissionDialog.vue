<script setup lang="ts">
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import FloatLabel from 'primevue/floatlabel'
import Calendar from 'primevue/calendar'
import { Ref } from 'vue'
import { Patient } from '@/types/patient'
import { ref } from 'vue'

const visible = defineModel<boolean>('visible')
const props = defineProps<{ admissionId: number | null }>()

const dischargeDatetime: Ref<Date | null> = ref(null)

const emptyPatientInfo = {
  lastName: null,
  firstName: null,
  middleName: null,
  suffixName: null,
  birthDate: null,
  address: null
}

const resetDischargeAdmission = (): void => {
  dischargeDatetime.value = null
}

const cancelAdmissionDischarge = (): void => {
  visible.value = false
}

const dischargeAdmission = (): void => {
  // TODO: Discharge admission
  console.log('Discharge admission')
}
</script>

<template>
  <Dialog
    v-model:visible="visible"
    header="Discharge Admission"
    modal
    closable
    close-on-escape
    dismissable-mask
    @hide="resetDischargeAdmission"
  >
    <span class="text-[--surface-500]">Provide discharge information.</span>

    <div class="pt-2">
      <FloatLabel class="mt-6">
        <Calendar v-model="dischargeDatetime" class="w-full" name="dischargeDatetime" autofocus />
        <label for="dischargeDatetime">Discharge Datetime</label>
      </FloatLabel>
    </div>

    <template #footer>
      <Button label="Cancel" type="button" severity="secondary" @click="cancelAdmissionDischarge" />
      <Button label="Discharge" type="submit" severity="danger" @click="dischargeAdmission" />
    </template>
  </Dialog>
</template>
