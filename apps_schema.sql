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
  role varchar(3),
  fname char(15),
  lname char(15),
  username varchar(20),
  password varchar(20),
  email varchar(50),
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
  uid int,
  recID int,
  PRIMARY KEY (email),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE rec_review (
  rating int,
  generic boolean,
  credible boolean,
  uid int,
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
  uid int,
  deg_type char(3),
  PRIMARY KEY (deg_type, uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE application_info (
  uid int,
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
