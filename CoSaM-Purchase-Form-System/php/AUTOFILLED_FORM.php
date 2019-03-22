<?php
####################
# Name: PHP AUTOFILLED_FORM.php
# Description: Purchase Page (autofilled for test purposes only)
# Initial Creation Date: 10/12/2018
# Last Modification Date: 03/22/2019
# Author: Wyly Andrews
####################

require "../php/initialization.php";
?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Purchase Form (Autofilled)</title>
    <script src="../javascript/form.js" defer></script>
	<link rel="stylesheet" type="text/css" href="../css/purchase.css">
</head>
<body>
	<div id=formSection>
		<h1>Purchase Form Demo</h1>
		<label class="warning"> * denotes a required field.</label>
		<br/>
		<form action="../php/form_submit.php" method="POST" onsubmit="return validateMyForm();">
			<fieldset>
				<legend>Employee Information</legend>

				<div class="inputRow">
					<label>*First Name</label>
					<input type="text" id="emplFirstName" name="emplFirstName" value=<?php echo $_SESSION['emplFirstName']; ?> readonly="readonly" required />
				</div>
				<div class="inputRow">
					<label>*Last Name</label>
					<input type="text" id="emplLastName" name="emplLastName" value=<?php echo $_SESSION['emplLastName']; ?> readonly="readonly" required />
				</div>
				<div class="inputRow">
					<label>*Department</label>
					<select id="selectDepartment" name="selectDepartment" required>
						<option value="NONE" selected disabled>Select a Department</option>
						<option value="BIO-AGHILL" <?php if($_SESSION[emplDepartment] == "BIO-AGHILL") { echo "selected"; } ?> >Biological Sciences: A Glenn Hill</option>
						<option value="BIO-STEVENS" <?php if($_SESSION[emplDepartment] == "BIO-STEVENS") { echo "selected"; } ?> >Biological Sciences: Stevens</option>
						<option value="CHEM-QBB" <?php if($_SESSION[emplDepartment] == "CHEM-QBB") { echo "selected"; } ?> >Chemistry and Biochemistry: QBB</option>
						<option value="CHEM-LADD" <?php if($_SESSION[emplDepartment] == "CHEM-LADD") { echo "selected"; } ?> >Chemistry and Biochemistry: Ladd/Dunbar</option>
						<option value="CPM" <?php if($_SESSION[emplDepartment] == "CPM") { echo "selected"; } ?> >Coatings and Polymeric Materials</option>
						<option value="CSCI" <?php if($_SESSION[emplDepartment] == "CSCI") { echo "selected"; } ?> >Computer Science</option>
						<option value="GEO" <?php if($_SESSION[emplDepartment] == "GEO") { echo "selected"; } ?> >Geosciences</option>
						<option value="MATH" <?php if($_SESSION[emplDepartment] == "MATH") { echo "selected"; } ?> >Mathematics</option>
						<option value="PHYS" <?php if($_SESSION[emplDepartment] == "PHYS") { echo "selected"; } ?> >Physics</option>
						<option value="PSYC" <?php if($_SESSION[emplDepartment] == "PSYC") { echo "selected"; } ?> >Psychology</option>
						<option value="STAT" <?php if($_SESSION[emplDepartment] == "STAT") { echo "selected"; } ?> >Statistics</option>
					</select>
				</div>
				<div class="inputRow">
					<label>Email</label>
					<input type="text" id="emplEmail" name="emplEmail" <?php if($_SESSION['emplEmail']!="") {echo "value= ".$_SESSION['emplEmail'];} ?> readonly="readonly" />
				</div>
			</fieldset>

			<fieldset>
				<legend>Purchase Information</legend>
				<div class="inputRow">
					<label>Purchase Order #: </label>
					<label id="formOrderID">Submit form to view order number</label>
				</div>
				<div class="inputRow">
					<label>Form Status: </label>
					<label id="formStatus"></label>
				</div>
				<div class="inputRow">
					<label>Order Date: </label>
					<label id="orderDate"><?php echo date("m/d/Y"); ?></label>
				</div>
				<div class="inputRow">
					<label>Order Time: </label>
					<label id="orderTime"><?php echo date("h:i:s a"); ?></label>
				</div>
			</fieldset>

			<fieldset>
				<legend>Vendor Information</legend>
				<div class="inputRow">
					<label>*Vendor Name</label>
					<input type="text" id="vendorName" name="vendorName" value="Walmart" required />
				</div>
				<div class="inputRow">
					<label>Vendor Email</label>
					<input type="text" id="vendorEmail" name="vendorEmail" value="Walmart@example.com" />
				</div>
				<div class="inputRow">
					<label>Vendor Phone</label>
					<input type="text" id="vendorPhone" name="vendorPhone" value="0987654321" />
				</div>
			</fieldset>
			<fieldset>
				<legend>Funding</legend>
				<div class="inputRow">
					<label>*Funding</label>
				</div>
				<p>
					<textarea rows="3" cols="50" id="funding" name="funding" required>Example Grant</textarea>
				</p>
			</fieldset>
			<fieldset>
				<legend>Product Information</legend>
				<table>
					<thead>
						<tr>
							<th>Quantity</th>
							<th>Catalog No.</th>
							<th>Description</th>
							<th>Unit Price</th>
							<th>Total Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr id="row">
							<td><input type="number" id="productQuantity" name="productQuantity[]" min="1" value="5" required/></td>
							<td><input type="text" id="productCatalogNumber" name="productCatalogNumber[]" value="12345" required/></td>
							<td><input type="text" size="35" name="productDescription[]" value="Chairs" required/></td>
							<td>$ <input type="number" class="money" id="productUnitPrice" name="productUnitPrice[]" min="0.00" step="0.01" value="100.00" required/></td>
							<td>$ <input type="number" class="money" id="productTotalAmount" name="productTotalAmount[]" min="0.00" step="0.01" value="500.00" readonly required/></td>
							<td id="subtractButtonCell"><button type="button" id="subtractButton" style="visibility:hidden"><img src="../images/subtract.png" style="width:18px;height:18px"></button></td>
							<td id="addButtonCell"><button type="button" id="addButton"><img src="../images/add.png" style="width:18px;height:18px"></button></td>
						</tr>
					</tbody>
				</table>
				<div class="inputRow">
					<label>*Shipping & Handling Costs:</label><label class="dollar"> $</label>
					<input type="number" class="money" id="shippingHandlingCost" name="shippingHandlingCost" min="0.00" step="0.01" value="20.00" required/>
				</div>
				<div class="inputRow">
					<label>*Additional Fees:</label><label class="dollar"> $</label>
					<input type="number" class="money" id="additionalCost" name="additionalCost" min="0.00" step="0.01" value="0.50" required/>
				</div>
				<div class="inputRow">
					<label>Total Cost:</label><label class="dollar"> $</label>
					<label id="labelTotalCost" >520.00</label>
					<input type="hidden" id="totalCost" name="totalCost" />
					<label id="warningTotalCost" name="warningTotalCost" class="warning"></label>
				</div>
			</fieldset>
			<fieldset>
				<legend>Ship to Address</legend>
				<div class="inputRow">
					<label>Default Address:</label>
					<label>Ship-To Additional Information</label>
				</div>
				<div class="inputRow">
					<label id="shipToAddress">Please enter a valid department.</label>
					<textarea rows="4" cols="50" id="shipToAdditional" name="shipToAdditional">Room 204B</textarea>
				</div>
			</fieldset>
			<fieldset>
				<legend>Bill to Address</legend>
				<div class="inputRow">
					<label>Default Address:</label>
					<label>Bill-To Additional Information</label>
				</div>
				<div class="inputRow">
					<label id="billToAddress">Please enter a valid department.</label>
					<textarea rows="4" cols="50" id="billToAdditional" name="billToAdditional">abcde</textarea>
				</div>
			</fieldset>
			<fieldset>
				<legend>Additional Information</legend>
				<p>
					<label>Please enter any additional information about the purchase. </label>
				</p>
				<p>
					<textarea rows="5" cols="50" id="additionalInformation" name="additionalInformation">The ACM needs these chairs by Thursday.</textarea>
				</p>
			</fieldset>
			<p>
				<input type="submit">
			</p>
		</form>
	</div>
</body>
</html>