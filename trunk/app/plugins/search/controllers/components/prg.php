<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Post-Redirect-Get: Transfers POST Requests to GET Requests
 *
 * @package		plugins.search
 * @subpackage	plugins.search.controllers.components
 */

class PrgComponent extends Object
{
    public $actions = array(  );
    public $encode = false;
    protected $_defaults = array( "commonProcess" => array(  ) );

    public function initialize($controller, $settings = array(  ))
    {
        $this->controller = $controller;
        $this->_defaults = Set::merge($this->_defaults, $settings);
    }

    public function presetForm($model)
    {
        $data = array( $model => array(  ) );
        $args = $this->controller->passedArgs;
        foreach( $this->controller->presetVars as $field ) 
        {
            if( ($this->encode == true || isset($field["encode"]) && $field["encode"] == true) && isset($args[$field["field"]]) ) 
            {
                $args[$field["field"]] = base64_decode(str_replace(array( "-", "_" ), array( "+", "/" ), $args[$field["field"]]));
                $this->controller->passedArgs[$field["field"]] = $args[$field["field"]];
            }

            if( $field["type"] == "lookup" && isset($args[$field["field"]]) ) 
            {
                $searchModel = $field["model"];
                $this->controller->loadModel($searchModel);
                $this->controller->$searchModel->recursive = 0 - 1;
                $result = $this->controller->$searchModel->findById($args[$field["field"]]);
                $data[$model][$field["field"]] = $args[$field["field"]];
                $data[$model][$field["formField"]] = $result[$searchModel][$field["modelField"]];
            }

            if( $field["type"] == "checkbox" && isset($args[$field["field"]]) ) 
            {
                $values = split("\\|", $args[$field["field"]]);
                $data[$model][$field["field"]] = $values;
            }

            if( $field["type"] == "value" && isset($args[$field["field"]]) ) 
            {
                $data[$model][$field["field"]] = $args[$field["field"]];
            }

        }
        $this->controller->data = $data;
        $this->controller->parsedData = $data;
    }

    public function serializeParams($data)
    {
        foreach( $this->controller->presetVars as $field ) 
        {
            if( $field["type"] == "checkbox" ) 
            {
                if( array_key_exists($field["field"], $data) ) 
                {
                    $values = join("|", (array) $data[$field["field"]]);
                }
                else
                {
                    $values = "";
                }

                $data[$field["field"]] = $values;
            }

            if( $this->encode == true || isset($field["encode"]) && $field["encode"] == true ) 
            {
                $data[$field["field"]] = base64_encode(str_replace(array( "+", "/" ), array( "-", "_" ), $data[$field["field"]]));
            }

        }
        return $data;
    }

    public function connectNamed($data = null, $exclude = array(  ))
    {
        if( !isset($data) ) 
        {
            $data = $this->controller->passedArgs;
        }

        if( !is_array($data) ) 
        {
            return NULL;
        }

        foreach( $data as $key => $value ) 
        {
            if( !is_numeric($key) && !in_array($key, $exclude) ) 
            {
                Router::connectnamed(array( $key ));
            }

        }
    }

    public function exclude($array, $exclude)
    {
        $data = array(  );
        foreach( $array as $key => $value ) 
        {
            if( !is_numeric($key) && !in_array($key, $exclude) ) 
            {
                $data[$key] = $value;
            }

        }
        return $data;
    }

    public function commonProcess($modelName = null, $options = array(  ))
    {
        $defaults = array( "formName" => null, "keepPassed" => true, "action" => null, "modelMethod" => "validateSearch", "allowedParams" => array(  ) );
        $defaults = Set::merge($defaults, $this->_defaults["commonProcess"]);
        extract(Set::merge($defaults, $options));
        if( empty($modelName) ) 
        {
            $modelName = $this->controller->modelClass;
        }

        if( empty($formName) ) 
        {
            $formName = $modelName;
        }

        if( empty($action) ) 
        {
            $action = $this->controller->action;
        }

        if( !empty($this->controller->data) ) 
        {
            $this->controller->$modelName->data = $this->controller->data;
            $valid = true;
            if( $modelMethod !== false ) 
            {
                $valid = $this->controller->$modelName->$modelMethod();
            }

            if( $valid ) 
            {
                $passed = $this->controller->params["pass"];
                $params = $this->controller->data[$modelName];
                $params = $this->exclude($params, array(  ));
                if( $keepPassed ) 
                {
                    $params = array_merge($passed, $params);
                }

                $this->serializeParams($params);
                $this->connectNamed($params, array(  ));
                $params["action"] = $action;
                $params = array_merge($this->controller->params["named"], $params);
                foreach( $allowedParams as $key ) 
                {
                    if( isset($this->controller->params[$key]) ) 
                    {
                        $params[$key] = $this->controller->params[$key];
                    }

                }
                $this->controller->redirect($params);
            }
            else
            {
                $this->controller->Session->setFlash(__d("search", "Please correct the errors below.", true));
            }

        }

        if( empty($this->controller->data) && !empty($this->controller->passedArgs) ) 
        {
            $this->connectNamed($this->controller->passedArgs, array(  ));
            $this->presetForm($formName);
        }

    }

}




?>