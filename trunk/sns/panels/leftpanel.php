<table width="170" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" background="../html/images/box/box_top_170.jpg"></td>
  </tr>
  <tr>
    <td background="../html/images/box/box_center_170.jpg">
      <div align="center">
        <?
        // User Pic
		include('panels/left/user_pic.php');
		
		// Edit Profile link		
		if($view_id == $_SESSION['user_id'])
		{?>		
			<a href="editprofile.php">Edit Profile</a><br>
			<hr width="140">
	
		<?php
		}
		
		// Applications link with all user applications
		include('panels/left/add_apps.php');
		
       // Album link
		if($view_id == $_SESSION['user_id'])
		{
		?>
			<a href="album.php">My Album</a><br>
			<hr width="140">
		<?
		}
		else
		{
		
			echo "<a href='album.php?userID=$view_id'>Album</a><br><hr width='140'>";
		
		}
		
		// ScrapBook link
		if($view_id == $_SESSION['user_id'])
		{
		?>
			<a href="scrap.php">My ScrapBook</a><br>
			<hr width="140">
		<?
		}
		else
		{
		
			echo "<a href='scrap.php?userID=$view_id'>ScrapBook</a><br><hr width='140'>";
		
		}

		// Send Mail link
		
		if($view_id == $_SESSION['user_id'])
		{
		?>
			<a href="sendmail.php">Send Mail</a><br>
			<hr width="140">
		<?
		}
		
		if($view_id != $_SESSION['user_id'])
		{
		// Add Friend link
		
			require_once("panels/GetSQLValueString.php");

			mysql_select_db($database_esprit_conn, $esprit_conn);
			$query_rs_friend = sprintf("SELECT count(*) FROM user_friend WHERE user_friend.user_id=%s AND user_friend.friend_id =%s AND user_friend.pending='no'",$_SESSION['user_id'],$view_id);
			$rs_friend = mysql_query($query_rs_friend, $esprit_conn) or die(mysql_error());
			$row_rs_friend = mysql_fetch_row($rs_friend);
			$totalRows_rs_friend = mysql_num_rows($rs_friend);
			//if user is not already a friend
			
			if($row_rs_friend[0]==0)
			{
			?>
			
			<a href="add_friend.php?userID=<?echo $view_id;?>">Add Friend</a>
			<?php
			}
			mysql_free_result($rs_friend);
					
		}
		
		?>    
    </div></td>
  </tr>
  <tr>
    <td height="20" background="../html/images/box/box_bottom_170.jpg"></td>
  </tr>
</table>


