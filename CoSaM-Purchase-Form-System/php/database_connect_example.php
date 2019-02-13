<?php 

# CONNECT TO MySQL DATABASE.
if (!($dbc = @mysqli_connect ( "temp_host", "temp_user", "temp_password","temp_database" )))
	die("cannot connect to db");
else {
	//print ("<p>you are connected to the database.</p>");
}