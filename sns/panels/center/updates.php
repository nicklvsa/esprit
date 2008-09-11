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
 ?>

 <link href="../../../html/CSS/table.css" rel="stylesheet" type="text/css" />

<table width="500" height="146" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="29" background="../../../html/images/box/center_box_top_500.jpg"></td>
  </tr>
  <tr>
    <td align="center" valign="top" background="../../../html/images/box/box_center_280.jpg"><br>
      <table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr><td align='center'><h3>
		<? if ($friends_updates)
{ ?>
          Friend's Updates 
		 <? }
else
{ ?>
           My Updates<? } ?></h3></td></tr>
       
      <tr>
       
      </tr>
      <tr>
        <td>
			<? //include("panels/updatePanel.php") ?>
			<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs_Activity = 10;
$pageNum_rs_Activity = 0;
$time = time();
if (isset($_GET['pageNum_rs_Activity']))
{
    $pageNum_rs_Activity = $_GET['pageNum_rs_Activity'];
}
$startRow_rs_Activity = $pageNum_rs_Activity * $maxRows_rs_Activity;

mysql_select_db($database_esprit_conn, $esprit_conn);

?>
<table width="90%" border="0" align="center" >
  
  <?php
$id = $_SESSION['user_id'];
if ($friends_updates)
{
    $querryGetActivity = sprintf("select 
			activities.title as title,
			activities.body as body,
			activities.created as created,
			user_profile.user_id as user_id,
			concat(user_profile.first_name,' ',user_profile.last_name) as user_name, 
			applications.id as app_id, 
			applications.title as app_title,
			applications.directory_title as app_directory_title,
			applications.url as app_url
		from ( activities, user_profile )
		left join applications on applications.id = activities.app_id
		where 
		(
			activities.user_id in (
				select friend_id from user_friend where user_id = %d
			)
			or 
			activities.user_id in (
				select user_id from user_friend where friend_id =%d
			)
		) and 
			user_profile.user_id = activities.user_id
		order by 
			created desc", $id, $id);
}
else
{
    $querryGetActivity = sprintf("select 
				activities.title as title,
				activities.body as body,
				activities.created as created,
				user_profile.user_id as user_id,
				concat(user_profile.first_name,' ',user_profile.last_name) as user_name, 
				applications.id as app_id, 
				applications.title as app_title,
				applications.directory_title as app_directory_title,
				applications.url as app_url
			from ( activities, user_profile )
			left join applications on applications.id = activities.app_id
			where 
				activities.user_id = %d and 
				user_profile.user_id = activities.user_id
			order by 
				created desc", $id);
}



$query_limit_rs_Activity = sprintf("%s LIMIT %d, %d", $querryGetActivity, $startRow_rs_Activity,
    $maxRows_rs_Activity);
$rs_Activity = mysql_query($query_limit_rs_Activity, $esprit_conn) or die(mysql_error
    ());


if (isset($_GET['totalRows_rs_Activity']))
{
    $totalRows_rs_Activity = $_GET['totalRows_rs_Activity'];
}
else
{
    $all_rs_Activity = mysql_query($querryGetActivity);
    $totalRows_rs_Activity = mysql_num_rows($all_rs_Activity);
}
$totalPages_rs_Activity = ceil($totalRows_rs_Activity / $maxRows_rs_Activity) -
    1;

$queryString_rs_Activity = "";
if (!empty($_SERVER['QUERY_STRING']))
{
    $params = explode("&", $_SERVER['QUERY_STRING']);
    $newParams = array();
    foreach ($params as $param)
    {
        if (stristr($param, "pageNum_rs_Activity") == false && stristr($param,
            "totalRows_rs_Activity") == false)
        {
            array_push($newParams, $param);
        }
    }
    if (count($newParams) != 0)
    {
        $queryString_rs_Activity = "&" . htmlentities(implode("&", $newParams));
    }
}
$queryString_rs_Activity = sprintf("&totalRows_rs_Activity=%d%s", $totalRows_rs_Activity,
    $queryString_rs_Activity);

while ($row_rs_Activity = mysql_fetch_assoc($rs_Activity))
{
    $app_id = $row_rs_Activity['id'];
    $u_id = $row_rs_Activity['user_id'];
    $title = $row_rs_Activity['title'];
    $name = $row_rs_Activity['user_name'];


    echo "<tr>";
    echo "<td><table bgcolor='#E9C1C2'><tr>";


    echo "<td width='101' >";
    echo "<td width='580' ><a href='$profile_url'>$name</a>" . " " . $title .
        "</td>";
    echo "<td width='80' >";
    echo "</td></tr></table></tr>";

} ?>
      
</table>
<br />
<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table border="0">
  <tr>
    <td><?php if ($pageNum_rs_Activity > 0)
{// Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs_Activity=%d%s", $currentPage, 0,
$queryString_rs_Activity); ?>">First</a>
          <?php }// Show if not first page ?>
    </td>
    <td><?php if ($pageNum_rs_Activity > 0)
{// Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs_Activity=%d%s", $currentPage, max
(0, $pageNum_rs_Activity - 1), $queryString_rs_Activity); ?>">Previous</a>
          <?php }// Show if not first page ?>
    </td>
    <td><?php if ($pageNum_rs_Activity < $totalPages_rs_Activity)
{// Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs_Activity=%d%s", $currentPage, min
($totalPages_rs_Activity, $pageNum_rs_Activity + 1), $queryString_rs_Activity); ?>">Next</a>
          <?php }// Show if not last page ?>
    </td>
    <td><?php if ($pageNum_rs_Activity < $totalPages_rs_Activity)
{// Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs_Activity=%d%s", $currentPage, $totalPages_rs_Activity,
$queryString_rs_Activity); ?>">Last</a>
          <?php }// Show if not last page
if ($totalRows_rs_Activity > 0)
{
    $startRow_rs_Activity = $startRow_rs_Activity + 1;
} ?>
    </td>
  </tr>
</table></td>
    <td>Records <?php echo ($startRow_rs_Activity) ?> to <?php echo min($startRow_rs_Activity +
$maxRows_rs_Activity, $totalRows_rs_Activity) ?> of <?php echo
$totalRows_rs_Activity;
mysql_free_result($rs_Activity); ?> </td>
  </tr>
</table>


	


 
 
		</td>
      </tr>
    </table>
      <br>
    
    </td>
  </tr>
  
  <tr>
    <td height="18" background="../../../html/images/box/box_bottom_500.jpg"></td>
  </tr>
</table>


