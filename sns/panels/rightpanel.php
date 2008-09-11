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
<table width="280" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" background="../html/images/box/box_top_280.jpg">&nbsp;</td>
  </tr>
  <tr>
    <td background="../html/images/box/box_center_280.jpg"><div align="center">

<?php
include_once ("GetSQLValueString.php");

mysql_select_db($database_esprit_conn, $esprit_conn);
$query_rs_friends = sprintf("SELECT user_friend.friend_id, user_profile.first_name as friend_name,user_online_status.last_online_time FROM user_friend, user_profile,user_online_status WHERE user_friend.user_id =%s AND user_friend.pending = 'no' AND user_profile.user_id = user_friend.friend_id AND user_friend.friend_id=user_online_status.user_id  order by user_online_status.last_online_time desc limit 0,9",
    $view_id);
$rs_friends = mysql_query($query_rs_friends, $esprit_conn) or die(mysql_error());

$totalRows_rs_friends = mysql_num_rows($rs_friends);
if($totalRows_rs_friends!=0){

echo "<table border='0' align='center' cellpadding='2' cellspacing='2'>";
echo "<tr><td align='center' colspan='3'><h3>My Friends</h3></td></tr>";

$j = 0;

while ($row = mysql_fetch_assoc($rs_friends))
{
    if ($j == 0)
        echo "<tr>";

    echo "<td bgcolor='#E9C1C2'><table>";
    echo "<tr>";
    $img_path = "../userdata/" . $row['friend_id'] . "/pic.jpg";

    if (!file_exists($img_path))
        $show_photo = "../html/images/default1.jpg";
    else
        $show_photo = $img_path;
    $url_path = "profile.php?userID=" . $row['friend_id'];
    echo "<td align='center'><a href = '$url_path'><img src='$show_photo' width= '70' height ='60'></a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align='center'><a href = '$url_path'>" . $row['friend_name'] .
        "</a></td>";
    echo "</tr>";
    echo "</table></td>";


    $j++;
    if ($j == 3)
    {
        echo "</tr>";
        $j = 0;
    }
}





echo "</table>";



mysql_free_result($rs_friends);
?>
<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="friends.php?userID=<?php echo $view_id; ?>">view all </a></td>
  </tr>
</table>

<?}
else{
echo "<h3>My Friends</h3>";

echo("You have 0 friends");}?>

    </div></td>
  </tr>
  <tr>
    <td background="../html/images/box/box_bottom_280.jpg">&nbsp;</td>
  </tr>
</table>

