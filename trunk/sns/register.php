<?
ob_start();
require_once('Config/config.php'); 
mysql_select_db($database_esprit_conn, $esprit_conn);

$fake = false;

if (isset($_POST['submit']))
{
  session_start();
  $user_name = $_POST['user_name'];
  $user_password = $_POST['password_entered'];
  $user_email = $_POST['user_email'];
  $firstname = strip_tags($_POST['firstname']);
  $lastname = strip_tags($_POST['lastname']);
  $chk_code = $_POST['chk_code'];
 // unlink($_SESSION['chkfile']);

  if (empty($user_name) or empty($user_password) or empty($user_email) or empty($firstname) or
    empty($lastname))
  {
    $error = "Please provide all the values";
  }
  if ($_SESSION['chkcode'] == $chk_code)
  {
    if ($error == "")
	{
		$sql = "select * from user_main where user_email='".$user_email."'";
	    $result = mysql_query($sql, $esprit_conn) or die(mysql_error());
		$temp = mysql_fetch_row($result);
		if(!$temp)
		{	
		    $sql = "select * from user_main where user_name='".$user_name."'";
    	    $result = mysql_query($sql, $esprit_conn) or die(mysql_error());
			$temp = mysql_fetch_row($result);
			if(!$temp)
		    {	header("location:registeruser.php?user_name=$user_name&user_password=$user_password&user_email=$user_email&firstname=$firstname&lastname=$lastname");
			}
			else
			{
				$error = "User Name Already Exists!!!";
			}
		}
		else
		{
			if($error=="") 
			{
				$error = "Email Address Already Exists!!!";
			}
		}
    }
	else
      $fake = true;
  }
  else
    $fake = true;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Register To Esprit</title>
	<link href="../html/CSS/style.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../html/js/validateRegistrationForm.js"></script>
</head>

<body onLoad="">
<table width="100%" heigt="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  <td width="5%" height="597" align="center" valign="middle"></td>
  <td width="58%" align="center" valign="middle">
  <form id="register_id" name="register" method="post" action="register.php">
  <p>&nbsp;</p>
<table width="714" height="404" border="0" align="center" cellpadding="0" cellspacing="0" background="../html/images/reg.jpg">
    <tr>
      <td height="67" colspan="3"><div align="center">
        <p class="SIGNIN style2">Register
          Esprit</p>
        </div></td>
      <td>&nbsp;</td>
    </tr>
	<?php
	if ($error == true)
	echo "<tr>";
    echo "<td colspan=3 class='error' align=center ><b>" . $error . "</b></td>";
    echo "</tr>";
    ?>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
	<tr>
      <td width="50">&nbsp;</td>
      <td width="159" class="logintext" align="right">First Name :</td>
      <td colspan="2" align="left">
        &nbsp;<input name="firstname" type="text" class="regbox" id="firstname"  accesskey="fn" tabindex="1" value="<? echo
$firstname; ?>" size="30" maxlength="25">
        </td>
    </tr>
	 <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
	<tr>
      <td width="50">&nbsp;</td>
      <td width="159" class="logintext" align="right">Last Name :</td>
      <td colspan="2" align="left">
        &nbsp;<input name="lastname" type="text" class="regbox" id="lastname"  accesskey="ln" tabindex="2" value="<? echo
$lastname; ?>" size="30" maxlength="25">
        </td>
    </tr>
	 <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td width="50">&nbsp;</td>
      <td width="159" class="logintext" align="right">Username :</td>
      <td colspan="2" align="left">
        &nbsp;<input name="user_name" type="text" class="regbox" id="username"  accesskey="u" tabindex="3" value="<? echo
$user_name; ?>" size="30" maxlength="25">
        </td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="logintext" align="right">Password :</td>
      <td colspan="2" align="left">&nbsp;<input name="password_entered" type="password" class="regbox" id="password_entered" accesskey="p" tabindex="4" size="30" maxlength="25">
        </td>
    </tr>
   <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="logintext" align="right">Email id :</td>
      <td colspan="2" align="left">&nbsp;<input name="user_email" type="text" class="regbox" id="user_email" accesskey="e" tabindex="5" value="<? echo
$user_email; ?>" size="30" maxlength="128">
        </td>
    </tr>
	<tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><div align="right">
          
    <?php
	// The text to draw
	$text = '1234567890qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM';
	$text = substr(str_shuffle($text), 0, 4);
	// Set the content-type
	// Create the image
	$im = imagecreatetruecolor(100, 30);

	// Create some colors
	$white = imagecolorallocate($im, 255, 255, 255);
	$grey = imagecolorallocate($im, 128, 128, 128);
	$black = imagecolorallocate($im, 255, 22, 110);


	// Replace path by your own font path
	$font = 'c:/windows/Fonts/arial.ttf';

	// Add some shadow to the text
	imagettftext($im, 20, rand(-10, 10), 10, 25, $grey, $font, $text[0]);
	imagettftext($im, 20, rand(-10, 10), 30, 25, $grey, $font, $text[1]);
	imagettftext($im, 20, rand(-10, 10), 50, 25, $grey, $font, $text[2]);
	imagettftext($im, 20, rand(-10, 10), 70, 25, $grey, $font, $text[3]);

	// Using imagepng() results in clearer text compared with imagejpeg()
	$filename = "../html/chkcode/" . rand(11, 1111) . ".jpg";
	imagejpeg($im, $filename);
	imagedestroy($im);
	echo "<img src ='$filename'>";
	$_SESSION['chkcode'] = $text;
	$_SESSION['chkfile'] = $filename;
    ?>


      </div></td>
      <td>&nbsp;<input name="chk_code" type="text" class="regbox" id="chk_code" accesskey="c" tabindex="6" size="30">
      <? if ($fake)
{
  echo "<span class=error style='margin-left:-50'><b>Please re-enter code</b></font>";
} ?></td>
    </tr>
    
    <tr>
      <td colspan="4"><div align="center"></div></td>
    </tr>
    <tr>
      <td></td><td></td><td>
          <input  type="submit" name="submit" class="style1" id="button" accesskey="r" tabindex="6"  value="Register">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  type="button" name="back" class="style1" id="button" accesskey="r" tabindex="6" onclick="window.location.href='login.php';" value="Back">
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="44" colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  </form>    </td>
    
  </tr>
</table>
</body>
</html>
