<?php


$gadget_server = 'http://shindig/';
$hostname_esprit_conn = "localhost";
$database_esprit_conn = "espritsns";
$username_esprit_conn = "root";
$password_esprit_conn = "";
$esprit_conn = mysql_connect($hostname_esprit_conn, $username_esprit_conn, $password_esprit_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_esprit_conn,$esprit_conn);

?>