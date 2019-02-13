<?php
###########################
# Name: PHP form_delete.php
# Description: Handles database work to remove an order from the database
# Initial Creation Date: 01/29/2019
# Last Modification Date: 01/29/2019
# Author: Wyly Andrews
#############################

require "../php/timeout.php";

#start session so we can access session variables
session_start();
if ( !isset( $_SESSION[ 'emplID' ] )  ) 
{ 
	header("Location: ../html/login.html");
}

# validates that the user is administrator
if ( $_SESSION[ 'emplType' ] != 2) {
	echo "<script type='text/javascript'>";
	echo "alert('You must be an administrator to delete orders.');";
	echo "window.location.href = 'home.php';";
	echo "</script>";
}
else if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST'  )
{

    # Open database connection
	require ( '../php/database_connect.php' ); 

	$orderID = $_POST[ 'deleteOrderID' ];

	# Perform the delete query
	$deleteQuery = ("DELETE FROM orders WHERE orderID = $orderID ; ");
		
	$preparedStatement = mysqli_prepare($dbc, $deleteQuery);
	
	$isSuccess = mysqli_stmt_execute($preparedStatement);
	
	if ($isSuccess)
	{
		echo "<script type='text/javascript'>";
		echo "alert('Order deleted successfully.');";
		echo "window.location.href = 'home.php';";
		echo "</script>";
	}
	else 
	{
		echo "Error occurred. Record not submitted. (error 100)";
		echo "<br/>order ID: " . $orderID;
		mysqli_close($dbc);
		exit();
	}


}
?>