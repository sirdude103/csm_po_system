<?php
###########################
# Name: PHP form_cancel.php
# Description: Handles database work to remove an order from the database
# Initial Creation Date: 01/29/2019
# Last Modification Date: 03/28/2019
# Author: Wyly Andrews
#############################

require "../php/initialization.php";

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST'  )
{

	$orderID = $_POST[ 'cancelOrderID' ];

	# Perform the update query
	$updateQuery = ("UPDATE orders SET orderStatus = 'Cancelled' WHERE orderID = ? ; ");
		
	$preparedStatement = mysqli_prepare($dbc, $updateQuery);

	mysqli_stmt_bind_param($preparedStatement, 'i', $orderID);
	
	$isSuccess = mysqli_stmt_execute($preparedStatement);
	
	if ($isSuccess)
	{
		echo "<script type='text/javascript'>";
		echo "alert('Order cancelled successfully.');";
		echo "window.location.href = 'view_all_orders.php';";
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