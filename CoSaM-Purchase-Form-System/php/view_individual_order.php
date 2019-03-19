<?php 

####################
# Name: PHP view_individual_order.php
# Description: Views accessed order and all connected products
# Initial Creation Date: 10/20/2018
# Last Modification Date: 02/21/2019
# Author: Wyly Andrews
####################

require "../php/initialization.php";

# Call session variables
$emplID = $_SESSION[ 'emplID' ];
$emplFirstName = $_SESSION[ 'emplFirstName' ];
$emplLastName = $_SESSION[ 'emplLastName' ];
$emplDepartment = $_SESSION[ 'emplDepartment' ];
$emplAdvisor = $_SESSION[ 'emplAdvisor' ];
$emplEmail = $_SESSION[ 'emplEmail' ];
if($emplEmail == "") { $emplEmail = "None"; }


if ( isset( $_SESSION[ 'viewOrderByID' ] ) )
{
	$orderID = $_SESSION[ 'viewOrderByID' ];
	unset( $_SESSION[ 'viewOrderByID' ] ); #Unset to avoid permanently calling this order
}
elseif ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
	$orderID = $_POST[ 'viewOrderButton' ];
}
else
{

	echo "An error has occured.";
	# Close the database
	mysqli_close( $dbc );

	#If failure, bail back to home
	header("Location: ../php/home.php");
}

# Return orders
$searchQuery = ( " SELECT * FROM orders WHERE orderID = ? " );

$preparedStatement = mysqli_prepare($dbc, $searchQuery);
	
mysqli_stmt_bind_param($preparedStatement, 'i', $orderID);
	
$isSuccess = mysqli_stmt_execute($preparedStatement);

if ($isSuccess) 
{
	
	$result = mysqli_stmt_get_result($preparedStatement);
	$row = mysqli_fetch_array($result, MYSQLI_NUM);

	# Employee Information
	$emplIDOnOrder = $row[1];
	
	$iSearchQuery = ( " SELECT * FROM employees WHERE ID = ? " );

	$iPreparedStatement = mysqli_prepare($dbc, $iSearchQuery);
	
	mysqli_stmt_bind_param($iPreparedStatement, 'i', $emplIDOnOrder);
	
	$iIsSuccess = mysqli_stmt_execute($iPreparedStatement);

	if ($iIsSuccess)
	{
		$iResult = mysqli_stmt_get_result($iPreparedStatement);
		$iRow = mysqli_fetch_array($iResult, MYSQLI_NUM);

		$emplFirstName = $iRow[1];
		if($emplFirstName == "") { $emplFirstName = "Error"; }
		$emplLastName = $iRow[2];
		if($emplLastName == "") { $emplLastName = "Error"; }
		$emplDepartment = $iRow[3];
		if($emplDepartment == "") { $emplDepartment = "Error"; }
		$emplAdvisor = $iRow[4];
		if($emplAdvisor == "") { $emplAdvisor = "None"; }
		$emplEmail = $iRow[5];
		if($emplEmail == "") { $emplEmail = "None"; }
	}

	# Vendor Information
	$vendorName = $row[3];
	if($vendorName == "") { $vendorName = "Error"; }
	$vendorEmail = $row[4];
	if($vendorEmail== "") { $vendorEmail = "None"; }
	$vendorPhone = $row[5];
	if($vendorPhone == "") { $vendorPhone = "None"; }

	# Funding Information
	$funding = $row[6];
	if($funding == "") { $funding = "Error"; }

	# Total Product Information
	$shippingHandlingCost = $row[7];
	if($shippingHandlingCost == "") { $shippingHandlingCost = "Error"; }
	$additionalCost = $row[8];
	if($additionalCost == "") { $additionalCost = "Error"; }
	$totalCost = $row[9];
	if($totalCost == "") { $totalCost = "Error"; }

	# Additional Information
	$orderStatus = $row[10];
	if($orderStatus == "") { $orderStatus = "Error"; }
	$additionalInformation = $row[11];
	if($additionalInformation == "") { $additionalInformation = "None"; }

	# Employee Information (at time of order)
	$orderDepartment = $row[12];
	if($orderDepartment == "") { $orderDepartment = "Error"; }

	# Ship/Bill Information
	$shipToAdditional = $row[13];
	if($shipToAdditional == "") { $shipToAdditional= "None"; }
	$billToAdditional = $row[14];
	if($billToAdditional == "") { $billToAdditional= "None"; }

	$datetime = new DateTime($row[2]);
	$orderDate = $datetime->format('Y-m-d');
	$orderTime = $datetime->format('g:i:s a'); 

	# Individual Product Information
	$products = array();

	$iSearchQuery = ( " SELECT productID FROM orderProduct WHERE orderID = ?");

	$iPreparedStatement = mysqli_prepare($dbc, $iSearchQuery);
	
	mysqli_stmt_bind_param($iPreparedStatement, 'i', $orderID);
	
	$iIsSuccess = mysqli_stmt_execute($iPreparedStatement);

	if ($iIsSuccess) 
	{
		#echo "orderProduct search query submitted successfully.";
	}
	else 
	{
		echo "Error occurred. Record not submitted.";
		mysqli_close($dbc);
		exit();
	}

	# Each loop is a new product
	$iResult = mysqli_stmt_get_result($iPreparedStatement);
	for($j=0; $jRow = mysqli_fetch_row($iResult); $j++)
	{
		$productID = $jRow[0];
		$jSearchQuery = ( " SELECT * FROM products WHERE productID = ? ");
		$jPreparedStatement = mysqli_prepare($dbc, $jSearchQuery);
	
		mysqli_stmt_bind_param($jPreparedStatement, 'i', $productID);
	
		$jIsSuccess = mysqli_stmt_execute($jPreparedStatement);

		if ($jIsSuccess) 
		{
			#echo "search query submitted successfully.";
		}
		else 
		{
			echo "Error occurred. Record not submitted.";
			mysqli_close($dbc);
			exit();
		}

		$product = array();
		
		# Each loop is a value of product
		$jResult = mysqli_stmt_get_result($jPreparedStatement);
		for($k=0; $kRow = mysqli_fetch_row($jResult); $k++)
		{
			foreach($kRow as $value)
				array_push($product, $value);
		}

		array_push($products, $product);
	}

}
else
{
	mysqli_close($dbc);
	# Continue to display home page on failure.
	echo '<script type="text/javascript">alert("Order not found, please try again.");</script>';
	header("Location: ../php/home.php");
}

switch($orderDepartment) {
	case "BIO-AGHILL":
        $shipTo =
            "A Glenn Hill Bldg" . "<br/>"
            . "1306 Centennial Blvd" . "<br/>"
            . "1340 Albrecht Boulevard" . "<br>"
            . "Fargo, ND 58102";
        $billTo =
            "Attn: Account Technician" . "<br/>"
            . "NDSU Dept. 2735 Ladd Hall Room 104" . "<br/>"
            . "PO Box 6050" . "<br/>"
            . "Fargo, ND 58108-6050";
        break;
    case "BIO-STEVENS":
        $shipTo =
            "Department of Biological Sciences" . "<br/>"
            . "North Dakota State University" . "<br/>"
            . "1340 Bolley Drive, 201 Stevens Hall" . "<br/>"
            . "Fargo, ND 58102";
		$billTo =
            "Attn: Account Technician" . "<br/>"
            . "NDSU Dept. 2735 Ladd Hall Room 104" . "<br/>"
            . "PO Box 6050" . "<br/>"
            . "Fargo, ND 58108-6050";
        break;
    case "CHEM-QBB":
        $shipTo =
            "Attn: " . $emplFirstName . " " . $emplLastName . "<br/>"
            . "NDSU Quentin Burdick Building 334" . "<br/>"
            . "1320 Albrecht Blvd" . "<br>"
            . "Fargo, ND 58102";
        $billTo =
            "North Dakota State University" . "<br/>"
            . "Department of Chemistry & Biochemistry" . "<br/>"
            . "NDSU Dept 2735" . "<br/>"
            . "PO Box 6050" . "<br/>"
            . "Fargo, ND 58108-6050";
        break;
    case "CHEM-LADD":
        $shipTo =
            "Department of Chemistry & Biochemistry" . "<br/>"
            . "NDSU Ladd Hall 208" . "<br/>"
            . "1231 Albrecht Blvd" . "<br/>"
            . "Fargo, ND 58102";
        $billTo =
            "North Dakota State University" . "<br/>"
            . "Department of Chemistry & Biochemistry" . "<br/>"
            . "NDSU Dept 2735" . "<br/>"
            . "PO Box 6050" . "<br/>"
            . "Fargo, ND 58108-6050";
        break;
    case "CPM":
        $shipTo =
            "Attn: " . $emplFirstName . " " . $emplLastName . "<br/>"
            . "Research 1, Room 216" . "<br/>"
            . "1735 NDSU Research Park Drive North" . "<br/>"
            . "Fargo, North Dakota 58102";
        $billTo =
            "Grant Account Technician" . "<br/>"
            . "NDSU Dept. 2705 Minard Hall 202" . "<br/>"
            . "PO Box 6050" . "<br/>"
            . "Fargo, ND 58108-6050";
        break;
    case "CSCI":
        $shipTo =
            "Quentin Burdick Building Room 258" . "<br/>"
            . "1320 Albrecht Boulevard" . "<br/>"
            . "Fargo, ND 58102";
        $billTo = 
			"Department of Biological Sciences" . "<br/>"
            . "North Dakota State University" . "<br/>"
            . "1340 Bolley Drive, 201 Stevens Hall" . "<br/>"
            . "Fargo, ND 58102";
        break;
    case "GEO":
        $shipTo =
            "North Dakota State University" . "<br/>"
            . "1340 Bolley Drive, 201 Stevens Hall" . "<br/>"
            . "Fargo, ND 58102";
        $billTo = 
			"Department of Biological Sciences" . "<br/>"
            . "North Dakota State University" . "<br/>"
            . "1340 Bolley Drive, 201 Stevens Hall" . "<br/>"
            . "Fargo, ND 58102";
        break;
    case "MATH":
        $shipTo =
            "NDSU Dept 2750" . "<br/>"
            . "1210 Albrecht Blvd" . "<br/>"
            . "Fargo, ND 58105";
        $billTo =
            "Attn: Mathematics" . "<br/>"
            . "NDSU Dept 2750" . "<br/>"
            . "PO Box 6050" . "<br/>"
            . "Fargo, ND 58108-6050";
        break;
    case "PHYS":
        $shipTo =
            "NDSU Dept. 2755" . "<br/>"
            . "1211 Albrecht Blvd" . "<br/>"
            . "Fargo, ND 58105";
        $billTo =
            "Attn: Physics" . "<br/>"
            . "NDSU Dept 2755" . "<br/>"
            . "PO Box 6050" . "<br/>"
            . "Fargo, ND 58108-6050";
        break; 
    case "PSYC":
        $shipTo =
            "NDSU Dept 2765" . "<br/>"
            . "1210 Albrecht Blvd" . "<br/>"
            . "Fargo, ND 58105";
        $billTo =
            "Attn: Psychology" . "<br/>"
            . "NDSU Dept 2765" . "<br/>"
            . "PO Box 6050" . "<br/>"
            . "Fargo, ND 58108-6050";
        break;
    case "STAT":
        $shipTo =
            "NDSU Dept 2770" . "<br/>"
            . "1230 Albrecht Blvd" . "<br/>"
            . "Fargo, ND 58105";
        $billTo =
            "Attn: Statistics" . "<br/>"
            . "NDSU Dept 2770" . "<br/>"
            . "PO Box 6050" . "<br/>"
            . "Fargo, ND 58108-6050";
        break;
    default:
        $shipTo = "No valid department selected";
        $billTo = "No valid department selected";
}

?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>View Individual Order</title>
	<script src="../javascript/validate_delete.js" defer></script>
	<link rel="stylesheet" type="text/css" href="../css/view_individual_order.css">
	<link rel="stylesheet" type="text/css" href="../css/print.css">
	<link rel="stylesheet" type="text/css" href="../css/tables.css">

</head>
<body>
	<!-- <button href="#" onclick="HTMLtoPDF()">Download PDF</button>-->
    <div id="HTMLtoPDF">
		<div id="page1" class="page">
			<div id="emplInfo" class="item">
				<fieldset>
					<label>Employee Information</label>
					<p><h4>Name: </h4><label><?php echo "$emplFirstName $emplLastName"; ?></label></p>
					<p><h4>ID: </h4><label><?php echo "$emplIDOnOrder"; ?></label></p>
					<p><h4>Department: </h4><label><?php echo "$orderDepartment"; ?></label></p>
					<p><h4>Advisor: </h4><label><?php echo "$emplAdvisor"; ?></label></p>
					<p><h4>Email: </h4><label><?php echo "$emplEmail"; ?></label></p>
				</fieldset>
			</div>
			<div id="vendInfo" class="item">
				<fieldset>
					<label>Vendor Information</label>
					<p><h4>Name: </h4><label><?php echo "$vendorName"; ?></label></p>
					<p><h4>Email: </h4><label><?php echo "$vendorEmail"; ?></label></p>
					<p><h4>Phone: </h4><label><?php echo "$vendorPhone"; ?></label></p>
				</fieldset>
			</div>
			<div id="shipInfo" class="item">
				<fieldset>
					<label>Shipping Information</label>
					<p><?php echo "$shipTo"; ?></p>
					<h4>Notes:</h4>
					<p><?php echo "$shipToAdditional"; ?></p>
				</fieldset>
			</div>
			<div id="billInfo" class="item">
				<fieldset>
					<label>Billing Information</label>
					<p><?php echo "$billTo"; ?></p>
					<h4>Notes:</h4>
					<p><?php echo "$billToAdditional"; ?></p>
				</fieldset>
			</div>
			<div id="fundingInfo" class="item">
				<span>
				<fieldset>
					<label>Funding Information</label>
					<p><label><?php echo "$funding"; ?></label></p>
				</fieldset>
				</span>
			</div>
		</div>
		<div id="page2" class="page">
			<div id="productInfo" class="item">
				<fieldset>
					<label>Product Information</label>
					<table border>
						<tr><td>Quantity</td><td>Catalog Number</td><td>Description</td><td>Unit Price</td><td>Total Price</td></tr>
						<?php
							foreach($products as $product)
							{
								print "<tr>";
								foreach($product as $key => $value)
								{
									if($value != $product[0])
									{
										if($key == 4 || $key == 5)
											print "<td>$$value</td>";
										else
											print "<td>$value</td>";
									}
								}
								print "</tr>";
							}
						?>
					</table border>
				</fieldset>
			</div>
			<div id="additionalInfo" class="item">
				<span>
				<fieldset>
					<label>Order Information</label>
					<p><h4>Order Number: </h4><label><?php echo "$orderID"; ?></label></p>
					<p><h4>Order Status: </h4><label><?php echo "$orderStatus"; ?></label></p>
					<p><h4>Order Submission Date: </h4><label><?php echo"$orderDate"; ?></label></p>
					<p><h4>Order Submission Time: </h4><label><?php echo"$orderTime"; ?></label></p>
					<p><h4>Additional Information: </h4><label><?php echo"$additionalInformation"; ?></label></p>
				</fieldset>
				</span>
			</div>
			<div id="totalInfo" class="item">
				<span>
				<fieldset>
					<label>Total Cost Information</label>
					<p><h4>Shipping and Handling Cost: </h4><label><?php echo"$$shippingHandlingCost"; ?></label></p>
					<p><h4>Additional Cost: </h4><label><?php echo"$$additionalCost"; ?></label></p>
					<p><h4>Total Cost: </h4><label><?php echo"$$totalCost"; ?></label></p>
				</fieldset>
				</span>
			</div>
		</div>
    </div>

	<div id="divButtons">
		<button type="editButton" onclick="">Edit Form</button>

		<br/>

		<form id="deleteForm" action='../php/form_delete.php' onsubmit='return validateDelete()' method='POST'>
			<input type='hidden' name='deleteOrderID' value=<?php echo $orderID; ?> >
			<input type='submit' value='Delete Form'/>
		</form>
	</div>

	<div class="printButton">
		<a class="printit" href="javascript:window.print()"> Print Order </a> 
	</div>

</body>
</html>
