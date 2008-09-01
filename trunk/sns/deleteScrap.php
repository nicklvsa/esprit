<?
ob_start();
 require_once('Config/config.php'); 

$view_id =$_REQUEST['userID'];
if($_REQUEST['scrap_id'])
{
	$scrapid = $_REQUEST['scrap_id'];
	//echo $scrapid;
	$currentid = $_REQUEST['sender_id'];
	//echo $currentid;

	//echo $id;
	//****************************to delete selected scraps*********************************************
	$sql_deleteScrap = "delete from user_scrap where receiver_id=$currentid and scrap_id=$scrapid";
	//echo $sql_deleteScrap;
	$resultDelete = mysql_query($sql_deleteScrap) or die("Error deleting scrap(s) from the database: " . mysql_error());
	header("Location:scrap.php?userID=$view_id");
}
else
{
	echo "values are not passed";
}
?>