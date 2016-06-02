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
		$this->assertTrue(array_key_exists('missions/delete-mission', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/search-simple', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/advanced-search-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/application-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/accept-invite', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/decline-invite', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/invite-user', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/remove-applicant', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/change-mission-form', _elgg_services()->actions->getAllActions()));
		//$this->assertTrue(array_key_exists('missions/remove-pending-invites', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/opt-from-main', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/cancel-mission', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/complete-mission', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/feedback-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/refine-my-missions-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/reopen-mission', _elgg_services()->actions->getAllActions()));
		
		$this->assertTrue(array_key_exists('missions/admin-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/change-entities-per-page', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/duplicate-mission', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/endorse-user', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/graph-data-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/graph-interval-form', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/mission-invite-selector', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/mission-offer', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/post-mission-skill-match', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/pre-create-opportunity', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/remove-department-from-graph', _elgg_services()->actions->getAllActions()));
		$this->assertTrue(array_key_exists('missions/wire-post', _elgg_services()->actions->getAllActions()));

		$this->assertTrue(elgg_action_exists('missions/post-mission-first-form'));
		$this->assertTrue(elgg_action_exists('missions/post-mission-second-form'));
		$this->assertTrue(elgg_action_exists('missions/post-mission-third-form'));
		$this->assertTrue(elgg_action_exists('missions/delete-mission'));
		$this->assertTrue(elgg_action_exists('missions/search-simple'));
		$this->assertTrue(elgg_action_exists('missions/advanced-search-form'));
		$this->assertTrue(elgg_action_exists('missions/application-form'));
		$this->assertTrue(elgg_action_exists('missions/accept-invite'));
		$this->assertTrue(elgg_action_exists('missions/decline-invite'));
		$this->assertTrue(elgg_action_exists('missions/invite-user'));
		$this->assertTrue(elgg_action_exists('missions/remove-applicant'));
		$this->assertTrue(elgg_action_exists('missions/change-mission-form'));
		//$this->assertTrue(elgg_action_exists('missions/remove-pending-invites'));
		$this->assertTrue(elgg_action_exists('missions/opt-from-main'));
		$this->assertTrue(elgg_action_exists('missions/cancel-mission'));
		$this->assertTrue(elgg_action_exists('missions/complete-mission'));
		$this->assertTrue(elgg_action_exists('missions/feedback-form'));
		$this->assertTrue(elgg_action_exists('missions/refine-my-missions-form'));
		$this->assertTrue(elgg_action_exists('missions/reopen-mission'));
		
		$this->assertTrue(elgg_action_exists('missions/admin-form'));
		$this->assertTrue(elgg_action_exists('missions/change-entities-per-page'));
		$this->assertTrue(elgg_action_exists('missions/duplicate-mission'));
		$this->assertTrue(elgg_action_exists('missions/endorse-user'));
		$this->assertTrue(elgg_action_exists('missions/graph-data-form'));
		$this->assertTrue(elgg_action_exists('missions/graph-interval-form'));
		$this->assertTrue(elgg_action_exists('missions/mission-invite-selector'));
		$this->assertTrue(elgg_action_exists('missions/mission-offer'));
		$this->assertTrue(elgg_action_exists('missions/post-mission-skill-match'));
		$this->assertTrue(elgg_action_exists('missions/pre-create-opportunity'));
		$this->assertTrue(elgg_action_exists('missions/remove-department-from-graph'));
		$this->assertTrue(elgg_action_exists('missions/wire-post'));
	}

	public function testMissionEntityMustBeRegistered() {
		$entities = get_registered_entity_types();
		$this->assertTrue(in_array("mission", $entities['object']));
		$this->assertTrue(in_array("mission-feedback", $entities['object']));
	}

	public function testMissionViewtypesMustBeRegistered() {
		$this->assertTrue(elgg_view_exists('missions/element-select'));
		$this->assertTrue(elgg_view_exists('missions/add-skill'));
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
		$expected = ",A,B,C";
		$actual = elgg_get_plugin_setting('language_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testDayStringsMustBeLoaded_En() {
		$expected = 'missions:mon,missions:tue,missions:wed,missions:thu,missions:fri,missions:sat,missions:sun';
		$actual = elgg_get_plugin_setting('day_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testHourStringsMustBeLoaded() {
		$expected = ",00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23";
		$actual = elgg_get_plugin_setting('hour_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testMinuteStringsMustBeLoaded() {
		$expected = ",00,15,30,45";
		$actual = elgg_get_plugin_setting('minute_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testSecurityStringsMustBeLoaded() {
		$expected = ",missions:reliability,missions:enhanced_reliability,missions:secret,missions:top_secret";
		$actual = elgg_get_plugin_setting('security_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testTimezoneStringsMustBeLoaded_En() {
		$expected = ",missions:timezone:three_half,missions:timezone:four,missions:timezone:five,missions:timezone:six,missions:timezone:seven,missions:timezone:eight,missions:timezone:nine";
		$actual = elgg_get_plugin_setting('timezone_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testTimeRateStringsMustBeLoaded() {
		$expected = "missions:total,missions:per_day,missions:per_week,missions:per_month";
		$actual = elgg_get_plugin_setting('time_rate_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testOpportunityTypeStringsMustBeLoaded_En() {
		$expected = "missions:micro_mission,missions:job_swap,missions:mentoring,missions:shadowing,missions:peer_coaching,missions:skill_sharing,missions:job_sharing";
		$actual = elgg_get_plugin_setting('opportunity_type_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testProvinceStringsMustBeLoaded_En() {
		$expected = "missions:alberta,missions:british_columbia,missions:manitoba,missions:new_brunswick,missions:newfoundland_and_labrador,missions:northwest_territories,missions:nova_scotia,missions:nunavut,missions:ontario,missions:prince_edward_island,missions:quebec,missions:saskatchewan,missions:yukon,missions:national_capital_region";
		$actual = elgg_get_plugin_setting('province_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testProgramAreaStringsMustBeLoaded_En() {
		$expected = ",missions:science,missions:information_technology,missions:administration,missions:human_resources,missions:finance,missions:legal_regulatory,missions:security_enforcement,missions:communications,missions:policy,missions:client_service";
		$actual = elgg_get_plugin_setting('program_area_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}

	public function testDeclineReasonStringsMustBeLoaded_En() {
		$expected = ",missions:decline:workload,missions:decline:interest,missions:decline:engagement,missions:decline:approval,missions:other";
		$actual = elgg_get_plugin_setting('decline_reason_string', 'missions');
		$this->assertIdentical($expected, $actual);
	}
}