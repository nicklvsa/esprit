<? require_once("../Config/config.php"); ?>
<? require_once("../lib/mysql2xml/class.mysql_xml.php"); ?>
<? require_once("../lib/mysql2xml/class.xml.php");?>
<?
	ob_start();

	$u_id = $_REQUEST['did'];
	
	$photoId = $_REQUEST['pid'];

	$photo_newCaption = $_REQUEST['captionedit'];

	
	mysql_select_db($database_esprit_conn, $esprit_conn);
	
	$query2 = "update user_album set photo_caption='$photo_newCaption' where (user_id=$u_id and photo_id=$photoId)";
	
	mysql_query($query2) or die("Error updating record(s) into the database: " . mysql_error());;

	header("location: ../album.php");
?>

