<?php

####################
# Name: PHP timeout.php
# Description: times out session if no server action was completed in a long time
# Initial Creation Date: 10/16/2018
# Last Modification Date: 11/25/2018
# Author: Wyly Andrews
####################

$time = $_SERVER['REQUEST_TIME'];

# 30 minute timeout duration (in seconds)
$timeout_duration = 1800;

# If time is up, delete the session
if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
	# echo "<label>You have been logged out for inactivity.</label>"; # Doesn't work
	require "../html/login.html";
}

# update current time
session_start();
$_SESSION['LAST_ACTIVITY'] = $time;

?>