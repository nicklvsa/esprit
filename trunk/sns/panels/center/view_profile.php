<link href="../html/CSS/table.css" rel="stylesheet" type="text/css" />

<table width="500" height="146" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="29" background="../html/images/box/center_box_top_500.jpg"></td>
  </tr>
  <tr>
    <td align="center" valign="top" background="../html/images/box/box_center_280.jpg"><br>
      <table width="90%" border="0" cellspacing="0" cellpadding="0">
            <tr>
        <td></td>
      </tr>
      <tr>
        <td><br>
			<?php
include_once ('lib/read_country_xml.php');
include_once ('lib/month_read_xml.php');
?>

<table width="90%" border="0" align="center"  >
  
<?php

$querryGetProfile = sprintf("select concat(first_name,' ',last_name) as user_name,gender,country,date_of_birth,profile_url,interests,city,user_image from user_profile where user_id=%d",
    $view_id);

$rs_Profile = mysql_query($querryGetProfile, $esprit_conn) or die(mysql_error());


while ($row_rs_Profile = mysql_fetch_assoc($rs_Profile))
{
    $user_name = $row_rs_Profile['user_name'];
    $gender = $row_rs_Profile['gender'];
    if ($gender == "f")
        $gender = "Female";
    else
        $gender = "Male";
    $country = $country_name[$row_rs_Profile['country']];
    $b_month = $month_name[substr($row_rs_Profile['date_of_birth'], 0, 2)];
    $b_day = substr($row_rs_Profile['date_of_birth'], 3, 2);
    $dob = $b_day . " " . $b_month;

    $profile_url = $row_rs_Profile['profile_url'];
    $interests = $row_rs_Profile['interests'];
    $city = $row_rs_Profile['city'];
    $image = $row_rs_Profile['user_image'];

    echo "<tr>";
    echo "<td><table >";
    if ($user_name != "")
        echo "<tr bgcolor='#E9C1C2' height='50px'><td  align='right' width='580' ><a href='$profile_url'><img src='" .
            $image . "' width='70' height='50'/></a></td><td valign='middle'><font size='2'>&nbsp;&nbsp;<b>$user_name</b></font></td></tr>";
    echo "<tr bgcolor='#E9C1C2'><td width='30%' align='right'>Gender:</td><td width='70%'>$gender</td></tr>";
    if ($row_rs_Profile['country'] != null && $row_rs_Profile['country'] != "" && $row_rs_Profile['country'] !=
        " " && $row_rs_Profile['country'] != null && $row_rs_Profile['country'] !=
        "null")
        echo "<tr bgcolor='#E9C1C2'><td width='30%' align='right'>Country:</td><td width='70%'>$country</td></tr>";
    if ($city != "")
        echo "<tr bgcolor='#E9C1C2'><td width='30%' align='right'>City:</td><td width='70%'>$city</td></tr>";
    if ($dob != " ")
        echo "<tr bgcolor='#E9C1C2'><td width='30%' align='right'>Date of Birth:</td><td width='70%'>$dob</td></tr>";
    if ($interests != "")
        echo "<tr bgcolor='#E9C1C2'><td width='30%' align='right'>Interested in:</td><td width='70%'>$interests</td></tr>";
    echo "</tr></table></tr>";

}
?>
			</table>
		</td>
      </tr>
    </table>
      <br>
    
    </td>
  </tr>
  
  <tr>
    <td height="18" background="../html/images/box/box_bottom_500.jpg"></td>
  </tr>
</table>


