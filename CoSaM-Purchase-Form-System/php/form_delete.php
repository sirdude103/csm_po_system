<?php
###########################
# Name: PHP form_delete.php
# Description: Handles database work to remove an order from the database
# Initial Creation Date: 01/29/2019
# Last Modification Date: 02/21/2019
# Author: Wyly Andrews
#############################

require "../php/initialization.php";

# validates that the user is administrator
if ( $_SESSION[ 'emplType' ] != 2) {
	echo "<script type='text/javascript'>";
	echo "alert('You must be an administrator to delete orders.');";
	echo "window.location.href = 'home.php';";
	echo "</script>";
}
else if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST'  )
{

	$orderID = $_POST[ 'deleteOrderID' ];

	# Perform the delete query
	$deleteQuery = ("DELETE FROM orders WHERE orderID = ? ; ");
		
	$preparedStatement = mysqli_prepare($dbc, $deleteQuery);

	mysqli_stmt_bind_param($preparedStatement, 'i', $orderID);
	
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