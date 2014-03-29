<?php 
//
// This source code was recovered by Recover-PHP.com
//


class LogUtilComponent extends Object
{
    public $components = array( "Auth" );
    public $logModel = "Log";
    public $user = array(  );
    public $params = array(  );

    const LOG_TYPE_INFO = 0;
    const LOG_TYPE_WARRING = 1;
    const LOG_TYPE_ERROR = 2;

    public function startup($controller)
    {
        $this->params = $controller->params;
        $this->user = $this->Auth->user("id");
    }

    public function __getParameters()
    {
        $parameters = "";
        if( !empty($this->params["pass"]) ) 
        {
            foreach( $this->params["pass"] as $param ) 
            {
                $parameters .= $param . "/";
            }
        }

        return $parameters;
    }

    public function log($options = array(  ), $action = null, $controller = null)
    {
        $params = $this->__getParameters();
        $action = !empty($action) ? $action : $this->params["action"];
        $controller = !empty($controller) ? $controller : $this->params["controller"];
        $options = array_merge(array( "description" => "", "type" => LogUtilComponent::LOG_TYPE_INFO, "params" => $params ), $options);
        $data["Log"]["controller"] = $controller;
        $data["Log"]["action"] = $action;
        $data["Log"]["params"] = $options["params"];
        $data["Log"]["description"] = $options["description"];
        $data["Log"]["type"] = $options["type"];
        $data["Log"]["url"] = $this->params["url"]["url"];
        $data["Log"]["user_id"] = !empty($this->user) ? $this->user : 0;
        $logModel =& $this->__getModel();
        $logModel->create();
        $logModel->save($data);
    }

    private function __getModel($name = null)
    {
        $model = null;
        if( !$name ) 
        {
            $name = $this->logModel;
        }

        if( PHP5 ) 
        {
            $model = ClassRegistry::init($name);
        }
        else
        {
            $model =& ClassRegistry::init($name);
        }

        if( empty($model) ) 
        {
            trigger_error(__("Log::getModel() - Model is not set or could not be found", true), E_USER_WARNING);
            return null;
        }

        return $model;
    }

}
