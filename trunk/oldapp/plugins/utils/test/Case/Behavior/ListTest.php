<?php 
//
// This source code was recovered by Recover-PHP.com
//


class UsersAddon extends CakeTestModel
{
    public $name = "UsersAddon";
    public $beforeSaveFalse = false;
    public $actsAs = array( "Utils.List" => array( "positionColumn" => "position", "scope" => "user_id" ) );

    public function beforeSave()
    {
        return $this->beforeSaveFalse;
    }

}


class ListTest extends CakeTestCase
{
    public $UsersAddon = null;
    public $fixtures = array( "plugin.utils.users_addon" );

    public function setUp()
    {
        $this->UsersAddon = ClassRegistry::init("UsersAddon");
        $this->UsersAddon->Behaviors->load("Utils.List", array( "positionColumn" => "position", "scope" => "user_id" ));
    }

    public function tearDown()
    {
        unset($this->UsersAddon);
        ClassRegistry::flush();
    }

    public function testMoveUp()
    {
        $result = $this->UsersAddon->moveUp("useraddon-2");
        $this->assertTrue(!empty($result));
        $result = $this->UsersAddon->moveUp("non-existing-uuid");
        $this->assertFalse($result);
    }

    public function testMoveDown()
    {
        $result = $this->UsersAddon->moveDown("useraddon-2");
        $this->assertTrue(!empty($result));
        $result = $this->UsersAddon->moveDown("non-existing-uuid");
        $this->assertFalse($result);
    }

    public function testInsertAt()
    {
        $result = $this->UsersAddon->insertAt(1, "useraddon-3");
        $this->assertTrue(!empty($result));
        $result = $this->UsersAddon->read("position", "useraddon-3");
        $this->assertEqual($result["UsersAddon"]["position"], 1);
        $result = $this->UsersAddon->insertAt(2, "useraddon-3");
        $this->assertTrue(!empty($result));
        $result = $this->UsersAddon->read("position", "useraddon-3");
        $this->assertEqual($result["UsersAddon"]["position"], 2);
        $position = $this->UsersAddon->find("count");
        $result = $this->UsersAddon->insertAt($position, "useraddon-3");
        $this->assertTrue(!empty($result));
        $result = $this->UsersAddon->read("position", "useraddon-3");
        $this->assertEqual($result["UsersAddon"]["position"], $position);
    }

    public function testMoveToBottom()
    {
        $this->UsersAddon->moveToBottom("useraddon-1");
        $result = $this->UsersAddon->read("position", "useraddon-1");
        $this->assertEqual($result["UsersAddon"]["position"], 3);
    }

    public function testMoveToTop()
    {
        $this->UsersAddon->moveToTop("useraddon-3");
        $result = $this->UsersAddon->read("position", "useraddon-3");
        $this->assertEqual($result["UsersAddon"]["position"], 1);
    }

    public function testIsFirst()
    {
        $result = $this->UsersAddon->isFirst("useraddon-1");
        $this->assertTrue($result);
        $result = $this->UsersAddon->isFirst("useraddon-3");
        $this->assertFalse($result);
    }

    public function testIsLast()
    {
        $result = $this->UsersAddon->isLast("useraddon-3");
        $this->assertTrue($result);
        $result = $this->UsersAddon->isLast("useraddon-1");
        $this->assertFalse($result);
    }

    public function testCallbacks()
    {
        $this->UsersAddon->Behaviors->unload("Utils.List");
        $this->UsersAddon->Behaviors->load("Utils.List", array( "positionColumn" => "position", "scope" => "user_id", "callbacks" => false, "validate" => false ));
        $this->UsersAddon->beforeSaveFalse = false;
        $result = $this->UsersAddon->moveDown("useraddon-1");
        $this->assertTrue(!empty($result));
    }

}




?>