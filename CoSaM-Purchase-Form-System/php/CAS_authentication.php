<?php

include_once('../phpCAS-master/CAS.php');


$client = phpCAS::client(CAS_VERSION_3_0,'arachnid-devel.ndsu.nodak.edu',443,'/cas/');

//For development. Prints out additional warnings. 
phpCAS::setVerbose(true);

// REMOVE THIS AFTER DEVELOPMENT
phpCAS::setNoCasServerValidation();
//phpCAS::setCasServerCACert('arachnid-devel.ndsu.nodak.edu/cas/p3/serviceValidate', true);

if(!phpCAS::isAuthenticated()) {
	phpCAS::forceAuthentication();
}

session_start();

$_SESSION['ePUID'] = $_SERVER{'HTTP_CAS_EDUPERSONUNIQUEID'} ;


?>