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
require_once('Config/config.php'); 

?>
<link rel="stylesheet" href="../html/CSS/general.css" type="text/css" media="screen" />
<script language='javascript' src="../html/js/validations.js"></script>

<?



$sql_getApp=sprintf("SELECT * FROM applications WHERE id IN (SELECT application_id FROM user_applications WHERE user_id =%d)",$view_id);
$resultGetApp = mysql_query($sql_getApp, $esprit_conn) or die("Error showing record(s) from the database: " . mysql_error());
	
		
?>
<?if($view_id == $_SESSION['user_id']){?>
<table><tr><td align="center"><div class="left_panel_heading"><a href="#" onClick="toggleAppDiv();">My Applications</a></div></td></tr>
<?}
else
{?>
<table><tr><td align="center"><div class="left_panel_heading"><a href="#" onClick="toggleAppDiv();">Applications</a></div></td></tr>
<?}?>
<tr>
<td>
<div id="left_app_div" style="display:none">
<table>
<?


	while($row = mysql_fetch_assoc($resultGetApp))
		{
			$sql_getModId = "SELECT id FROM user_applications WHERE user_id =".$view_id." AND application_id =". $row['id'];
			$resultGetModId = mysql_query($sql_getModId, $esprit_conn) or die("Error showing record(s) from the database: " . mysql_error());
			$result = mysql_fetch_assoc($resultGetModId);
			if(!isset($_REQUEST['user_id']))
				$_REQUEST['user_id'] = $view_id;
			$url = "application.php?viewer_id=".$view_id."&owner_id=".$_REQUEST['user_id']."&app_id=".$row['id']."&mod_id=".$result['id'];
			
			?>
		<tr><td class="app_name" align='left'><img src="../../../html/images/appList.gif" height=8 width=8>&nbsp;<a href='<?echo $url?>'><?= $row['title'] ?></a></td></tr>
		<?
		}	
		
	?>
	<?if($view_id == $_SESSION['user_id']){?>
	<tr><td align='left'><img src='images/plus2.gif'/>&nbsp;<a href='addApplications.php'>add apps</a></td></tr>
	<?}?>
</table>
</div>
</td>	
</tr>	
</table>
<hr width="140">