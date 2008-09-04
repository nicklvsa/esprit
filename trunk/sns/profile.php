<?php
ob_start();
// *** Validate request to login to this site.
require_once('chkuser.php');
$view_id = $_GET['userID'];
$page = "profile";
if($view_id == "")
	header("location:home.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome To Esprit</title>
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
    <td width="170" height="230" align="center" valign="top" >
      <? include_once('panels/leftpanel.php')?>
	</td>
    <td width="520" align="center" valign="top">
      <? include_once('panels/centerpanel.php')?>
    </td>
    <td width="280" align="center" valign="top">
      <? include_once('panels/rightpanel.php')?>
    </td>
  </tr>
  <tr>
    <td height="50" colspan="3" align="center" valign="middle" background="../html/images/box/bottom.jpg"><? include_once('panels/bottompanel.php')?></td>
  </tr>
</table>
</body>
</html>
