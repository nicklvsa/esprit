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

require_once ('Config/config.php');
require_once("GetSQLValueString.php");
mysql_select_db($database_esprit_conn);

$photo_path = sprintf("../userdata/%s/pic.jpg", $view_id);
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != ""))
{
  $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true"))
{
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['user_name'] = null;
  $_SESSION['user_id'] = null;
  $_SESSION['auth'] = null;
  unset($_SESSION);


  $logoutGoTo = "login.php";
  if ($logoutGoTo)
  {
    $online_query = sprintf("update user_online_status set online_status = 'no' where user_id = '%s'", $_SESSION['user_id']);
    mysql_query($online_query, $esprit_conn) or die(mysql_error());
    header("Location: $logoutGoTo");
    exit;
  }
}


$query_welcome_user = sprintf("SELECT concat(user_profile.first_name,' ',user_profile.last_name) as name FROM user_profile WHERE  user_profile.user_id = %s",
  $view_id);
$welcome_user = mysql_query($query_welcome_user, $esprit_conn) or die(mysql_error());
$row_welcome_user = mysql_fetch_row($welcome_user);
$totalRows_welcome_user = mysql_num_rows($welcome_user);
$user_info_name = $row_welcome_user[0];
?>


<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr align="center">
    <td width="17%" align="left"><img src="../html/images/esprittitle.png" width="" height="40" /></td>
    <td width="12%" ><span class="welcome">
      <?php echo "Welcome <br>" . $_SESSION['user_name']; ?>
    </span></td>
    <td width="35%"><a href="home.php" class="toplink">Home</a> | <a href="profile.php?myprofile=true&userID=<?= $_SESSION['user_id'] ?>" class="toplink">My Profile </a>| <a href="friends.php" class="toplink">Friends </a>| <a href="addApp.php" class="toplink">Application Gallery </a> </td>
    <td >&nbsp;</td>
    <td  ><a href="<?php echo $logoutAction ?>" ><b>Logout</b></a></td>
	<td>&nbsp;&nbsp;&nbsp</td>
    <td  ><form id="form1" name="form1" method="get" action="search.php" onSubmit="return checkBlankSearch();">
      Search Friends
       <input class="searchbox"type="text" name="search_query" id="textfield" size="15" />
      <input type="submit" name="search" id="search" value="Go" />
    </form>    </td>
  </tr>
</table>

<?php
mysql_free_result($welcome_user);
?>
