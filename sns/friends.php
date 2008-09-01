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
<title>Friends</title>
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
	
	<?php
		if (!function_exists("GetSQLValueString")) {
		function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
		{
		  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

		  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

		  switch ($theType) {
			case "text":
			  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			  break;    
			case "long":
			case "int":
			  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
			  break;
			case "double":
			  $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
			  break;
			case "date":
			  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			  break;
			case "defined":
			  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
			  break;
		  }
		  return $theValue;
		}
		}

		$currentPage = $_SERVER["PHP_SELF"];

		$maxRows_rs_friend = 10;
		$pageNum_rs_friend = 0;
		if (isset($_GET['pageNum_rs_friend'])) {
		  $pageNum_rs_friend = $_GET['pageNum_rs_friend'];
		}
		$startRow_rs_friend = $pageNum_rs_friend * $maxRows_rs_friend;

		mysql_select_db($database_esprit_conn, $esprit_conn);
		$query_rs_friend = sprintf("SELECT user_friend.friend_id, concat(user_profile.first_name, ' ',user_profile.last_name) as friend_name , user_profile.Gender FROM user_friend, user_profile WHERE user_profile.user_id = user_friend.friend_id AND user_friend.user_id =%s",$view_id);
		$query_limit_rs_friend = sprintf("%s LIMIT %d, %d", $query_rs_friend, $startRow_rs_friend, $maxRows_rs_friend);
		$rs_friend = mysql_query($query_limit_rs_friend, $esprit_conn) or die(mysql_error());
		$row_rs_friend = mysql_fetch_assoc($rs_friend);

		if (isset($_GET['totalRows_rs_friend'])) {
		  $totalRows_rs_friend = $_GET['totalRows_rs_friend'];
		} else {
		  $all_rs_friend = mysql_query($query_rs_friend);
		  $totalRows_rs_friend = mysql_num_rows($all_rs_friend);
		}
		$totalPages_rs_friend = ceil($totalRows_rs_friend/$maxRows_rs_friend)-1;

		$queryString_rs_friend = "";
		if (!empty($_SERVER['QUERY_STRING'])) {
		  $params = explode("&", $_SERVER['QUERY_STRING']);
		  $newParams = array();
		  foreach ($params as $param) {
			if (stristr($param, "pageNum_rs_friend") == false && 
				stristr($param, "totalRows_rs_friend") == false) {
			  array_push($newParams, $param);
			}
		  }
		  if (count($newParams) != 0) {
			$queryString_rs_friend = "&" . htmlentities(implode("&", $newParams));
		  }
		}
		$queryString_rs_friend = sprintf("&totalRows_rs_friend=%d%s", $totalRows_rs_friend, $queryString_rs_friend);
		?><table width="800" height="80" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td height="29" background="../html/images/box/box_top_800.jpg"></td>
		  </tr>
		  <tr>
			<td height="33"  valign="top" background="../html/images/box/box_center_280.jpg"><h2>Friend List</h2>
			  <table width="90%" border="0" align="center">
				<?php do {?>
						<?if($row_rs_friend['friend_id']!=""){?>

				  <tr>
					<td><a href="profile.php?userID=<?php echo $row_rs_friend['friend_id']; ?>"> 
					<?php
					  $path = '../userdata/'.$row_rs_friend['friend_id'].'/pic.jpg';
					  if(file_exists($path))
						echo "<img src=$path hight=100 width=100> </a> </td>";
					  else
						echo "<img src='../html/images/default2.png'> </a> </td>";
					?>
					
					<td><a href="profile.php?userID=<?php echo $row_rs_friend['friend_id']; ?>"><?php echo $row_rs_friend['friend_name']; ?></a>&nbsp; </td>
					<td><?php if($row_rs_friend['Gender']=='f')echo "Female";else echo "Male"; ?></td>
				  </tr>
				  <tr><td colspan="3"><br><hr></td></tr><?}?>
				  <?php } while ($row_rs_friend = mysql_fetch_assoc($rs_friend)); ?>
			  </table>
			  <br />
			  <table border="0">
				<tr>
				  <td><?php if ($pageNum_rs_friend > 0) { // Show if not first page ?>
						<a href="<?php printf("%s?pageNum_rs_friend=%d%s", $currentPage, 0, $queryString_rs_friend); ?>">First</a>
						<?php } // Show if not first page ?>
				  </td>
				  <td><?php if ($pageNum_rs_friend > 0) { // Show if not first page ?>
						<a href="<?php printf("%s?pageNum_rs_friend=%d%s", $currentPage, max(0, $pageNum_rs_friend - 1), $queryString_rs_friend); ?>">Previous</a>
						<?php } // Show if not first page ?>
				  </td>
				  <td><?php if ($pageNum_rs_friend < $totalPages_rs_friend) { // Show if not last page ?>
						<a href="<?php printf("%s?pageNum_rs_friend=%d%s", $currentPage, min($totalPages_rs_friend, $pageNum_rs_friend + 1), $queryString_rs_friend); ?>">Next</a>
						<?php } // Show if not last page ?>
				  </td>
				  <td><?php if ($pageNum_rs_friend < $totalPages_rs_friend) { // Show if not last page ?>
						<a href="<?php printf("%s?pageNum_rs_friend=%d%s", $currentPage, $totalPages_rs_friend, $queryString_rs_friend); ?>">Last</a>
						<?php } // Show if not last page 
						if($totalRows_rs_friend > 0)
						{
							$startRow_rs_friend = $startRow_rs_friend +1;
						}
						?>
				  </td>
				</tr>
			  </table>
			<table><tr><td>Records <?php echo ($startRow_rs_friend) ?> to <?php echo min($startRow_rs_friend + $maxRows_rs_friend, $totalRows_rs_friend) ?> of <?php echo $totalRows_rs_friend ?> </td>
		  </tr>
		  <tr>
			<td height="18" background="../html/images/box/box_bottom_800.jpg"></td>
		  </tr>
		</table>

<?php
	mysql_free_result($rs_friend);
?>

	
	</td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" valign="middle" background="../html/images/box/bottom.jpg"><? include_once('panels/bottompanel.php')?></td>
  </tr>
</table>
</body>
</html>
