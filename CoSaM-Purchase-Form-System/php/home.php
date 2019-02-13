<?php
####################
# Name: PHP home.php
# Description: Hosts home page to link to other options
# Initial Creation Date: 11/26/2018
# Last Modification Date: 11/26/2018
# Author: Wyly Andrews
####################

#start session so we can access session variables
session_start();
if ( isset( $_SESSION[ 'emplID' ] ) ) 
{ 
	$emplName = $_SESSION[ 'emplFirstName' ]." ".$_SESSION[ 'emplLastName' ];
}
else
{
	header("Location: ../html/login.html");
}

include_once( '../php/header_footer.php' );

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