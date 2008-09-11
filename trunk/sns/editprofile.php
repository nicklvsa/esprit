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
require_once('chkuser.php');
$view_id = $_SESSION['user_id'];
$page = "edit";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Profile</title>
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
    <td width="170" height="230" align="center" valign="top" ><? include('panels/leftpanel.php')?>    </td>
    <td align="center" valign="top">
<?php require_once('Config/config.php');
	include('lib/read_country_xml.php');
	include('lib/month_read_xml.php');
	require_once("panels/GetSQLValueString.php");

mysql_select_db($database_esprit_conn, $esprit_conn);
$query_rs_name = sprintf("SELECT user_profile.first_name,user_profile.last_name,user_profile.Gender,user_profile.country,user_profile.interests,user_profile.date_of_birth,user_profile.city FROM user_profile WHERE user_profile.user_id = %d",$view_id);
$rs_name = mysql_query($query_rs_name, $esprit_conn) or die(mysql_error());
$row_rs_name = mysql_fetch_assoc($rs_name);
$totalRows_rs_name = mysql_num_rows($rs_name);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
session_start();
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
{
	if(strlen($_POST['day'])==1)
		$day="0".$_POST['day'];
	else 
		$day = $_POST['day'];
	$birthDate=$_POST['month'].'/'.$day.'/'.$_POST['year'];

	if(isset($_POST['friends']))
		$interests.=$_POST['friends'].",";
	if(isset($_POST['activity_partners']))
		$interests.=$_POST['activity_partners'].",";
	if(isset($_POST['business_networking']))
		$interests.=$_POST['business_networking'].",";
	if(isset($_POST['dating']))
		$interests.=$_POST['dating'];

	if(substr($interests,-1,1) == ",")
		$interests = substr($interests,0,strlen($interests)-1);

if(!empty($_POST['first_name']) and !empty($_POST['last_name']))
	{	
  $updateSQL = sprintf("UPDATE `user_profile` SET `first_name` = %s,
`last_name` = %s,
`Gender` = %s, country = %s,city=%s,date_of_birth=%s,interests=%s WHERE `user_profile`.`user_id` =%s;",
                       GetSQLValueString(strip_tags($_POST['first_name']), "text"),
                       GetSQLValueString(strip_tags($_POST['last_name']), "text"),
                       GetSQLValueString($_POST['Gender'], "text"),
					   GetSQLValueString($_POST['country'], "text"),
    				   GetSQLValueString($_POST['city'], "text"),
						GetSQLValueString($birthDate, "text"),
						GetSQLValueString($interests, "text"),
					   $view_id);

		  mysql_select_db($database_esprit_conn, $esprit_conn);
		  $Result1 = mysql_query($updateSQL, $esprit_conn) or die(mysql_error());
		  $_SESSION['user_name'] = strip_tags($_POST['first_name'])." ".strip_tags($_POST['last_name']);
		  $insertGoTo = "home.php";
		  if (isset($_SERVER['QUERY_STRING'])) {
			$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
			$insertGoTo .= $_SERVER['QUERY_STRING'];
		  }
		  header(sprintf("Location: %s", $insertGoTo));
	}
else
	{
	   $error = "Please provide First and Last names both";
	}
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../html/CSS/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="800" height="113" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="29" background="../html/images/box/box_top_800.jpg"></td>
  </tr>
  <tr>
    <td height="33" valign="top" align="center" background="../html/images/box/box_center_280.jpg"><h2>Edit Profile</h2></td>
  </tr>
  <tr>
    <td height="33" valign="top" background="../html/images/box/box_center_280.jpg">      
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="center">
         <tr>
		 <td colspan=2 align=center><font color=red><b><?php echo  $error; ?></font></b>
		 </td>
		 </tr>
		  <tr valign="baseline">
             <td nowrap="nowrap" align="right">First Name::</td>
            <td align="left">
              <input type="text" name="first_name" value="<?php echo $row_rs_name['first_name']; ?>" size="32" />
            </td>
          </tr>
		  <tr valign="baseline">
             <td nowrap="nowrap" align="right">Last Name::</td>
            <td align="left">
              <input type="text" name="last_name" value="<?php echo $row_rs_name['last_name']; ?>" size="32" />
            </td>
          </tr>
          
          <tr >
            <td nowrap="nowrap" align="right">Gender:</td>
            <td valign="baseline"  align="left" colspan='3'><table>
                <tr>
                  <td align="left"><input name="Gender" type="radio" value="M" <?if($row_rs_name['Gender']=='m')echo "checked='checked'";?> />
                    Male</td>

                  <td align="left"><input type="radio" name="Gender" value="F" <?if($row_rs_name['Gender']=='f')echo "checked='checked'";?>/>
                    Female</td>
                </tr> </table></td>
				 <tr>
           <td nowrap="nowrap" align="right">Birthday:</td>

		   <?php
           $date = $row_rs_name['date_of_birth'];
		   $newDate = explode("/",$date);

		   ?>
            <td valign="baseline" colspan='3'  align="left"><table><tr>
			 <td align="left">
             <select name='month' onchange="javascript:selectDays(this.value)"><? foreach($month_name as $id=>$name){?><option value= <?=$id?> 
			 <?php if($newDate[0]==$id)
			 echo "selected='true'"
			 ?> >
			 <?=$name?></option><?}?></select></td>
			  <td id='day'><select name='day'><?for($i=1;$i<=31;$i++){?>
			  <option value= <?=$i ?>
			  <?php if($newDate[1]==$i)
			     echo "selected='true'"
			 ?>
			  ><?=$i;?></option><?}?></select></td>
			 <td><select name='year'><?for($i=2008;$i>=1920;$i--){?>
			 <option value= <?=$i ?>
			 <?php if($newDate[2]==$i)
			 echo "selected='true'"
			 ?>
			 ><?=$i;?></option><?}?></select></td></tr></table>
          </tr>
		   <tr valign="baseline">
            <td nowrap="nowrap" align="right">City:</td>
            <td align="left">
              <input type="text" name="city" value="<?php echo $row_rs_name['city']; ?>" size="32" />
            </td>
          </tr>
				 <tr>
            <td nowrap="nowrap" align="right">Country:</td>
            <td valign="baseline"><table><tr><td id='country'>
             <select name='country' ><?foreach($country_name as $id=>$name){?><option value= <?=$id ?>
			 <?php
				 if($row_rs_name['country']==$id)
				    echo "selected='true'";
			 ?>
			 ><?=$name;?></option><?}?></select></td></tr></table>
          </tr>
		  <tr>
		  <?php
		    $intrests = explode(",",$row_rs_name['interests']);
		  ?>
		  <td nowrap="nowrap" align="right" valign="top">Interested in:</td>
            <td valign="top" align="left"><table>
		  <tr><td align="left"><INPUT
		  <?php
		  	 if(in_array("friends",$intrests))
			    echo "checked"
		  ?>
		  TYPE=CHECKBOX NAME="friends" value="friends" >friends</td></tr>
		  <tr><td align="left"><INPUT TYPE=CHECKBOX
		  <?php
		  	 if(in_array("activity partners",$intrests))
			    echo "checked"
		  ?>
		  NAME="activity_partners" value="activity partners">activity partners</td></tr>
		  <tr><td align="left"><INPUT TYPE=CHECKBOX 
		  <?php
		  	 if(in_array("business networking",$intrests))
			    echo "checked"
		  ?>
		  NAME="business_networking" value="business networking">business networking</td></tr> 
		 <tr><td align="left"><INPUT TYPE=CHECKBOX 
		 <?php
		  	 if(in_array("dating",$intrests))
			    echo "checked"
		  ?>
		 NAME="dating" value="dating">dating</td></tr>
		 </table></td></tr>
          </tr>
           
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Update Profile" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form></td>
  </tr>
  <tr>
    <td height="18" background="../html/images/box/box_bottom_800.jpg"></td>
  </tr>
</table>


</body>
</html>
<?php
mysql_free_result($rs_name);
?>

	</td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" valign="middle" background="../html/images/box/bottom.jpg"><? include_once('panels/bottompanel.php')?></td>
  </tr>
</table>
</body>
</html>
