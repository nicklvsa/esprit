<?
ob_start();
require_once('Config/config.php'); 

$app_id= $_GET['app_id'];
$u_id= $_GET['u_id'];
mysql_select_db($database_esprit_conn);
	
$sql_addApp = sprintf("INSERT INTO `user_applications` (`user_id`,`application_id`) values(%d,%d)",$u_id,$app_id);

$resultAddApp = mysql_query($sql_addApp, $esprit_conn) or die("Error inserting record(s) into the database: " . mysql_error());
header('location:addApp.php');
?>
	