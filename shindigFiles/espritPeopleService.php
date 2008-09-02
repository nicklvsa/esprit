<?php


class espritPeopleService implements PeopleService {

	private function comparator($person, $person1)
	{
		$name = $person['name']->getUnstructured();
		$name1 = $person1['name']->getUnstructured();
		if ($name == $name1) {
			return 0;
		}
		return ($name < $name1) ? - 1 : 1;
	}

	public function getPerson($userId, $groupId, $profileDetails,SecurityToken $token)
	{

		$person = $this->getPeople($userId, $groupId, null, null, null, null, $profileDetails, null,$token);
        
		// return of getPeople is a ResponseItem(RestfulCollection(ArrayOfPeople)), disassemble to return just one person
		$person = $person->getResponse()->getEntry();
		if (is_array($person) && count($person) == 1) {
			return new ResponseItem(null, null, $person[0]);
		}
		return new ResponseItem(NOT_FOUND, "Person not found", null);
	}
    

	public function getPeople($userId, $groupId, $sortOrder, $filter, $first, $max, $profileDetails,$networkDistance,SecurityToken $token)
	{
		$ids = array();
		switch ($groupId->getType()) {
			case 'all':
			case 'friends':
				$person = $userId->getUserId($token);
				$friendIds = espritDBFetcher::get()->getFriendIds($person);
				if (is_array($friendIds) && count($friendIds)) {
					$ids = $friendIds;
				}
				break;
			case 'self':
			default:
				$ids[] = $userId->getUserId($token);
				break;
		}
		$allPeople = espritDBFetcher::get()->getPeople($ids, $profileDetails);
		$people = array();
		foreach ($ids as $id) {
			$person = null;
			if (is_array($allPeople) && isset($allPeople[$id])) {
				$person = $allPeople[$id];
				if (! $token->isAnonymous() && $id == $token->getViewerId()) {
					$person->setIsViewer(true);
				}
				if (! $token->isAnonymous() && $id == $token->getOwnerId()) {
					$person->setIsOwner(true);
				}
				if (is_array($profileDetails) && count($profileDetails) && ! in_array('all', $profileDetails)) {
					$newPerson = array();
					$newPerson['isOwner'] = $person->isOwner;
					$newPerson['isViewer'] = $person->isViewer;
					$newPerson['name'] = $person->name;
					foreach ($profileDetails as $field) {
						if (isset($person->$field) && ! isset($newPerson[$field])) {
							$newPerson[$field] = $person->$field;
						}
					}
					$person = $newPerson;
				}
				$people[] = $person;
			}
		}
		if ($sortOrder == 'name') {
			usort($people, array($this, 'comparator'));
		}
		$totalSize = count($people);
		$last = $first + $max;
		$last = min($last, $totalSize);
		if ($first !== false && $first != null && $last) {
			$people = array_slice($people, $first, $last);
		}
		$collection = new RestfulCollection($people, $first, $totalSize);
		return new ResponseItem(null, null, $collection);
	}

}
