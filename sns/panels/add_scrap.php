
<form method="POST" name='bk' action="<? echo $_SERVER['PHP_SELF']."?userID=".$view_id;?>">
  
  <table border="0" width='90%' align="center" cellpadding="20" cellspacing="0" height="124">
  
    <tr>
      <td height="104">
      <textarea name="scrapContents" cols="80" rows="6" wrap="physical" onclick="javascript: this.value=''; ">Enter your message here.</textarea>
      <span id="countsprytextarea1">&nbsp;</span> </td>
    </tr>
    <tr>
      <td height="19" ><input type="submit" value="Post Scrap" name="post_scrap" ></td>
    </tr>
  </table>
  

</form>

<?
//to insert scrap form data
 $noOfScraps=1;//to increase scrap id of particular user

//******************************************if any scrap is posted********************************************************//
if(isset($_POST['post_scrap']))
{
	$contents = $_POST['scrapContents'];	
	
	$sql_scrapCount = "select max(scrap_id) from user_scrap where receiver_id=$view_id ";
	//echo $sql_scrapCount;
	$resultScrap = mysql_query($sql_scrapCount) or die("Error counting scrap(s) from the database: " . mysql_error());
	$row1 = mysql_fetch_row($resultScrap);
	$noOfScraps = $row1[0]+1;
	
	//********************************to insert values in user_scrap****************************************
	//user_scrap------scrap_id, sender_id,user_id,scrap_contents
	$sql_insertScrap = sprintf("INSERT INTO user_scrap values(%s,%s,%s,'%s')",$noOfScraps,$_SESSION['user_id'],$view_id,$contents);
	//echo $sql_insertScrap;
	$result = mysql_query($sql_insertScrap) or die("Error inserting record(s) into the database: " . mysql_error());

	$sql_sender = "SELECT user_name FROM user_main WHERE user_id = ".$_SESSION['user_id'];
    $sql_viewer = "SELECT user_email FROM user_main WHERE user_id = ".$view_id;
	$result1 = mysql_query($sql_sender);
    $result2 = mysql_query($sql_viewer);
	$sender = mysql_fetch_assoc($result1);
    $viewer = mysql_fetch_assoc($result2);

	$mail_subject = $sender['user_name']." has written you a scrapbook entry !!!";
    $to = $viewer['user_email'];
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: noreply@esprit.com\r\n';

	$mail_contents = "<br><br>This message has been sent by impetus Esprit Platform<br>Copyright <b>(c)</b> 2008 Impetus Infotech (India) Pvt Ltd Inc (www.impetus.com). All Rights Reserved.";

	@mail($to,$mail_subject,$mail_contents,$headers);
}

?>
