-- erase anything that is already there

DROP TABLE IF EXISTS gre CASCADE;
DROP TABLE IF EXISTS prior_degrees CASCADE;
DROP TABLE IF EXISTS academic_info CASCADE;
DROP TABLE IF EXISTS form1 CASCADE;
DROP TABLE IF EXISTS corereq CASCADE;
DROP TABLE IF EXISTS requirements CASCADE;
DROP TABLE IF EXISTS rec_review CASCADE;
DROP TABLE IF EXISTS app_review CASCADE;
DROP TABLE IF EXISTS transcript CASCADE;
DROP TABLE IF EXISTS rec_letter CASCADE;
DROP TABLE IF EXISTS course CASCADE;
DROP TABLE IF EXISTS room CASCADE;
DROP TABLE IF EXISTS user CASCADE;

CREATE TABLE user (
  type varchar(5),
  uid int(8) auto_increment,
  password varchar(20),
  fname varchar(20),
  lname varchar(20),
  ssn int(9),
  email varchar(20),
  street varchar(20),
  city varchar(20),
  state varchar(2),
  zip int(5),
  program varchar(20),
  major varchar(10),
  gradYear varchar(20),
  active varchar(5),
  donation int(15),
  advisor int(8),
  phone varchar(10),
  PRIMARY KEY (uid)
);

CREATE TABLE room (
  roomid int(6),
  cap int(2),
  building varchar(20),
  rmnumber int(4),
  PRIMARY KEY (roomid)
);

CREATE TABLE course (
  crn int(10) auto_increment,
  dept varchar(20),
  name varchar(40),
  credits int(1),
  prereq1 varchar(20),
  prereq2 varchar(20),
  semester varchar(6),
  year int(4),
  section int(2),
  day varchar(20),
  tme varchar(20),
  instructor int(8),
  location int(6),
  courseno int(4),
  PRIMARY KEY (crn),
  foreign key (instructor) references user(uid),
  foreign key (location) references room(roomid)
);

CREATE TABLE transcript (
  uid int(8),
  crn int(10),
  grade varchar(2),
  numgrade varchar(4),
  lineid int auto_increment primary key,
  foreign key (uid) references user(uid),
  foreign key (crn) references course(crn)
);


CREATE TABLE requirements(
     program varchar(25) NOT NULL,
     GPA DECIMAL(3,2),
     NumCredits int(5),
     Thesis varchar(25),
     CScredits int(5),
     nonCScourses int(5),
     Blower int(5),
     suspensionCount int(5),
     primary key(program)
   );

CREATE TABLE corereq(
     crn int(10) NOT NULL,
     dept varchar(30) NOT NULL,
     program varchar(20),
     primary key(crn, program),
     foreign key(program) REFERENCES requirements(program),
     foreign key(crn) REFERENCES course(crn)
   );


CREATE TABLE form1(
   u_id int(8) NOT NULL,
   fname  varchar(25) NOT NULL,
   lname  varchar(25) NOT NULL,
   crn int(10) NOT NULL,
   primary key(crn,u_id)
   );


CREATE TABLE academic_info (
  uid int(8) NOT NULL,
  dated varchar(21),
  degreeType char(3),
  AOI varchar(30),
  experience varchar(100),
  semester char(2),
  year int(4),
  transcript boolean,
  recletter boolean,
  PRIMARY KEY (uid),
  FOREIGN KEY (uid) REFERENCES user(uid)
);

CREATE TABLE rec_letter  (
  fname char(15),
  lname char(15),
  email varchar(30),
  institution varchar(30),
  uid int(8) NOT NULL,
  recID int NOT NULL AUTO_INCREMENT,
  recommendation varchar(10000),
  PRIMARY KEY (recID),
  FOREIGN KEY (uid) REFERENCES user(uid)
);

CREATE TABLE app_review (
  uid int(8) NOT NULL,
  reviewID int(8) NOT NULL AUTO_INCREMENT,
  reviewerRole varchar(3),
  comments varchar(100),
  deficiency varchar(20),
  reason char,
  rating int,
  advisor char(30),
  status int NOT NULL DEFAULT 1,
  PRIMARY KEY (reviewID),
  FOREIGN KEY (uid) REFERENCES user(uid)
);

CREATE TABLE rec_review (
  reviewID int(8) NOT NULL, 
  reviewerRole varchar(3),
  rating int,
  generic boolean, 
  credible boolean, 
  uid int(8) NOT NULL,
  recID int,
  PRIMARY KEY (reviewID),
  FOREIGN KEY (uid) REFERENCES user(uid),
  FOREIGN KEY (recID) REFERENCES rec_letter(recID),
  FOREIGN KEY (reviewID) REFERENCES app_review(reviewID)
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
  FOREIGN KEY (uid) REFERENCES user(uid)
);

CREATE TABLE prior_degrees (
  gpa float,
  year int(4),
  university varchar(30),
  major varchar(30),
  uid int(8) NOT NULL,
  deg_type char(3),
  PRIMARY KEY (deg_type, uid),
  FOREIGN KEY (uid) REFERENCES user(uid)
);

insert into user (fname, lname, street, city, state, zip, phone, email, password, active, type)VALUES

  ("Dietrich", "Reidenbaugh", "Pennsylvania Ave", "Washington", "DC", 20052, "4567890123", "dreidenbaugh@gwu.edu", "123456", "yes", "admin"),

  ("Maya", "Shende", "Massachusetts Ave", "Washington", "DC", 20052, "4567890123", "mshende@gwu.edu", "123456", "yes", "secr"),

  ("Bhagi", "Narahari", "South Carolina Ave", "Washington", "DC", 20052, "4567890123", "bnarahari@gwu.edu", "123456", "yes", "inst"),
  ("Hyeong-Ah", "Choi", "Wisconsin Ave", "Washington", "DC", 20052, "4567890123", "choi@gwu.edu", "123456", "yes", "inst"),
  ("Gabe", "Parmer", "Virignia Ave", "Washington", "DC", 20052, "4567890123", "gparmer@gwu.edu", "123456", "yes", "adv"),
  ("Tim", "Wood", "Maryland Ave", "Washington", "DC", 20052, "4567890123", "wood@gwu.edu", "123456", "yes", "rev"),
  ("Rachelle", "Heller", "New York Ave", "Washington", "DC", 20052, "4567890123", "heller@gwu.edu", "123456", "yes", "rev"),
  ("John", "Smith", "Pennsylvania Ave", "Washington", "DC", 20052, "4567890123", "jsmith@gwu.edu", "123456", "yes", "cac");

insert into user (fname, lname, uid, street, city, state, zip, phone, email, password, active, type)VALUES

  ("Eric", "Clapton", 7777777, "North Carolina Ave", "Washington", "DC", 20052, "4567890123", "eclapton@gwu.edu", "123456", "yes", "alum"),
  ("Kurt", "Cobain", 34567890, "California Ave", "Washington", "DC", 20052, "4567890123", "kcobain@gwu.edu", "123456", "yes", "alum"),

  ("Billie", "Holiday", 88888888, "South Dakota Ave", "Washington", "DC", 20052, "4567890123", "bholiday@gwu.edu", "123456", "yes", "MS"),
  ("Diana", "Krall", 99999999, "Texas Ave", "Washington", "DC", 20052, "4567890123", "dkrall@gwu.edu", "123456", "yes", "MS"),
  ("Ella", "Fitzgerald", 23456789, "Louisiana Ave", "Washington", "DC", 20052, "4567890123", "efitz@gwu.edu", "123456", "yes", "PHD"),
  ("Eva", "Cassidy", 87654321, "Nevade Ave", "Washington", "DC", 20052, "4567890123", "ecassidy@gwu.edu", "123456", "yes", "MS"),
  ("Jimi", "Hendrix", 45678901, "Kentucky Ave", "Washington", "DC", 20052, "4567890123", "jhendrix@gwu.edu", "123456", "yes", "MS"),

  ("Paul", "McCartney", 55555550, "Georgia Ave", "Washington", "DC", 20052, "4567890123", "pmccartney@gwu.edu", "123456", "yes", "MS"),
  ("George", "Harrison", 66666660, "Michigan Ave", "Washington", "DC", 20052, "4567890123", "gharrison@gwu.edu", "123456", "yes", "MS"),
  ("Stevie", "Nicks", 12345678, "Vermont Ave", "Washington", "DC", 20052, "4567890123", "snicks@gwu.edu", "123456", "yes", "PHD");

insert into user (fname, lname, uid, ssn, street, city, state, zip, phone, email, password, active, type)VALUES
  ("John", "Lennon", 55555555, 111111111, "Florida Ave", "Washington", "DC", 20052, "4567890123", "jlennon@gwu.edu", "123456", "yes", "App"),
  ("Ringo", "Starr", 66666666, 222111111, "Oregon Ave", "Washington", "DC", 20052, "4567890123", "rstarr@gwu.edu", "123456", "yes", "App"),
  ("Louis", "Armstrong", 00001234, 555111111, "Washington Ave", "Washington", "DC", 20052, "4567890123", "larmstrong@gwu.edu", "123456", "yes", "App"),
  ("Aretha", "Franklin", 00001235,  666111111,"North Dakota Ave", "Washington", "DC", 20052, "4567890123", "afranklin@gwu.edu", "123456", "yes", "App"),
  ("Carlos", "Santana", 00001236, 777111111, "Nebraska Ave", "Washington", "DC", 20052, "4567890123", "csantana@gwu.edu", "123456", "yes", "App");

  insert into room VALUES
	(1, 24, "SEH", 1300),
	(2, 24, "SEH", 1400),
	(3, 24, "SEH", 1450),
	(4, 80, "SMPA", 404),
	(5, 80, "SMPA", 405),
	(6, 80, "SMPA", 204),
	(7, 80, "SMPA", 205),
	(8, 60, "SMPA", 210),
	(9, 60, "SMPA", 410),
	(10, 30, "SEH", 4040),
	(11, 30, "SEH", 3040),
	(12, 30, "SEH", 5040);

insert into course (dept, courseno, name, credits, prereq1, prereq2, day, tme, section, year, semester, instructor, location)
VALUES
	("CSCI", 6221, "SW Paradigms", 3,  null, null, "M", "1500-1730",1,2019,"Spring",4,1), 
	("CSCI", 6461, "Computer Architecture", 3, null, null, "T", "1500-1730",1,2019,"Spring",3,1), 
	("CSCI", 6212, "Algorithms", 3, null, null, "W", "1500-1700",1,2019,"Spring",4,1), 
	("CSCI", 6220, "Machine Learning", 3, null, null, null, null,null,null,null,null,null), 
	("CSCI", 6232, "Networks 1", 3, null, null, "M", "1800-2030",1,2019,"Spring",4,2), 
	("CSCI", 6233, "Networks 2", 3, "CSCI 6232", null, "T", "1800-2030",1,2019,"Spring",6,2), 
	("CSCI", 6241, "Database 1", 3, null, null, "W", "1800-2030",1,2019,"Spring",null,2), 
	("CSCI", 6242, "Database 2", 3, "CSCI 6241", null, "R", "1800-2030",1,2019,"Spring",6,2), 
	("CSCI", 6246, "Compilers", 3, "CSCI 6461", "CSCI 6212", "T", "1500-1730",1,2019,"Spring",null,3), 
	("CSCI", 6260, "Multimedia", 3, null, null, "R", "1800-2030",1,2019,"Spring",4,3), 
	("CSCI", 6251, "Cloud Computing", 3, "CSCI 6461", null, "M", "1800-2030",1,2019,"Spring",null,6), 
	("CSCI", 6254, "SW Engineering", 3, "CSCI 6221", null,"M", "1530-1800",1,2019,"Spring",null,3), 
	("CSCI", 6262, "Graphics 1", 3, null, null,"W", "1800-2030",1,2019,"Spring",null,4), 
	("CSCI", 6283, "Security 1", 3, "CSCI 6212", null, "T", "1800-2030",1,2019,"Spring",null,3), 
	("CSCI", 6284, "Cryptography", 3, "CSCI 6212", null, "M", "1800-2030",1,2019,"Spring",null,10), 
	("CSCI", 6286, "Network Security", 3, "CSCI 6283", "CSCI 6232", "W", "1800-2030",1,2019,"Spring",null,10), 
	("CSCI", 6325, "Algorithms 2", 3, "CSCI 6212", null, null, null,null,null,null,null,null), 
	("CSCI", 6339, "Embedded Systems", 3, "CSCI 6461", "CSCI 6212", "R", "1600-1830",1,2019,"Spring",null,10), 
	("CSCI", 6384, "Cryptography 2", 3, "CSCI 6284", null, "W", "1500-1730",1,2019,"Spring",null,10), 
	("ECE", 6241, "Communication Theory", 3, null, null, "M", "1800-2030",1,2019,"Spring",null,11), 
	("ECE", 6242, "Information Theory", 2, null, null, "T", "1800-2030",1,2019,"Spring",null,11), 
	("MATH", 6210, "Logic", 2, null, null,"W", "1800-2030",1,2019,"Spring",null,9),
	("CSCI", 6212, "Algorithms", 3, null, null, "W", "1500-1700",1,2018,"Fall",4,1),
	("CSCI", 6232, "Networks 1", 3, null, null, "M", "1800-2030",1,2018,"Fall",4,2),
	("CSCI", 6233, "Networks 2", 3, "CSCI 6232", null, "T", "1800-2030",1,2018,"Fall",6,2),
	("CSCI", 6220, "Machine Learning", 3, null, null, null, null,null,2018,"Fall",null,null),
	("CSCI", 6325, "Algorithms 2", 3, "CSCI 6212", null, null, null,null,2018,"Fall",null,null);


