<?php
/**
 * Class that represents an object of subtype poll
 */
class Poll extends ElggObject {
	const SUBTYPE = "poll";

	/**
	 * @var array $responses Cache for number of responses for each voting choice
	 */
	private $responses_by_choice = array();

	/**
	 * @var int $response_count Total amount of responses
	 */
	private $response_count = 0;

	/**
	 * @var int $voter_count Total amount of voted users
	 */
	private $voter_count = 0;

	/**
	 * Set subtype
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = $this::SUBTYPE;
	}

	/**
	 * Check whether the user has voted in this poll
	 *
	 * @param ElggUser $user
	 * @return boolean
	 */
	public function hasVoted($user) {
		$votes = elgg_get_annotations(array(
			'guid' => $this->guid,
			'type' => "object",
			'subtype' => "poll",
			'annotation_name' => "vote",
			'annotation_owner_guid' => $user->guid,
			'limit' => 1
		));

		if ($votes) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get choice objects
	 *
	 * @return ElggObject[] $choices
	 */
	public function getChoices() {
		$choices = $this->getEntitiesFromRelationship(array(
			'relationship' => 'poll_choice',
			'inverse_relationship' => true,
			'limit' => false,
			'order_by_metadata' => array(
				'name' => 'display_order',
				'direction' => 'ASC',
				'as' => integer
			),
		));

		if (!$choices) {
			$choices = array();
		}

		return $choices;
	}

	/**
	 * Delete all choices associated with this poll
	 */
	public function deleteChoices() {
		foreach ($this->getChoices() as $choice) {
			$choice->delete();
		}
	}

	/**
	 * Delete all votes associated with this poll, reset vote counters and delete associated vote river items
	 */
	public function deleteVotes() {
		$access = elgg_set_ignore_access(true);
		$access_status = access_get_show_hidden_status();
		access_show_hidden_entities(true);

		$river_items = new ElggBatch('elgg_get_river', array(
			'action_type' => 'vote',
			'object_guid' => $this->guid,
			'limit' => false,
			'wheres' => array("rv.view = \"river/object/poll/vote\""),
		));

		$river_items->setIncrementOffset(false);
		foreach ($river_items as $river_item) {
			$river_item->delete();
		}

		access_show_hidden_entities($access_status);
		elgg_set_ignore_access($access);

		elgg_delete_annotations(array(
			'guid' => $this->guid,
			'type' => "object",
			'subtype' => "poll",
			'annotation_name' => "vote",
		));

		$this->responses_by_choice = array();
		$this->response_count = 0;
		$this->voter_count = 0;
	}

	/**
	 * Adds poll choices
	 *
	 * @param array $choices
	 */
	public function setChoices(array $choices) {
		if (empty($choices)) {
			return false;
		}

		$this->deleteChoices();

		// Ignore access (necessary in case a group admin is editing the poll of another group member)
		$ia = elgg_set_ignore_access(true);

		$i = 0;
		foreach ($choices as $choice) {
			$poll_choice = new ElggObject();
			$poll_choice->owner_guid = $this->owner_guid;
			$poll_choice->container_guid = $this->container_guid;
			$poll_choice->subtype = "poll_choice";
			$poll_choice->text = $choice;
			$poll_choice->display_order = $i*10;
			$poll_choice->access_id = $this->access_id;
			$poll_choice->save();

			add_entity_relationship($poll_choice->guid, 'poll_choice', $this->guid);
			$i += 1;
		}

		elgg_set_ignore_access($ia);
	}

	/**
	 * Update acccess_id of poll choices to match (changed) access_id of poll
	 *
	 */
	public function updateChoicesAccessID() {
		// Ignore access (necessary in case a group admin is editing the poll of another group member)
		$ia = elgg_set_ignore_access(true);

		$choices = $this->getChoices();

		foreach ($choices as $choice) {
			$choice->access_id = $this->access_id;
			$choice->save();
		}

		elgg_set_ignore_access($ia);
	}

	/**
	 * Check for changes in poll choices on editing of a poll and update choices if necessary
	 * If an update is necessary the existing votes get deleted and the vote counters get reset
	 *
	 * @param array $choices
	 */
	public function updateChoices(array $choices, $former_access_id) {
		if (empty($choices)) {
			return false;
		}

		$choices_changed = false;
		$old_choices = $this->getChoices();

		if (count($choices) != count($old_choices)) {
			$choices_changed = true;
		} else {
			$i = 0;
			foreach ($old_choices as $old_choice) {
				if ($old_choice->text != $choices[$i]) {
					$choices_changed = true;
				}
				$i += 1;
			}
		}

		if ($choices_changed) {
			$this->deleteVotes();
			$this->setChoices($choices);
		} else if ($former_access_id != $this->access_id) {
			$this->updateChoicesAccessID();
		}
		
		return $choices_changed;
	}

	/**
	 * Is the poll open for new votes?
	 *
	 * @return boolean
	 */
	public function isOpen() {
		if (empty($this->close_date)) {
			// There is no closing date so this poll is always open
			return true;
		}

		$now = time();

		// input/date saves beginning of day and we want to include closing date day in poll
		$deadline = $this->close_date + 86400;

		return $deadline > $now;
	}

	/**
	 * Fetch and cache amount of responses for each choice
	 *
	 * Caches the data in form:
	 *     array(
	 *         'choice 1' => 5,
	 *         'choice 2' => 13,
	 *         'choice 3' => 2,
	 *     )
	 */
	private function fetchResponses() {
		if ($this->responses_by_choice) {
			return;
		}

		// Make sure choices without responses are included in the result
		foreach ($this->getChoices() as $choice) {
			$this->responses_by_choice[$choice->text] = 0;
		}

		// Get responses
		$responses = new ElggBatch('elgg_get_annotations', array(
			'guid' => $this->guid,
			'annotation_name' => 'vote',
			'limit' => false,
		));

		$users = array();

		// Cache the amount of results for each choice
		foreach ($responses as $response) {
			$users[] = $response->owner_guid;

			$this->responses_by_choice[$response->value] += 1;
		}

		$this->voter_count = count(array_unique($users));

		// Cache the total amount of responses
		$this->response_count = array_sum($this->responses_by_choice);
	}

	/**
	 * Get amount of responses for the given choice
	 *
	 * @param string $choice
	 * @return int Response count
	 */
	public function getResponseCountForChoice($choice) {
		// Make sure the values have been populated
		$this->fetchResponses();

		return $this->responses_by_choice[$choice];
	}

	/**
	 * Get total amount of responses
	 *
	 * @todo Save the total amount as poll metadata in the voting action
	 *
	 * @return int
	 */
	public function getResponseCount() {
		// Make sure the values have been populated
		$this->fetchResponses();

		return $this->response_count;
	}

	/**
	 * Get amount of people who have voted
	 *
	 * @return int
	 */
	public function getVoterCount() {
		// Make sure the values have been populated
		$this->fetchResponses();

		return $this->voter_count;
	}
}
