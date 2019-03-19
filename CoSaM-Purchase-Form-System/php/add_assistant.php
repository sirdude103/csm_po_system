<?php
####################
# Name: PHP add_assistant.php
# Description: Adds an assistant based on their ID
# Initial Creation Date: 01/31/2019
# Last Modification Date: 02/21/2019
# Author: Wyly Andrews
####################

require "../php/initialization.php";

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{

	$assistantID = $_POST['newAssistantID'];
	
	# ensure user exists
	$searchQuery = ( " SELECT ID FROM employees WHERE ID = ? " );
	
	$preparedStatement = mysqli_prepare($dbc, $searchQuery);
	
	mysqli_stmt_bind_param($preparedStatement, 'i', $assistantID);

	$isSuccess = mysqli_stmt_execute($preparedStatement);

	if ($isSuccess) 
	{
		# add employee as an assistant to the bridge table
		#$insertQuery = ( " INSERT " );
	} else {
		echo "no valid employee using ID #$assistantID.";
	}
}


?>