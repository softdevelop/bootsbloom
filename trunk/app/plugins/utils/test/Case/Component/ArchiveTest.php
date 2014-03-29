<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::import("Controller", "Controller", false);
App::import("Component", "Utils.Archive");

class Article extends CakeTestModel
{
    public $name = "Article";

}


/**
 * 
 */

class ArticlesTestController extends Controller
{
    public $name = "ArticlesTest";
    public $uses = array( "Article" );
    public $components = array( "Utils.Archive" );

    public function redirect($url, $status = NULL, $exit = true)
    {
        $this->redirectUrl = $url;
    }

}


class PrgComponentTest extends CakeTestCase
{
    public $fixtures = array( "plugin.utils.article" );

    public function setUp()
    {
        $request = new CakeRequest();
        $this->Controller = new ArticlesTestController($request);
        $this->Controller->constructClasses();
        $this->Controller->params = array( "named" => array(  ), "pass" => array(  ), "url" => array(  ) );
        $this->Controller->modelClass = "Article";
        $this->Controller->Archive->startup($this->Controller);
    }

    public function tearDown()
    {
        unset($this->Controller);
        ClassRegistry::flush();
    }

    public function testArchiveLinks()
    {
        $result = $this->Controller->Archive->archiveLinks();
        $this->assertEqual($result[0], array( "year" => 2007, "month" => 3, "count" => 3 ));
    }

}




?>