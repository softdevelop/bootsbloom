<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::import("Controller", "Controller", false);
App::import("Component", array( "Utils.FormPreserver", "Session", "Auth" ));

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
    public $components = array( "Utils.FormPreserver", "Session", "Auth" );

    public function redirect($url, $status = NULL, $exit = true)
    {
        $this->redirectUrl = $url;
    }

}


class FormPreserverComponentTest extends CakeTestCase
{
    public $fixtures = array( "plugin.utils.article" );

    public function setUp()
    {
        $this->Controller = new ArticlesTestController();
        $this->Controller->constructClasses();
        $this->Controller->action = "edit";
        $this->Controller->params = array( "named" => array(  ), "pass" => array(  ), "url" => array(  ) );
        $this->Controller->modelClass = "Article";
        $this->Controller->Component->init($this->Controller);
        $this->Controller->Component->initialize($this->Controller);
    }

    public function tearDown()
    {
        unset($this->Controller);
        ClassRegistry::flush();
    }

    public function testStartup()
    {
        $data = array( "_Token" => "token", "ArticleTest" => array( "title" => "Foo" ) );
        $this->Controller->data = $data;
        $this->Controller->FormPreserver->actions = array( "edit" );
        $this->Controller->FormPreserver->startup($this->Controller);
        $this->assertEqual($this->Controller->redirectUrl, array( "controller" => "users", "action" => "login", "plugin" => null ));
    }

    public function testRestore()
    {
        $data = array( "_Token" => "token", "ArticleTest" => array( "title" => "Foo" ) );
        $this->Controller->Session->write("PreservedForms.ArticlesTest.edit", $data);
        $this->Controller->data = null;
        $this->Controller->FormPreserver->restore();
        $this->assertTrue($this->Controller->Session->check("PreservedForms"));
        $this->assertEqual($this->Controller->data, $data);
        session_destroy();
    }

    public function testPreserve()
    {
        $data = array( "_Token" => "token", "ArticleTest" => array( "title" => "Foo" ) );
        $result = $this->Controller->FormPreserver->preserve($data);
        $this->assertTrue($this->Controller->Session->check("PreservedForms"));
        $this->assertTrue($result);
        session_destroy();
    }

}




?>