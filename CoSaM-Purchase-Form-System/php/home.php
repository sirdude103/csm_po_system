<?php
####################
# Name: PHP home.php
# Description: Hosts home page to link to other options
# Initial Creation Date: 11/26/2018
# Last Modification Date: 02/21/2019
# Author: Wyly Andrews
####################

# $save_path = session_save_path('/var/lib/php/session/groups/csm-po-system');

$current_file = "php/home.php";
require "../php/initialization.php";

#start session so we can access session variables
//if (!isset($_SESSION)) { session_start(); }
if ( isset( $_SESSION[ 'emplID' ] ) ) 
{ 
	$emplName = $_SESSION[ 'emplFirstName' ]." ".$_SESSION[ 'emplLastName' ];
	$_SESSION['ePUID'] = $_SERVER['HTTP_CAS_MAIL'] ;
	$ePUID = $_SESSION[ 'ePUID' ];
}
else
{
	//header("Location: ../php/login_action.php");
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
	<p>Please use the navigation bar at the top to get started.</p>
</body>
</html>