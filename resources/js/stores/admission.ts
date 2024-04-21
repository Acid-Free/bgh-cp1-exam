import { Admission, AdmissionFormData, DischargeAdmissionFormData } from '@/types/admission'
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

  const addAdmission = async (admissionData: AdmissionFormData): Promise<void> => {
    const response = await axios.post(route('admission.add'), admissionData)

    console.log(response.data)
  }

  const dischargeAdmission = async (admissionData: DischargeAdmissionFormData): Promise<void> => {
    const response = await axios.post(route('admission.discharge'), admissionData)

    console.log(response)
  }

  return { admissions, fetchAdmissions, addAdmission, dischargeAdmission }
})
