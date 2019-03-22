<?php
###########################
# Name: PHP form_submit.php
# Description: Handles initial purchase form submission
# Initial Creation Date: 9/30/2018
# Last Modification Date: 03/22/2019
# Author: Wyly Andrews
#############################

require "../php/initialization.php";

# Helper function to help us debug the program
function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) ) {
        $output = implode( ',', $output);
	}
    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{

    function modify_input($input) {
        $input = trim($input);
        $input = htmlspecialchars($input);
        return $input;
    }

	# Employee Information
    $emplFirstName = modify_input( $_POST['emplFirstName']);
    $emplLastName = modify_input( $_POST['emplLastName']);
    $emplDepartment = modify_input( $_POST['selectDepartment']);
    $emplEmail = modify_input( $_POST['emplEmail']);
    
	# Vendor Information
    $vendorName = $_POST['vendorName'];
    $vendorEmail = $_POST['vendorEmail'];
    $vendorPhone = $_POST['vendorPhone'];

	# Funding Information
    $funding = modify_input( $_POST['funding']);

	# Individual Product Information
	$productQuantity = $_POST['productQuantity'];
	$productCatalogNumber = $_POST['productCatalogNumber'];
	$productDescription = $_POST['productDescription'];
	$productUnitPrice = $_POST['productUnitPrice'];
	$productTotalAmount = $_POST['productTotalAmount'];

	# Total Product Information
	$shippingHandlingCost = $_POST['shippingHandlingCost'];
	$additionalCost = $_POST['additionalCost'];
	$totalCost = $_POST['totalCost'];

	# Additional Information
	$additionalInfo = modify_input( $_POST['additionalInformation']);
	$orderStatus = "Submitted";

	# Bill/Ship Information
	$shipInfo = modify_input( $_POST['shipToAdditional']);
	$billInfo = modify_input( $_POST['billToAdditional']);

	if ( isset( $_SESSION[ 'emplID' ] ) ) 
	{ 
		$employeeID = $_SESSION[ 'emplID' ];
	}
	else 
	{
		# no employee found
		mysqli_close($dbc);
		exit;
		
	}

	# make a new order
	echo $employeeID;
	echo $vendorName;
	echo $vendorEmail;
	echo $vendorPhone;
	echo $funding;
	echo $shippingHandlingCost;
	echo $additionalCost;
	echo $totalCost;

	$insertQuery = "INSERT INTO orders(employeeID, creationDT, vendName, vendEmail, vendPhone, funding, shippingHandlingCost, additionalCost, totalCost, orderStatus, additionalInfo, orderDepartment, shipAdditional, billAdditional) values ( ? , NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
	
	$preparedStatement = mysqli_prepare($dbc, $insertQuery);
	
	mysqli_stmt_bind_param($preparedStatement, 'issssdddsssss', $employeeID, $vendorName, $vendorEmail, $vendorPhone, $funding, $shippingHandlingCost, $additionalCost, $totalCost, $orderStatus, $additionalInfo, $emplDepartment, $shipInfo, $billInfo);
	
	$isSuccess = mysqli_stmt_execute($preparedStatement);
	
	if ($isSuccess) 
	{
		echo "order query submitted successfully.";
		$orderID = mysqli_insert_id($dbc);
	}
	else 
	{
		echo "Error occurred. Record not submitted.";
		mysqli_close($dbc);
        exit();
	}
	
	#Delcare an array to keep track of all product IDs
	$currentOrderProducts = array();

	# record the products submitted
	for ($i = 0; $i < count($productQuantity); $i++ )
	{
		$insertQuery = ("INSERT INTO products(quantity, catalogNumber, description, unitPrice, totalPrice) values (?, ?, ?, ?, ?)");
	
		$preparedStatement = mysqli_prepare($dbc, $insertQuery);
	
		mysqli_stmt_bind_param($preparedStatement, 'issss', $productQuantity[$i], $productCatalogNumber[$i], $productDescription[$i], $productUnitPrice[$i], $productTotalAmount[$i] );
	
		$isSuccess = mysqli_stmt_execute($preparedStatement);
		
		if ($isSuccess) 
		{
			echo "product query submitted successfully.";
			$currentOrderProducts[$i] = mysqli_insert_id($dbc);
		}
		else 
		{
			echo "Error occurred. Record not submitted.";
			mysqli_close($dbc);
			exit();
		}
	}

	# Create bridge table between orders and products
	for ($i = 0; $i < count($currentOrderProducts); $i++ )
	{
		$insertQuery = ("INSERT INTO orderProduct(orderID, productID) values ( ? , ? )");
		
		$preparedStatement = mysqli_prepare($dbc, $insertQuery);
	
		mysqli_stmt_bind_param($preparedStatement, 'ii', $orderID, $currentOrderProducts[$i] );
	
		$isSuccess = mysqli_stmt_execute($preparedStatement);

		if ($isSuccess) 
		{
			echo "orderProduct query submitted successfully.";
		}
		else 
		{
			echo "Error occurred. Record not submitted.";
			mysqli_close($dbc);
			exit();
		}
	}

	# View form in pdf format.

	$_SESSION[ 'viewOrderByID' ] = $orderID;
	header("Location: view_individual_order.php");


	#foreach($productQuantity as $value) 
	#	echo $value.'<br />';

}
#echo('end if statement.');

# Close the database
mysqli_close( $dbc );

#If failure, go back to form
include ( '../php/form.php' );
?>