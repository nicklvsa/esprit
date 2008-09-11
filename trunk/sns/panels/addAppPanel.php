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


?>
<table width="800" height="113" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="29" background="../html/images/box/box_top_800.jpg"></td>
  </tr>
  <tr>
    <td height="33" valign="top" background="../html/images/box/box_center_280.jpg" align='left'>
<form action="createApp.php" method="POST">
<table>

<tr>
<td width="50%" height="81"  bgcolor="#FFFFFF" align="right">  
     Enter url : <input type="text" name="app_url" id="urlField" size="36" /></td>
		<td  align="left"><input type="submit" name="addApp" value="add application"></td>
</tr>
<tr><td width="50%" colspan='2'>&nbsp;&nbsp;&nbsp;The applications listed below are currently on your eSprit profile. On this page you can add new applications or remove them </td></tr>
</table>
</form>
    </td>
  </tr>
  <tr>
    <td height="33" valign="top" background="../html/images/box/box_center_280.jpg">
<?php

require_once("GetSQLValueString.php");

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs_App = 10;
$pageNum_rs_App = 0;
if (isset($_GET['pageNum_rs_App'])) {
  $pageNum_rs_App = $_GET['pageNum_rs_App'];
}
$startRow_rs_App = $pageNum_rs_App * $maxRows_rs_App;

mysql_select_db($database_esprit_conn, $esprit_conn);


$sql_getUserApps = "Select application_id From user_applications Where user_id = ".$_SESSION['user_id'];
$resultGetUserApp = mysql_query($sql_getUserApps);
$i=0;
$userAppArray = array();
while($userAppRecord = mysql_fetch_assoc($resultGetUserApp))
{
	$userAppArray[$i++] = $userAppRecord['application_id'];
}

$query_rs_App = sprintf("SELECT * from applications  where id in(Select application_id From user_applications Where user_id =%d) order by applications.order asc",$_SESSION['user_id']);
$query_limit_rs_App = sprintf("%s LIMIT %d, %d", $query_rs_App, $startRow_rs_App, $maxRows_rs_App);
$rs_App = mysql_query($query_limit_rs_App, $esprit_conn) or die(mysql_error());
$row_rs_App = mysql_fetch_assoc($rs_App);

if (isset($_GET['totalRows_rs_App'])) {
  $totalRows_rs_App = $_GET['totalRows_rs_App'];
} else {
  $all_rs_App = mysql_query($query_rs_App);
  $totalRows_rs_App = mysql_num_rows($all_rs_App);
}
$totalPages_rs_App = ceil($totalRows_rs_App/$maxRows_rs_App)-1;

$queryString_rs_App = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_App") == false && 
        stristr($param, "totalRows_rs_App") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_App = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_App = sprintf("&totalRows_rs_App=%d%s", $totalRows_rs_App, $queryString_rs_App);


?>
<table width="90%" border="0" align="center" >

  <?php do { 
		if( $row_rs_App['id'] != "")
	  {
  				$appId = $row_rs_App['id'];
				$appTitle = $row_rs_App['title'];
				$sql_getModId = "SELECT id FROM user_applications WHERE user_id =".$_SESSION['user_id']." AND application_id =".$appId ;

				$resultGetModId = mysql_query($sql_getModId, $esprit_conn) or die("Error showing record(s) from the database: " . mysql_error());
			$result = mysql_fetch_assoc($resultGetModId);
			$url = "deleteApp.php?modId=".$result['id']."&show_app=".true;
	?>			
     
	<?		echo  "<tr>";
			echo "<td align='left'><table bgcolor='#E9C1C2' width='70%'><tr>";
			echo "<td align='left' width='5%'><img width='20' heigth='20' src='images/icon40.gif'/></td>";
			echo  "<td align='left'  width='60%'><a href='#' onclick='showPreview($appId);'><br>$appTitle</a></td>";
			echo  "<td align='right' width='25%'><a href='$url'>delete</a></td>";
			echo  "<td width='10%'></td>";
			if($view_id == $_SESSION['user_id'] || $_SESSION['user_id'] == $senderId)
			{
				$uid= $_SESSION['user_id'];				
			}
			echo  "</tr></table></tr>";
		    		   
  
	  }
	  else
	  {
		  echo "Sorry There are no apps added in your profile!!";
	  }
       } while ($row_rs_App = mysql_fetch_assoc($rs_App)); ?>
</table>
<br />
<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table border="0">
  <tr>
    <td><?php if ($pageNum_rs_App > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs_App=%d%s", $currentPage, 0, $queryString_rs_App); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_rs_App > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs_App=%d%s", $currentPage, max(0, $pageNum_rs_App - 1), $queryString_rs_App); ?>">Previous</a>
          <?php }
		   if($totalRows_rs_App > 0)
				{
					$startRow_rs_App = $startRow_rs_App +1;
				}// Show if not first page ?>
    </td>
    <td><?php if ($pageNum_rs_App < $totalPages_rs_App) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs_App=%d%s", $currentPage, min($totalPages_rs_App, $pageNum_rs_App + 1), $queryString_rs_App); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_rs_App < $totalPages_rs_App) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs_App=%d%s", $currentPage, $totalPages_rs_App, $queryString_rs_App); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table></td>
    <td>Records <?php echo ($startRow_rs_App) ?> to <?php echo min($startRow_rs_App + $maxRows_rs_App, $totalRows_rs_App) ?> of <?php echo $totalRows_rs_App; mysql_free_result($rs_App);?> </td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td height="18" background="../html/images/box/box_bottom_800.jpg"></td>
  </tr>
</table>
