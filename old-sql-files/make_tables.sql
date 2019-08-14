DROP TABLE IF EXISTS transcript CASCADE;
DROP TABLE IF EXISTS course CASCADE;
DROP TABLE IF EXISTS room CASCADE;
DROP TABLE IF EXISTS user CASCADE;


CREATE TABLE user (
  fname varchar(20),
  lname varchar(20),
  uid int(8) auto_increment,
  street varchar(20),
  city varchar(20),
  state varchar(2),
  zip int(5),
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


