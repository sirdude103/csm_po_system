<?php
####################
# Name: PHP profile.php
# Description: Hosts profile page to allow changes to profile
# Initial Creation Date: 10/30/2018
# Last Modification Date: 11/26/2018
# Author: Wyly Andrews
####################

#start session so we can access session variables
session_start();
if ( isset( $_SESSION[ 'emplID' ] ) ) 
{ 
	$emplID = $_SESSION[ 'emplID' ];
	$emplFirstName = $_SESSION[ 'emplFirstName' ];
	$emplLastName = $_SESSION[ 'emplLastName' ];
	$emplDepartment = $_SESSION[ 'emplDepartment' ];
	$emplAdvisor = $_SESSION[ 'emplAdvisor' ];
	$emplEmail = $_SESSION[ 'emplEmail' ];
	if($emplEmail == "") { $emplEmail = "None"; }
}
else
{
	header("Location: ../html/login.html");
}

include( '../php/header_footer.php' );

?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Profile</title>
	<script src="../javascript/profile.js" defer></script>
</head>
<body>
	<h1>Profile</h1></br>
	<form action="../php/update_profile.php" method="POST" id="profileForm" >
		<fieldset>
			<h4>Name: </h4><label><?php echo $emplFirstName . " " . $emplLastName; ?></label>
			<h4>Employee ID: </h4><label><?php echo $emplID; ?></label>
			<h4>Advisor: </h4><label><?php echo $emplAdvisor; ?></label>
			<h4>Email: </h4><p><input type="text" id="emplEmail" name="emplEmail" value=<?php echo $emplEmail; ?> /></p>
			<h4>Department: </h4>
			<select id="selectDepartment" name="selectDepartment">
				<option value="NONE" >Select a Department</option>
				<option value="BIO-AGHILL" <?php if($_SESSION[emplDepartment] == "BIO-AGHILL") { echo "selected"; } ?> >Biological Sciences: A Glenn Hill</option>
				<option value="BIO-STEVENS" <?php if($_SESSION[emplDepartment] == "BIO-STEVENS") { echo "selected"; } ?> >Biological Sciences: Stevens</option>
				<option value="CHEM-QBB" <?php if($_SESSION[emplDepartment] == "CHEM-QBB") { echo "selected"; } ?> >Chemistry and Biochemistry: QBB</option>
				<option value="CHEM2-LADD" <?php if($_SESSION[emplDepartment] == "CHEM-LADD") { echo "selected"; } ?> >Chemistry and Biochemistry: Ladd/Dunbar</option>
				<option value="CPM" <?php if($_SESSION[emplDepartment] == "CPM") { echo "selected"; } ?> >Coatings and Polymeric Materials</option>
				<option value="CSCI" <?php if($_SESSION[emplDepartment] == "CSCI") { echo "selected"; } ?> >Computer Science</option>
				<option value="GEO" <?php if($_SESSION[emplDepartment] == "GEO") { echo "selected"; } ?> >Geosciences</option>
				<option value="MATH" <?php if($_SESSION[emplDepartment] == "MATH") { echo "selected"; } ?> >Mathematics</option>
				<option value="PHYS" <?php if($_SESSION[emplDepartment] == "PHYS") { echo "selected"; } ?> >Physics</option>
				<option value="PSYC" <?php if($_SESSION[emplDepartment] == "PSYC") { echo "selected"; } ?> >Psychology</option>
				<option value="STAT" <?php if($_SESSION[emplDepartment] == "STAT") { echo "selected"; } ?> >Statistics</option>
			</select>
			<input type="submit" value="Save Changes">
		</fieldset>
	</form>
	<h3 id="changes">All changes saved.</h3>

</body>
</html>