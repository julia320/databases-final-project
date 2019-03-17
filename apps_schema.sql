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
  role varchar(3) NOT NULL,
  fname char(15) NOT NULL,
  lname char(15) NOT NULL,
  username varchar(20) NOT NULL,
  password varchar(20) NOT NULL,
  email varchar(50) NOT NULL,
  userID int(8) NOT NULL,
  PRIMARY KEY (userID)
);

CREATE TABLE personal_info (
  fname char(15) NOT NULL,
  lname char(15) NOT NULL,
  uid int(8) NOT NULL,
  address varchar(50) NOT NULL,
  ssn int(9) NOT NULL,
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
  recID int,
  PRIMARY KEY (uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE rec_letter  (
  fname char(15) NOT NULL,
  lname char(15) NOT NULL,
  email varchar(30) NOT NULL,
  institution varchar(30) NOT NULL,
  uid int(8) NOT NULL,
  recID int NOT NULL,
  PRIMARY KEY (email),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE rec_review (
  rating int,
  generic boolean,
  credible boolean,
  uid int(8) NOT NULL,
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

CREATE TABLE application_info (
  uid int(8) NOT NULL,
  status int NOT NULL,
  comments varchar(100),
  rating int,
  deficiency varchar(20),
  reason char,
  decision int,
  advisor char(30),
  PRIMARY KEY (uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);


-- insert admissions committee and first applicant
INSERT INTO users VALUES 
	-- Systems Administrator
	("SA", "Sarah", "Hoffman", "shoffman", "admin123", "sarah_hoffman@apps.edu", 1),
	-- Graduate Secretary
	("GS", "John", "Lipton", "john_lipton", "password7", "liptonj@gmail.com", 2),
	-- Faculty Reviewer
	("FR", "Jennifer", "Clare", "jenclare", "mypetsname", "jenclare@gmail.com", 3),
	-- Chair of Admissions Comm
	("CAC", "Mike", "Myers", "myers", "123456", "mmyers@aol.com", 4),
	-- Applicant
	("A", "Adrian", "Peters", "apeters", "plsletmein", "apeters@verizon.net", 5);

-- all other tables will be blank until application is submitted
