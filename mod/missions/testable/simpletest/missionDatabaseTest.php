<?php
class MissionDatabaseTest extends ElggCoreUnitTest {
	
	private $list_of_missions = array();
	
	function setUp() {
		$options['type'] = 'object';
		$options['subtype'] = 'mission';
		$options['limit'] = 0;
		$this->list_of_missions = elgg_get_entities_from_metadata($options);
	}
	
	function tearDown() {
		unset($this->list_of_missions);
	}
	
	public function testForEachMission() {
		$this->assertTrue((count($this->list_of_missions) > 0), elgg_echo('missions:diagnostic_suite:no_missions_in_db'));
		
		foreach($this->list_of_missions as $mission) {
			$this->testMissionNameMustNotBeEmpty($mission);
			
			$this->testMissionEmailMustBeValid($mission);
			
			$this->testMissionPhoneMustBeValid($mission);
			
			$this->testMissionJobTitleMustNotBeEmpty($mission);
			
			$this->testMissionJobTypeMustNotBeEmpty($mission);
			$this->testMissionJobTypeMustBeInList($mission);
			
			//$this->testMissionProgramAreaMustBeInList($mission);
			
			$this->testMissionNumberMustBeValid($mission);
			
			$this->testMissionStartMustBeValid($mission);
			$this->testMissionCompletionMustBeValid($mission);
			$this->testMissionDeadlineMustBeValid($mission);
			if(trim($mission->completion_date) != '') {
				$this->testMissionStartMustBeBeforeCompletionAndDeadline($mission);
			}
			
			$this->testMissionLocationMustNotBeEmpty($mission);
			$this->testMissionLocationMustBeInList($mission);
			
			$this->testMissionSecurityMustBeInList($mission);
			
			$this->testMissionTimeCommitmentMustBeValid($mission);
			$this->testMissionTimeIntervalMustBeInList($mission);
			
			$this->testMissionTimezoneMustBeInList($mission);
			if(mm_check_days_for_start_or_duration($mission)) {
				$this->testMissionTimezoneMustNotBeEmpty($mission);
			}
		}
	}
	
	private function testMissionNameMustNotBeEmpty($mission) {
		$this->assertTrue((trim($mission->name) != ''), elgg_echo('missions:diagnostic_suite:no_manager_name', array($mission->guid)));
	}
	
	private function testMissionDepartmentMustNotBeEmpty($mission) {
		$this->assertTrue((trim($mission->department) != ''), elgg_echo('missions:diagnostic_suite:no_department', array($mission->guid)));
	}
	
	private function testMissionEmailMustBeValid($mission) {
		$result = $this->assertTrue(filter_var($mission->email, FILTER_VALIDATE_EMAIL), 
				elgg_echo('missions:diagnostic_suite:invalid_email_format', array($mission->guid, $mission->email)));
		if($result) {
			$returned_users = get_user_by_email($mission->email);
			$this->assertTrue(count($returned_users), elgg_echo('missions:diagnostic_suite:no_account_has_email', array($mission->guid, $mission->email)));
		}
	}
	
	private function testMissionPhoneMustBeValid($mission) {
		if($mission->phone != '') {
			$result = $this->assertTrue(mm_is_valid_phone_number($mission->phone), 
					elgg_echo('missions:diagnostic_suite:invalid_phone_format', array($mission->guid, $mission->phone)));
		}
	}
	
	private function testMissionJobTitleMustNotBeEmpty($mission) {
		$this->assertTrue((trim($mission->job_title) != ''), elgg_echo('missions:diagnostic_suite:no_mission_title', array($mission->guid)));
	}
	
	private function testMissionJobTypeMustNotBeEmpty($mission) {
		$this->assertTrue((trim($mission->job_type) != ''), elgg_echo('missions:diagnostic_suite:no_mission_type', array($mission->guid)));
	}
	
	private function testMissionJobTypeMustBeInList($mission) {
		$list_array = explode(',', elgg_get_plugin_setting('opportunity_type_string', 'missions'));
		$this->assertTrue((array_search($mission->job_type, $list_array) !== false), 
				elgg_echo('missions:diagnostic_suite:job_type_not_in_list', array($mission->guid, $mission->job_type)));
	}
	
	/*private function testMissionProgramAreaMustBeInList($mission) {
		$list = elgg_get_plugin_setting('program_area_string', 'missions');
		$this->assertTrue(mm_get_translation_key_from_setting_string($mission->program_area, $list) != false,
				elgg_echo('missions:diagnostic_suite:program_area_not_in_list', array($mission->guid, $mission->program_area)));
	}*/
	
	private function testMissionNumberMustBeValid($mission) {
		$result = $this->assertTrue((trim($mission->number) != ''), elgg_echo('missions:diagnostic_suite:no_number', array($mission->guid)));
		if($result) {
			$this->assertTrue(($mission->number > 0), elgg_echo('missions:diagnostic_suite:number_less_than_one', array($mission->guid, $mission->number)));
		}
	}
	
	private function testMissionStartMustBeValid($mission) {
		$result = $this->assertTrue((trim($mission->start_date) != ''), elgg_echo('missions:diagnostic_suite:no_start_date', array($mission->guid)));
		if($result) {
			$this->assertTrue(mm_is_valid_date($mission->start_date), 
					elgg_echo('missions:diagnostic_suite:invalid_start_date', array($mission->guid, $mission->start_date)));
		}
	}
	
	private function testMissionCompletionMustBeValid($mission) {
		//$result = $this->assertTrue((trim($mission->completion_date) != ''), elgg_echo('missions:diagnostic_suite:no_completion_date', array($mission->guid)));
		if(trim($mission->completion_date) != '') {
			$this->assertTrue(mm_is_valid_date($mission->completion_date), 
					elgg_echo('missions:diagnostic_suite:invalid_completion_date', array($mission->guid, $mission->completion_date)));
		}
	}
	
	private function testMissionDeadlineMustBeValid($mission) {
		$result = $this->assertTrue((trim($mission->deadline) != ''), elgg_echo('missions:diagnostic_suite:no_deadline', array($mission->guid)));
		if($result) {
			$this->assertTrue(mm_is_valid_date($mission->deadline), elgg_echo('missions:diagnostic_suite:invalid_deadline', array($mission->guid, $mission->deadline)));
		}
	}
	
	private function testMissionStartMustBeBeforeCompletionAndDeadline($mission) {
		$this->assertTrue((strtotime($mission->start_date) <= strtotime($mission->completion_date)), 
				elgg_echo('missions:diagnostic_suite:start_after_completion', array($mission->guid, $mission->start_date, $mission->completion_date)));
		$this->assertTrue((strtotime($mission->deadline) <= strtotime($mission->completion_date)), 
				elgg_echo('missions:diagnostic_suite:deadline_after_completion', array($mission->guid, $mission->deadline, $mission->completion_date)));
	}
	
	private function testMissionLocationMustNotBeEmpty($mission) {
		$this->assertTrue((trim($mission->location) != ''), elgg_echo('missions:diagnostic_suite:no_location', array($mission->guid)));
	}
	
	private function testMissionLocationMustBeInList($mission) {
		$list_array = explode(',', elgg_get_plugin_setting('province_string', 'missions'));
		$this->assertTrue((array_search($mission->location, $list_array) !== false), 
				elgg_echo('missions:diagnostic_suite:location_not_in_list', array($mission->guid, $mission->location)));
	}
	
	private function testMissionSecurityMustBeInList($mission) {
		$list_array = explode(',', elgg_get_plugin_setting('security_string', 'missions'));
		$this->assertTrue((array_search($mission->security, $list_array) !== false || $mission->security === ''), 
				elgg_echo('missions:diagnostic_suite:security_not_in_list', array($mission->guid, $mission->security)));
	}
	
	private function testMissionTimeCommitmentMustBeValid($mission) {
		$result = $this->assertTrue((trim($mission->time_commitment) != ''), elgg_echo('missions:diagnostic_suite:no_time_commitment', array($mission->guid)));
		if($result) {
			$this->assertTrue(($mission->time_commitment < 100), 
					elgg_echo('missions:diagnostic_suite:time_commitment_greater', array($mission->guid, $mission->time_commitment)));
			$this->assertTrue(($mission->time_commitment > 0), 
					elgg_echo('missions:diagnostic_suite:time_commitment_negative_or_zero', array($mission->guid, $mission->time_commitment)));
		}
	}
	
	private function testMissionTimeIntervalMustBeInList($mission) {
		$list_array = explode(',', elgg_get_plugin_setting('time_rate_string', 'missions'));
		$this->assertTrue((array_search($mission->time_interval, $list_array) !== false), 
				elgg_echo('missions:diagnostic_suite:time_interval_not_in_list', array($mission->guid, $mission->time_interval)));
	}
	
	private function testMissionTimezoneMustBeInList($mission) {
		$list_array = explode(',', elgg_get_plugin_setting('timezone_string', 'missions'));
		$this->assertTrue((array_search($mission->timezone, $list_array) !== false || $mission->timezone === ''), 
				elgg_echo('missions:diagnostic_suite:timezone_not_in_list', array($mission->guid, $mission->timezone)));
	}
	
	private function testMissionTimezoneMustNotBeEmpty($mission) {
		$this->assertTrue((trim($mission->timezone) != ''), elgg_echo('missions:diagnostic_suite:no_timezone', array($mission->guid)));
	}
}