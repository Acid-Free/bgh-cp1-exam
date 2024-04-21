import { Admission } from '@/types/admission'
import axios from 'axios'
import { defineStore } from 'pinia'
import { Ref, ref } from 'vue'

export const useAdmisionStore = defineStore('admission', () => {
  const admissions: Ref<Admission[] | null> = ref(null)

  /** Obtain latest admission list from backend to update `admissions` */
  const fetchAdmissions = async (admissionDate: Date): Promise<void> => {
    const response = await axios.get(route('admission.all.day', { admissionDate }))

    admissions.value = response.data
  }

  return { admissions, fetchAdmissions }
})
