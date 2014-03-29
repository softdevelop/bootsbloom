<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Post Test Model
 */

class Post extends CakeTestModel
{
    public $useTable = "posts";
    public $alias = "Post";
    public $belongsTo = array( "Article" );

}


/**
 * Lookupable Test case
 */

class LookupableTest extends CakeTestCase
{
    public $fixtures = array( "plugin.utils.post", "plugin.utils.article" );

    public function setUp()
    {
        $this->Post = new Post();
    }

    public function tearDown()
    {
        unset($this->Post);
        ClassRegistry::flush();
    }

    public function testAddRecordAndLookup()
    {
        $this->Post->Behaviors->load("Utils.Lookupable", array( "types" => array( "Article" ) ));
        $this->Post->create();
        $firstResult = $this->Post->save(array( "Post" => array( "title" => "foobar", "article_title" => "Im looked up!" ), "Article" => array( "slug" => "TEST", "tiny_slug" => "1" ) ));
        $result = $this->Post->Article->find("first", array( "conditions" => array( "Article.title" => "Im looked up!" ) ));
        $this->assertTrue(is_array($result));
        $this->assertEqual($result["Article"]["title"], "Im looked up!");
        $this->Post->create();
        $secondResult = $this->Post->save(array( "Post" => array( "title" => "foobar123", "article_title" => "Im looked up!" ) ));
        $this->assertEqual($firstResult["Post"]["article_id"], $secondResult["Post"]["article_id"]);
    }

}




?>