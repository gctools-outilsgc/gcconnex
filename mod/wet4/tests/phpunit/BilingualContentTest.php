<?php

include dirname(dirname(__DIR__)) . "/lib/translate_display.php";

/**
 * 
 */
class BilingualContentTest extends \PHPUnit_Framework_TestCase {

	function setUp() {
    }

    function tearDown() {
    }

// Should save "" to both
    function testCreateEmptyContent() {
    	$content = gc_implode_translation( "", "" );

    	$json = json_decode( $content );
    	$this->assertSame( "", $json->en );							// check english
    	$this->assertSame( "", $json->fr );							// check french

    	return $content;
    }

    /**
     * @depends testCreateEmptyContent
     */
    function testReadEmptyContent( $content ) {
    	$en = gc_explode_translation( $content, 'en');
    	$fr = gc_explode_translation( $content, 'fr');

    	$this->assertSame( "", $en );								// check english
    	$this->assertSame( "", $fr );								// check french
    }

    // Should save 
    function testCreateEnglishOnlyContent() {
    	$content = gc_implode_translation( "English Content", "" );

    	$json = json_decode( $content );
    	$this->assertSame( "English Content", $json->en );			// check english
    	$this->assertSame( "", $json->fr );							// check french

    	return $content;
    }

    /**
     * @depends testCreateEnglishOnlyContent
     */
    function testReadEnglishOnlyContent( $content ) {
    	$en = gc_explode_translation( $content, 'en');
    	$fr = gc_explode_translation( $content, 'fr');

    	$this->assertSame( "English Content", $en );				// check english
    	$this->assertSame( "", $fr );								// check french
    }


    // Should save 
    function testCreateFrenchOnlyContent() {
    	$content = gc_implode_translation( "", "Français Content" );

    	$json = json_decode( $content );
    	$this->assertSame( "", $json->en );							// check english
    	$this->assertSame( "Français Content", $json->fr );			// check french

    	return $content;
    }

    /**
     * @depends testCreateFrenchOnlyContent
     */
    function testReadFrenchOnlyContent( $content ) {
    	$en = gc_explode_translation( $content, 'en');
    	$fr = gc_explode_translation( $content, 'fr');

    	$this->assertSame( "", $en );								// check english
    	$this->assertSame( "Français Content", $fr );				// check french
    }

    // Should save 
    function testCreateBilingualContent() {
    	$content = gc_implode_translation( "English Content", "Français Content" );

    	$json = json_decode( $content );
    	$this->assertSame( "English Content", $json->en );			// check english
    	$this->assertSame( "Français Content", $json->fr );			// check french

    	return $content;
    }

    /**
     * @depends testCreateBilingualContent
     */
    function testReadBilingualContent( $content ) {
    	$en = gc_explode_translation( $content, 'en');
    	$fr = gc_explode_translation( $content, 'fr');

    	$this->assertSame( $en, "English Content" );				// check english
    	$this->assertSame( $fr, "Français Content" );				// check french
    }
}
?>