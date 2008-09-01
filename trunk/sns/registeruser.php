<?php 
	ob_start();
	require_once('Config/config.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
	$user_name = $_GET['user_name'];
	$user_password = $_GET['user_password'];
	$user_email = $_GET['user_email'];
	$firstname = $_GET['firstname'];
	$lastname = $_GET['lastname'];

	mysql_select_db($database_esprit_conn, $esprit_conn);
	$query_insert_user_main = "INSERT INTO `user_main` ( `user_id` , `user_name` , `user_password` , `user_email` )
	VALUES (
	NULL , '$user_name', '$user_password', '$user_email'
	);";
	$insert_user_main = mysql_query($query_insert_user_main, $esprit_conn) or die(mysql_error());

	$query_select_user_main ="SELECT `user_id`
	FROM `user_main`
	WHERE `user_name` = '$user_name'";

	$select_user_main = mysql_query($query_select_user_main, $esprit_conn) or die(mysql_error());

	$id = mysql_fetch_row($select_user_main);

	 $thumbnail_url = "../html/images/default1.jpg";
	 $profile_url = sprintf("profile.php?userID=%d",$id[0]);
	$query_insert_user_profile = "INSERT INTO `user_profile` ( `user_id` , `first_name` , `last_name` , `user_image`,`profile_url` )
	VALUES (
	'$id[0]', '$firstname', '$lastname','$thumbnail_url','$profile_url'
	);";
	mysql_query($query_insert_user_profile, $esprit_conn) or die(mysql_error());
	//initializing user_online
	$query_insert_user_online = sprintf("INSERT INTO `user_online_status` ( `user_id` , `last_online_time` , `online_status` )
	VALUES (
	%s, NOW( ) , 'no'
	);",$id[0]);
	mysql_query($query_insert_user_online, $esprit_conn) or die(mysql_error());

	$query_insert_user_broadcast = sprintf("INSERT INTO `user_broadcast` ( `user_id` , `header` , `article` , `article_title` , `time_expire` )
	VALUES (
	%s, NULL , NULL , NULL , NOW( )
	);",$id[0]);
	mysql_query($query_insert_user_broadcast, $esprit_conn) or die(mysql_error());


	mkdir("../userdata/$id[0]") ;
	mkdir("../userdata/$id[0]/images");
	mkdir("../userdata/$id[0]/thumbs");
	 
	$file = fopen("../userdata/$id[0]/.htaccess",'w');
	echo fwrite($file,"php_value sendmail_from \"".$user_email."\"");
	fclose($file);

	$file = fopen("../userdata/$id[0]/album.xml",'w');
	echo fwrite($file,"<?xml version='1.0' encoding='UTF-8'?>
	<table>
	</table>
	");
	fclose($file);

	header('location:user_reg.php');
?>
</body>
</html>
<?php
	mysql_free_result($insert_user_main);
?>
