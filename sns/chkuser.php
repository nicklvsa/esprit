<?php
// *** Validate request to login to this site.
ob_start();
//if (!isset($_SESSION)) 
//{
  session_start();
//}

if(!isset($_COOKIE['auth']))
{
    header("Location:login.php");
}
else
{
	if(!isset($_SESSION['user_name']))
		header("Location:login.php");
	else
		if($_SESSION['auth']!==$_COOKIE['auth'])
            header("Location:login.php");
}
?>


