<?php
####################
# Name: PHP add_assistant.php
# Description: Adds an assistant based on their ID
# Initial Creation Date: 01/31/2019
# Last Modification Date: 01/31/2019
# Author: Wyly Andrews
####################

#start session so we can access session variables
session_start();
if ( !isset( $_SESSION[ 'emplID' ] ) ) 
{ 
	header("Location: ../html/login.html");
}

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
	require ( '../php/database_connect.php' );


	$assistantID = $_POST['newAssistantID'];
	
	# ensure user exists
	$searchQuery = ( " SELECT ID FROM employees WHERE ID = $assistantID " );
	$result = mysqli_query($dbc, $searchQuery);

	if (@mysqli_num_rows( $result ) == 1) 
	{
		# add employee as an assitant to the bridge table
		#$insertQuery = ( " INSERT " );
	} else {
		echo "no valid employee using ID #$assistantID.";
	}
}


?>