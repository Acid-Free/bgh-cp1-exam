<script setup lang="ts">
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import FloatLabel from 'primevue/floatlabel'
import Calendar from 'primevue/calendar'
import { Ref } from 'vue'
import { ref } from 'vue'
import { DischargeAdmissionFormData } from '@/types/admission'
import { useAdmisionStore } from '@/stores/admission'

const admissionStore = useAdmisionStore()
const { dischargeAdmission } = admissionStore

const visible = defineModel<boolean>('visible')
const props = defineProps<{ admissionId: number | null }>()

const admission: Ref<DischargeAdmissionFormData> = ref({
  id: props.admissionId,
  dischargeDatetime: null
})

const refreshAdmissionData = (): void => {
  admission.value.id = props.admissionId
  admission.value.dischargeDatetime = new Date()
}

const dischargeDatetime: Ref<Date | null> = ref(null)

const resetDischargeAdmission = (): void => {
  dischargeDatetime.value = null
}

const cancelAdmissionDischarge = (): void => {
  visible.value = false
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
    @show="refreshAdmissionData"
    @hide="resetDischargeAdmission"
  >
    <span class="text-[--surface-500]">Provide discharge information.</span>

    <div class="pt-2">
      <FloatLabel class="mt-6">
        <Calendar
          v-model="admission.dischargeDatetime"
          class="w-full"
          name="dischargeDatetime"
          autofocus
          show-time
          hour-format="12"
        />
        <label for="dischargeDatetime">Discharge Datetime</label>
      </FloatLabel>
    </div>

    <template #footer>
      <Button label="Cancel" type="button" severity="secondary" @click="cancelAdmissionDischarge" />
      <Button
        label="Discharge"
        type="submit"
        severity="danger"
        @click="dischargeAdmission(admission)"
      />
    </template>
  </Dialog>
</template>
