<?php
####################
# Name: PHP view_employee_assistants.php
# Description: shows the assistants working under current employee
# Initial Creation Date: 01/28/2019
# Last Modification Date: 02/21/2019
# Author: Wyly Andrews
####################

require "../php/initialization.php"; 

#Reject access
if ( $_SESSION[ 'emplType' ] < 1 ) 
{ 
	header("Location: ../php/home.php");
}

# Return employee
function makeAssistantTable() {
	global $emplID;
	global $dbc;

	$searchQuery = ( " SELECT * FROM employees INNER JOIN ( SELECT assistantID FROM advisorAssistant WHERE advisorID = $emplID ) AS T1 ON T1.assistantID = employees.ID; ");

	$preparedStatement = mysqli_prepare($dbc, $searchQuery);
	
	$isSuccess = mysqli_stmt_execute($preparedStatement);
	
	if ($isSuccess)
	{
		#echo "search query submitted successfully.";
	}
	else 
	{
		echo "Error occurred. Record not submitted. (error 100)";
		echo "<br/>advisor ID: " . $emplID;
		mysqli_close($dbc);
		exit();
	}

	$result = mysqli_stmt_get_result($preparedStatement);
	if ($row = mysqli_fetch_array($result, MYSQLI_NUM))
	{
		print "<table border>";
		print "<tr>";
		print "<td>Employee ID</td>";
		print "<td>First Name</td>";
		print "<td>Last Name</td>";
		print "<td>Department</td>";
		//print "<td>Employee Advisor</td>";
		print "<td>Email</td>";
		//print "<td>Employee Type</td>";
		//print "<td>Advisor ID</td>";
		print "</tr>";
		print "<br/>";
		do 
		{
			
			$rowID = "row".$i;
			print "<tr id='$rowID'>";

			$undisplayedKeys = array(4, 6, 7);
			foreach($row as $key => $value) {
				if(!in_array($key, $undisplayedKeys)) {	
					print ("<td>$value</td>");
				}
			}
			print "</tr>";

		} while($row = mysqli_fetch_array($result, MYSQLI_NUM));
		
		print "</table border>";

	} else { # No employees found
		print "<p>No matches found.</p>";
	}

}
?>

<head>
    <meta charset="utf-8" />
    <title>View Employee Assistants</title>
	<link rel="stylesheet" type="text/css" href="../css/view_employee_orders.css">
	<link rel="stylesheet" type="text/css" href="../css/tables.css">
</head>
<body>
	<div id="addSection">
		<form action="../php/add_assistant.php" method="POST" >
			<label>Add assistant by ID: </label>
			<input type="text" id="newAssistantID" name="newAssistantID" maxlength="11" required></input>
			<input type="submit" value="Add Assistant"/>
		</form>
	</div>

	<div id="searchSection">
		<h1>View Assistants</h1>
		<div id="searchResults">
			<?php makeAssistantTable(); ?>
		</div>
	</div>
</body>