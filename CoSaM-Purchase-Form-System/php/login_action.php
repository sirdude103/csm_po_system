<?php
####################
# Name: PHP login_action.php
# Description: Handles Login attempts
# Initial Creation Date: 10/2018
# Last Modification Date: 02/21/2019
# Author: Wyly Andrews
####################

require "../php/initialization.php";

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
	# Open database connection
	require ('../php/database_connect.php');

	$emplIDCheck = $_POST[ 'ID' ];
	
	// Form search query to get employee information located across multiple tables
	$searchQuery =  "SELECT T1.ID, T1.emplFirstName, T1.emplLastName, T1.department, T1.emplEmail, T1.emplType, employees.emplFirstName, employees.emplLastName ";
	$searchQuery .= "FROM employees RIGHT JOIN ";
	$searchQuery .= "( SELECT ID, emplFirstName, emplLastName, department, emplEmail, emplType, advisorID ";
	$searchQuery .= " FROM employees LEFT JOIN advisorAssistant ON advisorAssistant.assistantID = employees.ID ) ";
	$searchQuery .= "AS T1 ON T1.advisorID = employees.ID ";

	$searchQuery .= "WHERE T1.ID = ? "; 

	$preparedStatement = mysqli_prepare($dbc, $searchQuery);
	
	mysqli_stmt_bind_param($preparedStatement, 'i', $emplIDCheck);
	
	$isSuccess = mysqli_stmt_execute($preparedStatement);

	if ($isSuccess) 
	{
		echo "search query submitted successfully.";

		$result = mysqli_stmt_get_result($preparedStatement);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		# Start session
		session_start();
		$_SESSION[ 'emplID' ] = $row[0];
		$_SESSION[ 'emplFirstName' ] = $row[1];
		$_SESSION[ 'emplLastName' ] = $row[2];
		$_SESSION[ 'emplDepartment' ] = $row[3];
		$_SESSION[ 'emplEmail' ] = $row[4];
		$_SESSION[ 'emplType' ] = $row[5];

		$emplAdvisor = $row[6]." ".$row[7];
		if ($emplAdvisor == " ") { $emplAdvisor = "none"; }
		$_SESSION[ 'emplAdvisor' ] = $emplAdvisor;

		header( 'Location: ../php/home.php' );
	}
	else
	{
		mysqli_close($dbc);
		# Continue to display login page on failure.
		echo "<label>Invalid login information.</label>";
		include "../html/login.html";

	} 
#	else
#	{
#		#theoretically, reaching this point should be impossible
#		mysqli_close($dbc);
#		echo "<label>Critical Error. Please contact an administrator (multiple accounts detected).</label>";
#		include "../html/login.html";
#	}
	
}

?>