<?php
include_once('../phpCAS-master/CAS.php');

$client = phpCAS::client(CAS_VERSION_3_0,'apps.ndsu.edu',443,'/cas/');
	
phpCAS::setNoCasServerValidation();
	
phpCAS::setServerServiceValidateURL('https://apps.ndsu.edu/cas/p3/serviceValidate');

phpCAS::setFixedServiceURL(BASE_URL);

phpCAS::forceAuthentication();



?>

<html>
  <head>
    <title>phpCAS simple client</title>
  </head>
  <body>
    <h1>Successfull Authentication!</h1>
    <p>the user's login is <b><?php echo phpCAS::getUser(); ?></b>.</p>
    <p>phpCAS version is <b><?php echo phpCAS::getVersion(); ?></b>.</p>
  </body>
</html>