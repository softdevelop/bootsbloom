<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::import("Controller", "Controller", false);
App::import("Component", "Search.Prg");

/**
 * Post-Redirect-Get: Transfers POST Requests to GET Requests tests
 *
 * @package search
 * @subpackage search.tests.cases.components
 */

class Post extends CakeTestModel
{
    public $name = "Post";
    public $actsAs = array( "Search.Searchable" );

}


/**
 * PostsTest Controller
 *
 * @package search
 * @subpackage search.tests.cases.components
 */

class PostsTestController extends Controller
{
    public $name = "PostsTest";
    public $uses = array( "Post" );
    public $components = array( "Search.Prg", "Session" );

    public function beforeFilter()
    {
        parent::beforefilter();
        $this->Prg->actions = array( "search" => array( "controller" => "Posts", "action" => "result" ) );
    }

    public function redirect($url, $status = NULL, $exit = true)
    {
        $this->redirectUrl = $url;
    }

}


/**
 * Posts Options Test Controller
 *
 * @package search
 * @subpackage search.tests.cases.components
 */

class PostOptionsTestController extends PostsTestController
{
    public $components = array( "Search.Prg" => array( "commonProcess" => array( "form" => "Post", "modelMethod" => false, "allowedParams" => array( "lang" ) ) ), "0" => "Session" );

}


/**
 * PRG Component Test
 *
 * @package search
 * @subpackage search.tests.cases.components
 */

class PrgComponentTest extends CakeTestCase
{
    public $fixtures = array( "plugin.search.post" );

    public function startTest()
    {
        $this->Controller = new PostsTestController();
        $this->Controller->constructClasses();
        $this->Controller->params = array( "named" => array(  ), "pass" => array(  ), "url" => array(  ) );
    }

    public function endTest()
    {
        unset($this->Controller);
        ClassRegistry::flush();
    }

    public function testOptions()
    {
        $this->Controller = new PostOptionsTestController();
        $this->Controller->constructClasses();
        $this->Controller->params = array( "named" => array(  ), "pass" => array(  ), "url" => array(  ) );
        $this->Controller->Component->init($this->Controller);
        $this->Controller->Component->initialize($this->Controller);
        $this->Controller->presetVars = array(  );
        $this->Controller->action = "search";
        $this->Controller->data = array( "Post" => array( "title" => "test" ) );
        $this->Controller->Prg->commonProcess("Post");
        $this->assertEqual($this->Controller->redirectUrl, array( "title" => "test", "action" => "search" ));
        $this->Controller->params = array_merge($this->Controller->params, array( "lang" => "en" ));
        $this->Controller->Prg->commonProcess("Post");
        $this->assertEqual($this->Controller->redirectUrl, array( "title" => "test", "action" => "search", "lang" => "en" ));
    }

    public function testPresetForm()
    {
        $this->Controller->presetVars = array( array( "field" => "title", "type" => "value" ), array( "field" => "checkbox", "type" => "checkbox" ), array( "field" => "lookup", "type" => "lookup", "formField" => "lookup_input", "modelField" => "title", "model" => "Post" ) );
        $this->Controller->passedArgs = array( "title" => "test", "checkbox" => "test|test2|test3", "lookup" => "1" );
        $this->Controller->Component->init($this->Controller);
        $this->Controller->Component->initialize($this->Controller);
        $this->Controller->beforeFilter();
        ClassRegistry::addobject("view", new View($this->Controller));
        $this->Controller->Prg->presetForm("Post");
        $expected = array( "Post" => array( "title" => "test", "checkbox" => array( "test", "test2", "test3" ), "lookup" => 1, "lookup_input" => "First Post" ) );
        $this->assertEqual($this->Controller->data, $expected);
    }

    public function testPresetFormWithIntegerField()
    {
        $this->Controller->presetVars = array( array( "field" => "views", "type" => "value" ) );
        $this->Controller->passedArgs = array( "views" => "0" );
        $this->Controller->Component->init($this->Controller);
        $this->Controller->Component->initialize($this->Controller);
        $this->Controller->beforeFilter();
        ClassRegistry::addobject("view", new View($this->Controller));
        $this->Controller->Prg->presetForm("Post");
        $expected = array( "Post" => array( "views" => "0" ) );
        $this->assertEqual($this->Controller->data, $expected);
    }

    public function testSerializeParams()
    {
        $this->Controller->presetVars = array( array( "field" => "options", "type" => "checkbox" ) );
        $this->Controller->Component->init($this->Controller);
        $this->Controller->Component->initialize($this->Controller);
        $testData = array( "options" => array( "test1", "test2", "test3" ) );
        $result = $this->Controller->Prg->serializeParams($testData);
        $this->assertEqual($result, array( "options" => "test1|test2|test3" ));
        $testData = array( "options" => "" );
        $result = $this->Controller->Prg->serializeParams($testData);
        $this->assertEqual($result, array( "options" => "" ));
        $testData = array(  );
        $result = $this->Controller->Prg->serializeParams($testData);
        $this->assertEqual($result, array( "options" => "" ));
    }

    public function testConnectNamed()
    {
        $this->Controller->passedArgs = array( "title" => "test" );
        $this->Controller->Component->init($this->Controller);
        $this->Controller->Component->initialize($this->Controller);
        $this->assertFalse($this->Controller->Prg->connectNamed());
        $this->assertFalse($this->Controller->Prg->connectNamed(1));
    }

    public function testExclude()
    {
        $this->Controller->params["named"] = array(  );
        $this->Controller->Component->init($this->Controller);
        $this->Controller->Component->initialize($this->Controller);
        $array = array( "foo" => "test", "bar" => "test", "test" => "test" );
        $exclude = array( "bar", "test" );
        $this->assertEqual($this->Controller->Prg->exclude($array, $exclude), array( "foo" => "test" ));
    }

    public function testCommonProcess()
    {
        $this->Controller->params["named"] = array(  );
        $this->Controller->Component->init($this->Controller);
        $this->Controller->Component->initialize($this->Controller);
        $this->Controller->presetVars = array(  );
        $this->Controller->action = "search";
        $this->Controller->data = array( "Post" => array( "title" => "test" ) );
        $this->Controller->Prg->commonProcess("Post", array( "form" => "Post", "modelMethod" => false ));
        $this->assertEqual($this->Controller->redirectUrl, array( "title" => "test", "action" => "search" ));
        $this->Controller->Prg->commonProcess(null, array( "modelMethod" => false ));
        $this->assertEqual($this->Controller->redirectUrl, array( "title" => "test", "action" => "search" ));
        $this->Controller->Post->filterArgs = array( array( "name" => "title", "type" => "value" ) );
        $this->Controller->Prg->commonProcess("Post");
        $this->assertEqual($this->Controller->redirectUrl, array( "title" => "test", "action" => "search" ));
    }

    public function testCommonProcessAllowedParams()
    {
        $this->Controller->params = array_merge($this->Controller->params, array( "named" => array(  ), "lang" => "en" ));
        $this->Controller->Component->init($this->Controller);
        $this->Controller->Component->initialize($this->Controller);
        $this->Controller->presetVars = array(  );
        $this->Controller->action = "search";
        $this->Controller->data = array( "Post" => array( "title" => "test" ) );
        $this->Controller->Prg->commonProcess("Post", array( "form" => "Post", "modelMethod" => false, "allowedParams" => array( "lang" ) ));
        $this->assertEqual($this->Controller->redirectUrl, array( "title" => "test", "action" => "search", "lang" => "en" ));
    }

    public function testCommonProcessGet()
    {
        $this->Controller->Component->init($this->Controller);
        $this->Controller->Component->initialize($this->Controller);
        $this->Controller->action = "search";
        $this->Controller->presetVars = array( array( "field" => "title", "type" => "value" ) );
        $this->Controller->data = array(  );
        $this->Controller->Post->filterArgs = array( array( "name" => "title", "type" => "value" ) );
        $this->Controller->params["named"] = array( "title" => "test" );
        $this->Controller->passedArgs = array_merge($this->Controller->params["named"], $this->Controller->params["pass"]);
        $this->Controller->Prg->commonProcess("Post");
        $this->assertEqual($this->Controller->data, array( "Post" => array( "title" => "test" ) ));
    }

    public function testSerializeParamsWithEncoding()
    {
        $this->Controller->Component->init($this->Controller);
        $this->Controller->Component->initialize($this->Controller);
        $this->Controller->action = "search";
        $this->Controller->presetVars = array( array( "field" => "title", "type" => "value", "encode" => true ) );
        $this->Controller->data = array(  );
        $this->Controller->Post->filterArgs = array( array( "name" => "title", "type" => "value" ) );
        $this->Controller->Prg->encode = true;
        $test = array( "title" => "Something new" );
        $result = $this->Controller->Prg->serializeParams($test);
        $this->assertEqual($result["title"], base64_encode("Something new"));
    }

    public function testPresetFormWithEncodedParams()
    {
        $this->Controller->presetVars = array( array( "field" => "title", "type" => "value" ), array( "field" => "checkbox", "type" => "checkbox" ), array( "field" => "lookup", "type" => "lookup", "formField" => "lookup_input", "modelField" => "title", "model" => "Post" ) );
        $this->Controller->passedArgs = array( "title" => base64_encode("test"), "checkbox" => base64_encode("test|test2|test3"), "lookup" => base64_encode("1") );
        $this->Controller->Component->init($this->Controller);
        $this->Controller->Component->initialize($this->Controller);
        $this->Controller->beforeFilter();
        ClassRegistry::addobject("view", new View($this->Controller));
        $this->Controller->Prg->encode = true;
        $this->Controller->Prg->presetForm("Post");
        $expected = array( "Post" => array( "title" => "test", "checkbox" => array( "test", "test2", "test3" ), "lookup" => 1, "lookup_input" => "First Post" ) );
        $this->assertEqual($this->Controller->data, $expected);
    }

}




?>