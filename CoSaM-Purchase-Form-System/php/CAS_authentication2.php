<?php

include_once('../phpCAS-master/CAS.php');

$client = phpCAS::client(CAS_VERSION_3_0, 'arachnid-devel.ndsu.nodak.edu',443,'/cas/');

phpCAS::setVerbose(true);

phpCAS::setNoCasServerValidation();

if(!phpCAS::isAuthenticated()){
    phpCAS::forceAuthentication();
}

?>

<html>
    <head>
        <title>Simple Client</title>
    </head>
    
    <body>
        <h1>Successful Authentication</h1>
    </body>
</html>