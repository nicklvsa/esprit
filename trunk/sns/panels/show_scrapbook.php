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
<script language='javascript' src="../html/js/scripts.js"></script>
<?php
include_once("GetSQLValueString.php");

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs_Scrap = 10;
$pageNum_rs_Scrap = 0;
if (isset($_GET['pageNum_rs_Scrap'])) {
  $pageNum_rs_Scrap = $_GET['pageNum_rs_Scrap'];
}
$startRow_rs_Scrap = $pageNum_rs_Scrap * $maxRows_rs_Scrap;

mysql_select_db($database_esprit_conn, $esprit_conn);
$query_rs_Scrap = sprintf("SELECT user_scrap.scrap_id,user_scrap.scrap_content, user_scrap.receiver_id,user_scrap.sender_id, concat(user_profile.first_name,' ', user_profile.last_name) as sender_name FROM user_scrap, user_profile WHERE user_scrap.receiver_id =%d AND user_profile.user_id = user_scrap.sender_id order by user_scrap.scrap_id desc",$view_id);
$query_limit_rs_Scrap = sprintf("%s LIMIT %d, %d", $query_rs_Scrap, $startRow_rs_Scrap, $maxRows_rs_Scrap);
$rs_Scrap = mysql_query($query_limit_rs_Scrap, $esprit_conn) or die(mysql_error());
$row_rs_Scrap = mysql_fetch_assoc($rs_Scrap);

if (isset($_GET['totalRows_rs_Scrap'])) {
  $totalRows_rs_Scrap = $_GET['totalRows_rs_Scrap'];
} else {
  $all_rs_Scrap = mysql_query($query_rs_Scrap);
  $totalRows_rs_Scrap = mysql_num_rows($all_rs_Scrap);
}
$totalPages_rs_Scrap = ceil($totalRows_rs_Scrap/$maxRows_rs_Scrap)-1;

$queryString_rs_Scrap = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_Scrap") == false && 
        stristr($param, "totalRows_rs_Scrap") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_Scrap = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_Scrap = sprintf("&totalRows_rs_Scrap=%d%s", $totalRows_rs_Scrap, $queryString_rs_Scrap);
?>
<table width="90%" border="0" align="center" >
  
  <?php do{ 
  
  				$receiverId = $row_rs_Scrap['receiver_id'];
  				$senderId = $row_rs_Scrap['sender_id'];
				$scrapcontents = $row_rs_Scrap['scrap_content'];
				$scrapcontents = wordwrap($scrapcontents, 50, "<br />\n",true);
				$scrapcontents= strip_tags($scrapcontents);
				$senderName = $row_rs_Scrap['sender_name'];
				$senderPic = "../userdata/$senderId/pic.jpg";
				if(!file_exists($senderPic))
				{
					$senderPic = "../html/images/default1.jpg";
				}
				$scrapid = $row_rs_Scrap['scrap_id'];

				
			if($scrapcontents != "")
	  {
			echo  "<tr>";
			echo "<td><table bgcolor='#E9C1C2'><tr>";
			//echo  "<td height='125' width='20' ><input type='checkbox' name='selectScrap' value='selectedScrap'></td>";
			
			echo  "<td width='101'  align='center'>";
			echo  "<a href = 'profile.php?userID=$senderId'><input src='$senderPic' type='image' width='100' height='75'><br>$senderName</a></td>";
			echo  "<td width='580' >$scrapcontents</td>";
			echo  "<td width='80' >";
			//this condition specifies scraps which a user can delete, first condition specifies user deleting his own scraps
			//in second condition user can delete scraps send by him.
			if($view_id == $_SESSION['user_id'] || $_SESSION['user_id'] == $senderId)
			{
			echo "<a href = 'deleteScrap.php?scrap_id=$scrapid&sender_id=$receiverId&userID=$view_id'>Delete</a><br>";
			if($view_id == $_SESSION['user_id'])
			{
			echo "<a style='cursor:hand' onclick='javascript:post_Reply($scrapid);'>Reply</a>";
			}
			echo "</td></tr>";
			if($view_id == $_SESSION['user_id'])
			{
			echo  "<tr><td id='$scrapid' colspan='3' align='center' style='display:none'  >";
            
			include("reply_scrap.php");;
			echo "</td></tr>";
			}

			echo "</table></tr>";
			}
		}   
  
       }while($row_rs_Scrap = mysql_fetch_assoc($rs_Scrap));  ?>
</table>
<br />
<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table border="0">
  <tr>
    <td><?php if ($pageNum_rs_Scrap > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs_Scrap=%d%s", $currentPage, 0, $queryString_rs_Scrap); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_rs_Scrap > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs_Scrap=%d%s", $currentPage, max(0, $pageNum_rs_Scrap - 1), $queryString_rs_Scrap); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_rs_Scrap < $totalPages_rs_Scrap) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs_Scrap=%d%s", $currentPage, min($totalPages_rs_Scrap, $pageNum_rs_Scrap + 1), $queryString_rs_Scrap); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_rs_Scrap < $totalPages_rs_Scrap) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs_Scrap=%d%s", $currentPage, $totalPages_rs_Scrap, $queryString_rs_Scrap); ?>">Last</a>
          <?php } // Show if not last page 
		  if($totalRows_rs_Scrap > 0)
				{
					$startRow_rs_Scrap = $startRow_rs_Scrap +1;
				}
		  
		  ?>
    </td>
  </tr>
</table></td>
    <td>Records <?php echo ($startRow_rs_Scrap ) ?> to <?php echo min($startRow_rs_Scrap + $maxRows_rs_Scrap, $totalRows_rs_Scrap) ?> of <?php echo $totalRows_rs_Scrap; mysql_free_result($rs_Scrap);?> </td>
  </tr>
</table>
