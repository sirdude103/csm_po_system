<?php
####################
# Name: PHP initialization.php
# Description: Sets up all mandatory php calls on every page
# Initial Creation Date: 02/20/2019
# Last Modification Date: 02/20/2019
# Author: Wyly Andrews
####################

require "../php/CAS_authentication.php";

#start session so we can access session variables
session_start();
if ( !isset( $_SESSION[ 'emplID' ] ) ) 
{ 
	header("Location: ../php/login_action.php");
}

require "../php/timeout.php";
require "../php/header_footer.php";
require "../php/database_connect.php";

$emplType = $_SESSION[ 'emplType' ];

?>