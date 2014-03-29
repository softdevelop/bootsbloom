<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::import("Behavior", "Utils.Toggleable");

/**
 * Post Test Model
 */

class Post extends CakeTestModel
{
    public $useTable = "posts";
    public $alias = "Post";

}


/**
 * Toggleable Test case
 */

class ToggleableTest extends CakeTestCase
{
    public $fixtures = array( "plugin.utils.post" );

    public function setUp()
    {
        $this->Post = new Post();
    }

    public function tearDown()
    {
        unset($this->Post);
        unset($this->Behavior);
        ClassRegistry::flush();
    }

    public function testToggle()
    {
        $this->Post->Behaviors->load("Utils.Toggleable", array( "fields" => array( "deleted" => array( 1, 0 ) ) ));
        $this->assertEqual($this->Post->toggle(1, "deleted"), 1);
        $this->assertEqual($this->Post->field("deleted"), true);
        $this->assertEqual($this->Post->toggle(1, "deleted"), 0);
        $this->assertEqual($this->Post->field("deleted"), false);
    }

    public function testInvalidFieldException()
    {
        $this->Post->Behaviors->load("Utils.Toggleable", array( "fields" => array( "other_field" => array( 1, 0 ) ) ));
        $this->expectException("InvalidArgumentException");
        $this->Post->toggle(1, "deleted");
    }

    public function testInvalidFieldStates()
    {
        $this->Post->Behaviors->load("Utils.Toggleable", array( "fields" => array( "deleted" => array( 1 ) ) ));
        $this->expectException("InvalidArgumentException");
        $this->Post->toggle(1, "deleted");
    }

    public function testToggleInvalidRecord()
    {
        $this->Post->Behaviors->load("Utils.Toggleable", array( "fields" => array( "deleted" => array( 1 ) ) ));
        $this->expectException("Exception");
        $this->Post->toggle("invalid-record-id", "deleted");
    }

}




?>