<?php
####################
# Name: PHP initialization.php
# Description: Sets up all mandatory php calls on every page
# Initial Creation Date: 02/20/2019
# Last Modification Date: 02/20/2019
# Author: Wyly Andrews
####################

function log_m($message) {
	echo "<script>";
	echo "console.log('$message')";
	echo "</script>";
}
log_m("Inside init file");

#start session so we can access session variables
$save_path = session_save_path('/var/lib/php/session/groups/csm-po-system');
session_start();

require "../php/CAS_authentication.php";

log_m("Passed through CAS file");



if ( !isset( $_SESSION[ 'emplID' ] ) ) 
{ 
	echo "no emplID found!";
 	header("Location: ../php/login_action.php");
}

require "../php/timeout.php";
require "../php/header_footer.php";
require "../php/database_connect.php";

$emplType = $_SESSION[ 'emplType' ];

?>