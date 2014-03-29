<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::import("Behavior", "Utils.SoftDelete");

/**
 * SoftDeletedPost
 *
 * @package utils
 * @subpackage utils.tests.cases.behaviors
 */

class SoftDeletedPost extends CakeTestModel
{
    public $useTable = "posts";
    public $actsAs = array( "Utils.SoftDelete" );
    public $alias = "Post";

}


/**
 * SoftDelete Test case
 */

class SoftDeleteTest extends CakeTestCase
{
    public $fixtures = array( "plugin.utils.post" );

    public function setUp()
    {
        $this->Post = new SoftDeletedPost();
    }

    public function tearDown()
    {
        unset($this->Post);
        ClassRegistry::flush();
    }

    public function testSoftDelete()
    {
        $data = $this->Post->read(null, 1);
        $this->assertEqual($data[$this->Post->alias][$this->Post->primaryKey], 1);
        $result = $this->Post->delete(1);
        $this->assertFalse($result);
        $data = $this->Post->read(null, 1);
        $this->assertFalse($data);
        $this->Post->Behaviors->unload("SoftDelete");
        $data = $this->Post->read(null, 1);
        $this->assertEqual($data["Post"]["deleted"], true);
        $this->assertEqual($data["Post"]["updated"], $data["Post"]["deleted_date"]);
    }

    public function testUnDelete()
    {
        $data = $this->Post->read(null, 1);
        $result = $this->Post->delete(1);
        $result = $this->Post->undelete(1);
        $this->Post->Behaviors->unload("SoftDelete");
        $data = $this->Post->read(null, 1);
        $this->assertEqual($data["Post"]["deleted"], false);
    }

    public function testSoftDeletePurge()
    {
        $this->Post->Behaviors->disable("SoftDelete");
        $data = $this->Post->read(null, 3);
        $this->assertTrue(!empty($data));
        $this->Post->Behaviors->enable("SoftDelete");
        $data = $this->Post->read(null, 3);
        $this->assertFalse($data);
        $count = $this->Post->purgeDeletedCount();
        $this->assertEqual($count, 1);
        $this->Post->purgeDeleted();
        $data = $this->Post->read(null, 3);
        $this->assertFalse($data);
        $this->Post->Behaviors->disable("SoftDelete");
        $data = $this->Post->read(null, 3);
        $this->assertFalse($data);
    }

}




?>