<?php
####################
# Name: PHP login_action.php
# Description: Handles Login attempts
# Initial Creation Date: 10/2018
# Last Modification Date: 03/22/2019
# Author: Wyly Andrews
####################

require "../php/CAS_authentication.php";

$attr = phpCAS::getAttributes();
$ePUID = $attr['eduPersonUniqueId'];

# Open database connection
require ('../php/database_connect.php');

// Form search query to get employee information located across multiple tables
$searchQuery =  "SELECT ID, emplFirstName, emplLastName, department, emplEmail, emplType, ePUID ";
$searchQuery .= "FROM employees ";

$searchQuery .= "WHERE ePUID = ? "; 

$preparedStatement = mysqli_prepare($dbc, $searchQuery);

mysqli_stmt_bind_param($preparedStatement, 's', $ePUID);

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
	
	header( 'Location: ../php/home.php' );
}
else
{

	# send to login_newEmplCheck to check for registration
	echo "<script type='text/javascript'>";
	echo "alert('Unable to find your log-in! Checking new users...');";
	echo "</script>";

	header("Location: ../php/login_newEmplCheck.php");
} 


?>