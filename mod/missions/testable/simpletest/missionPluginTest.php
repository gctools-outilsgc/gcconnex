<?php


/**
 * Mission Plugin Tests
 *
 * these tests are integrated into the system unit tests (see start.php)
 * the functions that are tested are in a library, which is registered and loaded (see start.php)
 *
 * these tests test that the plugin is installed and activated
 * these tests DO NOT access the database
 *
 * to run the tests integrated into the core tests:
 *    - Administration page | Develop | Tools | Unit Tests | (press Run)
 *			-- or --
 *    - http://127.0.0.1/gcconnex/engine/tests/suite.php
 *
 * to run independently of the core tests:
 *    - requires install and activate ufcoe_testable plugin from
 *     		git clone git@github.com:ufcoe/Elgg-ufcoe_testable.git ufcoe_testable
 *    - Administration page  | Develop | Plugin Tests | (click Micro Missions Run tests!)
 *			-- or --
 *	  - http://127.0.0.1/gcconnex/testable/run/missions
 */
class MissionPluginTest extends ElggCoreUnitTest {

	public function testMissionActionsMustBeRegistered() {
		//global $CONFIG;

		$this->assertTrue(array_key_exists('missions/post-mission-first-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/post-mission-second-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/post-mission-third-form', _elgg_services()->actions->getAllActions()));
		//$this->assertTrue(array_key_exists('missions/search-form', _elgg_services()->actions->getAllActions()));
		//$this->assertTrue(array_key_exists('missions/display-more', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/close-from-display', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/search-simple', _elgg_services()->actions->getAllActions()));
		//$this->assertTrue(array_key_exists('missions/search-prereq', _elgg_services()->actions->getAllActions()));
		//$this->assertTrue(array_key_exists('missions/search-language', _elgg_services()->actions->getAllActions()));
		//$this->assertTrue(array_key_exists('missions/search-time', _elgg_services()->actions->getAllActions()));
		//$this->assertTrue(array_key_exists('missions/browse-display', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/advanced-search-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/application-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/accept-invite', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/decline-invite', _elgg_services()->actions->getAllActions()));
		//$this->assertTrue(array_key_exists('missions/fill-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/invite-user', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/remove-applicant', _elgg_services()->actions->getAllActions()));
		//$this->assertTrue(array_key_exists('missions/search-switch', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/change-mission-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/remove-pending-invites', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/opt-from-main', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/cancel-mission', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/complete-mission', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/feedback-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/refine-my-missions-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/reopen-mission', _elgg_services()->actions->getAllActions()));

		$this->assertTrue(elgg_action_exists('missions/post-mission-first-form'));
		$this->assertTrue(elgg_action_exists('missions/post-mission-second-form'));
		$this->assertTrue(elgg_action_exists('missions/post-mission-third-form'));
		//$this->assertTrue(elgg_action_exists('missions/search-form'));
		//$this->assertTrue(elgg_action_exists('missions/display-more'));
		$this->assertTrue(elgg_action_exists('missions/close-from-display'));
		$this->assertTrue(elgg_action_exists('missions/search-simple'));
		//$this->assertTrue(elgg_action_exists('missions/search-prereq'));
		//$this->assertTrue(elgg_action_exists('missions/search-language'));
		//$this->assertTrue(elgg_action_exists('missions/search-time'));
		//$this->assertTrue(elgg_action_exists('missions/browse-display'));
		$this->assertTrue(elgg_action_exists('missions/advanced-search-form'));
		$this->assertTrue(elgg_action_exists('missions/application-form'));
		$this->assertTrue(elgg_action_exists('missions/accept-invite'));
		$this->assertTrue(elgg_action_exists('missions/decline-invite'));
		//$this->assertTrue(elgg_action_exists('missions/fill-form'));
		$this->assertTrue(elgg_action_exists('missions/invite-user'));
		$this->assertTrue(elgg_action_exists('missions/remove-applicant'));
		//$this->assertTrue(elgg_action_exists('missions/search-switch'));
		$this->assertTrue(elgg_action_exists('missions/change-mission-form'));
		$this->assertTrue(elgg_action_exists('missions/remove-pending-invites'));
		$this->assertTrue(elgg_action_exists('missions/opt-from-main'));
		$this->assertTrue(elgg_action_exists('missions/cancel-mission'));
		$this->assertTrue(elgg_action_exists('missions/complete-mission'));
		$this->assertTrue(elgg_action_exists('missions/feedback-form'));
		$this->assertTrue(elgg_action_exists('missions/refine-my-missions-form'));
		$this->assertTrue(elgg_action_exists('missions/reopen-mission'));
	}

	public function testMissionEntityMustBeRegistered() {
		$entities = get_registered_entity_types();
		$this->assertTrue(in_array("mission", $entities['object']));
	}

	public function testMissionViewtypesMustBeRegistered() {
		$this->assertTrue(elgg_view_exists('missions/element-select'));
	}

	/*public function testMissionMenuMustBeRegistered() {
		$this->assertTrue(elgg_is_menu_item_registered('user_menu', 'mission_main'));
	}*/

	/*public function testMissionPageHandlerMustBeRegistered() {
		//global $CONFIG;
		$expected = 'missions_main_page_handler';
		$actual = _elgg_services()->hooks->hasHandler('pagehandler', $expected);
		$this->assertTrue($actual);
	}*/

	public function testLanguageStringsMustBeLoaded_En() {
		$expected = " ,A,B,C";
		$actual = elgg_get_plugin_setting('language_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testDayStringsMustBeLoaded_En() {
		$expected = "Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday";
		$actual = elgg_get_plugin_setting('day_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testHourStringsMustBeLoaded() {
		$expected = " ,00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23";
		$actual = elgg_get_plugin_setting('hour_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testMinuteStringsMustBeLoaded() {
		$expected = " ,00,15,30,45";
		$actual = elgg_get_plugin_setting('minute_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testSecurityStringsMustBeLoaded_En() {
		$expected = " ,Enhanced reliability,Secret,Top Secret";
		$actual = elgg_get_plugin_setting('security_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testTimezoneStringsMustBeLoaded_En() {
		$expected = "Canada/Pacific (-8),Canada/Mountain (-7),Canada/Central (-6),Canada/Eastern (-5),Canada/Atlantic (-4),Canada/Newfoundland (-3.5)";
		$actual = elgg_get_plugin_setting('timezone_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}
}