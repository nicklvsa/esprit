<?php 

require_once('Config/config.php'); 

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];

if (isset($_POST['user_name'])) {
  $loginUsername=$_POST['user_name'];
  $password=$_POST['user_password'];
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_esprit_conn, $esprit_conn);
  //select 1 from accounts where BINARY username = 'xxxx' and password = 'yyyy'
  
  $LoginRS__query=sprintf("SELECT user_name, user_password, user_id FROM user_main WHERE user_name=%s AND BINARY user_password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $esprit_conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  $loginUser = mysql_fetch_assoc($LoginRS);
  
  $getNameQuery = "select first_name,last_name from user_profile where user_id=".$loginUser['user_id']; 
  $resultName = mysql_query($getNameQuery);
  if($resultName)
    $user_name = mysql_fetch_assoc($resultName);
  
  if ($loginFoundUser) {
     //declare two session variables and assign them
    #$_SESSION['user_name'] = $loginUser['user_name'];
    $_SESSION['user_name'] = $user_name['first_name']." ".$user_name['last_name'];
	$_SESSION['user_id'] = $loginUser['user_id'];
    $_SESSION['auth'] = session_id();
	setcookie("auth",session_id());
	$online_query = sprintf("update user_online_status set last_online_time = now(), online_status = 'yes' where user_id = '%s'",$_SESSION['user_id']);
	mysql_query($online_query, $esprit_conn) or die(mysql_error());
	
	
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    $errormsg = "Cannot Login Please Check Username and password";
  }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login to eSprit</title>
<link href="../html/CSS/style.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>

<form name="login" method='POST' action="<?php echo $loginFormAction; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr> <td align='center' colspan='2'><img src='../html/images/welcomeesprit1.png' height='140' width='650'/></td></tr>
  <tr>
 
    <td width="60%" align="center" valign="middle">  <!--<p>&nbsp;</p>
 <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
   <p>&nbsp;</p>
    <p>&nbsp;<img src="../html/images/esprit.jpg" width="550" height="400" /></p>-->
	<table>

	<tr>
	
	  <td width="42%" align="center" valign="middle"><span style="visibility:visible;">
	  <img src="../html/images/home.png" height="370" width="520"></img>
      </td>
	</tr></table>
	</td>


    <td width="31%" align="center" valign="middle"><p>&nbsp;</p><!--<p>&nbsp;</p><p align='center'><img src='images/NEWTITLE1.gif' height='70'/></p>--><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../html/images/FORMBG.jpg">
      <tr>
        <td colspan="2"><div align="center">
          <p>&nbsp;</p>
		  <p><img src="../html/images/signin1.gif" width='350'/></p>
          <p>&nbsp;</p>
        </div></td>
        </tr>
      <tr>
        <td width="38%"><div align="right" class="logintext">Username  :</div></td>
        <td width="62%"><input name="user_name" type="text" class="loginbox" id="user_name" accesskey="u" tabindex="1" /></td>
      </tr>
      <tr>
        <td><div align="right"></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="right" class="logintext">Password  :</div></td>
        <td><input name="user_password" type="password" class="loginbox" id="user_password" accesskey="p" tabindex="2" /></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
      
      <tr>
        <td colspan="2"><div align="center">
          <input type="submit" name="login" id="login" value="Login" />
        </div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td><a href="forgot_pass.php" ></a></td>
      </tr>
      <tr>
        <td colspan="2"><div align="center"><?php echo $errormsg; ?></div></td>
        </tr>
      <tr>
        <td colspan="2"><div align="center">
          <p><a href="javascript:void(0);" onclick="MM_openBrWindow('forgot_pass.php','','width=400,height=400')" >Forgot password</a></p>
          </div></td>
        </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2"><div align="center"><a href="register.php">Join eSprit!!</a></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
      <p>&nbsp;</p>
      </td>
    <td width="9%" align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
