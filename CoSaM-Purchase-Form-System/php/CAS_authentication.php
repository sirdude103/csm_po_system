<?php

include_once('../phpCAS-master/CAS.php');


$client = phpCAS::client(CAS_VERSION_3_0,'arachnid-devel.ndsu.nodak.edu',443,'/cas/');

if(!phpCAS::isAuthenticated()) {
	phpCAS::forceAuthentication();
}

session_start();

?>