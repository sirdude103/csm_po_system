<?php

####################
# Name: PHP login_newEmplCheck.php
# Description: Checks to see if user is new or not
# Initial Creation Date: 02/24/2019
# Last Modification Date: 03/24/2019
# Author: Wyly Andrews
####################


require "../php/CAS_authentication.php";
require "../php/database_connect.php";

// retrieve affiliation
$attr = phpCAS::getAttributes();
$affiliations = $attr['scopedAffiliation'];
$isEmployee = false;

for ($affiliation in $affiliations) 
{
	if ($affiliation == "employee@ndsu.edu")
	{
		$isEmployee = true;
	}
}

if ($isEmployee) 
{
	
	$attr = phpCAS::getAttributes();
	$username = $attr['username'];
	$ePUID = $attr['eduPersonUniqueId'];
	$emplMail = $attr['mail'];

	$whileSuccess = true;
	$name = explode ( "." , $username);
	$emplFirstName = $name[0];
	$emplLastName = end($name);
	$department = "CPM"; #default
	$emplType = 0; #default

	# Make a new employee
	$insertQuery = ("INSERT INTO employees (emplFirstName, emplLastName, department, emplEmail, emplType, ePUID ) values ( ?, ?, ?, ?, ?, ? );");
		
			
	$preparedStatement = mysqli_prepare($dbc, $insertQuery);
			
	mysqli_stmt_bind_param($preparedStatement, 'ssssis', $emplFirstName, $emplLastName, $department, $emplMail, $emplType, $ePUID);
					
	$isSuccess = mysqli_stmt_execute($preparedStatement);
			
	if ($isSuccess) 
	{
		echo "<script type='text/javascript'>";
		echo "alert('Successfully added you as employee! Logging you in...');";
		echo "</script>";
		header( 'Location: ../php/home.php' );
	}
	else 
	{
		echo "Error occurred. Record not submitted. (Error: Insert)";
		mysqli_close($dbc);
		exit();
	}

} # not an employee at NDSU
else 
{
	echo "<script>console.log('no employee found. Unauthorized log-in.')</script>";
	header( 'Location: ../php/access_denied.php' );
}

?>