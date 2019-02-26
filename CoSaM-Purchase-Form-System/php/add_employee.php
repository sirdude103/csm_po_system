<?php

####################
# Name: PHP add_employee.php
# Description: adds an employee by username into the newEmployees table
# Initial Creation Date: 02/24/2019
# Last Modification Date: 02/24/2019
# Author: Wyly Andrews
####################

require "../php/initialization.php"; 

function modify_input($input) {
    $input = trim($input);
    $input = htmlspecialchars($input);
    return $input;
}

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{

	$username = modify_input( $_POST['addRequest']);

	$insertQuery = ("INSERT INTO newEmployees (username) values ( ? ); ");

	$preparedStatement = mysqli_prepare($dbc, $insertQuery);
	

	mysqli_stmt_bind_param($preparedStatement, 's', $username);
	
	$isSuccess = mysqli_stmt_execute($preparedStatement);

	if($isSuccess)
	{
		echo "<script type='text/javascript'>";
		echo "alert('Employee added successfully! Have the user log-in to complete registration.');";
		echo "window.location.href = 'home.php';";
		echo "</script>";
	}
	else 
	{
		echo "Error occurred. Record not submitted.";
		mysqli_close($dbc);
        exit();
		header("Location: view_all_employees.php");
	}
}
?>