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
	require('chkuser.php');


	if(isset($_GET['show_app']))
		$show_app=$_GET['show_app'];

	mysql_select_db($database_esprit_conn);

	$sql_deleteApp=sprintf("DELETE FROM user_applications WHERE id =%d",$_GET['modId']);
/*	echo $sql_deleteApp;
	exit;*/
	if(mysql_query($sql_deleteApp, $esprit_conn) or die("Error showing record(s) from the database: " . mysql_error()))
	{
			if($show_app)
			header("location:addApplications.php");
			else
			header("location:profile.php?userID=".$_SESSION['user_id']);
	}


?>