<?php
####################
# Name: PHP home.php
# Description: Hosts home page to link to other options
# Initial Creation Date: 11/26/2018
# Last Modification Date: 02/21/2019
# Author: Wyly Andrews
####################

require "../php/initialization.php";

#start session so we can access session variables
session_start();
if ( isset( $_SESSION[ 'emplID' ] ) ) 
{ 
	$emplName = $_SESSION[ 'emplFirstName' ]." ".$_SESSION[ 'emplLastName' ];
	$_SESSION['ePUID'] = $_SERVER['HTTP_CAS_MAIL'] ;
	$ePUID = $_SESSION[ 'ePUID' ];
}
else
{
	header("Location: ../php/login_action.php");
}

?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Home</title>
	<link rel="stylesheet" type="text/css" href="../css/home.css">
</head>
<body>
	<h1>Home</h1></br>
	<h3>Welcome, <?php echo $emplName; ?>!</h3></br>
	<h5>
	<?php 
		$attr = phpCAS::getAttributes();
		$user = phpCAS::getUser();
		echo 'Your username is: ' . $attr['username'] . "</br>";
		echo 'Your ePUID is: ' . $attr['eduPersonUniqueId'] . "</br>";
		echo 'Your user_id is: ' . $attr['user_id'] . "</br>";
		echo 'Your nid is: ' . $attr['nid'] . "</br>";
		echo 'Your unique_id is: ' . $attr['unique_id'] . "</br>";
		echo 'Server UID is: ' . $_SERVER['HTTP_CAS_UID'] .  "</br>";
		echo 'Server unique_id is: ' .$_SERVER['HTTP_CAS_UNIQUE_ID'] . "</br>";
		echo 'Your email is: ' .$attr['mail'] . "</br>";
		//echo 'Your username is: ' . attr['username'] . "</br>";
		//echo $_SERVER['HTTP_CAS_UID']; 
	?></h2></br>
	<p>Please use the navigation bar at the top to get started.</p>

	<h6>phpCAS::getAttributes: </h6></br>
	<ul style="background-color: white">
	<?php
	foreach (phpCAS::getAttributes() as $key => $value) {
		if (is_array($value)) {
			echo '<li>', $key, ':<ol>';
			foreach ($value as $item) {
				echo '<li><strong>', $item, '</strong></li><br>';
			}
			echo '</ol></li>';
		} else {
			echo '<li>', $key, ': <strong>', $value, '</strong></li><br>' . PHP_EOL;
		}
	}
	?>
	</ul>

	<h6>phpCAS::getUser: </h6></br>

	<?php
	echo phpCAS::getUser();
	?>
	
	<h6>$_SERVER: </h6></br>
	<ul style="background-color: white">
	<?php
	foreach ($_SERVER as $key => $value) {
		if (is_array($value)) {
			echo '<li>', $key, ':<ol>';
			foreach ($value as $item) {
				echo '<li><strong>', $item, '</strong></li><br>';
			}
			echo '</ol></li>';
		} else {
			echo '<li>', $key, ': <strong>', $value, '</strong></li><br>' . PHP_EOL;
		}
	}
	?>
	</ul>

	<h6>$_REQUEST: </h6></br>
	<ul style="background-color: white">
	<?php
	foreach ($_REQUEST as $key => $value) {
		if (is_array($value)) {
			echo '<li>', $key, ':<ol>';
			foreach ($value as $item) {
				echo '<li><strong>', $item, '</strong></li><br>';
			}
			echo '</ol></li>';
		} else {
			echo '<li>', $key, ': <strong>', $value, '</strong></li><br>' . PHP_EOL;
		}
	}
	?>
	</ul>

</body>
</html>