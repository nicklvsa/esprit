<?

require_once("panels/GetSQLValueString.php");

mysql_select_db($database_esprit_conn, $esprit_conn);
$query_rs__pending_friend = sprintf("SELECT user_friend.user_id, concat(user_profile.first_name,' ', user_profile.last_name) as friend_name FROM user_friend, user_profile WHERE user_friend.friend_id = %s AND user_friend.pending = 'yes' AND user_friend.user_id = user_profile.user_id",$_SESSION['user_id']);
$rs__pending_friend = mysql_query($query_rs__pending_friend, $esprit_conn) or die(mysql_error());
//$row_rs__pending_friend = mysql_fetch_assoc($rs__pending_friend);
$totalRows_rs__pending_friend = mysql_num_rows($rs__pending_friend);

if($totalRows_rs__pending_friend>0)
{
?>


<table width="500" height="113" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="29" background="../html/images/box/center_box_top_500.jpg"></td>
  </tr>
  <tr>
    <td height="33" valign="top" background="../html/images/box/box_center_280.jpg" align='center'><h3>Pending friend requests</h3></td>
  </tr>
  <tr>
    <td height="33" valign="top" background="../html/images/box/box_center_280.jpg"><p>&nbsp;</p>
    <table align='center' width="90%" cellpadding="0" cellspacing="0">
	<?
	while($row = mysql_fetch_assoc($rs__pending_friend))
	{
		$url = "profile.php?userID=".$row['user_id'];
		$redirUrl_yes = "add_friend.php?accpt=yes&userID=".$row['user_id'];
		$redirUrl_no = "add_friend.php?accpt=no&userID=".$row['user_id'];
		$img = "../userdata/".$row['user_id']."/pic.jpg";
		if(!file_exists($img))
			$show_photo = "../html/images/default1.jpg";
		else
			$show_photo = $img ;
		echo "<tr bgcolor='#E9C1C2'>";
		echo "<td><a href='$url'><img src= '$show_photo'></a></td>";
		echo "<td><a href='$url'>".$row['friend_name']."</a></td>";
		echo "<td><a href='$redirUrl_yes'>yes</a></td>";
		echo "<td><a href='$redirUrl_no'>no</a></td>";
		echo "<tr>";		
	}
	   
    
    ?></table> </td>
  </tr>
  <tr>
    <td height="18" background="../../../html/images/box/box_bottom_500.jpg"></td>
  </tr>
</table>


<?php
}
mysql_free_result($rs__pending_friend);
?>
