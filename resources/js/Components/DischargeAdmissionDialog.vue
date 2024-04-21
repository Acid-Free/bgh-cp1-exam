<script setup lang="ts">
import Dialog from 'primevue/dialog'
import FloatLabel from 'primevue/floatlabel'
import Calendar from 'primevue/calendar'
import { Ref } from 'vue'
import { ref } from 'vue'
import { DischargeAdmissionFormData } from '@/types/admission'
import { useAdmisionStore } from '@/stores/admission'
import { AxiosError } from 'axios'
import Message from 'primevue/message'

const admissionStore = useAdmisionStore()
const { dischargeAdmission } = admissionStore

// Loading flag for form process
const formProcessing = ref(false)

// Used by Message component for showing errors
const errorMessages = ref([])

const visible = defineModel<boolean>('visible')
const props = defineProps<{ admissionId: number | null }>()
const emits = defineEmits(['admission-discharged'])

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
  errorMessages.value = []
  dischargeDatetime.value = null
}

const cancelAdmissionDischarge = (): void => {
  visible.value = false
}

const attemptDischargeAdmission = async (): Promise<void> => {
  try {
    errorMessages.value = []
    formProcessing.value = true

    await dischargeAdmission(admission.value)

    emits('admission-discharged')
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

    <Message v-for="(message, index) of errorMessages" :key="index" severity="error">
      {{ message }}
    </Message>

    <template #footer>
      <Button label="Cancel" type="button" severity="secondary" @click="cancelAdmissionDischarge" />
      <Button
        label="Discharge"
        type="submit"
        severity="danger"
        @click="attemptDischargeAdmission"
      />
    </template>
  </Dialog>
</template>
