<?php
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

if(isset($_GET['app_present']))
		$app_present = $_GET['app_present'];
	

	if($app_present)
		{?>
			<script>alert("The application is already added in your profile");</script>
		<?}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Apps</title>
<link href="../html/CSS/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../html/js/scripts.js"></script>
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
    <td align="center" valign="top"><? include_once('panels/addAppPanel.php')?></td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" valign="middle" background="../html/images/box/bottom.jpg"><? include_once('panels/bottompanel.php')?></td>
  </tr>
</table>
</body>
</html>
<?
if($_GET['error'])
{
	echo "<script language='javascript'>alert(\"". $_GET['error'].". Not able to add this application.\");</script>";
}
?>


