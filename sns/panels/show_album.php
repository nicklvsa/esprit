<script type="text/javascript" src="../html/js/prototype.js"></script>
<script type="text/javascript" src="../html/js/scripts.js"></script>
<script type="text/javascript" src="../html/js/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="../html/js/lightbox.js"></script>
<link rel="stylesheet" href="../html/css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../html/css/general.css" type="text/css" media="screen" />
<?
$j=0;
echo "<table border=2 align='center'  bordercolor='#885C5C' cellspacing='10' cellpadding='10' >";
if($j==0)
			echo "<tr>";
foreach($photo_thumb as $pic_thumb)
{

	$pic =$thumbs_path.$pic_thumb;
	$pic_large =$album_path.$pic_thumb;

	$query = "select photo_id,photo_caption from user_album where photo_name='".$pic_thumb."'";
	
	$res= mysql_query($query);
	if(($p_id=mysql_fetch_row($res)))
	{
	 	$u=$_SESSION['user_id'];



		echo "<td>";
		echo "<table><tr><td align='center' colspan='2'><a href='$pic_large' rel='lightbox[album]' title='$p_id[1]'><img src='$pic'></a></td></tr>";
		echo "<tr><td align='center' colspan='2' ><label class='caption'>$p_id[1]</label></tr>";
		
		if($view_id == $_SESSION['user_id'])
		{
		echo "<tr><td align='left'><a href='delete_photo.php?pid=$p_id[0]&did=$u'>Delete</a></td>";
		echo "<td colspan='2'> <a style='cursor:hand' onclick='javascript: edit_caption(\"$p_id[0]\",1);'>Edit</a></td></tr>";
		echo "<form name='editCaption' method='POST' action='panels/save_caption.php?pid=$p_id[0]&did=$u'><tr ><td  id ='$p_id[0]' style='display:none' colspan='2'><input type='text' name='captionedit' value='$p_id[1]' ><input type='submit' value=' Save ' ><input type='button' value='Cancel' onclick='javascript: edit_caption(\"$p_id[0]\",0);' ></td></tr></form>";
		
		}
		echo "</table>";
		echo "</td>";

		
		$j++;
		
		if($j==3)
		{
			echo "</tr>";
			$j=0;
		}
		
	}
}
echo "</table>";
echo "<table><tr><td></td></tr></table>";
?>
