<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::import("Behavior", "Utils.Btree");

class BArticle extends CakeTestModel
{
    public $useTable = "b_articles";
    public $actsAs = array( "Utils.Btree" );

}


/**
 * BTree test case
 *
 */

class BtreeTest extends CakeTestCase
{
    public $Model = null;
    public $Behavior = null;
    public $fixtures = array( "plugin.utils.b_article" );

    public function setUp()
    {
        parent::setup();
        $this->Model = new BArticle();
        $this->Behavior = $this->Model->Behaviors->Btree;
    }

    public function tearDown()
    {
        parent::teardown();
        unset($this->Model);
        unset($this->Behavior);
        ClassRegistry::flush();
    }

    public function testBeforeSave()
    {
        $data = array( $this->Model->alias => array( "title" => "Third article", "parent_id" => 3 ) );
        $this->Model->data = $data;
        $this->assertTrue($this->Behavior->beforeSave($this->Model));
    }

    public function testChildren()
    {
        $result = $this->Model->children(false, true);
        $this->assertEqual(Set::extract("/BArticle/id", $result), array( 1, 4 ));
        $this->Model->id = 1;
        $result = $this->Model->children();
        $this->assertEqual(Set::extract("/BArticle/id", $result), array( 2, 3 ));
    }

    public function testGeneratetreelist()
    {
        $result = $this->Model->generatetreelist();
        $expected = array( 1 => "First article", 2 => "_First article - child 1", 3 => "__First article - child 1 - subchild 1", 4 => "Second article" );
        $this->assertEqual($result, $expected);
    }

    public function testGetParentNode()
    {
        $result = $this->Model->getparentnode(2);
        $this->assertEqual($result["BArticle"]["id"], 1);
        $result = $this->Model->getparentnode(3);
        $this->assertEqual($result["BArticle"]["id"], 2);
    }

    public function testGetPath()
    {
        $result = $this->Model->getpath(3);
        $this->assertEqual(Set::extract("/BArticle/id", $result), array( 1, 2, 3 ));
    }

    public function testChildcount()
    {
        $this->assertEqual($this->Model->childcount(1, true), 1);
        $this->assertEqual($this->Model->childcount(null, false), 4);
    }

}




?>