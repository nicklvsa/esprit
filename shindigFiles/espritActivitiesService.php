<?php

class espritActivitiesService implements ActivitiesService {

	public function getActivity(UserId $userId, $groupId, $activityId,$first, $max, SecurityToken $token)
	{
		$activities = $this->getActivities($userId, $groupId, $token);
		$activities = $activities->getResponse();
		if ($activities instanceof RestFulCollection) {
			$activities = $activities->getEntry();
			foreach ($activities as $activity) {
				if ($activity->getId() == $activityId) {
					return new ResponseItem(null, null, $activity);
				}
			}
		}
		return new ResponseItem(NOT_FOUND, "Activity not found", null);
	}
	
	public function getActivities(UserId $userId, $groupId,$first, $max, SecurityToken $token)
	{
		$ids = array();
		$activities = array();
		switch ($groupId->getType()) {
			case 'all':
			case 'friends':
				$friendIds = espritDBFetcher::get()->getFriendIds($userId->getUserId($token));
				if (is_array($friendIds) && count($friendIds)) {
					$ids = $friendIds;
				}
				break;
			case 'self':
        		$ids[] = $userId->getUserId($token);
        		break;
    	}
		$activities = espritDBFetcher::get()->getActivities($ids);
		foreach ($ids as $id) {
			if (isset($allActivities[$id])) {
				//FIXME return one big collection with the activities mixed, atleast thats what i think the spec suggests :)
				$activities = array_merge($activities, $allActivities[$id]);
			}
		}
		// TODO: Sort them
		return new ResponseItem(null, null, RestfulCollection::createFromEntry($activities));
	}

	public function createActivity(UserId $userId, $activity, SecurityToken $token)
	{
		// TODO: Validate the activity and do any template expanding
		espritDBFetcher::get()->createActivity($userId->getUserId($token), $activity, $token->getAppId());
		return new ResponseItem(null, null, array());
	}
}
