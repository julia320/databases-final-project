-- erase anything that is already there
DROP TABLE IF EXISTS rec_review CASCADE;
DROP TABLE IF EXISTS app_review CASCADE;
DROP TABLE IF EXISTS gre CASCADE;
DROP TABLE IF EXISTS prior_degrees CASCADE;
DROP TABLE IF EXISTS rec_letter CASCADE;
DROP TABLE IF EXISTS academic_info CASCADE;
DROP TABLE IF EXISTS transcript CASCADE;
DROP TABLE IF EXISTS course CASCADE;
DROP TABLE IF EXISTS room CASCADE;
DROP TABLE IF EXISTS user CASCADE;
DROP TABLE IF EXISTS form1 CASCADE;
DROP TABLE IF EXISTS corereq CASCADE;
DROP TABLE IF EXISTS course_catalog CASCADE;
DROP TABLE IF EXISTS requirements CASCADE;


CREATE TABLE user (
  fname varchar(20),
  lname varchar(20),
  uid int(8) auto_increment,
  phone varchar(10),
  email varchar(20),
  password varchar(20),
  active varchar(5),
  type varchar(5),
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
  semester varchar(6),
  credits int(1),
  section int(2),
  year int(4),
  name varchar(40),
  dept varchar(20),
  courseno int(4),
  prereq1 varchar(20),
  prereq2 varchar(20),
  day varchar(20),
  tme varchar(20),
  instructor int(8),
  crn int(10) auto_increment,
  location int(6),
  PRIMARY KEY (crn),
  foreign key (instructor) references user(uid),
  foreign key (location) references room(roomid)
);

CREATE TABLE transcript (
  uid int(8),
  grade varchar(2),
  crn int(10),
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
     crn varchar(10) NOT NULL,
     dept varchar(30) NOT NULL,
     program varchar(20),
     primary key(crn, dept, program)
   );


CREATE TABLE form1(
   u_id int(8) NOT NULL,
   fname  varchar(25) NOT NULL,
   minit  varchar(25),
   lname  varchar(25) NOT NULL,
   program  varchar(50) NOT NULL,
   dept varchar(30) NOT NULL,
   semYear varchar(15) NOT NULL,
   crn varchar(10) NOT NULL,
   primary key(crn,u_id)
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
  PRIMARY KEY (uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
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
  FOREIGN KEY (uid) REFERENCES users(userID)
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
  FOREIGN KEY (uid) REFERENCES users(userID)
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
  FOREIGN KEY (uid) REFERENCES users(userID),
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
  FOREIGN KEY (uid) REFERENCES users(userID)
);

CREATE TABLE prior_degrees (
  gpa float,
  year int(4),
  university varchar(30),
  major varchar(30),
  uid int(8) NOT NULL,
  deg_type char(3),
  PRIMARY KEY (deg_type, uid),
  FOREIGN KEY (uid) REFERENCES users(userID)
);



ALTER TABLE students ADD foreign key(a_id) REFERENCES faculty(f_id) ON DELETE CASCADE;
ALTER TABLE thesis_status ADD foreign key(u_id) REFERENCES students(u_id) ON DELETE CASCADE;
ALTER TABLE student_courses ADD foreign key(crn,dept) REFERENCES course_catalog(crn, dept) ON DELETE CASCADE;
ALTER TABLE form1 ADD foreign key(crn,dept) REFERENCES course_catalog(crn,dept) ON DELETE CASCADE;
ALTER TABLE form1 ADD foreign key(crn,semYear,u_id) REFERENCES student_courses(crn,semYear,u_id) ON DELETE CASCADE;
ALTER TABLE form1 ADD foreign key(u_id) REFERENCES students(u_id) ON DELETE CASCADE;
ALTER TABLE corereq ADD foreign key(program) REFERENCES requirements(program) ON DELETE CASCADE;
ALTER TABLE corereq ADD foreign key(crn, dept) REFERENCES course_catalog(crn,dept) ON DELETE CASCADE;
