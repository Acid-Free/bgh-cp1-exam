CREATE TABLE patients (
  id bigint NOT NULL AUTO_INCREMENT,
  first_name varchar(50) NOT NULL,
  last_name varchar(50) NOT NULL,
  middle_name varchar(50),
  suffix_name varchar(10),
  birth_date date,
  address varchar(100),
  PRIMARY KEY (id)
)
