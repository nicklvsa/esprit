<?php require_once('lib/mysql2xml/class.mysql_xml.php'); ?>
<?php require_once('lib/mysql2xml/class.xml.php'); ?>
<?php require_once('ImageCreateFromBmp.php');?>
<?php 
$album_path = sprintf("../userdata/%s/images/",$view_id);
$thumbs_path = sprintf("../userdata/%s/thumbs/",$view_id);

if(isset($_REQUEST['error']))
	$error=$_REQUEST['error'];

function createthumb($image_path,$thumbs_path,$pic_name,$thumb_width)
{
	
	$system = explode('.',$pic_name);
	if (preg_match('/jpg|jpeg/',$system[1])){
		$src_img = imagecreatefromjpeg($image_path."/".$pic_name);
	}
	if (preg_match('/png/',$system[1])){
		$src_img = imagecreatefrompng($image_path."/".$pic_name);
	}
	if (preg_match('/bmp/',$system[1])){
		$src_img = ImageCreateFromBMP($image_path."/".$pic_name);
	}
	if (preg_match('/gif/',$system[1])){
		$src_img = imagecreatefromgif($image_path."/".$pic_name);
	}
		$origw=imagesx($src_img); 
    $origh=imagesy($src_img); 
    $new_w = $thumb_width; 
    $diff=$origw/$new_w; 
    $new_h=$new_w; 
    $dst_img = ImageCreateTrueColor($new_w,$new_h); 
    imagecopyresized($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img)); 

    imagejpeg($dst_img, "$thumbs_path/$pic_name"); 
}

if(isset($_POST['add_pic']))
{
	$arr = explode("/",$_FILES['picfile']['type']);
	$pic_name = $_FILES['picfile']['name'];
	$max_filesize = 2300000;
	if($arr[0]=="image")
	{		
		 if($_FILES['picfile']['size'] > $max_filesize)
		 {
			$error = "The image you attempted to upload is too large";
 	     }
 	     else
 	     {
			$error=false;
			$new_photo_id = count($photo_id)+1;
	
			$pic=(md5(rand() * time())).".".$arr[1];
			$new_caption = $_REQUEST['caption'];
	        
	
	
			copy($_FILES['picfile']['tmp_name'], $album_path.$pic);
			createthumb($album_path,$thumbs_path,$pic,125);
	
			mysql_select_db($database_esprit_conn, $esprit_conn);
			//insert data to database
	
			$query_insert_album = sprintf("INSERT INTO `user_album` ( `user_id` , `photo_id` , `photo_name` , `thumb_name` , `photo_caption` ) VALUES (%s, %s, '%s', '%s', '%s');",$view_id,$new_photo_id,$pic,$pic,$new_caption);
			//echo $query_insert_album;
			mysql_query($query_insert_album);
		 }
			
	}
	else
	{
		$error="";
	}

	//create a xml file
	$query_select_album = sprintf("select * from user_album where user_id=%s",$view_id);
	$result = mysql_query($query_select_album);
	if(mysql_num_rows($result)>0)
	{
	$conv = new mysql2xml;
	$conv->convertToXML($result,"$album_xml_path");
	header('location:album.php?error='.$error);
}

}
if($view_id==$_SESSION['user_id'])
{
	if(count($photo_id)<=11)
	{
?>

<script language='javascript' src="../html/js/validations.js"></script>

<form id="upload" name="upload" enctype="multipart/form-data" method="post" action="<? echo $_SERVER['PHP_SELF'];?>" >
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="middle" bgcolor="#FFFFFF"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="64%" height="81" valign="middle" bgcolor="#FFFFFF">  <div align="center">Upload Photo
          <input type="file" name="picfile" id="fileField" />
      </div></td>
    </tr>
	
    <tr>
      <td height="55" valign="middle" bgcolor="#FFFFFF"><div align="center">Caption      
      <input type="text" name="caption" id="caption" />
       </div></td>
    </tr>  
    <tr>
      <td valign="middle" bgcolor="#FFFFFF">
        <div align="center">
          <input type="submit" name="add_pic" id="button" value="Upload" onclick='upLoad(fileField.value)' />
        </div></td>
    </tr>
    <tr>
      <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
  </table>
<?if($error){?>
     <script>alert("<?php echo $error?>");</script><?}?>
</form>

<?}}?>