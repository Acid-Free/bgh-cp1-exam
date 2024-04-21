import { Patient } from '@/types/patient'
import axios from 'axios'
import { defineStore } from 'pinia'
import { Ref, ref } from 'vue'

export const usePatientStore = defineStore('patient', () => {
  const patients: Ref<Patient[] | null> = ref(null)

  /** Obtain latest patients list from backend to update `patients` */
  const fetchPatients = async (): Promise<void> => {
    const response = await axios.get(route('patient.all'))

    patients.value = response.data

    // TODO: Add validation and error handling
    console.log(response)
  }

  return { patients, fetchPatients }
})
