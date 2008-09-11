<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements. See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership. The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations under the License.
 * 
 */

// *** Validate request to login to this site.
require_once('chkuser.php');
if(isset($_GET['userID']))
{
	$view_id = $_GET['userID'];
}
else
{
	$view_id = $_SESSION['user_id'];
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Send Mail</title>
<link href="../html/CSS/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="40" align="center" valign="middle" background="../html/images/table/table_top_bg.jpg"><? include_once('panels/topnav.php')?></td>
  </tr>
</table>
<table width="1000" height="289" border="0" align="center" cellpadding="3" cellspacing="3" bordercolor="#FFFFFF">
  <tr>
    <td width="170" height="230" align="center" valign="top" ><? include_once('panels/leftpanel.php')?>    </td>
    <td align="center" valign="top">
	
			<table width="800" height="113" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td height="29" background="../html/images/box/box_top_800.jpg"></td>
			  </tr>
			  <tr>
				<td height="33" valign="top" background="../html/images/box/box_center_280.jpg">
				<h2>Compose Message</h2>
				<?php
require_once('Config/config.php');

if (isset($_GET['user_id'])) {
  $colname_Recordset1 = $_GET['user_id'];
}
mysql_select_db($database_esprit_conn, $esprit_conn);
$query_Recordset1 = sprintf("SELECT user_email FROM user_main WHERE user_id = %d",$_SESSION['user_id']);
$Recordset1 = mysql_query($query_Recordset1, $esprit_conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$e_mail = $row_Recordset1['user_email'];

?>
<form action="<? echo $_SERVER['PHP_SELF']."?userID=".$view_id;?>" method="POST" name="mailform">
  <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="2%">&nbsp;</td>
    <td width="16%">&nbsp;</td>
    <td width="82%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">To :</td>
    <td> <select name="unames" id="unames" >
        <?
		$query_Recordset2=sprintf("SELECT user_id, user_email FROM user_main WHERE user_id IN(SELECT friend_id FROM user_friend WHERE user_id=%d)",$_SESSION['user_id']);
		$Recordset2 = mysql_query($query_Recordset2, $esprit_conn) or die(mysql_error());

        while($resultRecords = mysql_fetch_assoc($Recordset2)) 
		{
			$query_friend = sprintf("SELECT concat(user_profile.first_name,' ',user_profile.last_name) as name FROM user_profile WHERE             user_profile.user_id = %d",$resultRecords['user_id']);
			$res = mysql_query($query_friend);
			$friend_name= mysql_fetch_row($res);
			echo "<option value = '$resultRecords[user_email]'>$friend_name[0]</option> ";
		} 
	  ?>
      </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Subject :</td>
    <td><input type="text" size="22" name="subject" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">
    <textarea name="contents" rows="5" cols="64"></textarea>
    </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="B1" value="Send" />
    </div></td>
    <td>
      <div align="left">
        <input type="reset" name="B2" value="Reset" />
        </div></td>
  </tr>
</table>
	</form>

    <?
if(isset($_POST['B1']))
{

//$to = $_POST['unames'];
$sql_getFrom = "Select user_email From user_main Where user_id = ".$_SESSION['user_id'];
$resultGetFrom = mysql_query($sql_getFrom);
$record = mysql_fetch_assoc($resultGetFrom);
$from = $record['user_email'];


$to = $_POST['unames'];
if(!empty($to))
{
	$mail_subject = $_POST['subject'];

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From:'.$from . "\r\n";

	$mail_contents = $_POST['contents']."<br><br>This message has been sent by impetus Esprit Platform<br>Copyright <b>(c)</b> 2008 Impetus Infotech (India) Pvt Ltd Inc (www.impetus.com). All Rights Reserved.";

	echo "<div align='center' ><center>";

	if(@mail($to,$mail_subject,$mail_contents,$headers))
	{
	  echo "<script language='javascript'>alert ('Your Mail Has been sent')</script>";
	  //header("location:home.php");
	}
	else
	{
	  echo "<table><tr><td>";
	  echo "<script language='javascript'>alert ('Your Mail was not sent')</script>";
	  echo "</td></tr>";
	  echo "</table>";
	}
}
else
	{
      echo "<table><tr><td>";
	  echo "<script language='javascript'>alert ('Please select any friend first.')</script>";
	  echo "</td></tr>";
	  echo "</table>";
	}

echo "</center></div>";
}

?>
<?php
mysql_free_result($Recordset1);
?>
	
				</td>
			  </tr>

			  <tr>
				<td height="18" background="../html/images/box/box_bottom_800.jpg"></td>
			  </tr>
		</table>
	
	</td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" valign="middle" background="../html/images/box/bottom.jpg"><? include_once('panels/bottompanel.php')?></td>
  </tr>
</table>
</body>
</html>


