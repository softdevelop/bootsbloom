<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::import("Controller", "Controller", false);
App::import("Component", "Utils.Referer");
App::uses("Router", "Routing");

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
    public $components = array( "Utils.Referer" );

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
        $this->Controller->Referer->initialize($this->Controller);
    }

    public function tearDown()
    {
        unset($this->Controller);
        ClassRegistry::flush();
    }

    public function testSetReferer()
    {
        $_SERVER["HTTP_REFERER"] = "/bar";
        $this->Controller->Referer->setReferer("/foo/bar");
        $this->assertEqual($this->Controller->viewVars["referer"], "/bar");
        $_SERVER["HTTP_REFERER"] = "/";
        $this->Controller->Referer->setReferer("/foo/bar2");
        $this->assertEqual($this->Controller->viewVars["referer"], "/foo/bar2");
        $_SERVER["HTTP_REFERER"] = "/";
        $this->Controller->Referer->setReferer(array( "controller" => "foo", "action" => "bar" ));
        $this->assertEqual($this->Controller->viewVars["referer"], "/foo/bar");
        $this->Controller->request->data["Data"]["referer"] = "/post";
        $this->Controller->Referer->setReferer("/foo/bar2");
        $this->assertEqual($this->Controller->viewVars["referer"], "/post");
    }

    public function testRedirect()
    {
        $this->Controller->request->data["Data"]["referer"] = "/foo/bar";
        $result = $this->Controller->Referer->redirect("/home");
        $this->assertEqual($this->Controller->redirectUrl, "/foo/bar");
        $_SERVER["HTTP_REFERER"] = "/";
        $this->Controller->request->data = null;
        $result = $this->Controller->Referer->redirect("/home");
        $this->assertEqual($this->Controller->redirectUrl, "/home");
    }

}




?>