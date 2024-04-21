CREATE TABLE admissions (
    id bigint NOT NULL AUTO_INCREMENT,
    patient_id bigint NOT NULL,
    ward varchar(100) NOT NULL,
    admission_datetime datetime NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (patient_id) REFERENCES patients(id)
);
