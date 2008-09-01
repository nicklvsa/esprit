<?php
// *** Validate request to login to this site.
require_once('chkuser.php');
if(isset($_GET['userID']))
{
	$view_id = $_GET['userID'];
}
else
{
	$view_id = $_SESSION['user_id'];
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Application Gallery</title>
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
			<td width="170" height="230" align="center" valign="top" >
				<? include_once('panels/leftpanel.php')?>    
			</td>
			<td align="center" valign="top">
				<table width="800" height="113" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td height="29" background="../html/images/box/box_top_800.jpg"></td>
					</tr>
					<tr>
						<td height="33" valign="top" background="../html/images/box/box_center_280.jpg">
						</td>
					</tr>
					<tr>
						<td height="33" valign="top" background="../html/images/box/box_center_280.jpg">


<?php

							require_once("panels/GetSQLValueString.php");
							$currentPage = $_SERVER["PHP_SELF"];
						
							$maxRows_rs_App = 10;
							$pageNum_rs_App = 0;
							if (isset($_GET['pageNum_rs_App'])) 
							{
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
							
							$query_rs_App = sprintf("SELECT * from applications where approved='yes' order by applications.order asc");
							$query_limit_rs_App = sprintf("%s LIMIT %d, %d", $query_rs_App, $startRow_rs_App, $maxRows_rs_App);
							$rs_App = mysql_query($query_limit_rs_App, $esprit_conn) or die(mysql_error());
							$row_rs_App = mysql_fetch_assoc($rs_App);

							if (isset($_GET['totalRows_rs_App'])) 
							{
								$totalRows_rs_App = $_GET['totalRows_rs_App'];
							} 
							else 
							{
								$all_rs_App = mysql_query($query_rs_App);
								$totalRows_rs_App = mysql_num_rows($all_rs_App);
							}
							$totalPages_rs_App = ceil($totalRows_rs_App/$maxRows_rs_App)-1;
							
							$queryString_rs_App = "";
							if (!empty($_SERVER['QUERY_STRING'])) 
							{
								$params = explode("&", $_SERVER['QUERY_STRING']);
								$newParams = array();
								foreach ($params as $param)
								{
									if (stristr($param, "pageNum_rs_App") == false && stristr($param, "totalRows_rs_App") == false) 
									{
										array_push($newParams, $param);
									}
								}
								if (count($newParams) != 0) 
								{
									$queryString_rs_App = "&" . htmlentities(implode("&", $newParams));
								}
							}
							$queryString_rs_App = sprintf("&totalRows_rs_App=%d%s", $totalRows_rs_App, $queryString_rs_App);
?>
							<table width="90%" border="0" align="center" >

<?php 
								do
								{ 
									if($row_rs_App['id']=="")
										break;
									$appId = $row_rs_App['id'];
									$appTitle = $row_rs_App['title'];
									$appThumb=  $row_rs_App['thumbnail'];
									$appDesc =  $row_rs_App['description'];
									echo  "<tr>";
									echo "<td><table bgcolor='#E9C1C2'><tr>";
									echo  "<td width='101'  align='center'>";
//									echo  "<input src='$appThumb' type='image' width='100' height='75' onclick='showPreview($appId);'><br>$appTitle</td>";
									echo "<img src='$appThumb' width='100' height='75' onclick='showPreview($appId);'><br><a href='#' onclick='showPreview($appId);'> $appTitle </a></td>";
									echo  "<td width='580' >$appDesc</td>";
									echo  "<td width='80' >";
									//this condition specifies scraps which a user can delete, first condition specifies user deleting his own scraps
									//in second condition user can delete scraps send by him.
									if($view_id == $_SESSION['user_id'] || $_SESSION['user_id'] == $senderId)
									{
										$uid= $_SESSION['user_id'];				
										if(!in_array($appId, $userAppArray))	
										{					
											echo "<a href = 'add_applications.php?app_id=$appId&u_id=$uid'>Add</a></td>";
										}
									}
									echo  "</td></tr></table></tr>";
							} while ($row_rs_App = mysql_fetch_assoc($rs_App)); ?>
						</table>
						<br />
						<table width="90%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><table border="0">
							<tr>
								<td>
<?php 
									if ($pageNum_rs_App > 0)
									 { // Show if not first page 
?>
										<a href="<?php printf("%s?pageNum_rs_App=%d%s", $currentPage, 0, $queryString_rs_App); ?>">First</a>
<?php
									 } // Show if not first page 
?>
								</td>
								<td>
<?php
									if ($pageNum_rs_App > 0) 
									{ // Show if not first page 
?>
										<a href="<?php printf("%s?pageNum_rs_App=%d%s", $currentPage, max(0, $pageNum_rs_App - 1), $queryString_rs_App); ?>">Previous</a>
<?php 
									} // Show if not first page 
?>
								</td>
								<td>
<?php 
									if ($pageNum_rs_App < $totalPages_rs_App) 
									{ // Show if not last page 
?>
										<a href="<?php printf("%s?pageNum_rs_App=%d%s", $currentPage, min($totalPages_rs_App, $pageNum_rs_App + 1), $queryString_rs_App); ?>">Next</a>
<?php 
									} // Show if not last page 
?>
								</td>
								<td>
<?php 
									if ($pageNum_rs_App < $totalPages_rs_App) 
									{ // Show if not last page 
?>
										<a href="<?php printf("%s?pageNum_rs_App=%d%s", $currentPage, $totalPages_rs_App, $queryString_rs_App); ?>">Last</a>
<?php
									} // Show if not last page 
?>
								</td>
							</tr>
						</table>
					</td>
<?php
				if($totalRows_rs_App==0)
					$add = 0;
				else
					$add = 1;
?>
				<td>Records <?php echo ($startRow_rs_App + $add) ?> to <?php echo min($startRow_rs_App + $maxRows_rs_App, $totalRows_rs_App) ?> of <?php echo $totalRows_rs_App; mysql_free_result($rs_App);?>
									 </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td height="18" background="../html/images/box/box_bottom_800.jpg"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="50" colspan="2" align="center" valign="middle" background="../html/images/box/bottom.jpg"><? include_once('panels/bottompanel.php')?></td>
		</tr>
	</table>
	</body>
</html>


