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