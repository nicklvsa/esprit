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
require_once ('chkuser.php');
require_once ('Config/config.php');
include_once ("panels/GetSQLValueString.php");


//initialize the session
if (!isset($_SESSION))
{
  session_start();
}
$view_id = $_SESSION['user_id'];

$page = "home";

mysql_select_db($database_esprit_conn, $esprit_conn);
$query_rs_album = sprintf("SELECT user_friend.friend_id, user_album.photo_name, user_album.photo_caption, concat(user_profile.first_name, ' ' ,user_profile.last_name) as friend_name FROM user_friend, user_album, user_profile WHERE user_friend.user_id =%s  AND user_album.user_id =user_friend.friend_id AND user_profile.user_id=user_friend.friend_id And user_friend.pending='no' order by rand() limit 0,5",
  $_SESSION['user_id']);
$rs_album = mysql_query($query_rs_album, $esprit_conn) or die(mysql_error());
$totalRows_rs_album = mysql_num_rows($rs_album);


?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome To Esprit</title>
<link href="../html/CSS/style.css" rel="stylesheet" type="text/css" />

<link href="../html/CSS/table.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="../html/js/scripts.js"></script>


<!-- TWO STEPS TO INSTALL BASIC SLIDESHOW:

  1.  Copy the coding into the HEAD of your HTML document
  2.  Add the last code into the BODY of your HTML document  -->

<!-- STEP ONE: Paste this code into the HEAD of your HTML document  -->

<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
NewImg = new Array (		
<?
$pic = "";
while ($row = mysql_fetch_assoc($rs_album))
{
  $pic .= "\"../userdata/" . $row['friend_id'] . "/images/" . $row['photo_name'] .
    "\",\n";
  //echo $pic;
}
echo substr($pic, 0, -2);
?>
);

var ImgNum = 0;
var ImgLength = NewImg.length - 1;

//Time delay between Slides in milliseconds
var delay = 3000;
var lock = false;
var run;
//  End -->
</script>
</head>

  <body onload="auto()">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td height="40" align="center" valign="middle" background="../html/images/table/table_top_bg.jpg"><? include_once ('panels/topnav.php') ?></td>
	  </tr>
	</table>
	<table width="1000" height="289" border="0" align="center" cellpadding="3" cellspacing="3" bordercolor="#FFFFFF">
	  <tr><td colspan="3"></td></tr>
	  <tr>
		<td width="170" height="230" align="center" valign="top" >
		  <? include_once ('panels/leftpanel.php') ?>
		</td>
		<td width="520" align="center" valign="top">
		  <? include_once ('panels/centerpanel.php') ?>
		</td>
		<td width="280" align="center" valign="top">
		  <? include_once ('panels/rightpanel.php') ?>
		</td>
	  </tr>
	  <tr>
		<td height="50" colspan="3" align="center" valign="middle" background="../html/images/box/bottom.jpg"><? include_once ('panels/bottompanel.php') ?></td>
	  </tr>
	</table>
  </body>
</html>
<?php
mysql_free_result($rs_album);
?>