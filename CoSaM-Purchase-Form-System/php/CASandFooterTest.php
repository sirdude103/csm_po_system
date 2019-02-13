<?php

	include_once('../phpCAS-master/CAS.php');


	$client = phpCAS::client(CAS_VERSION_3_0,'arachnid-devel.ndsu.nodak.edu',443,'/cas');

	//For development. Prints out additional warnings. 
	phpCAS::setVerbose(true);
	
	phpCAS::setNoCasServerValidation();
	//phpCAS::setCasServerCACert('arachnid-devel.ndsu.nodak.edu/cas/p3/serviceValidate', true);

	
	if (!phpCAS::isAuthenticated()) {
		phpCAS::forceAuthentication();
	}

?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Footer</title>
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
</head>
<body>
    <footer>
        <nav id=footerOptions>
            <ul>
                <li><a href="https://www.ndsu.edu/alphaindex/buildings">CAMPUS MAP</a></li>
                <li><a href="https://jobs.ndsu.edu/">EMPLOYMENT</a></li>
                <li><a href="https://www.ndsu.edu/equity/">EQUITY</a></li>
                <li><a href="https://www.ndsu.edu/onlineservices/">ONLINE SERVICES</a></li>
                <li><a href="https://www.ndsu.edu/directory/">PHONE/EMAIL DIRECTORY</a></li>
                <li><a href="https://www.ndsu.edu/registrar/">REGISTRATION AND RECORDS</a></li>
            </ul>
        </nav>
        <p id="department">
            College of Science and Mathematics <br/>
            North Dakota State University <br/>
            Phone: 1+ (701) 231-7411 <br/>
            Fax: (701) 231-1047 <br/>
            Campus address: Minard 202 <br/>
            Mailing address: Dept 2700 PO Box 6050, Fargo, ND 58108-6050 <br/>
            Page Manager: <a href="mailto:wyly.andrews@ndsu.edu">Wyly Andrews</a>
        </p>
        <p id="lastUpdated">
            Last Updated: 11/17/2018 8:47pm
        </p>
    </footer>
</body>
</html>