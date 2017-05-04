<?php

class ElggQuestion extends ElggObject {
	
	const SUBTYPE = 'question';
	
	/**
	 * (non-PHPdoc)
	 * @see ElggObject::initializeAttributes()
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ElggEntity::getURL()
	 */
	public function getURL() {
		$url = "questions/view/{$this->getGUID()}/" . elgg_get_friendly_title($this->title);
		
		return elgg_normalize_url($url);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ElggObject::canComment()
	 */
	public function canComment($user_guid = 0) {
		
		if ($this->comments_enabled === 'off') {
			return false;
		}
		
		return parent::canComment($user_guid);
	}
	
	/**
	 * Get the answers on this question
	 *
	 * @param array $options accepts all elgg_get_entities options
	 *
	 * @return false|int|ElggAnswer[]
	 */
	public function getAnswers(array $options = array()) {
		$defaults = [
			'order_by' => 'time_created asc',
		];
		
		$overrides = [
			'type' => 'object',
			'subtype' => 'answer',
			'container_guid' => $this->getGUID(),
		];
		
		$options = array_merge($defaults, $options, $overrides);
		
		return elgg_get_entities($options);
	}
	
	/**
	 * List the answers on this question
	 *
	 * @param array $options accepts all elgg_list_entities options
	 *
	 * @return string
	 */
	public function listAnswers(array $options = []) {
		return elgg_list_entities($options, [$this, 'getAnswers']);
	}
	
	/**
	 * Get the answer that was marked as the correct answer.
	 *
	 * @return fasle|ElggAnswer
	 */
	public function getMarkedAnswer() {
		$result = false;
		
		$options = [
			'type' => 'object',
			'subtype' => ElggAnswer::SUBTYPE,
			'limit' => 1,
			'container_guid' => $this->getGUID(),
			'metadata_name_value_pairs' => array(
				'name' => 'correct_answer',
				'value' => true
			)
		];
		
		$answers = elgg_get_entities_from_metadata($options);
		if (!empty($answers)) {
			$result = $answers[0];
		}
		
		return $result;
	}
	
	/**
	 * Helper function to close a question from further answers.
	 *
	 * @return void
	 */
	public function close() {
		$this->status = 'closed';
	}
	
	/**
	 * Reopen the question for more answers.
	 *
	 * @return void
	 */
	public function reopen() {
		$this->status = 'open';
	}
	
	/**
	 * Get the current status of the question.
	 *
	 * This can be
	 * - 'open'
	 * - 'closed'
	 *
	 * @return string the current status
	 */
	public function getStatus() {
		$result = 'open';
		
		// do we even support status
		if (questions_close_on_marked_answer()) {
			// make sure the status is correct
			switch ($this->status) {
				case 'open':
					// is it still open, so no marked answer
					if ($this->getMarkedAnswer()) {
						$result = 'closed';
					}
					break;
				case 'closed':
					$result = 'closed';
					// is it still open, so no marked answer
					if (!$this->getMarkedAnswer()) {
						$result = 'open';
					}
					break;
				default:
					// no setting yet
					if ($this->getMarkedAnswer()) {
						$result = 'closed';
					}
					break;
			}
		}
		
		return $result;
	}
}
