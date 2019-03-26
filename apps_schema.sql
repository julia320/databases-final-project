-- erase anything that is already there
DROP TABLE IF EXISTS app_review CASCADE;
DROP TABLE IF EXISTS gre CASCADE;
DROP TABLE IF EXISTS prior_degrees CASCADE;
DROP TABLE IF EXISTS rec_review CASCADE;
DROP TABLE IF EXISTS rec_letter CASCADE;
DROP TABLE IF EXISTS academic_info CASCADE;
DROP TABLE IF EXISTS personal_info CASCADE;
DROP TABLE IF EXISTS users CASCADE;


-- create the tables

CREATE TABLE users (
  role varchar(3) NOT NULL,
  fname char(15) NOT NULL,
  lname char(15) NOT NULL,
  username varchar(20) NOT NULL,
  password varchar(20) NOT NULL,
  email varchar(50) NOT NULL,
  userID int(8) NOT NULL,
  appStatus int NOT NULL DEFAULT 1,
  PRIMARY KEY (userID)
);

CREATE TABLE personal_info (
  fname char(15),
  lname char(15),
  uid int(8) NOT NULL,
  address varchar(50),
  ssn int(9),
  PRIMARY KEY (uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE academic_info (
  uid int(8) NOT NULL,
  degreeType char(3),
  AOI varchar(30),
  experience varchar(100),
  semester char(2),
  year int(4),
  transcript boolean,
  recletter boolean, 
  recID int,
  PRIMARY KEY (uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE rec_letter  (
  fname char(15),
  lname char(15),
  email varchar(30),
  institution varchar(30),
  uid int(8) NOT NULL,
  PRIMARY KEY (email),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE rec_review (
  reviewerRole char(3),
  rating int,
  generic boolean, 
  credible boolean, 
  uid int(8) NOT NULL,
  PRIMARY KEY (uid, reviewerRole),
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
  uid int(8) NOT NULL,
  PRIMARY KEY (uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE prior_degrees (
  gpa float,
  year int(4),
  university varchar(30),
  uid int(8) NOT NULL,
  deg_type char(3),
  PRIMARY KEY (deg_type, uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE app_review (
  uid int(8) NOT NULL,
  reviewerRole char(3),
  comments varchar(100),
  deficiency varchar(20),
  reason char,
  action int,
  advisor char(30),
  PRIMARY KEY (uid, reviewerRole),
  FOREIGN KEY (uid) REFERENCES users(userID)
);


-- insert admissions committee and two applicants
INSERT INTO users VALUES 
  -- Systems Administrator
  ("SA", "Julia", "Bristow", "julia320", "admin1", "julia_bristow@gwu.edu", 12345678, 0),
  -- Graduate Secretary
  ("GS", "Jack", "Sloane", "jacksloane", "password", "email@gmail.com", 13254761, 0),
  -- Faculty Reviewer
  ("FR", "Bhagi", "Narahari", "bn", "password", "narahari@gwu.edu", 21147362, 0),
  -- Chair of Admissions Comm
  ("CAC", "John", "Smith", "jsmith", "123456", "jsmith@gmail.com", 42142172, 0),
  -- Applicants
  ("A", "John", "Lennon", "john_lennon", "plsletmein", "john_lennon@gmail.com", 55555555, 1),
  ("A", "Ringo", "Starr", "rstarr", "Apply!", "ringostarr@gmail.com", 66666666, 1);


-- insert personal data for applicants
INSERT INTO personal_info VALUES
  ("John", "Lennon", 55555555, "123 Main St, New York NY", 111111111),
  ("Ringo", "Starr", 66666666, NULL, 222111111);

-- John's application (complete)
INSERT INTO academic_info VALUES
  (55555555, "MS", "Computer Science", "bioinformatics research", "FA", 2019, true, true, 121);
INSERT INTO rec_letter VALUES ("Recommender", "1", "recommend@gmail.com", "GWU", 55555555);
INSERT INTO gre VALUES (157, 162, 2018, 830, "mathematics", 100, 2018, 55555555);
INSERT INTO prior_degrees VALUES (3.6, 2017, "GWU", 55555555, "BS");


-- Ringo's application (incomplete)
INSERT INTO academic_info (uid, transcript, recletter) VALUES (66666666, false, false);
