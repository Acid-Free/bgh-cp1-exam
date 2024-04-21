# Notes

- _italicized_ and **Misc** entries are not required

# TODOS

## Core

- [x] Interfaces
  - [x] Patient dashboard
  - [x] Admission dashboard
  - [x] Add patient
  - [x] Update patient
  - [x] Remove patient
  - [x] Admit patient
    - [ ] _From Patient page_
    - [x] From Admisson page
  - [x] Remove admission
- [x] Database tables
  - [x] Patient
  - [x] Admission
- [ ] Functions
  - [ ] _Fetch patient_
  - [x] Fetch patients
  - [x] Add patient
  - [x] Update patient
  - [x] Remove patient
  - [ ] Fetch admissions for the day
  - [ ] Admit patient
    - [ ] Select patient
      - [ ] Ensure patient is not yet admitted
    - [ ] Provide admission datetime and ward
  - [ ] Discharge admission
    - [ ] Ensure admission is active
    - [ ] Provide discharge datetime
- [ ] Compliance
  - [x] Send GitHub link to company email
  - [x] Add sql queries for table creation
  - [ ] Update `README.md`

## Misc

- [ ] Show age instead of date of birth in patient dashboard
- [ ] Instead of just fetching patient data from dashboard when updating, fetch the latest patient info from backend
- [ ] Add datable sorting filters
- [ ] Add datatable search
- [ ] Show admissions with the following filters: active, discharged, all
- [ ] Add register redirect from login page
- [ ] Parse backend date when used as `Calendar` model

## Refactors

- [ ] Move patient list to store
  - [ ] _Use patient id as prop instead of last patient info to update patient dialog_
- [ ] Add and update patient content is the same, reuse as component
- [ ] Move common logic and fields to \[inline\] composables
- [ ] Separate patient and admission mutation logic from markup
- [ ] Move `confirm delete patient` prompt to separate file (e.g. composable)

## Issues
