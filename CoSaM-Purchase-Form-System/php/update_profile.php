<?php 

###########################
# Name: PHP update_profile.php
# Description: Updates profile to autofill forms with information
# Initial Creation Date: 10/21/2018
# Last Modification Date: 11/02/2018
# Author: Wyly Andrews
#############################

require "../php/initialization.php";

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{

	$emplID = $_SESSION[ 'emplID' ];

	#$newEmail = $_POST[ 'emplEmail' ];
	$newEmail = $_POST[ 'emplEmail' ];
	$newDepartment = $_POST[ 'selectDepartment' ];

	# Check if update is necessary
	if( $_SESSION[ 'emplDepartment' ] != $newDepartment || $_SESSION[ 'emplEmail' ] != $newEmail )
	{
		# Update is necessary
		$updateQuery = "UPDATE employees SET department = ?, emplEmail = ? WHERE ID = ?";
		$preparedStatement = mysqli_prepare($dbc, $updateQuery);
	
		mysqli_stmt_bind_param($preparedStatement, 'ssi', $newDepartment, $newEmail, $emplID);
	
		$isSuccess = mysqli_stmt_execute($preparedStatement);

		if($isSuccess)
		{
			$_SESSION[ 'emplDepartment' ] = $newDepartment;
			$_SESSION[ 'emplEmail' ] = $newEmail;
		}
	}

	header("Location: ../php/profile.php");
}


?>