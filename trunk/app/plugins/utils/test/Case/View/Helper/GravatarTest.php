<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::import("Helper", array( "Html", "Utils.Gravatar" ));
App::uses("View", "View");
App::uses("String", "Utility");
App::uses("Security", "Utility");
App::uses("Validation", "Utility");

/**
 * GravatarHelper Test
 *
 * @package goodies
 * @subpackage goodies.test.cases.views.helpers
 */

class GravatarHelperTest extends CakeTestCase
{
    public $Gravatar = null;

    public function setUp()
    {
        $null = null;
        $this->View = new View($null);
        $this->Gravatar = new GravatarHelper($this->View);
        $this->Gravatar->Html = new HtmlHelper($this->View);
    }

    public function tearDown()
    {
        unset($this->Gravatar);
    }

    public function testBaseUrlGeneration()
    {
        $expected = "http://www.gravatar.com/avatar/" . Security::hash("example@gravatar.com", "md5");
        $result = $this->Gravatar->url("example@gravatar.com", array( "ext" => false, "default" => "wavatar" ));
        list($url, $params) = explode("?", $result);
        $this->assertEqual($expected, $url);
    }

    public function testExtensions()
    {
        $result = $this->Gravatar->url("example@gravatar.com", array( "ext" => true, "default" => "wavatar" ));
        $this->assertPattern("/\\.jpg(?:\$|\\?)/", $result);
    }

    public function testRating()
    {
        $result = $this->Gravatar->url("example@gravatar.com", array( "ext" => true, "default" => "wavatar" ));
        $this->assertPattern("/\\.jpg(?:\$|\\?)/", $result);
    }

    public function testAlternateDefaultIcon()
    {
        $result = $this->Gravatar->url("example@gravatar.com", array( "ext" => false, "default" => "wavatar" ));
        list($url, $params) = explode("?", $result);
        $this->assertPattern("/default=wavatar/", $params);
    }

    public function testAlternateDefaultIconCorrection()
    {
        $result = $this->Gravatar->url("example@gravatar.com", array( "ext" => false, "default" => "12345" ));
        $this->assertPattern("/[^\\?]+/", $result);
    }

    public function testSize()
    {
        $result = $this->Gravatar->url("example@gravatar.com", array( "size" => "120" ));
        list($url, $params) = explode("?", $result);
        $this->assertPattern("/size=120/", $params);
    }

    public function testImageTag()
    {
        $expected = "<img src=\"http://www.gravatar.com/avatar/" . Security::hash("example@gravatar.com", "md5") . "\" alt=\"\" />";
        $result = $this->Gravatar->image("example@gravatar.com", array( "ext" => false ));
        $this->assertEqual($expected, $result);
        $expected = "<img src=\"http://www.gravatar.com/avatar/" . Security::hash("example@gravatar.com", "md5") . "\" alt=\"Gravatar\" />";
        $result = $this->Gravatar->image("example@gravatar.com", array( "ext" => false, "alt" => "Gravatar" ));
        $this->assertEqual($expected, $result);
    }

    public function testDefaulting()
    {
        $result = $this->Gravatar->url("example@gravatar.com", array( "default" => "wavatar", "size" => "default" ));
        list($url, $params) = explode("?", $result);
        $this->assertEqual($params, "default=wavatar");
    }

    public function testNonSecureUrl()
    {
        $_SERVER["HTTPS"] = false;
        $expected = "http://www.gravatar.com/avatar/" . Security::hash("example@gravatar.com", "md5");
        $result = $this->Gravatar->url("example@gravatar.com", array( "ext" => false ));
        $this->assertEqual($expected, $result);
        $expected = "http://www.gravatar.com/avatar/" . Security::hash("example@gravatar.com", "md5");
        $result = $this->Gravatar->url("example@gravatar.com", array( "ext" => false, "secure" => false ));
        $this->assertEqual($expected, $result);
        $_SERVER["HTTPS"] = true;
        $expected = "http://www.gravatar.com/avatar/" . Security::hash("example@gravatar.com", "md5");
        $result = $this->Gravatar->url("example@gravatar.com", array( "ext" => false, "secure" => false ));
        $this->assertEqual($expected, $result);
    }

    public function testSecureUrl()
    {
        $expected = "https://secure.gravatar.com/avatar/" . Security::hash("example@gravatar.com", "md5");
        $result = $this->Gravatar->url("example@gravatar.com", array( "ext" => false, "secure" => true ));
        $this->assertEqual($expected, $result);
        $_SERVER["HTTPS"] = true;
        $expected = "http://www.gravatar.com/avatar/" . Security::hash("example@gravatar.com", "md5");
        $result = $this->Gravatar->url("example@gravatar.com", array( "ext" => false ));
        $this->assertEqual($expected, $result);
        $expected = "https://secure.gravatar.com/avatar/" . Security::hash("example@gravatar.com", "md5");
        $result = $this->Gravatar->url("example@gravatar.com", array( "ext" => false, "secure" => true ));
        $this->assertEqual($expected, $result);
    }

}




?>