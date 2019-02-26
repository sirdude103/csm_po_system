<?php
####################
# Name: PHP logout_action.php
# Description: Handles Logout attempts
# Initial Creation Date: 10/14/2018
# Last Modificatin Date: 10/14/2018
# Author: Wyly Andrews
####################

#start session so we can access session variables
session_start();

session_unset();
session_destroy();

echo "<label>You have successfully logged out.</label>";
require "../php/home.php";
?>