<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements. See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership. The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations under the License.
 * 
 */

// *** Validate request to login to this site.
require('chkuser.php');
if(isset($_GET['userID']))
{
	$view_id = $_GET['userID'];
}
else
{
	$view_id = $_SESSION['user_id'];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Albums</title>
<link href="../html/CSS/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="40" align="center" valign="middle" background="../html/images/table/table_top_bg.jpg"><? include_once('panels/topnav.php')?></td>
  </tr>
</table>
<table width="1000" height="289" border="0" align="center" cellpadding="3" cellspacing="3" bordercolor="#FFFFFF">
  <tr>
    <td width="170" height="230" align="center" valign="top" ><? include_once('panels/leftpanel.php')?>    </td>
    <td align="center" valign="top">
	
		<table width="800" height="80" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td height="29" background="../html/images/box/box_top_800.jpg"></td>
			</tr>
			<tr>
				<td height="33" valign="top" background="../html/images/box/box_center_280.jpg">
				  <h2>Album</h2>
					
					<?

						$xmlDoc = new DOMDocument();
						$album_xml_path = sprintf("../userdata/%s/album.xml",$view_id);
						$xmlDoc->load($album_xml_path);

						 $photos = $xmlDoc->getElementsByTagName( "ROW" );
						 
						  foreach( $photos as $photo )
						  {
							  $photo_uids = $photo->getElementsByTagName( "USER_ID" );
							  $photo_uid[] = $photo_uids->item(0)->nodeValue;
							  
							  $photo_ids = $photo->getElementsByTagName( "PHOTO_ID" );
							  $photo_id[] = $photo_ids->item(0)->nodeValue;
							  
							  $photo_names = $photo->getElementsByTagName( "PHOTO_NAME" );
							  $photo_name[] = $photo_names->item(0)->nodeValue;
							  
							  $photo_thumbs = $photo->getElementsByTagName( "THUMB_NAME" );
							  $photo_thumb[] = $photo_thumbs->item(0)->nodeValue;
						  }
						  

			include("panels/add_album.php");
			if(is_array($photo_id))
			{
			include("panels/show_album.php");
			}
			?>
				  
				  
				</td>
			</tr>
			<tr>
				<td height="18" background="../html/images/box/box_bottom_800.jpg"></td>
			</tr>
			</table>
	
	</td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" valign="middle" background="../html/images/box/bottom.jpg"><? include_once('panels/bottompanel.php')?></td>
  </tr>
</table>
</body>
</html>
