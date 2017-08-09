<?php

class GroupMail extends ElggObject {
	
	const SUBTYPE = 'group_tools_group_mail';
	
	/**
	 * (non-PHPdoc)
	 * @see ElggObject::initializeAttributes()
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['access_id'] = ACCESS_PUBLIC;
	}
	
	/**
	 * Get the mail subject
	 *
	 * @return string
	 */
	public function getSubject() {
		return $this->title;
	}
	
	/**
	 * Get the mail message
	 *
	 * @return string
	 */
	public function getMessage() {
		
		$group = $this->getContainerEntity();
		
		$message = $this->description;
		$message .= PHP_EOL . PHP_EOL;
		$message .= elgg_echo('group_tools:mail:message:from');
		$message .= ": {$group->name}" . PHP_EOL;
		$message .= $group->getURL();
		
		return $message;
	}
	
	/**
	 * Save the recipients for this message
	 *
	 * @param array $recipients GUID array of group members to receive this message
	 *
	 * @return void
	 */
	public function setRecipients($recipients) {
		$this->recipients = $recipients;
	}
	
	/**
	 * Get the recipients for this message in the form [guid => ['email']]
	 *
	 * @return false|array
	 */
	public function getRecipients() {
		
		if (empty($this->recipients)) {
			return false;
		}
		
		$recipients = (array) $this->recipients;
		$batch = new ElggBatch('elgg_get_entities_from_relationship', [
			'type' => 'user',
			'limit' => false,
			'guids' => $recipients,
			'relationship' => 'member',
			'relationship_guid' => $this->getContainerGUID(),
			'inverse_relationship' => true,
		]);
		
		$formatted_recipients = [];
		/* @var $user \ElggUser */
		foreach ($batch as $user) {
			$formatted_recipients[$user->getGUID()] = ['email'];
		}
		
		return $formatted_recipients;
	}
	
	/**
	 * Enqueue the mail for delivery
	 *
	 * @return bool
	 */
	public function enqueue() {
		
		if (!$this->save()) {
			return false;
		}
		
		elgg_trigger_event('enqueue', 'object', $this);
		
		return true;
	}
}
