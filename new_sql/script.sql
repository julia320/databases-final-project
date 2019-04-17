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
  address varchar(100),
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
   minit  varchar(25),
   lname  varchar(25) NOT NULL,
   program  varchar(50) NOT NULL,
   dept varchar(30) NOT NULL,
   semYear varchar(15) NOT NULL,
   crn int(10) NOT NULL,
   primary key(crn,u_id),
   foreign key(crn) REFERENCES transcript(crn)
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
  date varchar(15),
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

insert into user (fname, lname, address, phone, email, password, active, type)VALUES
  ("Dietrich", "Reidenbaugh", "Pennsylvania Ave, Washington, DC 20052", "4567890123", "dreidenbaugh@gwu.edu", "123456", "yes", "admin"),
  ("Markeil", "Blow", "Pennsylvania Ave, Washington, DC 20052", "4567890123", "mblow@gwu.edu", "123456", "yes", "alum"),
  ("Julia", "Bristow", "Pennsylvania Ave, Washington, DC 20052", "4567890123", "jbristow@gwu.edu", "123456", "yes", "MS"),
  ("Rick", "Sears", "Pennsylvania Ave, Washington, DC 20052", "4567890123", "rsears@gwu.edu", "123456", "yes", "PHD"),
  ("Roxana", "Leontie", "Pennsylvania Ave, Washington, DC 20052", "4567890123", "rleontie@gwu.edu", "123456", "yes", "inst"),
  ("Thomas", "LeBlanc", "Pennsylvania Ave, Washington, DC 20052", "4567890123", "tleblanc@gwu.edu", "123456", "yes", "adv"),
  ("Maya", "Shende", "Pennsylvania Ave, Washington, DC 20052", "4567890123", "mshende@gwu.edu", "123456", "yes", "secr"),
  ("Naian", "Yin", "Pennsylvania Ave, Washington, DC 20052", "4567890123", "nyin@gwu.edu", "123456", "yes", "app"),
  ("Allison", "DeCicco", "Pennsylvania Ave, Washington, DC 20052", "4567890123", "adecicco@gwu.edu", "123456", "yes", "cac"),
  ("Billy", " Miller", "Pennsylvania Ave, Washington, DC 20052", "4567890123", "bmiller@gwu.edu", "123456", "yes", "rev"),
  ("Bhagi", "Narahari", "Pennsylvania Ave, Washington, DC 20052", "4567890123", "bnarahari@gwu.edu", "123456", "yes", "reg");
