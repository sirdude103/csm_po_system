<?php

include_once('../phpCAS-master/CAS.php');

$client = phpCAS::client(CAS_VERSION_3_0,'apps.ndsu.edu',443,'/cas/');

phpCAS::setServerServiceValidateURL('https://apps.ndsu.edu/cas/p3/serviceValidate');
phpCAS::setFixedServiceURL('https://www.ndsu.edu/pubweb/csm-po-system/php/home.php');

//phpCAS::setServerLoginURL('https://apps.ndsu.edu/cas/login');
//phpCAS::setFixedCallbackURL('https://www.ndsu.edu/pubweb/csm-po-system/');


if(!phpCAS::isAuthenticated()) {
	phpCAS::forceAuthentication();
}

session_start();

?>