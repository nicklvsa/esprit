<?php
// *** Validate request to login to this site.
require_once('chkuser.php');
$view_id = $_GET['userID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Add Friend</title>
		<link href="../html/CSS/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height="40" align="center" valign="middle" background="../html/images/table/table_top_bg.jpg">
				<? include_once('panels/topnav.php')?>
			</td>
		</tr>
	</table>
	<table width="1000" height="289" border="0" align="center" cellpadding="3" cellspacing="3" bordercolor="#FFFFFF">
		<tr>
			<td width="170" height="230" align="center" valign="top" >
				<? include_once('panels/leftpanel.php')?>	  
			</td>
			<td align="center" valign="top">
				<?
					if(isset($_GET['userID']) && isset($_GET['accpt']))
					{
						if($_GET['accpt']=='yes')
						{					
							$updateSQL = sprintf("UPDATE `user_friend` SET `pending` = 'no' WHERE `user_friend`.`friend_id` = %s AND `user_friend`.`user_id` = %s ;", GetSQLValueString($_SESSION['user_id'], "int"), GetSQLValueString($_GET['userID'], "int"));
					
							mysql_select_db($database_esprit_conn, $esprit_conn);
							$Result1 = mysql_query($updateSQL, $esprit_conn) or die(mysql_errno());
																			
							$insertSQL = sprintf("INSERT INTO user_friend (friend_id,user_id,pending) VALUES (%s, %s, 'no')", GetSQLValueString($_GET['userID'], "int"), GetSQLValueString($_SESSION['user_id'], "int"));
					
							mysql_select_db($database_esprit_conn, $esprit_conn);
							$Result1 = mysql_query($insertSQL, $esprit_conn);
							
							$nameProfSQL1 = sprintf("select `first_name`,`last_name`,`profile_url` from  `user_profile` WHERE `user_id` = %d ",$_SESSION['user_id']);
							$nameProfSQL2 = sprintf("select `first_name`,`last_name`,`profile_url` from  `user_profile` WHERE `user_id` = %d ",$_GET['userID']);					
							mysql_select_db($database_esprit_conn, $esprit_conn);
							$ResultName1 = mysql_query($nameProfSQL1, $esprit_conn) or die(mysql_errno());
							$ResultName2 = mysql_query($nameProfSQL2, $esprit_conn) or die(mysql_errno());
							
							
							while($row = mysql_fetch_assoc($ResultName1))
							{
								$name1=$row['first_name']." ".$row['last_name'];
								$profile_url1 = $row['profile_url'];
							}
							
							while($row = mysql_fetch_assoc($ResultName2))
							{
								$name2=$row['first_name']." ".$row['last_name'];
								$profile_url2 = $row['profile_url'];
							}
							
							$time = time();
							$title= "is now friends with <a href=\'$profile_url2\'>$name2</a>";
							$insertUpdateSQL = sprintf("INSERT INTO activities (user_id,app_id,title,created) VALUES (%d, %d, %s,%d)",$_SESSION['user_id'],0,"'$title'",$time);
							
							mysql_select_db($database_esprit_conn, $esprit_conn);
							$Result1 = mysql_query($insertUpdateSQL, $esprit_conn)or die("Error inserting record(s) into the database: " . mysql_error());
							
							$time = time();
							$title= "is now friends with <a href=\'$profile_url1\'>$name1</a>";
							$insertUpdateSQL = sprintf("INSERT INTO activities (user_id,app_id,title,created) VALUES (%d, %d, %s,%d)",$_GET['userID'],0,"'$title'",$time);
							
							mysql_select_db($database_esprit_conn, $esprit_conn);
							$Result1 = mysql_query($insertUpdateSQL, $esprit_conn)or die("Error inserting record(s) into the database: " . mysql_error());
							
							
							if($Result1<1)
							{
								$updateSQL = sprintf("UPDATE `user_friend` SET `pending` = 'no' WHERE `user_friend`.`friend_id` = %s AND `user_friend`.`user_id` = %s ;", GetSQLValueString($_GET['userID'], "int"), GetSQLValueString($_SESSION['user_id'], "int"));
							
								mysql_select_db($database_esprit_conn, $esprit_conn);
								$Result1 = mysql_query($updateSQL, $esprit_conn) or die(mysql_errno());							
							}
						}
						else
						{
							$deleteSQL = sprintf("DELETE FROM `user_friend` WHERE `user_friend`.`friend_id` = %s AND `user_friend`.`user_id` = %s ;", GetSQLValueString($_GET['userID'], "int"), GetSQLValueString($_SESSION['user_id'], "int"));
						
						mysql_select_db($database_esprit_conn, $esprit_conn);
						$Result1 = mysql_query($deleteSQL, $esprit_conn) or die(mysql_errno());
						
						$updateSQL = sprintf("DELETE FROM `user_friend` WHERE `user_friend`.`friend_id` = %s AND `user_friend`.`user_id` = %s ;", GetSQLValueString($_SESSION['user_id'], "int"), GetSQLValueString($_GET['userID'], "int"));
						
						mysql_select_db($database_esprit_conn, $esprit_conn);
						$Result1 = mysql_query($updateSQL, $esprit_conn) or die(mysql_errno());
						}
					header('location:home.php');
					}
					else
					{													
						require_once('Config/config.php'); 
						require_once("panels/GetSQLValueString.php");
						$editFormAction = $_SERVER['PHP_SELF'];
						if (isset($_SERVER['QUERY_STRING'])) 
						{
							$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
						}

						if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
						{
							$insertSQL = sprintf("INSERT INTO user_friend (friend_id,user_id,pending) VALUES (%s, %s, 'yes')", GetSQLValueString($_POST['userID'], "int"), GetSQLValueString($_SESSION['user_id'], "int"));
							mysql_select_db($database_esprit_conn, $esprit_conn);
							$Result1 = mysql_query($insertSQL, $esprit_conn);// or die(mysql_errno());
							$insertGoTo = "../chkfake.php";
							if (isset($_SERVER['QUERY_STRING'])) {
							$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
							$insertGoTo .= $_SERVER['QUERY_STRING'];
							}
						}
					?>
					<table width="800" height="80" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td height="29" background="../html/images/box/box_top_800.jpg"></td>
						</tr>
						<tr>
							<td height="33" valign="top" align = 'center' background="../html/images/box/box_center_280.jpg">
								<h2 > ADD Friend</h2>
<?
									if(mysql_errno()==1062)
									{
										echo "A request to add $user_info_name as a friend is already pending<br> Please wait till request is accepted";
									}
									else
									{
										if(!isset($_POST['add_frnd']))
										{
?>
											<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
												<input name="userID" type="hidden" value="<?echo $view_id;?>">
												Do you want to Invite <?echo $user_info_name;?> as a friend
												<input type="submit" name="add_frnd" id="button" value="Send Request">
												<input type="reset" name="button2" id="button2" value="Reset" onClick="history.back();">
												<input type="hidden" name="MM_insert" value="form1">
											</form>
<?
										}
										else
										{
											$sql_viewer = "SELECT user_email FROM user_main WHERE user_id = ".$_POST['userID'];
											$result2 = mysql_query($sql_viewer);
											$viewer = mysql_fetch_assoc($result2);
											$mail_subject = $user_info_name." has sent you a friend request!!!";
											$to = $viewer['user_email'];
											$headers  = 'MIME-Version: 1.0' . "\r\n";
											$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
											$headers .= 'From: noreply@esprit.com\r\n';

											$mail_contents = "<br><br>This message has been sent by impetus Esprit Platform<br>Copyright <b>(c)</b> 2008 Impetus Infotech (India) Pvt Ltd Inc (www.impetus.com). All Rights Reserved.";

											@mail($to,$mail_subject,$mail_contents,$headers);
											echo "A request to add $user_info_name as a friend is sent<br> Please wait till request is accepted";
										}
								
									}
?>
											<br>
							</td>
						</tr>
						<tr>
							<td height="18" background="../html/images/box/box_bottom_800.jpg"></td>
						</tr>
					</table>

<?
					}
?>
				</td>
			</tr>
			<tr>
				<td height="50" colspan="2" align="center" valign="middle" background="../html/images/box/bottom.jpg"><? include_once('panels/bottompanel.php')?></td>
			</tr>
		</table>
	</body>
</html>
