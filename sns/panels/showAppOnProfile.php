
<?php

	require('chkuser.php');
	require("Config/config.php");
	
	require "lib/Crypto.php";
	require "lib/BlobCrypter.php";
	require "lib/SecurityToken.php";
	require "lib/BasicBlobCrypter.php";
	require "lib/BasicSecurityToken.php";
	
	$width = 500;
	$view = "profile";
	$person_id = isset($_GET['userID'])?$_GET['userID']:$_SESSION['user_id'];
	$viewer_id = $_SESSION['user_id'];

	$sql_getApp=sprintf("SELECT id, title FROM applications WHERE id IN (SELECT application_id FROM user_applications WHERE user_id =%d)",$person_id);
	$resultGetApp = mysql_query($sql_getApp, $esprit_conn) or die("Error showing record(s) from the database: " . mysql_error());
	while($row = mysql_fetch_assoc($resultGetApp))		
	{
			$app_id = $row['id'];
			
			$sql_getModId = "SELECT id FROM user_applications WHERE user_id =".$_SESSION['user_id']." AND application_id =". $row['id'];
			$resultGetModId = mysql_query($sql_getModId, $esprit_conn) or die("Error showing record(s) from the database: " . mysql_error());
			$result = mysql_fetch_assoc($resultGetModId);
			$mod_id= $result['id'];	
//			echo "<tr><td>loading....</tr></td>";
?>		
			<tr width="500"><td align='center' valign='top' width="100%">
			<div id="<?=$mod_id?>" width="500" style="background-color:#FFFFFF;"><img src="../html/images/loading.gif"></div>		
			<?include('addGadget.php');?>
			</td></tr>
			<?
			
	}	

?>