CREATE TABLE admissions (
    id bigint NOT NULL AUTO_INCREMENT,
    created_at date,
    updated_at date,
    patient_id bigint NOT NULL,
    ward varchar(100) NOT NULL,
    admission_datetime datetime NOT NULL,
    discharge_datetime datetime,
    PRIMARY KEY (id),
    FOREIGN KEY (patient_id) REFERENCES patients(id)
);
