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
