/*drop tables if exists*/

      drop table if exists form1 cascade;
      drop table if exists thesis_status cascade;
    drop table if exists corereq cascade;
       drop table if exists alumni cascade;
      drop table if exists students cascade;
      drop table if exists faculty cascade;
     drop table if exists student_courses cascade;
     drop table if exists course_catalog cascade;

    drop table if exists requirements cascade;

   /*create and define tables*/


   create table faculty(
   f_id int(8) NOT NULL,
   pswd varchar(25) NOT NULL,
   fname  varchar(25) NOT NULL,
   minit  varchar(25),
   lname  varchar(25) NOT NULL,
   adv  varchar(4) NOT NULL,
   admin varchar(4) NOT NULL,
   grad_sec varchar(4) NOT NULL,
   primary key (f_id)
   );

   create table requirements(
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

   create table corereq(
     crn varchar(10) NOT NULL,
     dept varchar(30) NOT NULL,
     program varchar(20),
     primary key(crn, dept, program)
   );

   create table students(
   u_id int(8) NOT NULL,
   fname  varchar(25) NOT NULL,
   minit  varchar(25),
   lname  varchar(25) NOT NULL,
   addr  varchar(255) NOT NULL,
   pnumber  varchar(12) NOT NULL,
   pswd  varchar(50) NOT NULL,
   program  varchar(50) NOT NULL,
   major  varchar(255) NOT NULL,
   gradYear   int(4),
   a_id int(8),
   grad_status varchar(255),
   curr_status varchar (255),
   primary key(u_id)
   );

   create table course_catalog(
   crn varchar(10) NOT NULL,
   title varchar(50) NOT NULL,
   credit int(2) NOT NULL,
   pre_req1 varchar(10),
   pre_req2 varchar(10),
   semYear varchar(15) NOT NULL,
   dept varchar(30) NOT NULL,
   primary key (crn,dept)
   );

   create table student_courses(
   title varchar(255) NOT NULL,
   dept varchar(30) NOT NULL,
   crn varchar(10) NOT NULL,
   semYear varchar(15) NOT NULL,
   u_id int(8) NOT NULL,
   credit int(2) NOT NULL,
   lettergrade varchar(3),
   numgrade varchar(10),
   program  varchar(50) NOT NULL,
   primary key(crn,semYear, u_id)
   );

   create table alumni(
     fname  varchar(25) NOT NULL,
     minit  varchar(25),
     lname  varchar(25) NOT NULL,
     addr  varchar(100) NOT NULL,
     pnumber  varchar(12) NOT NULL,
     u_id int(8) AUTO_INCREMENT,
     pswd  varchar(50) NOT NULL,
     program  varchar(50) NOT NULL,
     gradYear   int(4),
     donation  int(15),
     a_id int(8),
     primary key(u_id)
   );

   create table form1(
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

   create table thesis_status(
     u_id int(8),
     status varchar(25),
     primary key(u_id)
   );

ALTER TABLE students ADD foreign key(a_id) REFERENCES faculty(f_id) ON DELETE CASCADE;
ALTER TABLE thesis_status ADD foreign key(u_id) REFERENCES students(u_id) ON DELETE CASCADE;
ALTER TABLE student_courses ADD foreign key(crn,dept) REFERENCES course_catalog(crn, dept) ON DELETE CASCADE;
ALTER TABLE form1 ADD foreign key(crn,dept) REFERENCES course_catalog(crn,dept) ON DELETE CASCADE;
ALTER TABLE form1 ADD foreign key(crn,semYear,u_id) REFERENCES student_courses(crn,semYear,u_id) ON DELETE CASCADE;
ALTER TABLE form1 ADD foreign key(u_id) REFERENCES students(u_id) ON DELETE CASCADE;
ALTER TABLE corereq ADD foreign key(program) REFERENCES requirements(program) ON DELETE CASCADE;
ALTER TABLE corereq ADD foreign key(crn, dept) REFERENCES course_catalog(crn,dept) ON DELETE CASCADE;

-- add insert into statements
insert into faculty values
(22001110,'hello','johan','v','jones','yes', 'no', 'no'),
(00000000,'hello','system', 'a', 'admin', 'no', 'yes', 'no'),
(22001111,'hello','Baghi',null, 'Narahari', 'yes', 'no', 'no'),
(22001112,'hello','Gabe',null, 'Parmer', 'yes', 'no', 'no'),
(330451128,'hello','Kloa','p','la', 'no', 'no', 'yes');




insert into students values
( 11111101,'laura','v', 'Johnson', 'washington DC','123-456-7890','swagg','master', 'computer science', '2026',22001110, NULL, "active"),
( 11111345,'dao','l', 'keb', '6375 Seven Corners Center','234-424-2244','danser','phd', 'computer science', '2015',330451128,NULL, "active"),
( 55555555,'Paul',NULL, 'McCartney', '67932 Eight Tree Center','808-635-1283','swagg','phd', 'computer science', '2027',22001111,NULL, "active"),
( 66666666,'George',NULL, 'Harrison', '9385 Seven Corners Drive','235-724-2244','program','master', 'computer science', '2020',22001112,NULL, "active"),
( 11112122,'donald','s','donald', 'detroit Michigan','103-954-2578','read','phd', 'computer science', '2019', 330451128,NULL, "active");


insert into thesis_status values
(11111345, 'passed'),
(11112122, 'In progress');



 insert into alumni values
('Clapton',null,'Eric', '993002 alexandria virginia', '235-426-2244',77777777, 'hello1', 'MS', 2014,0,22001110);


insert into course_catalog values
('6620', 'stat', 3,'csci 6001', null,'f2014','csci'),
('6621', 'AI', 3,'csci 6111', null,'f2019','csci'),
('6631', 'software engineering', 3,'csci 6001', null,'f2015','csci'),
('6632', 'stat', 3,'csci 6632', null,'f2017','csci'),
('6221', 'SW Paradigms', 3,'csci 6221', null,'f2018','csci'),
('6634', 'Mathematical Reaoning', 3,'csci 6634', null,'f2015','csci'),
('6461', 'Computer Architecture', 3,null, null,'f2015','csci'),
('6212', 'Algorithms', 3,null, null,'f2015','csci'),
('6220', 'Machine Learning II', 3,null, null,'f2015','csci'),
('6232', 'Networks 1', 3,null, null,'f2015','csci'),
('6233', 'Networks 2', 3,'CSCI 6232', null,'f2015','csci'),
('6241', 'Database 1', 3,null, null,'f2015','csci'),
('6242', 'Database 2', 3,'CSCI 6241', null,'f2015','csci'),
('6246', 'Compilers', 3,'CSCI 6461', 'CSCI 6212','f2015','csci'),
('6260', 'Multimedia', 3,null, null,'f2015','csci'),
('6251', 'Cloud Computing', 3,'CSCI 6461', null,'f2015','csci'),
('6254', 'SW Engineering', 3,'CSCI 6221', null,'f2015','csci'),
('6262', 'Graphics 1', 3,null, null,'f2015','csci'),
('6283', 'Security 1', 3,'CSCI 6212', null,'f2019','csci'),
('6284', 'Cryptography', 3,'CSCI 6212', null,'f2018','csci'),
('6286', 'Network Security', 3,'CSCI 6283', 'CSCI 6232','f2015','csci'),
('6325', 'Algorithms 2', 3,'CSCI 6212', null,'f2018','csci'),
('6339', 'Embedded Systems', 3,'CSCI 6461', null,'f2015','csci'),
('6384', 'Cryptography 2', 3,'CSCI 6284', null,'f2015','csci'),
('6241', 'Communication Theory', 3,null, null,'f2015','ECE'),
('6242', 'Information Theory', 3,null, null,'f2017','ECE'),
('6244', 'Circuit Knowledge 1', 3,null, null,'f2017','ECE'),
('6210', 'Logic', 3,'CSCI 6212', null,'f2019','MATH');

insert into requirements values
  ('MS', 3.00, 30, "no", 9, 2, 2, 3),
  ('PhD', 3.50, 36, "yes", 30, 100, 1, 3);

insert into corereq values
  ('6212', 'csci', 'MS'),
  ('6621', 'csci', 'MS'),
  ('6461', 'csci', 'MS');

insert into student_courses values
('stat','csci', '6620', 'f2020', 11111101, 3, 'A','4.0','master'),
('AI','csci', '6621', 'f2020', 11111101, 3, 'A-','3.7','master'),
('Machine learning','csci', '6631', 'f2021',  11112122, 3, 'B+','3.33','master'),
('software engineering','csci', '6632', 's2020', 11111101, 3, 'B+','3.33','master'),
('SW Paradigms','csci','6221','f2022',11112122,3,'IP','-','master'),
('Mathematical Reaoning','csci', '6634', 's2020', 11111101, 3, 'A','4.0','master'),
('Computer Architecture','csci', '6461', 'f2015', 11112122, 3, 'A','4.0','master'),
('Networks 1','csci','6232', 's2020', 11111101, 3, 'A','4.0','master'),
('Logic','MATH', '6210', 's2020', 11111101, 3, 'A','4.0','master'),
('Information Theory','ECE', '6242', 's2020', 11111101, 3, 'A','4.0','master'),
('Communication Theory','ECE', '6241', 's2020', 11111101, 3, 'A','4.0','master'),
('Cryptography 2','csci', '6325', 's2020', 11111101, 3, 'A','4.0','master'),
('Embedded Systems','csci', '6339', 's2020', 11111101, 3, 'A','4.0','master'),
('Algorithms 2','csci', '6325', 's2019', 11111101, 3, 'A','4.0','master'),
('Network Security','csci', '6286', 'f2019', 11111101, 3, 'A','4.0','master'),
('Network Security','csci', '6286', 's2020', 11112122, 3, 'A','4.0','master'),
('Communication Theory','ECE', '6241', 'f2020', 11112122, 3, 'A','4.0','master'),
('software engineering','csci', '6632', 'W2015', 11112122, 3, 'B+','3.33','master'),
('Computer Architecture','csci', '6461', 's2014', 55555555, 3, 'A','4.0','phd'),
('Algorithms','csci', '6212', 's2014', 55555555, 3, 'A','4.0','phd'),
('SW Paradigms','csci', '6221', 's2014', 55555555, 3, 'A','4.0','phd'),
('Networks 1','csci', '6232', 's2014', 55555555, 3, 'A','4.0','phd'),
('Networks 2','csci', '6233', 's2014', 55555555, 3, 'A','4.0','phd'),
('Database 1','csci', '6241', 's2014', 55555555, 3, 'B','3.0','phd'),
('Compilers','csci', '6246', 's2014', 55555555, 3, 'B','3.0','phd'),
('Graphics 1','csci', '6262', 's2014', 55555555, 3, 'B','3.0','phd'),
('Security 1','csci', '6283', 's2014', 55555555, 3, 'B','3.0','phd'),
('Database 2','csci', '6242', 's2014', 55555555, 3, 'B','3.0','phd'),

('Circuit Knowledge 1','ECE', '6244', 's2014', 66666666, 3, 'C','2.0','master'),
('SW Paradigms','csci', '6221', 's2014', 66666666, 3, 'B','3.0','master'),
('Computer Architecture','csci', '6461', 's2014', 66666666, 3, 'B','3.0','master'),
('Algorithms','csci', '6212', 's2014', 66666666, 3, 'B','3.0','master'),
('Networks 1','csci', '6232', 's2014', 66666666, 3, 'B','3.0','master'),
('Networks 2','csci', '6233', 's2014', 66666666, 3, 'B','3.0','master'),
('Database 1','csci', '6241', 's2014', 66666666, 3, 'B','3.0','master'),
('Database 2','csci', '6242', 's2014', 66666666, 3, 'B','3.0','master'),
('Security 1','csci', '6283', 's2014', 66666666, 3, 'B','3.0','master'),
('Cryptography','csci', '6284', 's2014', 66666666, 3, 'B','3.0','master'),



('SW Paradigms','csci', '6221', 's2014', 77777777, 3, 'B','3.0','master'),
('Algorithms','csci', '6212', 's2014', 77777777, 3, 'B','3.0','master'),
('Computer Architecture','csci', '6461', 's2014', 77777777, 3, 'B','3.0','master'),
('Networks 1','csci', '6232', 's2014', 77777777, 3, 'B','3.0','master'),
('Networks 2','csci', '6233', 's2014',77777777, 3, 'B','3.0','master'),
('Database 1','csci', '6241', 's2014', 77777777, 3, 'B','3.0','master'),
('Database 2','csci', '6242', 's2014', 77777777, 3, 'B','3.0','master'),
('Security 1','csci', '6283', 's2014', 77777777, 3, 'A','4.0','master'),
('Cryptography','csci', '6284', 's2014',77777777, 3, 'A','4.0','master'),
('Network Security','csci', '6286', 's2014', 77777777, 3, 'A','4.0','master'),


('Communication Theory','ECE', '6241', 'f2020', 11111345, 3, 'A','4.0','master'),
('software engineering','csci', '6632', 's2014', 11111345, 3, 'B+','3.33','phd'),
('SW Paradigms','csci','6221','f2015',11111345,3,'IP','-','phd'),
('Mathematical Reaoning','csci', '6634', 'f2013', 11111345, 3, 'A-','3.7','phd'),
('Computer Architecture','csci', '6461', 'f2015', 11111345, 3, 'IP','-','phd'),
('Networks 1','csci','6232', 'f2013', 11111345, 3, 'A','4.0','phd'),
('Logic','MATH', '6210', 's2013', 11111345, 3, 'A','4.0','phd'),
('Information Theory','ECE', '6242', 'f2023', 11111345, 3, 'A-','3.7','phd'),
('Communication Theory','ECE', '6241', 'W2014', 11111345, 3, 'IP','-','phd'),
('Cryptography 2','csci', '6325', 'f2012', 11111345, 3, 'B+','3.33','phd'),
('Embedded Systems','csci', '6339', 's2012', 11111345, 3, 'A','4.0','phd'),
('Algorithms 2','csci', '6325', 's2014', 11111345, 3, 'IP','-','phd'),
('Network Security','csci', '6286', 's2013', 11111345, 3, 'B+','3.33','phd');


insert into form1 values
(11111101,'laura','v', 'Johnson','master','MATH','s2020','6210'),
(11111101,'laura','v', 'Johnson','master','csci','s2020','6232'),
(11111101,'laura','v', 'Johnson','master','ECE','s2020','6241'),
(11111101,'laura','v', 'Johnson','master','ECE','s2020','6242'),
(11111101,'laura','v', 'Johnson','master','csci','f2019','6286'),
(11111101,'laura','v', 'Johnson','master','csci','s2020','6325'),
(11111101,'laura','v', 'Johnson','master','csci','f2020','6620'),
(11111101,'laura','v', 'Johnson','master','csci','f2020','6621'),
(11111101,'laura','v', 'Johnson','master','csci','s2020','6632'),
(11112122,'Eric','s', 'Leonardo','phd','csci','f2022','6221'),
(11112122,'Eric','s', 'Leonardo','phd','ECE','f2020','6241'),
(11112122,'Eric','s', 'Leonardo','phd','csci','s2020','6286'),
(11112122,'Eric','s', 'Leonardo','phd','csci','f2015','6461'),
(11112122,'Eric','s', 'Leonardo','phd','csci','f2021','6631'),
(11112122,'Eric','s', 'Leonardo','phd','csci','W2015','6632'),
(11111345,'dao','l', 'keb','phd','MATH','s2013','6210'),
(11111345,'dao','l', 'keb','phd','csci','f2015','6221'),
(11111345,'dao','l', 'keb','phd','csci','f2013','6232'),
(11111345,'dao','l', 'keb','phd','ECE','f2020','6241'),
(11111345,'dao','l', 'keb','phd','ECE','f2023','6242'),
(11111345,'dao','l', 'keb','phd','csci','s2013','6286'),
(11111345,'dao','l', 'keb','phd','csci','f2012','6325');

