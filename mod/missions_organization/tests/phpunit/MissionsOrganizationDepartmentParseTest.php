<?php

include dirname(dirname(__DIR__)) . "/lib/missions-organization.php";

/**
 * tests parsing of department strings
 */
class MissionsOrganizationDepartmentParseTest extends \PHPUnit_Framework_TestCase {


	protected function setUp() {


	}

	public function testMockFunctions(){
		// mock functions stuff
		if ( !function_exists("elgg_get_entities_from_metadata") ){
			function elgg_get_entities_from_metadata(){
				global $mockDBoutput;

				return $mockDBoutput;
			}
		}
	}

	public function testParseEmptyString(){
		global $mockDBoutput;

		$department = "not a department";
		$mockDBoutput = array();
			

		$parsed_value = mo_get_department_next_to_root($department);


		$this->assertFalse( $parsed_value );

		return $parsed_value;
	}


	public function testParseSingleOrgFound(){
		global $mockDBoutput;
		$department = "Treasury Board of Canada Secretatiat";
			
		$mockDBoutput = $this->getMockBuilder(stdClass::class)
						->getMock();
		$mockDBoutput->guid = 123;

		$mockDBoutput = array($mockDBoutput);

		$parsed_value = mo_get_department_next_to_root($department);


		$this->assertEquals( 123, $parsed_value );

		return $parsed_value;
	}

}

