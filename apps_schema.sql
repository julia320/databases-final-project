-- erase anything that is already there
DROP TABLE IF EXISTS application_info CASCADE;
DROP TABLE IF EXISTS gre CASCADE;
DROP TABLE IF EXISTS prior_degrees CASCADE;
DROP TABLE IF EXISTS rec_review CASCADE;
DROP TABLE IF EXISTS rec_letter CASCADE;
DROP TABLE IF EXISTS academic_info CASCADE;
DROP TABLE IF EXISTS personal_info CASCADE;
DROP TABLE IF EXISTS users CASCADE;


-- create the tables
CREATE TABLE users (
  role varchar(10),
  fname char(15),
  lname char(15),
  username varchar(10),
  password varchar(20),
  userID int(8),
  PRIMARY KEY (userID)
);

CREATE TABLE personal_info (
  finame char(15),
  lname char(15),
  uid int(8),
  address varchar(50),
  ssn int(9),
  PRIMARY KEY (uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE academic_info (
  uid int(8),
  degreeType char(3),
  AOI varchar(30),
  experience varchar(100),
  semester char(2),
  year int(4),
  transcript boolean,
  recID int,
  PRIMARY KEY (uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE rec_letter  (
  fname char(15),
  lname char(15),
  email varchar(30),
  institution varchar(30),
  uid int(8),
  recID int,
  PRIMARY KEY (email),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE rec_review (
  rating int,
  generic boolean,
  credible boolean,
  uid int(8),
  recID int,
  PRIMARY KEY (recID),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE gre (
  verbal int,
  quant int,
  year int,
  advScore int,
  subject varchar(15),
  toefl int,
  advYear int,
  uid int,
  PRIMARY KEY (uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE prior_degrees (
  gpa float,
  year int(4),
  university varchar(30),
  uid int(8),
  type char(3),
  PRIMARY KEY (type, uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE application_info (
  uid int(8),
  status int,
  comments varchar(100),
  rating int,
  deficiency varchar(20),
  reason char,
  decision int,
  advisor char(30),
  PRIMARY KEY (uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);


-- insert data into the tables
INSERT INTO users VALUES 
	(),
	();