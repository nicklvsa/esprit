<?php
    require_once('chkuser.php');
	require_once("Config/config.php");	    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Application</title>
<link href="../html/CSS/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../html/CSS/general.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?=$gadget_server?>/gadgets/js/rpc.js?c=1"></script>
<script type="text/javascript" src="../html/js/prototype-1.6.0.2-min.js"></script>
<script src="../html/js/container.js" type="text/javascript"></script>
<?php
    require "lib/Crypto.php";
	require "lib/BlobCrypter.php";
	require "lib/SecurityToken.php";
	require "lib/BasicBlobCrypter.php";
	require "lib/BasicSecurityToken.php";
	$view_id = $_REQUEST['owner_id'];
	if($view_id=="")
	   $view_id = $_REQUEST['viewer_id'] ;
   if($view_id==0)
       $view_id = $_SESSION['user_id'];
	   
 ?>
  
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="40" align="center" valign="middle" background="../html/images/table/table_top_bg.jpg"><? include_once('panels/topnav.php')?></td>
</tr>
</table>
  <?php
  	$width = 788;
    $view = 'canvas';
	$ret = array();
	$person_id = $_REQUEST['owner_id'];
	if(!isset($person_id) and $person_id=="")
	   $person_id = $_REQUEST['viewer_id'];
	$viewer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_REQUEST['viewer_id'];
	$app_id = $_REQUEST['app_id'];
	$mod_id = $_REQUEST['mod_id'];			
?>


<table width="1000" height="289" border="0" align="center" cellpadding="3" cellspacing="3" bordercolor="#FFFFFF">
  <tr>
    <td width="170" height="230"  valign="top" ><? include_once('panels/leftpanel.php')?>    </td>
    <td align="center" valign="top" style="background-color:#FFFFFF;" width="788"><table border="0" height=100%><tr><td><div id="<?=$mod_id?>" width=100% style"background-color:#FFFFFF;"><img src="../html/images/loading.gif"></div><?include_once('addGadget.php');?></tr></td><tr><td><?if($view_id == $_SESSION['user_id']){?><a href="deleteApp.php?modId=<?= $mod_id?>" id="delete_app"> Delete this Application</a></tr><?}?></td></table></td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" valign="middle" background="../html/images/box/bottom.jpg"><? include_once('panels/bottompanel.php')?></td>
  </tr>
</table>
</body>
</html>
