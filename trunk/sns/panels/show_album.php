<script type="text/javascript" src="../html/js/prototype.js"></script>
<script type="text/javascript" src="../html/js/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="../html/js/lightbox.js"></script>
<link rel="stylesheet" href="../html/css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../html/css/general.css" type="text/css" media="screen" />
<?
$j=0;
echo "<table border=2 align='center' cellspacing='10' cellpadding='10' style='color:#885C5C'>";
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
		echo "<table><tr><td align='center'><a href='$pic_large' rel='lightbox[album]' title='$p_id[1]'><img src='$pic'></a></td></tr>";
		echo "<tr><td align='center'><label class='caption'>$p_id[1]</label></tr>";
		
		if($view_id == $_SESSION['user_id'])
		{
		echo "<tr><td align='center'><a href='delete_photo.php?pid=$p_id[0]&did=$u'>Delete</a></td></tr>";
		
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