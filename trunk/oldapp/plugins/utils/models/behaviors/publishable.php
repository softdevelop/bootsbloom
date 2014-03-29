<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Publishable Behavior
 *
 * @package utils
 * @subpackage utils.models.behaviors
 */

class PublishableBehavior extends ModelBehavior
{
    public $__settings = array(  );

    public function setup($Model, $settings = array(  ))
    {
        $default = array( "field" => "published", "field_date" => "published_date", "find" => true );
        if( !isset($this->__settings[$Model->alias]) ) 
        {
            $this->__settings[$Model->alias] = $default;
        }

        $this->__settings[$Model->alias] = array_merge($this->__settings[$Model->alias], is_array($settings) ? $settings : array(  ));
    }

    public function publish($Model, $id = null, $attributes = array(  ))
    {
        if( $Model->hasField($this->__settings[$Model->alias]["field"]) ) 
        {
            if( empty($id) ) 
            {
                $id = $Model->id;
            }

            $onFind = $this->__settings[$Model->alias]["find"];
            $this->enablePublishable($Model, false);
            $data = array( $Model->alias => array( $Model->primaryKey => $id, $this->__settings[$Model->alias]["field"] => true ) );
            $Model->id = $id;
            if( isset($this->__settings[$Model->alias]["field_date"]) && $Model->hasField($this->__settings[$Model->alias]["field_date"]) && !$Model->field($this->__settings[$Model->alias]["field_date"]) ) 
            {
                $data[$Model->alias][$this->__settings[$Model->alias]["field_date"]] = date("Y-m-d H:i:s");
            }

            if( !empty($attributes) ) 
            {
                $data[$Model->alias] = array_merge($data[$Model->alias], $attributes);
            }

            $result = $Model->save($data, false, array_keys($data[$Model->alias]));
            $this->enablePublishable($Model, "find", $onFind);
            return $result !== false;
        }

        return false;
    }

    public function unPublish($Model, $id = null, $attributes = array(  ))
    {
        if( $Model->hasField($this->__settings[$Model->alias]["field"]) ) 
        {
            if( empty($id) ) 
            {
                $id = $Model->id;
            }

            $data = array( $Model->alias => array( $Model->primaryKey => $id, $this->__settings[$Model->alias]["field"] => false ) );
            if( !empty($attributes) ) 
            {
                $data[$Model->alias] = array_merge($data[$Model->alias], $attributes);
            }

            $onFind = $this->__settings[$Model->alias]["find"];
            $this->enablePublishable($Model, false);
            $Model->id = $id;
            $result = $Model->save($data, false, array_keys($data[$Model->alias]));
            $this->enablePublishable($Model, "find", $onFind);
            return $result !== false;
        }

        return false;
    }

    public function enablePublishable($Model, $methods, $enable = true)
    {
        if( is_bool($methods) ) 
        {
            $enable = $methods;
            $methods = array( "find" );
        }

        if( !is_array($methods) ) 
        {
            $methods = array( $methods );
        }

        foreach( $methods as $method ) 
        {
            $this->__settings[$Model->alias][$method] = $enable;
        }
    }

    public function beforeFind($Model, $queryData, $recursive = null)
    {
        if( Configure::read("Publishable.disable") === true ) 
        {
            return $queryData;
        }

        if( $this->__settings[$Model->alias]["find"] && $Model->hasField($this->__settings[$Model->alias]["field"]) ) 
        {
            $Db =& ConnectionManager::getdatasource($Model->useDbConfig);
            $include = false;
            if( !empty($queryData["conditions"]) && is_string($queryData["conditions"]) ) 
            {
                $include = true;
                $fields = array( $Db->name($Model->alias) . "." . $Db->name($this->__settings[$Model->alias]["field"]), $Db->name($this->__settings[$Model->alias]["field"]), $Model->alias . "." . $this->__settings[$Model->alias]["field"], $this->__settings[$Model->alias]["field"] );
                foreach( $fields as $field ) 
                {
                    if( preg_match("/^" . preg_quote($field) . "[\\s=!]+/i", $queryData["conditions"]) || preg_match("/\\x20+" . preg_quote($field) . "[\\s=!]+/i", $queryData["conditions"]) ) 
                    {
                        $include = false;
                        break;
                    }

                }
            }
            else
            {
                if( empty($queryData["conditions"]) || !in_array($this->__settings[$Model->alias]["field"], array_keys($queryData["conditions"])) && !in_array($Model->alias . "." . $this->__settings[$Model->alias]["field"], array_keys($queryData["conditions"])) ) 
                {
                    $include = true;
                }

            }

            if( $include ) 
            {
                if( isset($this->__settings[$Model->alias]["field_date"]) && $Model->hasField($this->__settings[$Model->alias]["field_date"]) ) 
                {
                    $includeDateCondition = true;
                }

                if( empty($queryData["conditions"]) ) 
                {
                    $queryData["conditions"] = array(  );
                }

                if( is_string($queryData["conditions"]) ) 
                {
                    $queryData["conditions"] = $Db->name($Model->alias) . "." . $Db->name($this->__settings[$Model->alias]["field"]) . "= 1 AND " . $queryData["conditions"];
                }
                else
                {
                    $queryData["conditions"][$Model->alias . "." . $this->__settings[$Model->alias]["field"]] = true;
                    if( !empty($includeDateCondition) ) 
                    {
                        $queryData["conditions"][$Model->alias . "." . $this->__settings[$Model->alias]["field_date"] . " <="] = date("Y-m-d H:i");
                    }

                }

            }

            if( is_null($recursive) && !empty($queryData["recursive"]) ) 
            {
                $recursive = $queryData["recursive"];
            }
            else
            {
                if( is_null($recursive) ) 
                {
                    $recursive = $Model->recursive;
                }

            }

            if( $recursive < 0 ) 
            {
                return $queryData;
            }

            $associated = $Model->getAssociated("belongsTo");
            foreach( $associated as $m ) 
            {
                if( $Model->$m->Behaviors->enabled("Publishable") ) 
                {
                    $queryData = $Model->$m->Behaviors->Publishable->beforeFind($Model->$m, $queryData, --$recursive);
                }

            }
        }

        return $queryData;
    }

    public function beforeSave($Model)
    {
        if( $this->__settings[$Model->alias]["find"] ) 
        {
            if( !isset($this->__backAttributes) ) 
            {
                $this->__backAttributes = array( $Model->alias => array(  ) );
            }
            else
            {
                if( !isset($this->__backAttributes[$Model->alias]) ) 
                {
                    $this->__backAttributes[$Model->alias] = array(  );
                }

            }

            $this->__backAttributes[$Model->alias]["find"] = $this->__settings[$Model->alias]["find"];
            $this->enablePublishable($Model, false);
        }

        return true;
    }

    public function afterSave($Model, $created)
    {
        if( isset($this->__backAttributes[$Model->alias]["find"]) ) 
        {
            $this->enablePublishable($Model, "find", $this->__backAttributes[$Model->alias]["find"]);
            unset($this->__backAttributes[$Model->alias]["find"]);
        }

    }

}




?>