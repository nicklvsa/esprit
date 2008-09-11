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
require("Config/config.php"); 
require("lib/mysql2xml/class.mysql_xml.php"); 
require("lib/mysql2xml/class.xml.php");

	ob_start();
	$u_id = $_REQUEST['did'];
	
	$photoId = $_REQUEST['pid'];
	
	mysql_select_db($database_esprit_conn, $esprit_conn);
	$query1 = "select photo_name,thumb_name from user_album where user_id=$u_id and photo_id=$photoId";
	$res1 =mysql_query($query1);
	$pname = mysql_fetch_row($res1);

	
	unlink("../userdata/$u_id/images/$pname[0]");
	unlink("../userdata/$u_id/thumbs/$pname[1]");



	$query2 = "delete from user_album where user_id=$u_id and photo_id=$photoId and photo_name='".$pname[0]."'";
	mysql_query($query2) or die("Error deleting record(s) into the database: " . mysql_error());;

	$query3 ="select max(photo_id) from user_album where user_id=$u_id";
	$res2 = mysql_query($query3);
	$pid1 = mysql_fetch_row($res2);

	$album_xml_path1="userdata/$u_id/album.xml";

	while($pid1[0]>=$photoId)
	{
		$query4 = "update user_album set photo_id=$photoId where (user_id=$u_id and photo_id=($photoId+1))";
		mysql_query($query4);
		$photoId++;
	}

	//recreating the xml file
	$query_select_album = sprintf("select * from user_album where user_id=%s",$u_id);
	$result = mysql_query($query_select_album);
	if(mysql_num_rows($result)>0)
	{
		$conv = new mysql2xml;
		$conv->convertToXML($result,"$album_xml_path1");
	
	}
		header("location:album.php");



	
	

?>

