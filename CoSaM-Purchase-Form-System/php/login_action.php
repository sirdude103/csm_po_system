<?php
####################
# Name: PHP login_action.php
# Description: Handles Login attempts
# Initial Creation Date: 10/2018
# Last Modification Date: 03/22/2019
# Author: Wyly Andrews
####################

$current_file = "php/login_action.php";
require_once "../php/CAS_authentication.php";

$attr = phpCAS::getAttributes();
$ePUID = $attr['eduPersonUniqueId'];

# Open database connection
require_once ('../php/database_connect.php');

// Form search query to get employee information located across multiple tables
$searchQuery =  "SELECT ID, emplFirstName, emplLastName, department, emplEmail, emplType, ePUID ";
$searchQuery .= "FROM employees ";

$searchQuery .= "WHERE ePUID = ? "; 

$preparedStatement = mysqli_prepare($dbc, $searchQuery);

mysqli_stmt_bind_param($preparedStatement, 's', $ePUID);

$isSuccess = mysqli_stmt_execute($preparedStatement);
if ($isSuccess) 
{
	echo "search query submitted successfully. </br>";
	echo "searchQuery: " . $searchQuery . "</br>";
	echo "ePUID: " . $ePUID . "</br>";
	echo "preparedStatement: " . $preparedStatement . "</br>";
	mysqli_stmt_bind_result($preparedStatement, $id, $emplFirstName, $emplLastName, $department, $emplEmail, $emplType, $ePUID);
	mysqli_stmt_fetch($preparedStatement);
	echo "id: " . $id . "</br>";
	if($id != 0)
	{
		echo "results found!";
		# Start session
		$save_path = session_save_path('/var/lib/php/session/groups/csm-po-system');
		session_start();
		$_SESSION[ 'emplID' ] = $id;
		$_SESSION[ 'emplFirstName' ] = $emplFirstName;
		$_SESSION[ 'emplLastName' ] = $emplLastName;
		$_SESSION[ 'emplDepartment' ] = $department;
		$_SESSION[ 'emplEmail' ] = $emplEmail;
		$_SESSION[ 'emplType' ] = $empType;
	
		echo "session variable emplID: " . $_SESSION[ 'emplID' ];
		header( 'Location: ../php/home.php' );
	}
	else
	{
		# send to login_newEmplCheck to check for registration
		echo "no results found!";
		header("Location: ../php/login_newEmplCheck.php");
	} 
}


?>