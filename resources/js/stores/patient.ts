import { Patient } from '@/types/patient'
import axios, { AxiosResponse } from 'axios'
import { defineStore } from 'pinia'
import { Ref, ref } from 'vue'

export const usePatientStore = defineStore('patient', () => {
  const patients: Ref<Patient[] | null> = ref(null)

  /** Obtain latest patients list from backend to update `patients` */
  const fetchPatients = async (): Promise<void> => {
    const response = await axios.get(route('patient.all'))

    patients.value = response.data
  }

  const addPatient = async (patientData: Patient): Promise<AxiosResponse> => {
    return await axios.post(route('patient.add'), patientData)
  }

  const updatePatient = async (patientData: Patient): Promise<AxiosResponse> => {
    return await axios.patch(route('patient.update'), patientData)
  }

  const deletePatient = async (patientId: number): Promise<AxiosResponse> => {
    return await axios.delete(route('patient.delete'), { data: { id: patientId } })
  }

  return { patients, fetchPatients, addPatient, updatePatient, deletePatient }
})
