<?php

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

/*
* Part of this file/code is referred/taken by Partuza
* http://code.google.com/p/partuza
*/
	require('chkuser.php');
	require_once('Config/config.php');
	$app_url = trim($_POST['app_url']);
	$error_gadget = false;
	$response = saveApplication($app_url);
	if($response['error'])
	{
		header("Location:addApplications.php?error=".$response['error']);
	}
	else
	{
		$sql_getApp = sprintf("select application_id from `user_applications` where user_id=%d",$_SESSION['user_id']);
		$resultGetApp = mysql_query($sql_getApp, $esprit_conn) or die("Error inserting record(s) into the database: " . mysql_error());


		while($row=mysql_fetch_assoc($resultGetApp))
		{
			if($row['application_id']==$response['id'])
				$app_present=true;
		}

		if(!$app_present)
		{
			$sql_addApp = sprintf("INSERT INTO `user_applications` (`user_id`,`application_id`) values(%d,%d)",$_SESSION['user_id'],$response['id']);

			$resultAddApp = mysql_query($sql_addApp, $esprit_conn) or die("Error inserting record(s) into the database: " . mysql_error());
		}
		
		
		header("Location:addApplications.php?app_present=".$app_present);
	}
		

	function fetch_gadget_metadata($app_url)
	{
		global $gadget_server;
		$request = json_encode(array('context' => array('country' => 'US', 'language' => 'en', 'view' => 'default', 'container' => 'partuza'), 'gadgets' => array(array('url' => $app_url, 'moduleId' => '1'))));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $gadget_server .'/gadgets/metadata');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'request=' . urlencode($request));
		$content = @curl_exec($ch);
		return json_decode($content);
	}
	
	function saveApplication($app_url)
	{	
		$info = array();
		global $esprit_conn;
		global $database_esprit_conn;
		mysql_select_db($database_esprit_conn);
		// see if we have up-to-date info in our db. Cut-off time is 1 day (aka refresh module info once a day)
		$time = time() - (24 * 60 * 60);
		$url = addslashes($app_url);
		$response = fetch_gadget_metadata($app_url);
			if (! is_object($response) && ! is_array($response)) {
				// invalid json object, something bad happened on the shindig metadata side.
				$error = 'An error occured while retrieving the gadget information';
				$error_gadget = true;
			} else {
				// valid response, process it
				$gadget = $response->gadgets[0];
				if (isset($gadget->errors) && ! empty($gadget->errors[0])) {
					// failed to retrieve gadget, or failed parsing it
					$error = $gadget->errors[0];
					$error_gadget = true;
				} else {
					// retrieved and parsed gadget ok, store it in db
					$info['url'] = addslashes($gadget->url);
					$info['title'] = isset($gadget->title) ? $gadget->title : '';
					$info['directory_title'] = isset($gadget->directoryTitle) ? $gadget->directoryTitle : '';
					$info['height'] = isset($gadget->height) ? $gadget->height : '';
					$info['screenshot'] = isset($gadget->screenshot) ? $gadget->screenshot : '';
					$info['thumbnail'] = isset($gadget->thumbnail) ? $gadget->thumbnail : '';
					$info['author'] = isset($gadget->author) ? $gadget->author : '';
					$info['author_email'] = isset($gadget->authorEmail) ? $gadget->authorEmail : '';
					$info['description'] = isset($gadget->description) ? $gadget->description : '';
					$info['settings'] = isset($gadget->userPrefs) ? serialize($gadget->userPrefs) : '';
					$info['scrolling'] = !empty($gadget->scrolling) ? $gadget->scrolling : '1';
					$info['height'] = !empty($gadget->height) ? $gadget->height : '0';
					// extract the version from the iframe url
					$iframe_url = $gadget->iframeUrl;
					$iframe_params = array();
					parse_str($iframe_url, $iframe_params);
					$info['version'] = isset($iframe_params['v']) ? $iframe_params['v'] : '';
					$info['modified'] = time();
					// Insert new application into our db, or if it exists (but had expired info) update the meta data
					 mysql_query("insert into applications
								(id, url, title, directory_title, screenshot, thumbnail, author, author_email, description, settings, version, height, scrolling, modified,approved)
								values
								(
									0,
									'" . addslashes($info['url']) . "',
									'" . addslashes($info['title']) . "',
									'" . addslashes($info['directory_title']) . "',
									'" . addslashes($info['screenshot']) . "',
									'" . addslashes($info['thumbnail']) . "',
									'" . addslashes($info['author']) . "',
									'" . addslashes($info['author_email']) . "',
									'" . addslashes($info['description']) . "',
									'" . addslashes($info['settings']) . "',
									'" . addslashes($info['version']) . "',
									'" . addslashes($info['height']) . "',
									'" . addslashes($info['scrolling']) . "',
									'" . addslashes($info['modified']) . "',
									'" . addslashes('yes') . "'
								) on duplicate key update
									url = '" . addslashes($info['url']) . "',
									title = '" . addslashes($info['title']) . "',
									directory_title = '" . addslashes($info['directory_title']) . "',
									screenshot = '" . addslashes($info['screenshot']) . "',
									thumbnail = '" . addslashes($info['thumbnail']) . "',
									author = '" . addslashes($info['author']) . "',
									author_email = '" . addslashes($info['author_email']) . "',
									description = '" . addslashes($info['description']) . "',
									settings = '" . addslashes($info['settings']) . "',
									version = '" . addslashes($info['version']) . "',
									height = '" . addslashes($info['height']) . "',
									scrolling = '" . addslashes($info['scrolling']) . "',
									modified = '" . addslashes($info['modified']) . "'
								") or die("Error inserting record(s) into the database: " . mysql_error());
					$res = mysql_query("select id from applications where url = '" . addslashes($info['url']) . "'");
					if ( !mysql_num_rows($res)) {
						$error = "Could not store application in registry";
						$error_gadget = true;
					} else {
						list($id) =  mysql_fetch_row($res);
						$info['id'] = $id;
					}
				}
			}			
			$info['error'] = $error;
			return $info;
		}
		

?>