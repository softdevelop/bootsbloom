<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::uses("Utils.Sluggable", "Model/Behavior");

/**
 * TinySluggableArticle model used for tests
 */

class TinySluggableArticle extends CakeTestModel
{
    public $useTable = "articles";
    public $actsAs = array( "Utils.TinySluggable" );

}


/**
 * TinySluggable Test Behavior
 **/

class TinySluggableBehaviorTest extends CakeTestCase
{
    public $fixtures = array( "plugin.utils.article" );

    public function setUp()
    {
        $this->Model = new TinySluggableArticle();
        $this->Model->Behaviors->load("Utils.TinySluggable", array(  ));
    }

    public function tearDown()
    {
        unset($this->Model);
        ClassRegistry::flush();
    }

    public function testBeforeSave()
    {
        $this->Model->data = array( "TinySluggableArticle" => array( "title" => "another title" ) );
        $this->assertTrue($this->Model->Behaviors->TinySluggable->beforeSave($this->Model));
        $this->assertEqual($this->Model->data["TinySluggableArticle"]["tiny_slug"], "3");
    }

    public function testCustomConfig()
    {
        $this->Model->Behaviors->unload("TinySluggable");
        $this->Model->Behaviors->load("TinySluggable", array( "tinySlug" => "tiny_slug", "codeset" => "2abcdefg" ));
        $this->Model->data = array( "TinySluggableArticle" => array( "title" => "and another title" ) );
        $this->assertTrue($this->Model->Behaviors->TinySluggable->beforeSave($this->Model));
        $this->assertTrue(!empty($this->Model->data["TinySluggableArticle"]["tiny_slug"]));
        $this->assertEqual($this->Model->data["TinySluggableArticle"]["tiny_slug"], "a");
    }

    public function testFirstSlugUsingStdCodeset()
    {
        $this->Model->query("truncate table " . $this->Model->useTable);
        $result = $this->Model->save(array( "TinySluggableArticle" => array( "title" => "and another title" ) ));
        $this->assertEqual($result["TinySluggableArticle"]["tiny_slug"], "0");
    }

    public function testManySlugs()
    {
        $this->Model->query("truncate table " . $this->Model->useTable);
        $codeset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for( $i = 0; $i <= 25; $i++ ) 
        {
            $expect[$i] = $codeset[$i];
            $this->Model->create();
            $this->Model->save(array( "TinySluggableArticle" => array( "title" => "Another Title " . $i ) ));
        }
        $results = Set::extract($this->Model->find("all"), "{n}.TinySluggableArticle.tiny_slug");
        $this->assertEqual($results, $expect);
    }

}




?>