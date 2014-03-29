<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Searchable behavior
 *
 * @package		plugins.search
 * @subpackage	plugins.search.models.behaviors
 */

class SearchableBehavior extends ModelBehavior
{
    public $settings = array(  );
    protected $_defaults = array(  );

    public function setup($model, $config = array(  ))
    {
        $this->settings[$model->alias] = array_merge($this->_defaults, $config);
    }

    public function parseCriteria($model, $data)
    {
        $conditions = array(  );
        foreach( $model->filterArgs as $field ) 
        {
            if( in_array($field["type"], array( "string", "like" )) ) 
            {
                $this->_addCondLike($model, $conditions, $data, $field);
            }
            else
            {
                if( in_array($field["type"], array( "int", "value" )) ) 
                {
                    $this->_addCondValue($model, $conditions, $data, $field);
                }
                else
                {
                    if( $field["type"] == "expression" ) 
                    {
                        $this->_addCondExpression($model, $conditions, $data, $field);
                    }
                    else
                    {
                        if( $field["type"] == "query" ) 
                        {
                            $this->_addCondQuery($model, $conditions, $data, $field);
                        }
                        else
                        {
                            if( $field["type"] == "subquery" ) 
                            {
                                $this->_addCondSubquery($model, $conditions, $data, $field);
                            }

                        }

                    }

                }

            }

        }
        return $conditions;
    }

    public function validateSearch($model, $data = null)
    {
        if( !empty($data) ) 
        {
            $model->set($data);
        }

        $keys = array_keys($model->data[$model->alias]);
        foreach( $keys as $key ) 
        {
            if( empty($model->data[$model->alias][$key]) ) 
            {
                unset($model->data[$model->alias][$key]);
            }

        }
        return true;
    }

    public function passedArgs($model, $vars)
    {
        $result = array(  );
        foreach( $vars as $var => $val ) 
        {
            if( in_array($var, Set::extract($model->filterArgs, "{n}.name")) ) 
            {
                $result[$var] = $val;
            }

        }
        return $result;
    }

    public function getQuery($model, $conditions = null, $fields = array(  ), $order = null, $recursive = null)
    {
        if( !is_string($conditions) || is_string($conditions) && !array_key_exists($conditions, $model->_findMethods) ) 
        {
            $type = "first";
            $query = compact("conditions", "fields", "order", "recursive");
        }
        else
        {
            list($type, $query) = array( $conditions, $fields );
        }

        $db =& ConnectionManager::getdatasource($model->useDbConfig);
        $model->findQueryType = $type;
        $model->id = $model->getID();
        $query = array_merge(array( "conditions" => null, "fields" => null, "joins" => array(  ), "limit" => null, "offset" => null, "order" => null, "page" => null, "group" => null, "callbacks" => true ), (array) $query);
        if( $type != "all" && $model->_findMethods[$type] === true ) 
        {
            $query = $model->{"_find" . ucfirst($type)}("before", $query);
        }

        if( !is_numeric($query["page"]) || intval($query["page"]) < 1 ) 
        {
            $query["page"] = 1;
        }

        if( 1 < $query["page"] && !empty($query["limit"]) ) 
        {
            $query["offset"] = ($query["page"] - 1) * $query["limit"];
        }

        if( $query["order"] === null && $model->order !== null ) 
        {
            $query["order"] = $model->order;
        }

        $query["order"] = array( $query["order"] );
        if( $query["callbacks"] === true || $query["callbacks"] === "before" ) 
        {
            $return = $model->Behaviors->trigger($model, "beforeFind", array( $query ), array( "break" => true, "breakOn" => false, "modParams" => true ));
            $query = is_array($return) ? $return : $query;
            if( $return === false ) 
            {
                return null;
            }

            $return = $model->beforeFind($query);
            $query = is_array($return) ? $return : $query;
            if( $return === false ) 
            {
                return null;
            }

        }

        return $this->__queryGet($model, $query, $recursive);
    }

    public function unbindAllModels($model, $reset = false)
    {
        $assocs = array( "belongsTo", "hasOne", "hasMany", "hasAndBelongsToMany" );
        $unbind = array(  );
        foreach( $assocs as $assoc ) 
        {
            $unbind[$assoc] = array_keys($model->$assoc);
        }
        $model->unbindModel($unbind, $reset);
    }

    protected function _addCondLike($model, $conditions, $data, $field)
    {
        $fieldName = $field["name"];
        if( isset($field["field"]) ) 
        {
            $fieldName = $field["field"];
        }

        if( strpos($fieldName, ".") === false ) 
        {
            $fieldName = $model->alias . "." . $fieldName;
        }

        if( !empty($data[$field["name"]]) ) 
        {
            $conditions[$fieldName . " LIKE"] = "%" . $data[$field["name"]] . "%";
        }

        return $conditions;
    }

    protected function _addCondValue($model, $conditions, $data, $field)
    {
        $fieldName = $field["name"];
        if( isset($field["field"]) ) 
        {
            $fieldName = $field["field"];
        }

        if( strpos($fieldName, ".") === false ) 
        {
            $fieldName = $model->alias . "." . $fieldName;
        }

        if( !empty($data[$field["name"]]) || isset($data[$field["name"]]) && ($data[$field["name"]] === 0 || $data[$field["name"]] === "0") ) 
        {
            $conditions[$fieldName] = $data[$field["name"]];
        }

        return $conditions;
    }

    protected function _addCondQuery($model, $conditions, $data, $field)
    {
        if( (method_exists($model, $field["method"]) || $this->__checkBehaviorMethods($model, $field["method"])) && (!empty($field["allowEmpty"]) || !empty($data[$field["name"]]) || isset($data[$field["name"]]) && ($data[$field["name"]] === 0 || $data[$field["name"]] === "0")) ) 
        {
            $conditionsAdd = $model->{$field["method"]}($data, $field);
            $conditions = array_merge($conditions, (array) $conditionsAdd);
        }

        return $conditions;
    }

    protected function _addCondExpression($model, $conditions, $data, $field)
    {
        $fieldName = $field["field"];
        if( (method_exists($model, $field["method"]) || $this->__checkBehaviorMethods($model, $field["method"])) && (!empty($field["allowEmpty"]) || !empty($data[$field["name"]]) || isset($data[$field["name"]]) && ($data[$field["name"]] === 0 || $data[$field["name"]] === "0")) ) 
        {
            $fieldValues = $model->{$field["method"]}($data, $field);
            if( !empty($conditions[$fieldName]) && is_array($conditions[$fieldName]) ) 
            {
                $conditions[$fieldName] = array_unique(array_merge(array( $conditions[$fieldName] ), array( $fieldValues )));
            }
            else
            {
                $conditions[$fieldName] = $fieldValues;
            }

        }

        return $conditions;
    }

    protected function _addCondSubquery($model, $conditions, $data, $field)
    {
        $fieldName = $field["field"];
        if( (method_exists($model, $field["method"]) || $this->__checkBehaviorMethods($model, $field["method"])) && (!empty($field["allowEmpty"]) || !empty($data[$field["name"]]) || isset($data[$field["name"]]) && ($data[$field["name"]] === 0 || $data[$field["name"]] === "0")) ) 
        {
            $subquery = $model->{$field["method"]}($data);
            $conditions[] = array( "" . $fieldName . " in (" . $subquery . ")" );
        }

        return $conditions;
    }

    private function __queryGet($model, $queryData = array(  ), $recursive = null)
    {
        $db =& ConnectionManager::getdatasource($model->useDbConfig);
        $db->__scrubQueryData($queryData);
        $null = null;
        $array = array(  );
        $linkedModels = array(  );
        $db->__bypass = false;
        $db->__booleans = array(  );
        if( $recursive === null && isset($queryData["recursive"]) ) 
        {
            $recursive = $queryData["recursive"];
        }

        if( !is_null($recursive) ) 
        {
            $_recursive = $model->recursive;
            $model->recursive = $recursive;
        }

        if( !empty($queryData["fields"]) ) 
        {
            $db->__bypass = true;
            $queryData["fields"] = $db->fields($model, null, $queryData["fields"]);
        }
        else
        {
            $queryData["fields"] = $db->fields($model);
        }

        foreach( $model->__associations as $type ) 
        {
            foreach( $model->$type as $assoc => $assocData ) 
            {
                if( 0 - 1 < $model->recursive ) 
                {
                    $linkModel =& $model->$assoc;
                    $external = isset($assocData["external"]);
                    if( $model->alias == $linkModel->alias && $type != "hasAndBelongsToMany" && $type != "hasMany" ) 
                    {
                        if( true === $db->generateSelfAssociationQuery($model, $linkModel, $type, $assoc, $assocData, $queryData, $external, $null) ) 
                        {
                            $linkedModels[] = $type . "/" . $assoc;
                        }

                    }
                    else
                    {
                        if( $model->useDbConfig == $linkModel->useDbConfig && true === $db->generateAssociationQuery($model, $linkModel, $type, $assoc, $assocData, $queryData, $external, $null) ) 
                        {
                            $linkedModels[] = $type . "/" . $assoc;
                        }

                    }

                }

            }
        }
        return $db->generateAssociationQuery($model, $null, null, null, null, $queryData, false, $null);
    }

    private function __checkBehaviorMethods($Model, $method)
    {
        $behaviors = $Model->Behaviors->enabled();
        $count = count($behaviors);
        $found = false;
        for( $i = 0; $i < $count; $i++ ) 
        {
            $name = $behaviors[$i];
            $methods = get_class_methods($Model->Behaviors->$name);
            $check = array_flip($methods);
            $found = isset($check[$method]);
            if( $found ) 
            {
                return true;
            }

        }
        return $found;
    }

}




?>