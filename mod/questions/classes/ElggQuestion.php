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
		
		$this->status = 'open';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ElggEntity::getURL()
	 */
	public function getURL() {
		$url = "questions/view/{$this->getGUID()}/" . elgg_get_friendly_title($this->getDisplayName());
		
		return elgg_normalize_url($url);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ElggObject::canComment()
	 */
	public function canComment($user_guid = 0, $default = null) {
		
		if ($this->comments_enabled === 'off') {
			return false;
		}
		
		return parent::canComment($user_guid, $default);
	}
	
	/**
	 * Get the answers on this question
	 *
	 * @param array $options accepts all elgg_get_entities options
	 *
	 * @return false|int|ElggAnswer[]
	 */
	public function getAnswers(array $options = []) {
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
	 * @return false|ElggAnswer
	 */
	public function getMarkedAnswer() {
		$result = false;
		
		$options = [
			'type' => 'object',
			'subtype' => ElggAnswer::SUBTYPE,
			'limit' => 1,
			'container_guid' => $this->getGUID(),
			'metadata_name_value_pairs' => [
				'name' => 'correct_answer',
				'value' => true,
			],
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
		$result = $this->status;
		
		// should we check if the status is correct
		if (!questions_close_on_marked_answer()) {
			return $result;
		}
		
		// make sure the status is correct
		switch ($result) {
			case 'open':
				// is it still open, so no marked answer
				if ($this->getMarkedAnswer()) {
					$result = 'closed';
				}
				break;
		}
		
		return $result;
	}
}
