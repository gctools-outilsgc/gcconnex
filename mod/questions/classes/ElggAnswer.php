<?php

class ElggAnswer extends ElggObject {
	
	const SUBTYPE = 'answer';
	
	/**
	 * (non-PHPdoc)
	 * @see ElggObject::initializeAttributes()
	 */
	function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ElggEntity::getURL()
	 */
	public function getURL() {
		// make sure we can get the container
		$ia = elgg_set_ignore_access(true);
		
		// get the container/question
		$container_entity = $this->getContainerEntity();
		
		$url = $container_entity->getURL() . "#elgg-object-{$this->getGUID()}";
		
		// restore access
		elgg_set_ignore_access($ia);
		
		return $url;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ElggObject::canComment()
	 */
	public function canComment($user_guid = 0) {
		
		return $this->getContainerEntity()->canComment($user_guid);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ElggEntity::__get()
	 */
	public function __get($name) {
		
		if ($name === 'title') {
			$question = $this->getContainerEntity();
			
			return elgg_echo('questions:object:answer:title', [$question->title]);
		}
		
		return parent::__get($name);
	}
	
	/**
	 * Get the metadata object for the correct answer
	 *
	 * @return false|ElggMetadata
	 */
	public function getCorrectAnswerMetadata() {
		$result = false;
		
		$options = [
			'metadata_name' => 'correct_answer',
			'guid' => $this->getGUID(),
		];
		
		$metadata = elgg_get_metadata($options);
		if ($metadata) {
			$result = $metadata[0];
		}
		
		return $result;
	}
	
	/**
	 * Mark an answer as the correct answer for this question
	 *
	 * @return void
	 */
	public function markAsCorrect() {
		// first set the mark
		$this->correct_answer = true;
		
		// trigger event for notifications
		elgg_trigger_event('correct', 'object', $this);
		
		// depending of the plugin settings, we also need to close the question
		if (questions_close_on_marked_answer()) {
			$question = $this->getContainerEntity();
			
			$question->close();
		}
	}
	
	/**
	 * This answer is no longer the correct answer for this question
	 *
	 * @return void
	 */
	public function undoMarkAsCorrect() {
		unset($this->correct_answer);
		
		// don't forget to reopen the question
		$question = $this->getContainerEntity();
			
		$question->reopen();
	}
	
	/**
	 * Check if we can auto mark this as the correct answer
	 *
	 * @param bool $creating new answer or editing (default: editing)
	 *
	 * @return void
	 */
	public function checkAutoMarkCorrect($creating = false) {
		
		$creating = (bool) $creating;
		if (empty($creating)) {
			// only on new entities
			return;
		}
		
		$question = $this->getContainerEntity();
		$container = $question->getContainerEntity();
		
		$user = $this->getOwnerEntity();
		
		if (questions_auto_mark_answer_correct($container, $user)) {
			$this->markAsCorrect();
		}
	}
}
