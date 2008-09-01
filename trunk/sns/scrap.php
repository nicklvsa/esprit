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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ScrapBook</title>
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
				<?
			   
				if($view_id != $_SESSION['user_id'])
				{
					include_once("panels/add_Scrap.php");
				}
				?>
				</td>
			  </tr>
			  <tr>
				<td height="33" valign="top" background="../html/images/box/box_center_280.jpg">
				<?
					include_once('panels/show_scrapbook.php');
				?></td>
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


