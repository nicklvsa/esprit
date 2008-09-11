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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search</title>
<link href="../html/CSS/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="40" align="center" valign="middle" background="../html/images/table/table_top_bg.jpg"><? include_once('panels/topnav.php')?></td>
  </tr>
</table>
<table width="1000" height="289" border="0" align="center" cellpadding="3" cellspacing="3" bordercolor="#FFFFFF">
  <tr>
    <td width="170" height="230" align="center" valign="top" ><? include_once('panels/leftpanel.php')?>    </td>
    <td align="center" valign="top">
	
	<?

		if(isset($_GET['search']))
		{


		include_once("panels/GetSQLValueString.php");

		$currentPage = $_SERVER["PHP_SELF"];

		$maxRows_rs_search = 10;
		$pageNum_rs_search = 0;
		if (isset($_GET['pageNum_rs_search'])) {
		  $pageNum_rs_search = $_GET['pageNum_rs_search'];
		}
		$startRow_rs_search = $pageNum_rs_search * $maxRows_rs_search;

		mysql_select_db($database_esprit_conn, $esprit_conn);
		$search_query = $_GET['search_query'];

		$search_array = explode(" ", $search_query);
		$query_rs_search ="SELECT user_profile.user_id,concat(user_profile.first_name ,' ',user_profile.last_name) as name FROM user_profile WHERE";
		foreach($search_array as $search_str)
		{
			$query_rs_search .= " user_profile.first_name like '%$search_str%' or user_profile.last_name like '%$search_str%' or";
		}

		$query_rs_search = substr($query_rs_search, 0, -2);

		$query_limit_rs_search = sprintf("%s LIMIT %d, %d", $query_rs_search, $startRow_rs_search, $maxRows_rs_search);
		$rs_search = mysql_query($query_limit_rs_search, $esprit_conn) or die(mysql_error());
		$row_rs_search = mysql_fetch_assoc($rs_search);

		if (isset($_GET['totalRows_rs_search'])) {
		  $totalRows_rs_search = $_GET['totalRows_rs_search'];
		} else {
		  $all_rs_search = mysql_query($query_rs_search);
		  $totalRows_rs_search = mysql_num_rows($all_rs_search);
		}
		$totalPages_rs_search = ceil($totalRows_rs_search/$maxRows_rs_search)-1;

		$queryString_rs_search = "";
		if (!empty($_SERVER['QUERY_STRING'])) {
		  $params = explode("&", $_SERVER['QUERY_STRING']);
		  $newParams = array();
		  foreach ($params as $param) {
			if (stristr($param, "pageNum_rs_search") == false && 
				stristr($param, "totalRows_rs_search") == false) {
			  array_push($newParams, $param);
			}
		  }
		  if (count($newParams) != 0) {
			$queryString_rs_search = "&" . htmlentities(implode("&", $newParams));
		  }
		}
		$queryString_rs_search = sprintf("&totalRows_rs_search=%d%s", $totalRows_rs_search, $queryString_rs_search);

		if($totalRows_rs_search > 0)
		{

		?>
		<table width="800" height="146" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td height="29" colspan="2" background="../html/images/box/box_top_800.jpg"></td>
		  </tr>
		  <tr>
			<td height="33" colspan="2" valign="top" background="../html/images/box/box_center_280.jpg">
			  <br>
			<hr width="90%" weight="10">

			
			</td>
		  </tr>
		  <tr>
			<td height="33" colspan="2" valign="top" background="../html/images/box/box_center_280.jpg">
			<table width="90%" align="center">
		  <?php do { ?>
		   <tr>
		   <td><a href="profile.php?userID=<?php echo $row_rs_search['user_id']; ?>"> 
				<?php 
				   $user_pic = sprintf("../userdata/%s/pic.jpg",$row_rs_search['user_id']);
				   if(!file_exists($user_pic))
				   {
						$user_pic = "../html/images/default1.jpg";	
				   }	      
						
				?>
				   <img src="<?php echo $user_pic ?>"></a> </td><td>
			  <a href="profile.php?userID=<?php echo $row_rs_search['user_id']; ?>"> <?php echo $row_rs_search['name']; ?></a>    </td></tr>
			  <tr ><td colspan ="2"><hr> </td></tr>
			<?php } while ($row_rs_search = mysql_fetch_assoc($rs_search)); ?>			
			</table>
			
		<br /></td>
		  </tr>
		  <tr>
			<td width="583" height="33" align="right" valign="top" background="../html/images/box/box_center_280.jpg">Records <?php echo ($startRow_rs_search + 1) ?> to <?php echo min($startRow_rs_search + $maxRows_rs_search, $totalRows_rs_search) ?> of <?php echo $totalRows_rs_search ?> </td>
			<td width="217" align="left" valign="top" background="../html/images/box/box_center_280.jpg"><table border="0" align="right">
			  <tr>
				<td><?php if ($pageNum_rs_search > 0) { // Show if not first page ?>
					<a href="<?php printf("%s?pageNum_rs_search=%d%s", $currentPage, 0, $queryString_rs_search); ?>">First</a>
					<?php } // Show if not first page ?>        </td>
				<td><?php if ($pageNum_rs_search > 0) { // Show if not first page ?>
					<a href="<?php printf("%s?pageNum_rs_search=%d%s", $currentPage, max(0, $pageNum_rs_search - 1), $queryString_rs_search); ?>">Previous</a>
					<?php } // Show if not first page ?>        </td>
				<td><?php if ($pageNum_rs_search < $totalPages_rs_search) { // Show if not last page ?>
					<a href="<?php printf("%s?pageNum_rs_search=%d%s", $currentPage, min($totalPages_rs_search, $pageNum_rs_search + 1), $queryString_rs_search); ?>">Next</a>
					<?php } // Show if not last page ?>        </td>
				<td><?php if ($pageNum_rs_search < $totalPages_rs_search) { // Show if not last page ?>
					<a href="<?php printf("%s?pageNum_rs_search=%d%s", $currentPage, $totalPages_rs_search, $queryString_rs_search); ?>">Last</a>
					<?php } // Show if not last page ?>        </td>
			  </tr>
			</table></td>
		  </tr>
		  <tr>
			<td height="18" colspan="2" background="../html/images/box/box_bottom_800.jpg"></td>
		  </tr>
		</table>
		<?php
		}
		else
			
			echo(" Sorry! No Matches Found");
			mysql_free_result($rs_search);

		}
		
		?>

	
	
	</td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" valign="middle" background="../html/images/box/bottom.jpg"><? include_once('panels/bottompanel.php')?></td>
  </tr>
</table>
</body>
</html>
