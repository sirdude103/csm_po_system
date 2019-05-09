<?php
/**
 *   Example for a simple cas 2.0 client
 *
 * PHP Version 5
 *
 * @file     example_simple.php
 * @category Authentication
 * @package  PhpCAS
 * @author   Joachim Fritschi <jfritschi@freenet.de>
 * @author   Adam Franco <afranco@middlebury.edu>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link     https://wiki.jasig.org/display/CASC/phpCAS
 */
// Load the settings from the central config file
require_once './config.php';
// Load the CAS lib
require_once $phpcas_path . '/CAS.php';

$save_path = session_save_path('/var/lib/php/session/groups/csm-po-system');

// Enable debugging
//phpCAS::setDebug("C:\\Users\\gandr\\Documents");
// Enable verbose error messages. Disable in production!
phpCAS::setVerbose(true);
// Initialize phpCAS
phpCAS::client(CAS_VERSION_3_0, $cas_host, $cas_port, $cas_context);

//phpCAS::proxy(CAS_VERSION_3_0, $cas_host, $cas_port, $cas_context);

phpCAS::setNoCasServerValidation();

//phpCAS::setFixedCallbackURL('https://www.ndsu.edu/pubweb/csm-po-system/php/example_simple.php');
phpCAS::setFixedServiceURL('https://www.ndsu.edu/pubweb/csm-po-system/php/example_simple.php');

// force CAS authentication
if (!phpCAS::isAuthenticated()) {
	phpCAS::forceAuthentication();
}

// at this step, the user has been authenticated by the CAS server
// and the user's login name can be read with phpCAS::getUser().
// logout if desired
if (isset($_REQUEST['logout'])) {
	phpCAS::logout();
}
// for this test, simply print that the authentication was successfull
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
	<p>Current directory is: <?php echo $curdir; ?></p>
	<p>Current base is: <?php echo $curbase; ?></p>
	<p>__FILE__ is: <?php echo __FILE__; ?></p>
	<p>$_SERVER["SCRIPT_FILENAME"] is: <?php echo $_SERVER["SCRIPT_FILENAME"]; ?> </p>
	<p>$_SERVER['PHP_SELF'] is: <?php echo $_SERVER['PHP_SELF']; ?></p>
	<p>basename(__FILE__) is: <?php echo basename(__FILE__); ?></p>
	<p>"-----"</p>
	</body>
</html>