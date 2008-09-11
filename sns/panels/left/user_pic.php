<?

/**
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements. See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership. The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations under the License.
 */


ob_start();

if (!file_exists($photo_path))
    $show_photo = "../html/images/default1.jpg";
else
    $show_photo = $photo_path;


?>
<br><table width="85%" height="105" border="2" cellpadding="0" cellspacing="0" bordercolor="#FF9900" bgcolor="#666633">
  <tr>
    <td valign="middle"><div align="center"><a href = 'profile.php?userID=<?= $view_id ?>'><img src="<? echo $show_photo; ?>" /></a>
    </div></td>
  </tr>
  </table>
  <table border=0>
  <tr>
  <td> <?php 
    $result = mysql_query("select first_name,last_name,Gender,city from user_profile where user_id=$view_id");
    $row = mysql_fetch_assoc($result);
    echo $row['first_name']." ".$row['last_name']; 
  ?>
  </td>
  </tr>
  <tr>
  <td><?php if($row['Gender']=="m"){echo "Male";} else {echo "Female";}?></td></tr><tr><td><?php echo $row['city']?></td>
  </tr>
</table>

<?
if ($view_id == $_SESSION['user_id'])
{
    if ($page == 'edit')
    {

?>
<div id="apDiv1" style="top:inherit">
<?

        $photo_path = sprintf("../userdata/%s", $view_id);
        if (isset($_POST['uploadpic']))
        {
            $arr = explode("/", $_FILES['picfile']['type']);
			$namepic = explode(".", $_FILES['picfile']['name']);

            $pic = "pic." . $arr[1];
            if ($arr[0] == "image" && $namepic[1]!= "bmp")
            {

                copy($_FILES['picfile']['tmp_name'], $photo_path . "/" . $pic);

                function createthumb($image_path, $thumbs_path, $pic_name, $thumb_width)
                {

                    $system = explode('.', $pic_name);
                    if (preg_match('/jpg|jpeg/', $system[1]))
                    {
                        $src_img = imagecreatefromjpeg($image_path . "/" . $pic_name);
                    }
                    if (preg_match('/png/', $system[1]))
                    {
                        $src_img = imagecreatefrompng($image_path . "/" . $pic_name);
                    }
                    if (preg_match('/gif/', $system[1]))
                    {
                        $src_img = imagecreatefromgif($image_path . "/" . $pic_name);
                    }
                    $origw = imagesx($src_img);
                    $origh = imagesy($src_img);
                    $new_w = $thumb_width;
                    $diff = $origw / $new_w;
                    $new_h = $new_w;
                    $dst_img = ImageCreateTrueColor($new_w, $new_h);
                    imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $new_w, $new_h, imagesx($src_img),
                        imagesy($src_img));

                    imagejpeg($dst_img, "$thumbs_path/" . $system[0] . ".jpg");

                }
                $thumbnail_url1 = $photo_path . "/$pic";
                $sql_addThumbnail = sprintf("update `user_profile` set `user_image`= %s where `user_id`=%d",
                    "'$thumbnail_url1'", $view_id);
                $resultAddThumb = mysql_query($sql_addThumbnail, $esprit_conn) or die("Error inserting record(s) into the database: " .
                    mysql_error());
                createthumb($photo_path, $photo_path, $pic, 125);
            }
            else
            { ?>
		<script>errorInUserPic();</script>	
	<? }
        }
?>



<form id="upload" name="upload" enctype="multipart/form-data" method="post" action="<? echo
        $_SERVER['PHP_SELF']; ?>">
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="33" colspan="2" valign="middle" background="../html/images/box/box_top_500.jpg">&nbsp;</td>
    </tr>
    <tr>
      <td align="center" valign="middle">&nbsp;</td>
      <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td width="36%" rowspan="2" align="center" valign="middle"><img src="<? echo
        $photo_path . "/pic.jpg"; ?>" /></td>
      <td width="64%" height="81" valign="middle" bgcolor="#FFFFFF">  Upload Photo
        <input type="file" name="picfile" id="fileField" /></td>
    </tr>
    <tr>
	<td colspan='2'><table><tr>
	<td >&nbsp;</td>
	<td >&nbsp;</td>
	<td >&nbsp;</td>
	<td >&nbsp;</td>
      <td  bgcolor="#FFFFFF">
        <input type="submit" name="uploadpic" id="button" value="Upload" />
      </td>
	  <td bgcolor="#FFFFFF">
        <input type="submit" name="canceluploadpic" id="canceluploadpic" value="Cancel" onclick="javascript:cancel()" />
      </td></tr></table></td>
    </tr>
    <tr>
	   <td align="center" valign="middle">&nbsp;</td>
      <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" valign="middle" background="../html/images/box/box_bottom_500.jpg">&nbsp;</td>
    </tr>
  </table>

</form>


</div>
<a href="javascript:void(0);" onclick="showHideLayers('apDiv1','','show',event)"><font size='1.5'>change photo</font></a><br>
<?
    }
}
?>
<br>
<!--<hr width="140">-->