// Client admission type
export type Admission = {
  id?: number

  patientLastName: string | null
  patientFirstName: string | null
  patientMiddleName: string | null
  patientSuffixName: string | null

  ward: string | null
  admissionDatetime: Date | null
  dischargeDatetime: Date | null
}

// Admission object to be sent to backend for entry insertion
type AdmissionFormData = {
  patientId: number | null
  ward: string | null
  admissionDatetime: Date | null
}

// Admission object to be sent to backend for discharge
type DischargeAdmissionFormData = {
  id: number | null
  dischargeDatetime: Date | null
}
