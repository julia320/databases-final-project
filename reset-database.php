<!DOCTYPE html>

<head>
    <title>Redirecting...</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
    <link rel = "stylesheet" type="text/css" href="style.css"/>
</head>

<body>
    <?php
        $q1 = "DROP TABLE IF EXISTS transcript CASCADE";
        $q2 = "DROP TABLE IF EXISTS course CASCADE";
        $q3 = "DROP TABLE IF EXISTS room CASCADE";
        $q4 = "DROP TABLE IF EXISTS user CASCADE";

        $q5 = "create table user(fname varchar(20), lname varchar(20), uid int(8) auto_increment, street varchar(50), city varchar(20), state varchar(2), zip int(5), phone varchar(10), email varchar(20), password varchar(20), active varchar(5), type varchar(5), PRIMARY KEY (uid))";
        $q6 = "create table room(roomid int(6), cap int(2), building varchar(20), rmnumber int(4), PRIMARY KEY (roomid))";
        $q7 = "create table course(semester varchar(6), credits int(1), section int(2), year int(4), name varchar(40), dept varchar(20), courseno int(4), prereq1 varchar(20), prereq2 varchar(20), day varchar(20), tme varchar(20), instructor int(8), crn int(10) auto_increment, location int(6), PRIMARY KEY (crn), foreign key (instructor) references user(uid), foreign key (location) references room(roomid))";
        $q8 = "create table transcript(uid int(8), grade varchar(2), crn int(10), lineid int auto_increment primary key, foreign key (uid) references user(uid), foreign key (crn) references course(crn))";
        
        $q9_1 = "insert into room VALUES";
        $q9_2 = "(1, 24, 'SEH', 1300),";
        $q9_3 = "(2, 24, 'SEH', 1400),";
        $q9_4 = "(3, 24, 'SEH', 1450),";
        $q9_5 = "(4, 80, 'SMPA', 404),";
        $q9_6 = "(5, 80, 'SMPA', 405),";
        $q9_7 = "(6, 80, 'SMPA', 204),";
        $q9_8 = "(7, 80, 'SMPA', 205),";
        $q9_9 = "(8, 60, 'SMPA', 210),";
        $q9_10 = "(9, 60, 'SMPA', 410),";
        $q9_11 = "(10, 30, 'SEH', 4040),";
        $q9_12 = "(11, 30, 'SEH', 3040),";
        $q9_13 = "(12, 30, 'SEH', 5040)";
        $q9 = $q9_1.$q9_2.$q9_3.$q9_4.$q9_5.$q9_6.$q9_7.$q9_8.$q9_9.$q9_10.$q9_11.$q9_12.$q9_13;

        $q10_1 = "insert into user (fname, lname, street, city, state, zip, phone, email, password, active, type) VALUES";
        $q10_2 = "('Richard', 'Sear', 'Wisconsin Ave', 'Washington', 'DC', 20052, '0123456789', 'searri@gwu.edu', '123456', 'yes', 'MS'),";
        $q10_3 = "('Rachell', 'Kim', 'I Street', 'Washington', 'DC', 20052, '1234567890', 'rachell@gwu.edu', '123456', 'yes', 'MS'),";
        $q10_4 = "('Selin', 'Onal', 'Pennsylvania Ave', 'Washington', 'DC', 20052, '2345678901', 'selingonal@gwu.edu', '123456', 'no', 'PHD'),";
        $q10_5 = "('Maya', 'Shende', 'Wisconsin Ave', 'Washington', 'DC', 20052, '3456789012', 'shende@gwu.edu', '123456', 'yes', 'inst'),";
        $q10_6 = "('Dietrich', 'Reidenbaugh', 'Pennsylvania Ave', 'Washington', 'DC', 20052, '4567890123', 'dreidenbaugh@gwu.edu', '123456', 'yes', 'admin'),";
        $q10_7 = "('Dawn', 'Ginetti', 'Franklin St', 'Arlington', 'VA', 22201, '5678901234', 'dawn@gwu.edu', '123456', 'yes', 'secr'),";
        $q10_8 = "('Aylin', 'Caliskan', 'Wisconsin Ave', 'Washington', 'DC', 20052, '6789012345', 'caliskan@gwu.edu', '123456', 'yes', 'inst'),";
        $q10_9 = "('Timothy', 'Wood', 'Wisconsin Ave', 'Washington', 'DC', 20052, '7890123456', 'timwood@gwu.edu', '123456', 'yes', 'inst'),";
        $q10_10 = "('Abdou', 'Youssef', 'Wisconsin Ave', 'Washington', 'DC', 20052, '8901234567', 'youssef@gwu.edu', '123456', 'yes', 'inst'),";
        $q10_11 = "('Bhagi', 'Narahari', 'Wisconsin Ave', 'Washington', 'DC', 20052, '9012345678', 'narahari@gwu.edu', '123456', 'yes', 'inst'),";
        $q10_12 = "('Pablo', 'Bolton', 'Wisconsin Ave', 'Washington', 'DC', 20052, '0012345678', 'pablo@gwu.edu', '123456', 'yes', 'inst'),";
        $q10_13 = "('Poorvi', 'Vora', 'Wisconsin Ave', 'Washington', 'DC', 20052, '112345678', 'vora@gwu.edu', '123456', 'yes', 'inst'),";
        $q10_14 = "('Hyeong-Ah', 'Choi', 'Minnesota Ave', 'Washington', 'DC', 20052, '1412345732', 'hchoi@gwu.edu', '123456', 'yes', 'inst')";
        $q10 = $q10_1.$q10_2.$q10_3.$q10_4.$q10_5.$q10_6.$q10_7.$q10_8.$q10_9.$q10_10.$q10_11.$q10_12.$q10_13.$q10_14;

        $q11_1 = "insert into course (dept, courseno, name, credits, prereq1, prereq2, day, tme, section, year, semester, instructor, location) VALUES";
        $q11_2 = "('CSCI', 6221, 'SW Paradigms', 3,  null, null, 'M', '1500-1730',1,2019,'Spring',8,1),";
        $q11_3 = "('CSCI', 6461, 'Computer Architecture', 3, null, null, 'T', '1500-1730',1,2019,'Spring',10,1),";
        $q11_4 = "('CSCI', 6212, 'Algorithms', 3, null, null, 'W', '1500-1700',1,2019,'Spring',13,1),";
        $q11_5 = "('CSCI', 6220, 'Machine Learning', 3, null, null, null, null,null,null,null,null,null),";
        $q11_6 = "('CSCI', 6232, 'Networks 1', 3, null, null, 'M', '1800-2030',1,2019,'Spring',10,2),";
        $q11_7 = "('CSCI', 6233, 'Networks 2', 3, 'CSCI 6232', null, 'T', '1800-2030',1,2019,'Spring',11,2),";
        $q11_8 = "('CSCI', 6241, 'Database 1', 3, null, null, 'W', '1800-2030',1,2019,'Spring',8,2),";
        $q11_9 = "('CSCI', 6242, 'Database 2', 3, 'CSCI 6241', null, 'R', '1800-2030',1,2019,'Spring',9,2),";
        $q11_10 = "('CSCI', 6246, 'Compilers', 3, 'CSCI 6461', 'CSCI 6212', 'T', '1500-1730',1,2019,'Spring',8,3),";
        $q11_11 = "('CSCI', 6260, 'Multimedia', 3, null, null, 'R', '1800-2030',1,2019,'Spring',4,3),";
        $q11_12 = "('CSCI', 6251, 'Cloud Computing', 3, 'CSCI 6461', null, 'M', '1800-2030',1,2019,'Spring',7,6),";
        $q11_13 = "('CSCI', 6254, 'SW Engineering', 3, 'CSCI 6221', null,'M', '1530-1800',1,2019,'Spring',9,3),";
        $q11_14 = "('CSCI', 6262, 'Graphics 1', 3, null, null,'W', '1800-2030',1,2019,'Spring',7,4),";
        $q11_15 = "('CSCI', 6283, 'Security 1', 3, 'CSCI 6212', null, 'T', '1800-2030',1,2019,'Spring',4,3), ";
        $q11_16 = "('CSCI', 6284, 'Cryptography', 3, 'CSCI 6212', null, 'M', '1800-2030',1,2019,'Spring',12,10), ";
        $q11_17 = "('CSCI', 6286, 'Network Security', 3, 'CSCI 6283', 'CSCI 6232', 'W', '1800-2030',1,2019,'Spring',11,10), ";
        $q11_18 = "('CSCI', 6325, 'Algorithms 2', 3, 'CSCI 6212', null, null, null,null,null,null,null,null), ";
        $q11_19 = "('CSCI', 6339, 'Embedded Systems', 3, 'CSCI 6461', 'CSCI 6212', 'R', '1600-1830',1,2019,'Spring',11,10),";
        $q11_20 = "('CSCI', 6384, 'Cryptography 2', 3, 'CSCI 6284', null, 'W', '1500-1730',1,2019,'Spring',10,10), ";
        $q11_21 = "('ECE', 6241, 'Communication Theory', 3, null, null, 'M', '1800-2030',1,2019,'Spring',4,11), ";
        $q11_22 = "('ECE', 6242, 'Information Theory', 2, null, null, 'T', '1800-2030',1,2019,'Spring',9,11), ";
        $q11_23 = "('MATH', 6210, 'Logic', 2, null, null,'W', '1800-2030',1,2019,'Spring',12,9),";
        $q11_24 = "('CSCI', 6212, 'Algorithms', 3, null, null, 'W', '1500-1700',1,2018,'Fall',9,1),";
        $q11_25 = "('CSCI', 6232, 'Networks 1', 3, null, null, 'M', '1800-2030',1,2018,'Fall',10,2),";
        $q11_26 = "('CSCI', 6233, 'Networks 2', 3, 'CSCI 6232', null, 'T', '1800-2030',1,2018,'Fall',11,2),";
        $q11_27 = "('CSCI', 6220, 'Machine Learning', 3, null, null, null, null,null,2018,'Fall',null,null),";
        $q11_28 = "('CSCI', 6325, 'Algorithms 2', 3, 'CSCI 6212', null, null, null,null,2018,'Fall',null,null)";
        $q11 = $q11_1.$q11_2.$q11_3.$q11_4.$q11_5.$q11_6.$q11_7.$q11_8.$q11_9.$q11_10.$q11_11.$q11_12.$q11_13.$q11_14.$q11_15.$q11_16.$q11_17.$q11_18.$q11_19.$q11_20.$q11_21.$q11_22.$q11_23.$q11_24.$q11_25.$q11_26.$q11_27.$q11_28;

        $q12 = "insert into transcript (uid, grade, crn) VALUES (1,'A',23), (1,'A',24),(1,'A-',25),(2,'B+',23),(2,'B',24),(2,'B-',25),(3,'C+',26),(3,'C',27)";
        
        $q13 = "insert into user (fname, lname, uid, password, type, active) values ('Billie', 'Holiday', 88888888, '123456', 'MS', 'yes'), ('Diana', 'Krall', 99999999, '123456', 'MS', 'yes')";
        $q14 = "insert into transcript (uid, grade, crn) values (88888888, 'IP', 2), (88888888, 'IP', 3)";

        //connect to database
        $servername = "localhost";
        $username = "SELECT_team_name";
        $password = "Password123!";
        $dbname = "SELECT_team_name";
        $connection = mysqli_connect($servername, $username, $password, $dbname);
        $result = mysqli_query($connection, $q1);
        if(!$result) {
            die("Query Error: 1");
        }
        $result = mysqli_query($connection, $q2);
        if(!$result) {
            die("Query Error: 2");
        }
        $result = mysqli_query($connection, $q3);
        if(!$result) {
            die("Query Error: 3");
        }
        $result = mysqli_query($connection, $q4);
        if(!$result) {
            die("Query Error: 4");
        }
        $result = mysqli_query($connection, $q5);
        if(!$result) {
            die("Query Error: 5");
        }
        $result = mysqli_query($connection, $q6);
        if(!$result) {
            die("Query Error: 6");
        }
        $result = mysqli_query($connection, $q7);
        if(!$result) {
            die("Query Error: 7");
        }
        $result = mysqli_query($connection, $q8);
        if(!$result) {
            die("Query Error: 8");
        }
        $result = mysqli_query($connection, $q9);
        if(!$result) {
            die("Query Error: 9");
        }
        $result = mysqli_query($connection, $q10);
        if(!$result) {
            die("Query Error: 10");
        }
        $result = mysqli_query($connection, $q11);
        if(!$result) {
            die("Query Error: 11");
        }
        $result = mysqli_query($connection, $q12);
        if(!$result) {
            die("Query Error: 12");
        }
        $result = mysqli_query($connection, $q13);
        if(!$result) {
            die("Query Error: 13");
        }
        $result = mysqli_query($connection, $q14);
        if(!$result) {
            die("Query Error: 14");
        }
        header("Location: login.php");
        die();
    ?>
</body>

</html>
