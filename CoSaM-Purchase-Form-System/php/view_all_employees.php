<?php
####################
# Name: PHP view_all_employees.php
# Description: Shows all employees in system
# Initial Creation Date: 11/07/2018
# Last Modification Date: 03/22/2019
# Author: Wyly Andrews
####################

require "../php/initialization.php"; 

# Reject access
if ( $_SESSION[ 'emplType' ] != 2 ) 
{ 
	header("Location: ../php/home.php");
}

#Search details
$searchRequest = "0";
$searchType = "0";
$searchOperator = "LIKE";
$sortType = "ID";
$sortDirection = "";

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
	if( isset( $_POST[ 'searchRequest' ] ) && $_POST[ 'searchRequest' ] != "" ) {
		$searchRequest = $_POST[ 'searchRequest' ];
		$searchType = "ID"; #Dummy value
	}
	if( isset( $_POST[ 'searchType' ] ) && $_POST[ 'searchType' ] != "" ) {
		$searchType = $_POST[ 'searchType' ];
		if ($searchType == "ID") {
			$searchOperator = "=";
		}
		else {
			$searchRequest = "%".$searchRequest."%";
		}
	}

	if( isset( $_POST[ 'sortType' ] ) && $_POST[ 'sortType' ] != "" ) {
		$sortType = $_POST[ 'sortType' ];
	}

	$sortDirection = $_POST[ 'sortDirection' ];
}

# Return employee
function makeEmployeeTable() {
	global $emplID;
	global $searchRequest;
	global $searchType;
	global $searchOperator;
	global $sortType;
	global $sortDirection;
	global $dbc;

	$searchQuery =  "SELECT ID, emplFirstName, emplLastName, department, emplEmail, emplType ";
	$searchQuery .= "FROM employees ";

	//$searchQuery .= "WHERE $searchType ? $searchRequest ORDER BY $sortType $sortDirection ";

	if( $searchOperator == "LIKE" ) {
		$searchQuery .= "WHERE ? LIKE ? ORDER BY ?";
	}
	else {
		$searchQuery .= "WHERE ? = ? ORDER BY ?";
	}

	if( $sortDirection == "desc") {
		$searchQuery .= " DESC";
	}

	$preparedStatement = mysqli_prepare($dbc, $searchQuery);
	
	mysqli_stmt_bind_param($preparedStatement, 'sis', $searchType, $searchRequest, $sortType);
	
	$isSuccess = mysqli_stmt_execute($preparedStatement);
	
	if ($isSuccess)
	{
		#print "<p>Query submitted successfully.</p>";
		echo "<br/>search type: " . $searchType;
		echo "<br/>search request: ". $searchRequest;
		echo "<br/>search operator: ". $searchOperator;
		echo "<br/>sort type: ". $sortType;
		echo "<br/>query: " . $searchQuery;
	}
	else 
	{
		echo "Error occurred. Record not submitted. (error 100)";
		echo "<br/>employee ID: " . $emplID;
		echo "<br/>search type: " . $searchType;
		echo "<br/>search request: ". $searchRequest;
		echo "<br/>search operator: ". $searchOperator;
		echo "<br/>query: " . $searchQuery;
		mysqli_close($dbc);
		exit();
	}

	$result = mysqli_stmt_get_result($preparedStatement);
	//echo "<br/>result: " . $result;
	if ($row = mysqli_fetch_array($result, MYSQLI_NUM))
	{

		print "<table border>";
		print "<tr>";
		print "<td>ID</td>";
		print "<td>First Name</td>";
		print "<td>Last Name</td>";
		print "<td>Department</td>";
		#print "<td>Advisor</td>";
		print "<td>Email</td>";
		print "<td>Position</td>";
		#print "<td>Advisor</td>";
		print "</tr>";
		print "<br/>";
		do 
		{

			$rowID = "row".$i;
			print "<tr id='$rowID'>";
			foreach($row as $key => $value)
				if ($key == 5) {
					switch ($value) {
						case 0:
							print("<td>user</td>");
							break;
						case 1:
							print("<td>advisor (ERROR)</td>");
							break;
						case 2:
							print("<td>administrator</td>");
							break;
						default:
							print("<td>N/A</td>");
					}
				}
				else if ($key == 6) {
					if ($value == null) { $value = "none"; }
					print ("<td>$value ");
				}
				else if ($key == 7) {
					print ("$value</td>");
				}
				else {
					print ("<td>$value</td>");
				}

			print "</tr>";

		} while($row = mysqli_fetch_array($result, MYSQLI_NUM));
		
		print "</table border>";

	} else { # No employees found
		print "<p>No matches found.</p>";
	}
}

?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>View All Employees</title>
	<link rel="stylesheet" type="text/css" href="../css/tables.css">
	<link rel="stylesheet" type="text/css" href="../css/view_all_employees.css">
	<link rel="stylesheet" type="text/css" href="../css/view_employee_orders.css">
</head>
<body>
	<div id="searchSection">
		<h2>View Employees</h2>
		<form action="../php/view_all_employees.php" method="POST" >
			<table style="width: 60%">
				<tbody>
					<tr id="searchRow">
						<td><label>Search by:</label></td>
						<td><input type="text" id="searchRequest" name="searchRequest" /></td>
						<td><select id="searchType" name="searchType" >
							<option value="ID">Select a value to search</option>
							<option value="ID">Employee ID</option>
							<option value="emplFirstName">First Name</option>
							<option value="emplLastName">Last Name</option>
							<option value="department">Department</option>
						</select></td>
						</br>
					</tr>
				</tbody>
			</table>
			</br>
			<table style="width: 60%">
				<tbody>
					<tr id="searchRow">
						<td><label>Sort by:</label></td>
						<td><select id="sortType" name="sortType" >
							<option value="">Select a value to sort</option>
							<option value="ID">Employee ID</option>
							<option value="emplFirstName">First Name</option>
							<option value="emplLastname">Last Name</option>
							<option value="department">Department</option>
							<option value="emplType">Employee Type</option>
						</select></td>
						<td><select id="sortDirection" name="sortDirection" >
							<option value="">Ascending</option>
							<option value="desc">Descending</option>
						</select></td>
					</tr>
				</tbody>
			</table>
			<input type="submit">
		</form>
		<div id="searchResults">
			<?php makeEmployeeTable(); ?>
		</div>
	</div>
</body>
