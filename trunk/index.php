<?php

require('sns/chkuser.php');

if(!isset($_SESSION['user_name']))
{
	header("Location:sns/login.php");
}
else
{
    header("Location:sns/home.php");
}

?>