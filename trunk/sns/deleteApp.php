<?php
	ob_start();
	require_once('Config/config.php'); 
	require('chkuser.php');


	if(isset($_GET['show_app']))
		$show_app=$_GET['show_app'];

	mysql_select_db($database_esprit_conn);

	$sql_deleteApp=sprintf("DELETE FROM user_applications WHERE id =%d",$_GET['modId']);
/*	echo $sql_deleteApp;
	exit;*/
	if(mysql_query($sql_deleteApp, $esprit_conn) or die("Error showing record(s) from the database: " . mysql_error()))
	{
			if($show_app)
			header("location:addApplications.php");
			else
			header("location:profile.php?userID=".$_SESSION['user_id']);
	}


?>