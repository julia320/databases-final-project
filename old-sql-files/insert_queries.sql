
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

insert into user (fname, lname, street, city, state, zip, phone, email, password, active, type)VALUES
	("Richard", "Sear", "Wisconsin Ave", "Washington", "DC", 20052, "0123456789", "searri@gwu.edu", "123456", "yes", "MS"),
	("Rachell", "Kim", "I Street", "Washington", "DC", 20052, "1234567890", "rachell@gwu.edu", "123456", "yes", "MS"),
	("Selin", "Onal", "Pennsylvania Ave", "Washington", "DC", 20052, "2345678901", "selingonal@gwu.edu", "123456", "no", "PHD"),
	("Maya", "Shende", "Wisconsin Ave", "Washington", "DC", 20052, "3456789012", "shende@gwu.edu", "123456", "yes", "inst"),
	("Dietrich", "Reidenbaugh", "Pennsylvania Ave", "Washington", "DC", 20052, "4567890123", "dreidenbaugh@gwu.edu", "123456", "yes", "admin"),
	("Dawn", "Ginetti", "Franklin St", "Arlington", "VA", 22201, "5678901234", "dawn@gwu.edu", "123456", "yes", "secr"),
	("Aylin", "Caliskan", "Wisconsin Ave", "Washington", "DC", 20052, "6789012345", "caliskan@gwu.edu", "123456", "yes", "inst"),
	("Timothy", "Wood", "Wisconsin Ave", "Washington", "DC", 20052, "7890123456", "timwood@gwu.edu", "123456", "yes", "inst"),
	("Abdou", "Youssef", "Wisconsin Ave", "Washington", "DC", 20052, "8901234567", "youssef@gwu.edu", "123456", "yes", "inst"),
	("Bhagi", "Narahari", "Wisconsin Ave", "Washington", "DC", 20052, "9012345678", "narahari@gwu.edu", "123456", "yes", "inst"),
	("Pablo", "Bolton", "Wisconsin Ave", "Washington", "DC", 20052, "0012345678", "pablo@gwu.edu", "123456", "yes", "inst"),
	("Poorvi", "Vora", "Wisconsin Ave", "Washington", "DC", 20052, "112345678", "vora@gwu.edu", "123456", "yes", "inst");


insert into course (dept, courseno, name, credits, prereq1, prereq2, day, tme, section, year, semester, instructor, location)
VALUES
	("CSCI", 6221, "SW Paradigms", 3,  null, null, "M", "1500-1730",1,2019,"Spring",8,1), 
	("CSCI", 6461, "Computer Architecture", 3, null, null, "T", "1500-1730",1,2019,"Spring",10,1), 
	("CSCI", 6212, "Algorithms", 3, null, null, "W", "1500-1700",1,2019,"Spring",9,1), 
	("CSCI", 6220, "Machine Learning", 3, null, null, null, null,null,null,null,null,null), 
	("CSCI", 6232, "Networks 1", 3, null, null, "M", "1800-2030",1,2019,"Spring",10,2), 
	("CSCI", 6233, "Networks 2", 3, "CSCI 6232", null, "T", "1800-2030",1,2019,"Spring",11,2), 
	("CSCI", 6241, "Database 1", 3, null, null, "W", "1800-2030",1,2019,"Spring",8,2), 
	("CSCI", 6242, "Database 2", 3, "CSCI 6241", null, "R", "1800-2030",1,2019,"Spring",9,2), 
	("CSCI", 6246, "Compilers", 3, "CSCI 6461", "CSCI 6212", "T", "1500-1730",1,2019,"Spring",8,3), 
	("CSCI", 6260, "Multimedia", 3, null, null, "R", "1800-2030",1,2019,"Spring",4,3), 
	("CSCI", 6251, "Cloud Computing", 3, "CSCI 6461", null, "M", "1800-2030",1,2019,"Spring",7,6), 
	("CSCI", 6254, "SW Engineering", 3, "CSCI 6221", null,"M", "1530-1800",1,2019,"Spring",9,3), 
	("CSCI", 6262, "Graphics 1", 3, null, null,"W", "1800-2030",1,2019,"Spring",7,4), 
	("CSCI", 6283, "Security 1", 3, "CSCI 6212", null, "T", "1800-2030",1,2019,"Spring",4,3), 
	("CSCI", 6284, "Cryptography", 3, "CSCI 6212", null, "M", "1800-2030",1,2019,"Spring",12,10), 
	("CSCI", 6286, "Network Security", 3, "CSCI 6283", "CSCI 6232", "W", "1800-2030",1,2019,"Spring",11,10), 
	("CSCI", 6325, "Algorithms 2", 3, "CSCI 6212", null, null, null,null,null,null,null,null), 
	("CSCI", 6339, "Embedded Systems", 3, "CSCI 6461", "CSCI 6212", "R", "1600-1830",1,2019,"Spring",11,10), 
	("CSCI", 6384, "Cryptography 2", 3, "CSCI 6284", null, "W", "1500-1730",1,2019,"Spring",10,10), 
	("ECE", 6241, "Communication Theory", 3, null, null, "M", "1800-2030",1,2019,"Spring",4,11), 
	("ECE", 6242, "Information Theory", 2, null, null, "T", "1800-2030",1,2019,"Spring",9,11), 
	("MATH", 6210, "Logic", 2, null, null,"W", "1800-2030",1,2019,"Spring",12,9),
	("CSCI", 6212, "Algorithms", 3, null, null, "W", "1500-1700",1,2018,"Fall",9,1),
	("CSCI", 6232, "Networks 1", 3, null, null, "M", "1800-2030",1,2018,"Fall",10,2),
	("CSCI", 6233, "Networks 2", 3, "CSCI 6232", null, "T", "1800-2030",1,2018,"Fall",11,2),
	("CSCI", 6220, "Machine Learning", 3, null, null, null, null,null,2018,"Fall",null,null),
	("CSCI", 6325, "Algorithms 2", 3, "CSCI 6212", null, null, null,null,2018,"Fall",null,null);


insert into transcript (uid, grade, crn)
VALUES
	(1,"A",23),
	(1,"A",24),
	(1,"A-",25),
	(2,"B+",23),
	(2,"B",24),
	(2,"B-",25),
	(3,"C+",26),
	(3,"C",27);

insert into user (fname, lname, uid, password, type, active) values ('Billie', 'Holiday', 88888888, '123456', 'MS', 'yes'), ('Diana', 'Krall', 99999999, '123456', 'MS', 'yes');
insert into transcript (uid, grade, crn) values (88888888, 'IP', 2), (88888888, 'IP', 3);


