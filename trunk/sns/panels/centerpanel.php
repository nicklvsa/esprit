<?php
echo "<table>";

if($_SESSION['user_id']==$view_id)
{
	if($page=="home")
	{
		echo "<tr><td>";
		//Show Friends Album on home page
		
		?>
		
		<table width="500" height="113" border="0" cellpadding="0" cellspacing="0">
		  <tr>
		    <td height="29" background="../html/images/box/center_box_top_500.jpg"></td>
		  </tr>
		  <tr>
		    <td height="300" valign="top" align="center" background="../html/images/box/box_center_280.jpg">
		<table width="450" height=350 border="0" cellspacing="2" cellpadding="2">
		<tr><td align='center'><h3>My Friend's Album</h3></td></tr>
		
		  <tr>
		    <td background="../html/images/photoframe.jpg"><div align="center"><img src="../html/images/loading.gif" name="slideshow" width="400" height="300" /></div></td>
		  </tr>
		</table><br>
		</td>
		  </tr>
		  <tr>
		    <td height="18" background="../html/images/box/box_bottom_500.jpg"></td>
		  </tr>
		</table>
		<?
		echo "</td></tr>";
		echo "<tr><td>";
		//Show pending friend requests
		include('panels/center/pending_friend_request.php');
		echo "</td></tr>";
	}
}
	if($_GET['myprofile']=="true" ||  $page!="home")
	{
		echo "<tr><td>";
		// Show user profile
		include('panels/center/view_profile.php');
		echo "</td></tr>";
	}
	if($_SESSION['user_id']==$view_id)
	{
		 if($page =="home")
			 $friends_updates= true;
		else 
			 $friends_updates= false; 
		echo "<tr><td>";
		// Show friends updates
		include('panels/center/updates.php');
		echo "</td></tr>";
		if($page == "profile")
		{
			// Show Applications on profile page
			include('showAppOnProfile.php');
		}
			
	}
echo "</table>";
?>
