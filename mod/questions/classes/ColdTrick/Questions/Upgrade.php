<?php

namespace ColdTrick\Questions;

class Upgrade {
	
	/**
	 * Make sure all questions have a status
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied object
	 *
	 * @return void
	 */
	public static function setStatusOnQuestions($event, $type, $object) {
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
		$path = 'admin/upgrades/set_question_status';
		$upgrade = new \ElggUpgrade();
		if (!$upgrade->getUpgradeFromPath($path)) {
			$upgrade->setPath($path);
			$upgrade->title = elgg_echo('admin:upgrades:set_question_status');
			$upgrade->description = elgg_echo('admin:upgrades:set_question_status:description');
				
			$upgrade->save();
		}
		
		// restore access
		elgg_set_ignore_access($ia);
	}
}
