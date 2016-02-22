<?php


/**
 * Mission Library Tests
 *
 * these tests are integrated into the system unit tests (see start.php)
 * the functions that are tested are in a library, which is registered and loaded (see start.php)
 *
 * these tests only test library functions that DO NOT access the database
 *
 * to run the tests integrated into the core tests:
 *    - Administration page | Develop | Tools | Unit Tests | (press Run)
 *			-- or --
 *    - [GCconnex base URL]/engine/tests/suite.php
 *
 * to run independently of the core tests:
 *    - requires install and activate ufcoe_testable plugin from
 *     		git clone git@github.com:ufcoe/Elgg-ufcoe_testable.git ufcoe_testable
 *    - Administration page  | Develop | Plugin Tests | (click Micro Missions Run tests!)
 *			-- or --
 *	  - [GCconnex base URL]/testable/run/missions
 */
class MissionLibraryTest extends ElggCoreUnitTest {

	private $session_language = null;

	function setUp() {
		$this->session_language = $_SESSION['language'];
    }

    function tearDown() {
        $_SESSION['language'] = $this->session_language;
		$this->session_language = null;
    }

    public function testIsValidPhoneNumber() {
     	$this->assertTrue(mm_is_valid_phone_number('5555555555'));
     	$this->assertTrue(mm_is_valid_phone_number('555-555-5555'));
     	$this->assertTrue(mm_is_valid_phone_number('555 555 5555'));
     	$this->assertTrue(mm_is_valid_phone_number('1(555) 555-5555'));
     	$this->assertTrue(mm_is_valid_phone_number('1 (555) 555-5555'));
     	$this->assertTrue(mm_is_valid_phone_number('1-555-555-5555'));

     	$this->assertFalse(mm_is_valid_phone_number('5'));
     	$this->assertFalse(mm_is_valid_phone_number('555-5555'));
     	//$this->assertFalse(mm_is_valid_phone_number('1-(555)-555-5555'));
     	$this->assertFalse(mm_is_valid_phone_number('(555) PA8-7572'));
    }

    public function testIsValidPersonName() {
     	$this->assertTrue(mm_is_valid_person_name('Eileen'));
     	$this->assertTrue(mm_is_valid_person_name('Eileen Williamson'));

     	$this->assertTrue(mm_is_valid_person_name('%$@#%$#&/:'.']}'));

     	$this->assertFalse(mm_is_valid_person_name('4Wesley'));
     	$this->assertFalse(mm_is_valid_person_name('Wes7ley'));
     	$this->assertFalse(mm_is_valid_person_name('Wesley9'));
    }

    public function testIsValidGuidNumber() {
     	$this->assertTrue(mm_is_guid_number('5'));
     	$this->assertTrue(mm_is_guid_number('673445'));

     	$this->assertFalse(mm_is_guid_number('1.0'));
     	$this->assertFalse(mm_is_guid_number('-2'));
     	$this->assertFalse(mm_is_guid_number('1.314E-7'));
     	$this->assertFalse(mm_is_guid_number('532K351'));
     	$this->assertFalse(mm_is_guid_number('@578532)'));
     	$this->assertFalse(mm_is_guid_number('578(532)'));
    }

	public function testPackLanguage() {
		//valid inputs

		$this->assertIdentical('englishABC', mm_pack_language('A', 'B', 'C', 'English'));
		$this->assertIdentical('english---', mm_pack_language('-', '-', '-', 'English'));
		$this->assertIdentical('english---', mm_pack_language('', '', '', 'English'));

		$this->assertIdentical('frenchABC', mm_pack_language('A', 'B', 'C', 'French'));
		$this->assertIdentical('french---', mm_pack_language('-', '-', '-', 'French'));
		$this->assertIdentical('french---', mm_pack_language('', '', '', 'French'));

		//invalid inputs

		$this->assertIdentical('englishDEF', mm_pack_language('D', 'E', 'F', 'English'));
		$this->assertIdentical('french789', mm_pack_language('7', '8', '9', 'French'));
		$this->assertIdentical('nosuchlanguage---', mm_pack_language('', '', '', 'nosuchlanguage'));
		$this->assertIdentical('---', mm_pack_language('', '', '', ''));
		$this->assertIdentical('---', mm_pack_language(NULL, NULL, NULL, NULL));
	}

	public function testUnpackLanguage() {
		//valid inputs

		$actual = mm_unpack_language('englishABC', 'English');
		$expected = array(
    		'lwc_english' => 'A',
    		'lwe_english' => 'B',
    		'lop_english' => 'C'
		);
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_language('english---', 'English');
		$expected = array(
    		'lwc_english' => '',
    		'lwe_english' => '',
    		'lop_english' => ''
		);
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_language('frenchABC', 'French');
		$expected = array(
    		'lwc_french' => 'A',
    		'lwe_french' => 'B',
    		'lop_french' => 'C'
		);
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_language('french---', 'French');
		$expected = array(
    		'lwc_french' => '',
    		'lwe_french' => '',
    		'lop_french' => ''
		);
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_language('---', '');
		$expected = array(
    		'lwc_' => '',
    		'lwe_' => '',
    		'lop_' => ''
		);
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_language('CBA', '');
		$expected = array(
    		'lwc_' => 'C',
    		'lwe_' => 'B',
    		'lop_' => 'A'
		);
		$this->assertIdentical($expected, $actual);


		//invalid inputs

		$actual = mm_unpack_language('englishABC', 'Thisisnotalanguage');
		$expected = array(
			'lwc_thisisnotalanguage' => false,
			'lwe_thisisnotalanguage' => false,
			'lop_thisisnotalanguage' => false
		);
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_language('ABC', 'Thisisnotalanguage');
		$expected = array(
			'lwc_thisisnotalanguage' => false,
			'lwe_thisisnotalanguage' => false,
			'lop_thisisnotalanguage' => false
		);
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_language('', 'English');
		$expected = array(
			'lwc_english' => false,
			'lwe_english' => false,
			'lop_english' => false
		);
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_language(NULL, 'English');
		$expected = array(
			'lwc_english' => false,
			'lwe_english' => false,
			'lop_english' => false
		);
		$this->assertIdentical($expected, $actual);


		$actual = mm_unpack_language(NULL, NULL);
		$expected = array(
			'lwc_' => false,
			'lwe_' => false,
			'lop_' => false
		);
		$this->assertIdentical($expected, $actual);

	}

	public function testPackTime() {
		//valid inputs

		$this->assertIdentical('mon_start0859', mm_pack_time('08', '59', 'mon_start'));
		$this->assertIdentical('tue_start', mm_pack_time('', '', 'tue_start'));
		$this->assertIdentical('wed_end6667', mm_pack_time('66', '67', 'wed_end'));
		$this->assertIdentical('thu_start--', mm_pack_time('-', '-', 'thu_start'));
		$this->assertIdentical('fri_end-55', mm_pack_time('-', '55', 'fri_end'));
		$this->assertIdentical('sat_start12-', mm_pack_time('12', '-', 'sat_start'));

		//invalid inputs

		$this->assertIdentical('Nosuchday0055', mm_pack_time('00', '55', 'Nosuchday'));
		$this->assertIdentical('0055', mm_pack_time('00', '55', ''));
		$this->assertIdentical('', mm_pack_time('', '', ''));
		$this->assertIdentical('', mm_pack_time(NULL, NULL, NULL));

	}

	public function testUnpackTime() {
		//valid inputs

		$actual = mm_unpack_time('mon_start0859', 'mon_start');
		$expected = array(
    		'mon_start_hour' => '08',
    		'mon_start_min' => '59',
		);
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_time('mon_end0910', 'mon_end');
		$expected = array(
    		'mon_end_hour' => '09',
    		'mon_end_min' => '10',
		);
		$this->assertIdentical($expected, $actual);



		//invalid inputs

		$actual = mm_unpack_time('tuesday6789', 'nonsenseday');
		$expected = array(
    		'nonsenseday_hour' => false,
    		'nonsenseday_min' => false,
		);
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_time('1234', '');
		$expected = array(
    		'_hour' => '12',
    		'_min' => '34',
		);
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_time('1234', NULL);
		$expected = array(
    		'_hour' => '12',
    		'_min' => '34',
		);
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_time(NULL, 'mon_start');
		$expected = array();
		$this->assertIdentical($expected, $actual);

		$actual = mm_unpack_time(NULL, NULL);
		$expected = array();
		$this->assertIdentical($expected, $actual);
	}

}


