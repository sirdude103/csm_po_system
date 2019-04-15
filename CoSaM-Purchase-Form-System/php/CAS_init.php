<?php

include_once('../phpCAS-master/CAS.php');

phpCAS::setDebug('debug_log.txt');
phpCAS::setVerbose(true);

if(!phpCAS::isInitialized()) {

	phpCAS::trace("not initialized...");

	$client = phpCAS::client(CAS_VERSION_3_0,'apps.ndsu.edu',443,'/cas/');
	
	phpCAS::setNoCasServerValidation();
	
	phpCAS::setServerServiceValidateURL('https://apps.ndsu.edu/cas/p3/serviceValidate');

	phpCAS::setFixedServiceURL('https://www.ndsu.edu/pubweb/csm-po-system/php/home.php');

	phpCAS::forceAuthentication();

	$_SESSION['CAS_client'] = $client;
}


?>