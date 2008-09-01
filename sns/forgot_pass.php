<?php require_once('Config/config.php'); ?>
<?php
ob_start();

if (isset($_POST['uname'])) 
{
 $user = $_POST['uname'];
mysql_select_db($database_esprit_conn, $esprit_conn);
$query_Recordset1 = "SELECT user_password, user_email FROM user_main WHERE user_name ='".$user."'";
$Recordset1 = mysql_query($query_Recordset1, $esprit_conn);

	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	$passwd = $row_Recordset1['user_password'];
	$e_mail = $row_Recordset1['user_email'];
	$admail = "admin@esprit.com";
	$file = fopen(".htaccess",'w');
	fwrite($file,"php_value sendmail_from \"".$admail."\"");
	fclose($file);
	if(!$passwd)
	{
	    echo "<b><h2><label><center>The user name does not exist!!!!</center></label></b></h2>"."<br/>";
		
    }
	else
	{
		if(mail("$e_mail","Your password ---","$passwd"))
		   echo "Your password has been sent to your mail account";
	   else
		  echo "The mail cannot be sent";
	}
}
?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post" name="forgot">


<table width="100%" height="100%"border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle">
    <p>&nbsp;</p>
    <table width="229" border="0">
  <tr>
    <td width="223"><div align="center">Enter your user name</div></td>
    </tr>
  <tr>
    <td align="center" valign="middle"><input type="text" name="uname" id="uname" /></td>
  </tr>
  <tr>
    <td align="center" valign="middle">      
          <input name="forgotp" type="submit" value="submit">        </td>
  </tr>
</table>
    
    </td>
  </tr>
</table>
</form>

