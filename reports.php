<?php
session_start();
$dept = $_POST['coursedept'];

//Ensure user is logged in
$loggedin = $_SESSION['loggedin'];
if(!$loggedin) {
	header("Location: login.php");
	die();
}

//send to menu page if they don't have sufficient permissions
if(!($_SESSION['type']=="secr" || $_SESSION['type']=="admin")) {
	header("Location: menu.php");
	die();
}

//Connect to database
$search = $_POST['search'];
$servername = "localhost";
$username = "ARGv";
$password = "CSCI2541_sp19";
$dbname = "ARGv";
$connection = mysqli_connect($servername, $username, $password, $dbname);
if (!$connection) {
	die("Couldn't connect: ".mysqli_error());
} 

//"back to menu" button
echo "<div style=\"display: inline-block;\" class=\"menu-button\">";
echo "<form action=\"menu.php\"><input type=\"submit\" value=\"Menu\"/></form></div>";
?>
<form class = "search"action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
<input type="text" name="search" placeholder="">
<input type="submit" value="Search"/>
<br>
                  <input type="radio" name="stats"> Stats
                  <input type="radio" name="applicants"> Applicants
				  <input type="radio" name="alumni"> Alumni
                  <input type="radio" name="cleared"> Cleared
<br>
				  <input type="radio" name="program"> Program
                  <input type="radio" name="semester"> Semester
				  <input type="radio" name="year"> Year

          </form>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Report Generator</title>
        <style>
            input[type=text] {
                width: 70%;
                padding: 5px 15px;
                margin: 8px 0;
                border-radius: 10px;
                border: 1px solid;
            }
        </style>
        <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
        <link rel = "stylesheet" type="text/css" href="style.css"/>
    </head>
	<body class="gray-bg">
        <?php
              

            

            //Display all courses or the search results
			if (!is_null($search)) 
			{
				if (!empty($_POST["stats"]))
				{
					if (!empty($_POST["program"]))
					{
						echo "Stats by program:";
						echo "<table>";
						echo "<thead><tr><th>Stat</th><<th>Count</th></tr></thead>";
			
						$query = "SELECT COUNT(*) as 'count' FROM user u, academic_info a  WHERE a.uid = u.uid AND a.degreeType = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . "Number of Applicants ". "</td>";
								echo "<td>" . $row["count"] . "</td>";
								echo "</tr>";
							}

						} 
						$query = "SELECT COUNT(DISTINCT u.uid) as 'count' FROM user u, app_review a, academic_info ac  WHERE a.uid = u.uid AND ac.uid = u.uid AND a.status = 8 AND ac.degreeType = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . "Number of Rejected ". "</td>";
								echo "<td>" . $row["count"] . "</td>";
								echo "</tr>";
							}

						}
						$query = "SELECT COUNT(DISTINCT u.uid) as 'count' FROM user u, app_review a, academic_info ac  WHERE a.uid = u.uid AND ac.uid = u.uid AND a.status != 8 AND ac.degreeType = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . "Number of Admitted ". "</td>";
								echo "<td>" . $row["count"] . "</td>";
								echo "</tr>";
							}

						}
						$query = "SELECT AVG(verbal) as 'avg' FROM  gre g, academic_info ac WHERE g.uid = ac.uid AND ac.degreeType = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								if($row["avg"] == NULL)
								{
									echo "<tr>";
									echo "<td>" . "Average Verbal GRE ". "</td>";
									echo "<td>" . "No data" . "</td>";
									echo "</tr>";
								}
								else
								{
									echo "<tr>";
									echo "<td>" . "Average Verbal GRE ". "</td>";
									echo "<td>" . $row["avg"] . "</td>";
									echo "</tr>";
								}
							}

						}
						$query = "SELECT AVG(quant) as 'avg' FROM  gre g, academic_info ac WHERE g.uid = ac.uid AND ac.degreeType = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								if($row["avg"] == NULL)
								{
									echo "<tr>";
									echo "<td>" . "Average Quantative GRE ". "</td>";
									echo "<td>" . "No data" . "</td>";
									echo "</tr>";
								}
								else
								{
									echo "<tr>";
									echo "<td>" . "Average Quantative GRE ". "</td>";
									echo "<td>" . $row["avg"] . "</td>";
									echo "</tr>";
								}
							}
							echo "</table>";

						}
					}
					else if (!empty($_POST["semester"]))
					{
						echo "Stats by semester:";
						echo "<table>";
						echo "<thead><tr><th>Stat</th><<th>Count</th></tr></thead>";
			
						$query = "SELECT COUNT(*) as 'count' FROM user u, academic_info a  WHERE a.uid = u.uid AND a.semester = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . "Number of Applicants ". "</td>";
								echo "<td>" . $row["count"] . "</td>";
								echo "</tr>";
							}

						} 
						$query = "SELECT COUNT(DISTINCT u.uid) as 'count' FROM user u, app_review a, academic_info ac  WHERE a.uid = u.uid AND ac.uid = u.uid AND a.status = 8 AND ac.semester = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . "Number of Rejected ". "</td>";
								echo "<td>" . $row["count"] . "</td>";
								echo "</tr>";
							}

						}
						$query = "SELECT COUNT(DISTINCT u.uid) as 'count' FROM user u, app_review a, academic_info ac  WHERE a.uid = u.uid AND ac.uid = u.uid AND a.status != 8 AND ac.semester = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . "Number of Admitted ". "</td>";
								echo "<td>" . $row["count"] . "</td>";
								echo "</tr>";
							}

						}
						$query = "SELECT AVG(verbal) as 'avg' FROM  gre g, academic_info ac WHERE g.uid = ac.uid AND ac.semester = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								if($row["avg"] == NULL)
								{
									echo "<tr>";
									echo "<td>" . "Average Verbal GRE ". "</td>";
									echo "<td>" . "No data" . "</td>";
									echo "</tr>";
								}
								else
								{
									echo "<tr>";
									echo "<td>" . "Average Verbal GRE ". "</td>";
									echo "<td>" . $row["avg"] . "</td>";
									echo "</tr>";
								}
							}

						}
						$query = "SELECT AVG(quant) as 'avg' FROM  gre g, academic_info ac WHERE g.uid = ac.uid AND ac.semester = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								if($row["avg"] == NULL)
								{
									echo "<tr>";
									echo "<td>" . "Average Quantative GRE ". "</td>";
									echo "<td>" . "No data" . "</td>";
									echo "</tr>";
								}
								else
								{
									echo "<tr>";
									echo "<td>" . "Average Quantative GRE ". "</td>";
									echo "<td>" . $row["avg"] . "</td>";
									echo "</tr>";
								}
							}
							echo "</table>";

						}
					}
					else if (!empty($_POST["year"]))
					{
						echo "Stats by year:";
						echo "<table>";
						echo "<thead><tr><th>Stat</th><<th>Count</th></tr></thead>";
			
						$query = "SELECT COUNT(*) as 'count' FROM user u, academic_info a  WHERE a.uid = u.uid AND a.year = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . "Number of Applicants ". "</td>";
								echo "<td>" . $row["count"] . "</td>";
								echo "</tr>";
							}

						} 
						$query = "SELECT COUNT(DISTINCT u.uid) as 'count' FROM user u, app_review a, academic_info ac  WHERE a.uid = u.uid AND ac.uid = u.uid AND a.status = 8 AND ac.year = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . "Number of Rejected ". "</td>";
								echo "<td>" . $row["count"] . "</td>";
								echo "</tr>";
							}

						}
						$query = "SELECT COUNT(DISTINCT u.uid) as 'count' FROM user u, app_review a, academic_info ac  WHERE a.uid = u.uid AND ac.uid = u.uid AND a.status != 8 AND ac.year = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . "Number of Admitted ". "</td>";
								echo "<td>" . $row["count"] . "</td>";
								echo "</tr>";
							}

						}
						$query = "SELECT AVG(verbal) as 'avg' FROM  gre g, academic_info ac WHERE g.uid = ac.uid AND ac.year = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								if($row["avg"] == NULL)
								{
									echo "<tr>";
									echo "<td>" . "Average Verbal GRE ". "</td>";
									echo "<td>" . "No data" . "</td>";
									echo "</tr>";
								}
								else
								{
									echo "<tr>";
									echo "<td>" . "Average Verbal GRE ". "</td>";
									echo "<td>" . $row["avg"] . "</td>";
									echo "</tr>";
								}
							}

						}
						$query = "SELECT AVG(quant) as 'avg' FROM  gre g, academic_info ac WHERE g.uid = ac.uid AND ac.year = '$search'"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
				
							//Display CRN, department, course number, name, credits, day, and time
							while ($row = mysqli_fetch_assoc($result)) 
							{
								if($row["avg"] == NULL)
								{
									echo "<tr>";
									echo "<td>" . "Average Quantative GRE ". "</td>";
									echo "<td>" . "No data" . "</td>";
									echo "</tr>";
								}
								else
								{
									echo "<tr>";
									echo "<td>" . "Average Quantative GRE ". "</td>";
									echo "<td>" . $row["avg"] . "</td>";
									echo "</tr>";
								}
							}
							echo "</table>";

						}
					}
					else
					{
						//If nothing came back from the query, there was a problem
                    	echo "The report could not be generated due to a lack of data.";
					}

					

				}
				else if (!empty($_POST["alumni"]))
				{
					if (!empty($_POST["program"]))
					{
						$query = "SELECT * FROM user u, dates d WHERE d.uid = u.uid AND u.type = 'alum' AND u.program = '$search' ORDER BY d.grad_year";  
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
							echo "Alumni by program:";
							echo "<table>";
							//Display CRN, department, course number, name, credits, day, and time
							echo "<thead><tr><th>Alumni</th><th>Email</th><th>Program</th><th>Graduated</th></tr></thead>";
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . $row["lname"] . ", " . $row["fname"] . "</td>";
								echo "<td>" . $row["email"] . "</td>";
								echo "<td>" . $row["program"] . "</td>";
								echo "<td>" . $row["grad_sem"] . " " . $row["grad_year"] . "</td>";

								echo "</tr>";
							}
							echo "</table>";
						}
					}
					if (!empty($_POST["semester"]))
					{
						$query = "SELECT * FROM user u, dates d WHERE d.uid = u.uid AND u.type = 'alum' AND d.grad_sem = '$search' ORDER BY d.grad_year, d.grad_sem";  
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
							echo "Alumni by semester:";
							echo "<table>";
							//Display CRN, department, course number, name, credits, day, and time
							echo "<thead><tr><th>Alumni</th><th>Email</th><th>Program</th><th>Graduated</th></tr></thead>";
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . $row["lname"] . ", " . $row["fname"] . "</td>";
								echo "<td>" . $row["email"] . "</td>";
								echo "<td>" . $row["program"] . "</td>";
								echo "<td>" . $row["grad_sem"] . " " . $row["grad_year"] . "</td>";

								echo "</tr>";
							}
							echo "</table>";
						}
					}
					if (!empty($_POST["year"]))
					{
						$query = "SELECT * FROM user u, dates d WHERE d.uid = u.uid AND u.type = 'alum' AND d.grad_year = '$search' ORDER BY d.grad_year";  
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
							echo "Alumni by year:";
							echo "<table>";
							//Display CRN, department, course number, name, credits, day, and time
							echo "<thead><tr><th>Alumni</th><th>Email</th><th>Program</th><th>Graduated</th></tr></thead>";
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . $row["lname"] . ", " . $row["fname"] . "</td>";
								echo "<td>" . $row["email"] . "</td>";
								echo "<td>" . $row["program"] . "</td>";
								echo "<td>" . $row["grad_year"] . "</td>";
								echo "</tr>";
							}
							echo "</table>";
						}
					}
                    
				}
				else if (!empty($_POST["applicants"]))
				{
					if (!empty($_POST["program"]))
					{
						$query = "SELECT * FROM user u, academic_info a WHERE a.uid = u.uid AND degreeType = '$search' ORDER BY semester, year"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
							echo "Applicant by semester:";
							echo "<table>";
							//Display CRN, department, course number, name, credits, day, and time
							echo "<thead><tr><th>Applicant</th><th>Email</th><th>Program</th><th>Applied</th></tr></thead>";
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . $row["lname"] . ", " . $row["fname"] . "</td>";
								echo "<td>" . $row["email"] . "</td>";
								echo "<td>" . $row["degreeType"] . "</td>";
								echo "<td>" . $row["semester"] . "</td>";
								echo "<td>" . $row["year"] . "</td>";

								echo "</tr>";
							}
							echo "</table>";

						}
					}
					if (!empty($_POST["semester"]))
					{
						$query = "SELECT * FROM user u, academic_info a WHERE a.uid = u.uid AND semester = '$search' ORDER BY year, semester"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
							echo "Applicant by semester:";
							echo "<table>";
							//Display CRN, department, course number, name, credits, day, and time
							echo "<thead><tr><th>Applicant</th><th>Email</th><th>Program</th><th>Applied</th></tr></thead>";
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . $row["lname"] . ", " . $row["fname"] . "</td>";
								echo "<td>" . $row["email"] . "</td>";
								echo "<td>" . $row["degreeType"] . "</td>";
								echo "<td>" . $row["semester"] . "</td>";
								echo "<td>" . $row["year"] . "</td>";

								echo "</tr>";
							}
							echo "</table>";

						}
					}
					if (!empty($_POST["year"]))
					{
						$query = "SELECT * FROM user u, academic_info a WHERE a.uid = u.uid AND year = '$search' ORDER BY year"; 
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
							echo "Applicant by semester:";
							echo "<table>";
							//Display CRN, department, course number, name, credits, day, and time
							echo "<thead><tr><th>Applicant</th><th>Email</th><th>Program</th><th>Applied</th></tr></thead>";
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . $row["lname"] . ", " . $row["fname"] . "</td>";
								echo "<td>" . $row["email"] . "</td>";
								echo "<td>" . $row["degreeType"] . "</td>";
								echo "<td>" . $row["year"] . "</td>";

								echo "</tr>";
							}
							echo "</table>";

						}
					}
                    
				}
				else if (!empty($_POST["cleared"]))
				{
					if (!empty($_POST["program"]))
					{
						$query = "SELECT * FROM user u, dates d WHERE d.uid = u.uid AND u.type = 'alum' AND u.program = '$search' ORDER BY d.grad_year";  
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
							echo "Cleared by program:";
							echo "<table>";
							//Display CRN, department, course number, name, credits, day, and time
							echo "<thead><tr><th>Alumni</th><th>Email</th><th>Program</th><th>Cleared</th></tr></thead>";
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . $row["lname"] . ", " . $row["fname"] . "</td>";
								echo "<td>" . $row["email"] . "</td>";
								echo "<td>" . $row["program"] . "</td>";
								echo "<td>" . $row["grad_sem"] . " " . $row["grad_year"] . "</td>";

								echo "</tr>";
							}
							echo "</table>";
						}
					}
					if (!empty($_POST["semester"]))
					{
						$query = "SELECT * FROM user u, dates d WHERE d.uid = u.uid AND u.type = 'alum' AND d.grad_sem = '$search' ORDER BY d.grad_year, d.grad_sem";  
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
							echo "Cleared by semester:";
							echo "<table>";
							//Display CRN, department, course number, name, credits, day, and time
							echo "<thead><tr><th>Alumni</th><th>Email</th><th>Program</th><th>Cleared</th></tr></thead>";
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . $row["lname"] . ", " . $row["fname"] . "</td>";
								echo "<td>" . $row["email"] . "</td>";
								echo "<td>" . $row["program"] . "</td>";
								echo "<td>" . $row["grad_sem"] . " " . $row["grad_year"] . "</td>";

								echo "</tr>";
							}
							echo "</table>";
						}
					}
					if (!empty($_POST["year"]))
					{
						$query = "SELECT * FROM user u, dates d WHERE d.uid = u.uid AND u.type = 'alum' AND d.grad_year = '$search' ORDER BY d.grad_year";  
						$result = mysqli_query($connection, $query);
						if (mysqli_num_rows($result) > 0) 
						{
							echo "Cleared by year:";
							echo "<table>";
							//Display CRN, department, course number, name, credits, day, and time
							echo "<thead><tr><th>Alumni</th><th>Email</th><th>Program</th><th>Cleared</th></tr></thead>";
							while ($row = mysqli_fetch_assoc($result)) 
							{
								echo "<tr>";
								echo "<td>" . $row["lname"] . ", " . $row["fname"] . "</td>";
								echo "<td>" . $row["email"] . "</td>";
								echo "<td>" . $row["program"] . "</td>";
								echo "<td>" . $row["grad_year"] . "</td>";
								echo "</tr>";
							}
							echo "</table>";
						}
					}
                    
                }
			} 
			else {
                //There WERE search terms, so display same info as above but for only the relevant courses
                echo $search;
            }
            //close sql connection
            mysqli_close($connection);
        ?>
	</body>
</html>
