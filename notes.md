# Notes

- _italicized_ and **Misc** entries are not required

# TODOS

## Core

- [ ] Interfaces
  - [x] Patient dashboard
  - [ ] Admission dashboard
  - [x] Add patient
  - [x] Update patient
  - [x] Remove patient
  - [ ] Admit patient
    - [ ] From Patient page
    - [ ] _From Admisson page_
  - [ ] Remove admission
- [ ] Database tables
  - [ ] Patient
  - [ ] Admission
- [ ] Functions
  - [ ] _Fetch patient_
  - [ ] Add patient
  - [ ] Update patient
  - [ ] Remove patient
  - [ ] Fetch admissions for the day
  - [ ] Admit patient
    - [ ] Select patient
    - [ ] Provide admission datetime and ward
  - [ ] Discharge admission
    - [ ] Ensure admission is active
    - [ ] Provide discharge datetime
- [ ] Compliance
  - [x] Send GitHub link to company email
  - [ ] Add sql queries for table creation to root file
  - [ ] Update `README.md`

## Misc

- [ ] Show age instead of date of birth in patient dashboard
- [ ] Instead of just fetching patient data from dashboard when updating, fetch the latest patient info from backend
- [ ] Add datable sorting filters
- [ ] Add datatable search

## Refactors

- [ ] Move patient list to store
  - [ ] _Use patient id as prop instead of last patient info to update patient dialog_
- [ ] Add and update patient content is the same, reuse as component
- [ ] Move common logic and fields to \[inline\] composables
- [ ] Separate patient and admission mutation logic from markup
- [ ] Move `confirm delete patient` prompt to separate file (e.g. composable)

## Issues
