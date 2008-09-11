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

$app_id= $_GET['app_id'];
$u_id= $_GET['u_id'];
mysql_select_db($database_esprit_conn);
	
$sql_addApp = sprintf("INSERT INTO `user_applications` (`user_id`,`application_id`) values(%d,%d)",$u_id,$app_id);

$resultAddApp = mysql_query($sql_addApp, $esprit_conn) or die("Error inserting record(s) into the database: " . mysql_error());
header('location:addApp.php');
?>
	