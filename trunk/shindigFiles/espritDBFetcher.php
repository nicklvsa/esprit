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
* Part of this code is referred from Partuza
* http://code.google.com/p/partuza
*/

class espritDBFetcher {
	private $db;
	//private $url_prefix;
	
	// Singleton
	private static $fetcher;

	private function __construct()
	{
		// enter your db config here
		$this->db = mysql_connect('localhost', 'root', '', 'espritsns');
		mysql_select_db('espritsns',$this->db);
		// change this to your site's location
		$this->url_prefix = '';
	}

	private function __clone()
	{
		// private, don't allow cloning of a singleton
	}

	static function get()
	{
		// This object is a singleton
		if (! isset(espritDBFetcher::$fetcher)) {
			espritDBFetcher::$fetcher = new espritDBFetcher();
		}
		return espritDBFetcher::$fetcher;
	}

	
	public function getFriendIds($person_id)
	{       
		$ret = array();
		$res = mysql_query("select user_id, friend_id from user_friend where user_id = $person_id or friend_id = $person_id") or die(mysql_error());
		while ($row = @mysql_fetch_assoc($res)) {
			if($row['user_id']==$person_id)
			{
	                    if(!in_array($row['friend_id'],$ret))
    			        $ret[] = $row['friend_id'] ;
			}
			else
			{
    			    if(!in_array($row['user_id'],$ret))
                                $ret[] = $row['user_id'] ;
			}
		}
		return $ret;
	}
    
	public function getPeople($ids, $profileDetails)
	{
		$ret = array();
		        
		$query = "select * from user_profile where user_id in (" . implode(',', $ids) . ")";
		$res = mysql_query($query);
		if ($res) {
			while ($row = @mysql_fetch_assoc($res)) {

				$person_id = $row['user_id'];
				$name = new Name($row['first_name'] . ' ' . $row['last_name']);
				$name->setGivenName($row['first_name']);
				$name->setFamilyName($row['last_name']);
				$person = new Person($row['user_id'], $name);
				$person->setProfileUrl($row['profile_url']);
				$date = date($row['date_of_birth']);
				$person->setDateOfBirth($date);
				$address = new Address($row['city']);
                $address->setLocality($row['city']);
                $person->setAddresses($address);
                $interests = $row['interests'];
                $interests = explode(',',$interests); 
                $person->setInterests($interests); 
				$person->setThumbnailUrl(! empty($row['user_image']) ? $this->url_prefix . $row['user_image'] : '');
				if (! empty($row['Gender'])) {
					if ($row['Gender'] == 'f') {
					    $person->setGender('FEMALE');
				    } else {
					    $person->setGender('MALE');
				    }
				}

				$ret[$person_id] = $person;
			}
		}
		return $ret;
	}

	public function setAppData($user_id, $key, $value, $app_id)
	{
		$user_id = mysql_real_escape_string($user_id,$this->db);
		$key = mysql_real_escape_string($key,$this->db);
		$value = mysql_real_escape_string($value,$this->db);
		$app_id = mysql_real_escape_string($app_id,$this->db);
		if (empty($value)) {
			if (! @mysql_query("delete from application_settings where application_id = $app_id and user_id = $user_id and name = '$key'")) {
				return false;
			}
		} else {
			if (! @mysql_query("insert into application_settings (application_id, user_id, module_id, name, value) values ($app_id, $user_id, 0, '$key', '$value') on duplicate key update value = '$value'")) {
				echo "error: ".mysql_error($this->db);
				return false;
			}
		}
		return true;
	}

	public function getAppData($ids, $keys, $app_id)
	{
		$data = array();
		foreach ($ids as $key => $val) {
			$ids[$key] = mysql_real_escape_string($val,$this->db);
		}
		if ($keys[0] == '') {
			$keys = '';
		} else {
			foreach ($keys as $key => $val) {
				$keys[$key] = "'" . mysql_real_escape_string($val,$this->db) . "'";
			}
			$keys = "and name in (" . implode(',', $keys) . ")";
		}
		$res = mysql_query("select user_id, name, value from application_settings where application_id = $app_id and user_id in (" . implode(',', $ids) . ") $keys");
        
		while ($row = @mysql_fetch_assoc($res)) {
			if (! isset($data[$row['user_id']])) {
				$data[$row['user_id']] = array();
			}
			$data[$row['user_id']][$row['name']] = $row['value'];
		}
		return $data;
	}

	public function createActivity($user_id, $activity, $app_id = '0')
	{
        
		$app_id = mysql_real_escape_string($app_id,$this->db);
		$user_id = mysql_real_escape_string($user_id,$this->db);
		$title = isset($activity['title']) ? $activity['title'] : '';
		$body = isset($activity['body']) ? $activity['body'] : '';
		$title = mysql_real_escape_string($title,$this->db);
		$body = mysql_real_escape_string($body,$this->db);
		$time = time();
        if($app_id=="" or $app_id=="null")		
			$app_id = 0;
		mysql_query("insert into activities (user_id, app_id, title, body, created) values ($user_id, $app_id, '$title', '$body', $time)");
		echo mysql_error($this->db);
		if (! ($activityId == mysql_insert_id($this->db))) {
			return false;
		}
		$mediaItems = isset($activity->mediaItems) ? $activity->mediaItems : (isset($activity['fields_']['mediaItems']) ? $activity['fields_']['mediaItems'] : array());
		if (count($mediaItems)) {
			foreach ($mediaItems as $mediaItem) {
				$type = isset($mediaItem->type) ? $mediaItem->type : (isset($mediaItem['fields_']['type']) ? $mediaItem['fields_']['type'] : '');
				$mimeType = isset($mediaItem->mimeType) ? $mediaItem->type : (isset($mediaItem['fields_']['mimeType']) ? $mediaItem['fields_']['mimeType'] : '');
				$url = isset($mediaItem->url) ? $mediaItem->url : (isset($mediaItem['fields_']['url']) ? $mediaItem['fields_']['url'] : '');
				$type = mysql_real_escape_string(trim($type),$this->db);
				$mimeType = mysql_real_escape_string(trim($mimeType),$this->db);
				$url = mysql_real_escape_string(trim($url),$this->db);
				mysql_query("insert into activity_media_items (id, activity_id, mime_type, media_type, url) values (0, $activityId, '$mimeType', '$type', '$url')");
				if (! mysql_insert_id($this->db)) {
					return false;
				}
			}
		}
		return true;
	}

	public function getActivities($ids)
	{
		$activities = array();
		foreach ($ids as $key => $val) {
			$ids[$key] = mysql_real_escape_string($val,$this->db);
		}
		$res = mysql_query("
			select 
				activities.user_id as user_id,
				activities.id as activity_id,
				activities.title as activity_title,
				activities.body as activity_body,
				activities.created as created
			from 
				activities
			where
				activities.user_id in (" . implode(',', $ids) . ")
			order by 
				created desc
			");
		while ($row = @mysql_fetch_assoc($res)) {
			$activity = new Activity($row['activity_id'], $row['user_id']);
			$activity->setStreamTitle('activities');
			$activity->setTitle($row['activity_title']);
			$activity->setBody($row['activity_body']);
			$activity->setPostedTime($row['created']);
			$activity->setMediaItems($this->getMediaItems($row['activity_id']));
			$activities[] = $activity;
		}
		return $activities;
	}

	private function getMediaItems($activity_id)
	{
		$media = array();
		$activity_id = mysql_real_escape_string($activity_id,$this->db);
		$res = mysql_query("select mime_type, media_type, url from activity_media_items where activity_id = $activity_id");
		while ($row = @mysql_fetch_assoc($res)) {
			$media[] = new MediaItem($row['mime_type'], $row['media_type'], $row['url']);
		}
		return $media;
	}


}