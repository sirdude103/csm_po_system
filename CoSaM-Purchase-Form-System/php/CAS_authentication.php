<?php

include_once('./config.php');
include_once('../phpCAS-master/CAS.php');

phpCAS::setDebug();
phpCAS::setVerbose(true);

phpCAS::client(CAS_VERSION_3_0, $cas_host, $cas_port, $cas_context);

phpCAS::setNoCasServerValidation();

//phpCAS::setFixedCallbackURL('https://www.ndsu.edu/pubweb/csm-po-system/CAS_authentication.php');


if(!phpCAS::isAuthenticated()) {
	phpCAS::setFixedServiceURL('https://www.ndsu.edu/pubweb/csm-po-system/');
	phpCAS::forceAuthentication();
}



//phpCAS::client(CAS_VERSION_3_0,'apps.ndsu.edu',443,'/cas/');

//phpCAS::setCasServerCACert('https://apps.ndsu.edu/cas/p3/serviceValidate');


/*if(!phpCAS::isInitialized()) {

	phpCAS::trace("not initialized...");

	$client = phpCAS::client(CAS_VERSION_3_0,'apps.ndsu.edu',443,'/cas/');
	
	phpCAS::setNoCasServerValidation();
	
	phpCAS::setServerServiceValidateURL('https://apps.ndsu.edu/cas/p3/serviceValidate');

	phpCAS::setFixedServiceURL('https://www.ndsu.edu/pubweb/csm-po-system/php/home.php');

}*/

//phpCAS::setServerServiceValidateURL('https://apps.ndsu.edu/cas/p3/serviceValidate');


//phpCAS::setServerLoginURL('https://apps.ndsu.edu/cas/login');
//phpCAS::setFixedCallbackURL('https://www.ndsu.edu/pubweb/csm-po-system/');

session_start();
?>

