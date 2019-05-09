<?php

require_once('./config.php');
require_once('../phpCAS-master/CAS.php');

function log_me($message) {
	echo "<script>";
	echo "console.log('$message')";
	echo "</script>";
}

#if (!$save_path) {
#	$save_path = session_save_path('/var/lib/php/session/groups/csm-po-system');
#}
phpCAS::setDebug();
phpCAS::setVerbose(true);

$_SESSION["client"] = phpCAS::client(CAS_VERSION_3_0, $cas_host, $cas_port, $cas_context);

phpCAS::setNoCasServerValidation();

//phpCAS::setFixedCallbackURL('https://www.ndsu.edu/pubweb/csm-po-system/CAS_authentication.php');

#$service_url = 'https://www.ndsu.edu' . $curfile;

#$service_url = 'https://www.ndsu.edu/pubweb/csm-po-system/php/CAS_authentication.php';

#$service_url = 'https://www.ndsu.edu/pubweb/csm-po-system/php/home.php';
$service_url = 'https://www.ndsu.edu/pubweb/csm-po-system/' . $current_file;
log_me("Setting fixed service URL with $service_url");

phpCAS::setFixedServiceURL($service_url);

log_me("Current authentication status: " . phpCAS::isAuthenticated());
log_me("Checking authentication...");

if(!phpCAS::isAuthenticated()) {
	log_me("Forcing authentication...");
	phpCAS::forceAuthentication();
	log_me("authentication forced.");
}

//if (!isset($_SESSION)) { session_start(); }
?>

<html>
  <head>
    <title>phpCAS simple client</title>
  </head>
  <body>
    <h1>Successfull Authentication!</h1>
    <p>the user's login is <b><?php echo phpCAS::getUser(); ?></b>.</p>
    <p>phpCAS version is <b><?php echo phpCAS::getVersion(); ?></b>.</p>
	<p>Save_Path: <?php echo $save_path; ?></p>
  </body>
</html>

