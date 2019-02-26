<?php

####################
# Name: PHP login_newEmplCheck.php
# Description: Checks to see if user is new or not
# Initial Creation Date: 02/24/2019
# Last Modification Date: 02/24/2019
# Author: Wyly Andrews
####################


require "../php/CAS_authentication.php";
require "../php/database_connect.php";

$searchQuery = "SELECT username FROM newEmployees";

$preparedStatement = mysqli_prepare($dbc, $searchQuery);

$isSuccess = mysqli_stmt_execute($preparedStatement);

if ($isSuccess) 
{
	

	$result = mysqli_stmt_get_result($preparedStatement);

	$attr = phpCAS::getAttributes();
	$username = $attr['username'];
	$ePUID = $attr['eduPersonUniqueId'];
	$emplMail = $attr['mail'];

	$whileSuccess = false;
	while($row = mysqli_fetch_array($result, MYSQLI_NUM))
	{

		if ($row[0] == $username) # new user found
		{
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
				# user found, delete from list
				$deleteQuery = ("DELETE FROM newEmployees WHERE username = ? ;");
		
				$preparedStatementDel = mysqli_prepare($dbc, $deleteQuery);
	
				mysqli_stmt_bind_param($preparedStatementDel, 's', $username);
	
				$isSuccessDel = mysqli_stmt_execute($preparedStatementDel);
			
				if ($isSuccessDel) 
				{
					echo "<script type='text/javascript'>";
					echo "alert('Successfully added you as employee! Logging you in...');";
					echo "</script>";
					header( 'Location: ../php/home.php' );
				}
				else 
				{
					echo "Error occurred. Record not submitted. (Error: Delete)";
					mysqli_close($dbc);
					exit();
				}
			}
			else 
			{
				echo "Error occurred. Record not submitted. (Error: Insert)";
				mysqli_close($dbc);
				exit();
			}


			break;
			
		} # if statement
	} # while loop

	if (!$whileSuccess) 
	{
		echo "<script>console.log('no employee found. Unauthorized log-in.')</script>";
	}
} # search request

?>