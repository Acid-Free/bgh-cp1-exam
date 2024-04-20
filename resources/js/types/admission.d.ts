export type Admission = {
  id?: number

  patientLastName: string
  patientFirstName: string
  patientMiddleName: string | null
  patientSuffixName: string | null

  ward: string | null
  admissionDatetime: Date
  dischargeDatetime: Date | null
}
