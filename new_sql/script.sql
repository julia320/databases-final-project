-- erase anything that is already there

DROP TABLE IF EXISTS gre CASCADE;
DROP TABLE IF EXISTS prior_degrees CASCADE;
DROP TABLE IF EXISTS academic_info CASCADE;
DROP TABLE IF EXISTS form1 CASCADE;
DROP TABLE IF EXISTS adv_form CASCADE;
DROP TABLE IF EXISTS corereq CASCADE;
DROP TABLE IF EXISTS requirements CASCADE;
DROP TABLE IF EXISTS rec_review CASCADE;
DROP TABLE IF EXISTS app_review CASCADE;
DROP TABLE IF EXISTS transcript CASCADE;
DROP TABLE IF EXISTS rec_letter CASCADE;
DROP TABLE IF EXISTS course CASCADE;
DROP TABLE IF EXISTS room CASCADE;
DROP TABLE IF EXISTS user CASCADE;
DROP TABLE IF EXISTS thesis_status;

CREATE TABLE user (
  type varchar(50),
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
  active varchar(5) DEFAULT 'yes',
  donation int(15) DEFAULT 0,
  advisor int(8),
  phone varchar(10),
  hold varchar(5) DEFAULT 'no',
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
  uid int(8) NOT NULL,
  crn int(10) NOT NULL,
  primary key(crn,uid),
  foreign key(uid) references user(uid)
);

CREATE TABLE thesis_status(
  u_id int(8),
  status varchar(25),
  primary key(u_id)
);

CREATE TABLE academic_info (
  uid int(8) NOT NULL,
  dated varchar(10),
  degreeType char(3),
  AOI varchar(100),
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

CREATE TABLE app_review (
  uid int(8) NOT NULL,
  reviewer int(8) NOT NULL,
  comments varchar(100),
  deficiency varchar(20),
  reason char,
  rating int,
  advisor char(30),
  status int NOT NULL DEFAULT 1,
  dated varchar(10),
  PRIMARY KEY (uid, reviewer),
  FOREIGN KEY (uid) REFERENCES user(uid),
  FOREIGN KEY (reviewer) REFERENCES user(uid)
);

CREATE TABLE rec_review (
  uid int(8) NOT NULL,
  reviewer int(8),
  rating int,
  generic boolean, 
  credible boolean,
  recID int,
  PRIMARY KEY (uid, reviewer),
  FOREIGN KEY (uid) REFERENCES user(uid),
  FOREIGN KEY (reviewer) REFERENCES user(uid),
  FOREIGN KEY (recID) REFERENCES rec_letter(recID)
);

CREATE TABLE adv_form(
  uid int(8) NOT NULL,
  crn int(10) NOT NULL,
  PRIMARY KEY (crn,uid),
  FOREIGN KEY(uid) REFERENCES user(uid)
);

INSERT INTO user (fname, lname, street, city, state, zip, phone, email, password, type) VALUES
  ("Dietrich", "Reidenbaugh", "Pennsylvania Ave", "Washington", "DC", 20052, "4567890123", "dreidenbaugh@gwu.edu", "123456", "admin"),
  ("Maya", "Shende", "Massachusetts Ave", "Washington", "DC", 20052, "4567890123", "mshende@gwu.edu", "123456", "secr"),
  ("Bhagi", "Narahari", "South Carolina Ave", "Washington", "DC", 20052, "4567890123", "bnarahari@gwu.edu", "123456", "inst,adv,rev"),
  ("Hyeong-Ah", "Choi", "Wisconsin Ave", "Washington", "DC", 20052, "4567890123", "choi@gwu.edu", "123456", "inst"),
  ("Gabe", "Parmer", "Virignia Ave", "Washington", "DC", 20052, "4567890123", "gparmer@gwu.edu", "123456", "adv,inst"),
  ("Tim", "Wood", "Maryland Ave", "Washington", "DC", 20052, "4567890123", "wood@gwu.edu", "123456", "rev,inst"),
  ("Rachelle", "Heller", "New York Ave", "Washington", "DC", 20052, "4567890123", "heller@gwu.edu", "123456", "rev"),
  ("John", "Smith", "Pennsylvania Ave", "Washington", "DC", 20052, "4567890123", "jsmith@gwu.edu", "123456", "cac,rev,inst"),
  ("Pablo", "Frank", "Virignia Ave", "Washington", "DC", 20052, "4567890123", "pfrank@gwu.edu", "123456", "inst");

INSERT INTO user (fname, lname, street, city, state, zip, phone, email, password, active, type, hold, advisor) VALUES
  ("Selin", "Onal", "Pennsylvania Ave", "Washington", "DC", 20052, "2345678901", "selingonal@gwu.edu", "123456", "no", "PHD", "no", 1),
  ("Richard", "Sear", "Wisconsin Ave", "Washington", "DC", 20052, "4567890123", "searri@gwu.edu", "123456", "yes", "MS", "yes", 3);
  
INSERT INTO user (fname, lname, uid, street, city, state, zip, phone, email, password, active, type) VALUES
  ("Eric", "Clapton", 77777777, "North Carolina Ave", "Washington", "DC", 20052, "4567890123", "eclapton@gwu.edu", "123456", "yes", "alum"),
  ("Kurt", "Cobain", 34567890, "California Ave", "Washington", "DC", 20052, "4567890123", "kcobain@gwu.edu", "123456", "yes", "alum"),

  ("Billie", "Holiday", 88888888, "South Dakota Ave", "Washington", "DC", 20052, "4567890123", "bholiday@gwu.edu", "123456", "yes", "MS"),
  ("Diana", "Krall", 99999999, "Texas Ave", "Washington", "DC", 20052, "4567890123", "dkrall@gwu.edu", "123456", "yes", "MS"),
  ("Ella", "Fitzgerald", 23456789, "Louisiana Ave", "Washington", "DC", 20052, "4567890123", "efitz@gwu.edu", "123456", "yes", "PHD"),
  ("Eva", "Cassidy", 87654321, "Nevade Ave", "Washington", "DC", 20052, "4567890123", "ecassidy@gwu.edu", "123456", "yes", "MS"),
  ("Jimi", "Hendrix", 45678901, "Kentucky Ave", "Washington", "DC", 20052, "4567890123", "jhendrix@gwu.edu", "123456", "yes", "MS"),

  ("Paul", "McCartney", 55555555, "Georgia Ave", "Washington", "DC", 20052, "4567890123", "pmccartney@gwu.edu", "123456", "yes", "MS"),
  ("George", "Harrison", 66666666, "Michigan Ave", "Washington", "DC", 20052, "4567890123", "gharrison@gwu.edu", "123456", "yes", "MS"),
  ("Stevie", "Nicks", 12345678, "Vermont Ave", "Washington", "DC", 20052, "4567890123", "snicks@gwu.edu", "123456", "yes", "PHD");

INSERT INTO user (fname, lname, uid, ssn, street, city, state, zip, phone, email, password, active, type) VALUES
  ("John", "Lennon", 55551111, 111111111, "Florida Ave", "Washington", "DC", 20052, "4567890123", "jlennon@gwu.edu", "123456", "yes", "App"),
  ("Ringo", "Starr", 66661111, 222111111, "Oregon Ave", "Washington", "DC", 20052, "4567890123", "rstarr@gwu.edu", "123456", "yes", "App"),
  ("Louis", "Armstrong", 00001234, 555111111, "Washington Ave", "Washington", "DC", 20052, "4567890123", "larmstrong@gwu.edu", "123456", "yes", "App"),
  ("Aretha", "Franklin", 00001235,  666111111,"North Dakota Ave", "Washington", "DC", 20052, "4567890123", "afranklin@gwu.edu", "123456", "yes", "App"),
  ("Carlos", "Santana", 00001236, 777111111, "Nebraska Ave", "Washington", "DC", 20052, "4567890123", "csantana@gwu.edu", "123456", "yes", "App");


# Application Inserts
INSERT INTO academic_info VALUES
  (55551111, "2019/04/28", "MS", "Robotics", "internship at Space X", "FA", "2019", 1, 1), #John Lennon
  (66661111, "2019/04/13", "MS", "Machine Learning and AI", "NLP research", "FA", "2019", 1, 0), #Ringo Starr
  (00001234, "2017/01/07", "MS", "Cyber Security", "none", "FA", "2017", 1, 1), #Louis Armstrong
  (00001235, "2016/12/05", "MS", "Quantum Computing", "built a quantum computer", "FA", "2017", 1, 1), #Aretha Franklin
  (00001236, "2016/11/29", "PHD", "Cybersecurity", "government internship", "FA", "2017", 1, 1), #Carlos Santana
  (87654321, "2014/01/01", "MS", "Computers", "Computing things", "FA", "2014", 1,1),
  (23456789, "2014/01/01", "PHD", "Computers", "Computing things", "FA", "2014", 1,1),
  (66666666, "2014/01/01", "MS", "Computers", "Computing things", "SP", "2015", 1,1),
  (45678901, "2000/01/01", "MS", "Computers", "Computing things", "SP", "2008", 1,1),
  (88888888, "2000/01/01", "MS", "Computers", "Computing things", "SP", "2008", 1,1),
  (99999999, "2000/01/01", "MS", "Computers", "Computing things", "FA", "2008", 1,1),
  (55555555, "2000/01/01", "MS", "Computers", "Computing things", "FA", "2009", 1,1),
  (12345678, "2000/01/01", "PHD", "Computers", "Computing things", "SP", "2008", 1,1),
  (11, "2000/01/01", "MS", "Computers", "Computing things", "FA", "2017", 1,1),
  (10, "2000/01/01", "PHD", "Computers", "Computing things", "FA", "2017", 1,1);

INSERT INTO rec_letter VALUES
  ("Professor", "Man", "prof@gwu.edu", "George Washington University", 55551111, 1, "This is John Lennon's recommendation"),
  ("Bob", "Smith", "bob@umd.edu", "University of Maryland", 00001234, 2, "This is Louis Armstrong's recommendation"),
  ("Jane", "Doe", "jane@gmail.com", "GWU", 00001235, 3, "This is Aretha Franklin's recommendation letter"),
  ("Sally", "Ride", "sally@nasa.com", "NASA", 00001236, 4, "This is Carlos Santana's recommendation letter"),
  ("John", "Deer", "johndeer@gwu.edu", "GWU", 66661111, 5, NULL);

INSERT INTO gre VALUES
  (145, 155, 2018, 140, "Physics", NULL, 2018, 55551111), #John Lennon
  (150, 160, 2018, 155, "English", NULL, 2018, 66661111), #Ringo Starr
  (145, 135, 2016, 145, "Chemistry", NULL, 2016, 00001234), #Louis Armstrong
  (165, 160, 2016, 160, "Physics", NULL, 2016, 00001235), #Aretha Franklin
  (160, 165, 2016, 170, "Chemistry", NULL, 2016, 00001236); #Carlos Santana

INSERT INTO prior_degrees VALUES
  (3.8, 2019, "GWU", "Computer Science", 55551111, "BS"), #John Lennon
  (3.7, 2019, "UMD", "Mathematics", 66661111, "BS"), #Ringo Starr
  (3.1, 2017, "UMD", "Computer Science", 00001234, "BS"), #Louis Armstrong
  (4.0, 2017, "Harvard", "Physics", 00001235, "BS"), #Aretha Franklin
  (3.9, 2017, "GWU", "Computer Science", 00001236, "BS"); #Carlos Santana

INSERT INTO app_review (uid, reviewer, status) VALUES
  (55551111, 7, 5), (55551111, 9, 5), # John Lennon: no reviews
  (66661111, 7, 4), (66661111, 9, 4), # Ringo Starr: incomplete, missing letters
  (87654321, 8, 7),
  (23456789, 8, 7),
  (66666666, 8, 7),
  (45678901, 8, 7),
  (88888888, 8, 7),
  (99999999, 8, 7),
  (55555555, 8, 7),
  (12345678, 8, 7),
  (11, 8, 7),
  (10, 8, 7);

INSERT INTO app_review VALUES
  # Louis Armstrong: rejected
  (00001234, 7, "not special", NULL, "D", 2, NULL, 8, "2017/05/01"), 
  (00001234, 9, "weak transcript", NULL, "D", 1, NULL, 8, "2017/05/01"),
  # Aretha Franklin: admitted but did not matriculate
  (00001235, 7, "strong rec letter", "none", NULL, 4, "Parmer", 6, "2017/05/02"),
  (00001235, 9, "good grades", "none", NULL, 4, "Parmer", 6, "2017/05/03"),
  # Carlos Santana: admitted but did not matriculate
  (00001236, 7, "good experience", "none", NULL, 4, "Narahari", 6, "2017/04/19"),
  (00001236, 9, "strong application", "none", NULL, 4, "Parmer", 6, "2017/04/27");

INSERT INTO rec_review VALUES
  # Louis Armstrong
  (1234, 7, 3, 1, 1, 2),
  (1234, 9, 2, 1, 1, 2),
  # Aretha Franklin
  (1235, 7, 5, 0, 1, 3),
  (1235, 9, 4, 0, 1, 3),
  #Carlos Santana
  (1236, 7, 4, 1, 1, 4),
  (1236, 9, 5, 0, 1, 4);


# Advising/Registration Inserts
INSERT INTO room VALUES
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

INSERT INTO course (dept, courseno, name, credits, prereq1, prereq2, day, tme, section, year, semester, instructor, location)
VALUES
	("CSCI", 6221, "SW Paradigms", 3,  null, null, "M", "1500-1730",1,2019,"Spring",4,1), 
	("CSCI", 6461, "Computer Architecture", 3, null, null, "T", "1500-1730",1,2019,"Spring",3,1), 
	("CSCI", 6212, "Algorithms", 3, null, null, "W", "1500-1700",1,2019,"Spring",4,1), 
	("CSCI", 6220, "Machine Learning", 3, null, null, null, null,null,null,null,null,null), 
	("CSCI", 6232, "Networks 1", 3, null, null, "M", "1800-2030",1,2019,"Spring",4,2), 
	("CSCI", 6233, "Networks 2", 3, "CSCI 6232", null, "T", "1800-2030",1,2019,"Spring",6,2), 
	("CSCI", 6241, "Database 1", 3, null, null, "W", "1800-2030",1,2019,"Spring",3,2), 
	("CSCI", 6242, "Database 2", 3, "CSCI 6241", null, "R", "1800-2030",1,2019,"Spring",6,2), 
	("CSCI", 6246, "Compilers", 3, "CSCI 6461", "CSCI 6212", "T", "1500-1730",1,2019,"Spring",5,3), 
	("CSCI", 6260, "Multimedia", 3, null, null, "R", "1800-2030",1,2019,"Spring",4,3), 
	("CSCI", 6251, "Cloud Computing", 3, "CSCI 6461", null, "M", "1800-2030",1,2019,"Spring",6,6), 
	("CSCI", 6254, "SW Engineering", 3, "CSCI 6221", null,"M", "1530-1800",1,2019,"Spring",7,3), 
	("CSCI", 6262, "Graphics 1", 3, null, null,"W", "1800-2030",1,2019,"Spring",7,4), 
	("CSCI", 6283, "Security 1", 3, "CSCI 6212", null, "T", "1800-2030",1,2019,"Spring",9,3), 
	("CSCI", 6284, "Cryptography", 3, "CSCI 6212", null, "M", "1800-2030",1,2019,"Spring",3,10), 
	("CSCI", 6286, "Network Security", 3, "CSCI 6283", "CSCI 6232", "W", "1800-2030",1,2019,"Spring",6,10), 
	("CSCI", 6325, "Algorithms 2", 3, "CSCI 6212", null, null, null,null,null,null,null,null), 
	("CSCI", 6339, "Embedded Systems", 3, "CSCI 6461", "CSCI 6212", "R", "1600-1830",1,2019,"Spring",9,10), 
	("CSCI", 6384, "Cryptography 2", 3, "CSCI 6284", null, "W", "1500-1730",1,2019,"Spring",5,10), 
	("ECE", 6241, "Communication Theory", 3, null, null, "M", "1800-2030",1,2019,"Spring",4,11), 
	("ECE", 6242, "Information Theory", 2, null, null, "T", "1800-2030",1,2019,"Spring",4,11), 
	("MATH", 6210, "Logic", 2, null, null,"W", "1800-2030",1,2019,"Spring",4,9),
	("CSCI", 6212, "Algorithms", 3, null, null, "W", "1500-1700",1,2018,"Fall",4,1),
	("CSCI", 6232, "Networks 1", 3, null, null, "M", "1800-2030",1,2018,"Fall",4,2),
	("CSCI", 6233, "Networks 2", 3, "CSCI 6232", null, "T", "1800-2030",1,2018,"Fall",6,2),
	("CSCI", 6220, "Machine Learning", 3, null, null, null, null,null,2018,"Fall",null,null),
	("CSCI", 6325, "Algorithms 2", 3, "CSCI 6212", null, null, null,null,2018,"Fall",null,null);

INSERT INTO form1 VALUES
  (12345678, 1),
  (12345678, 2),
  (12345678, 3),
  (12345678, 5),
  (12345678, 6),
  (12345678, 15),
  (12345678, 16),
  (12345678, 7),
  (12345678, 8),
  (12345678, 9),
  (12345678, 13),
  (12345678, 14),
  (87654321, 1),
  (87654321, 2),
  (87654321, 3),
  (87654321, 5),
  (87654321, 6),
  (87654321, 15),
  (87654321, 16),
  (87654321, 7),
  (87654321, 9),
  (87654321, 13),
  (45678901, 1),
  (45678901, 2),
  (45678901, 3),
  (45678901, 5),
  (45678901, 6),
  (45678901, 7),
  (45678901, 15),
  (45678901, 16),
  (45678901, 20),
  (45678901, 21),
  (45678901, 22),
  (55555555, 1),
  (55555555, 2),
  (55555555, 3),
  (55555555, 5),
  (55555555, 6),
  (55555555, 7),
  (55555555, 8),
  (55555555, 9),
  (55555555, 13),
  (55555555, 14),
  (66666666, 2),
  (66666666, 3),
  (66666666, 5),
  (66666666, 6),
  (66666666, 7),
  (66666666, 8),
  (66666666, 13),
  (66666666, 14),
  (66666666, 21);

INSERT INTO transcript (uid, crn, grade, numgrade) VALUES
  (77777777, 1, "B", "85"),
  (77777777, 2, "B", "85"),
  (77777777, 3, "B", "85"),
  (77777777, 5, "B", "85"),
  (77777777, 6, "B", "85"),
  (77777777, 7, "B", "85"),
  (77777777, 8, "B", "85"),
  (77777777, 14, "A", "95"),
  (77777777, 15, "A", "95"),
  (77777777, 16, "A", "95"),
  (34567890, 1, "A", "95"),
  (34567890, 2, "A", "95"),
  (34567890, 3, "A", "95"),
  (34567890, 5, "A", "95"),
  (34567890, 6, "A", "95"),
  (34567890, 7, "A", "95"),
  (34567890, 14, "A", "95"),
  (34567890, 15, "A", "95"),
  (34567890, 16, "A", "95"),
  (34567890, 8, "B", "85"),
  (34567890, 11, "B", "85"),
  (34567890, 12, "B", "85"),
  (12345678, 1, "A", "95"),
  (12345678, 2, "A", "95"),
  (12345678, 3, "A", "95"),
  (12345678, 5, "A", "95"),
  (12345678, 6, "A", "95"),
  (12345678, 15, "A", "95"),
  (12345678, 16, "A", "95"),
  (12345678, 7, "B", "85"),
  (12345678, 8, "B", "85"),
  (12345678, 9, "B", "85"),
  (12345678, 13, "B", "85"),
  (12345678, 14, "B", "85"),
  (87654321, 1, "A", "95"),
  (87654321, 2, "A", "95"),
  (87654321, 3, "A", "95"),
  (87654321, 5, "A", "95"),
  (87654321, 6, "A", "95"),
  (87654321, 15, "A", "95"),
  (87654321, 16, "A", "95"),
  (87654321, 7, "B", "85"),
  (87654321, 9, "B", "85"),
  (87654321, 13, "B", "85"),
  (45678901, 1, "A", "95"),
  (45678901, 2, "A", "95"),
  (45678901, 3, "A", "95"),
  (45678901, 5, "A", "95"),
  (45678901, 6, "A", "95"),
  (45678901, 7, "A", "95"),
  (45678901, 15, "A", "95"),
  (45678901, 16, "A", "95"),
  (45678901, 20, "B", "85"),
  (45678901, 21, "B", "85"),
  (45678901, 22, "B", "85"),
  (55555555, 1, "A", "95"),
  (55555555, 2, "A", "95"),
  (55555555, 3, "A", "95"),
  (55555555, 5, "A", "95"),
  (55555555, 6, "A", "95"),
  (55555555, 7, "B", "85"),
  (55555555, 8, "B", "85"),
  (55555555, 9, "B", "85"),
  (55555555, 13, "B", "85"),
  (55555555, 1, "B", "85"),
  (66666666, 2, "B", "85"),
  (66666666, 3, "B", "85"),
  (66666666, 5, "B", "85"),
  (66666666, 6, "B", "85"),
  (66666666, 7, "B", "85"),
  (66666666, 8, "B", "85"),
  (66666666, 13, "B", "85"),
  (66666666, 14, "B", "85"),
  (66666666, 21, "C", "75"),
  (88888888, 2, "IP", "0"),
  (88888888, 3, "IP", "0");
