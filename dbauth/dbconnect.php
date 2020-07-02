<?php

#$hostname = "184.154.226.15";
$hostname = "localhost";
$database = "uwdesi46_2012";
$username = "uwdesi46_2012";
$password = "JvM?6dBJgR=R";

$db = mysql_pconnect($hostname, $username, $password) or die(mysql_error() . mysql_errno());

mysql_select_db($database, $db);

?>
