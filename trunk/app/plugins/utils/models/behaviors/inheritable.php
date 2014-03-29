<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Inheritable Behavior
 *
 * @package utils
 * @subpackage utils.models.behaviors
 */

class InheritableBehavior extends ModelBehavior
{
    public $settings = array(  );

    public function setup($Model, $config = array(  ))
    {
        $_defaults = array( "inheritanceField" => "type", "method" => "STI", "fieldAlias" => $Model->alias );
        $this->settings[$Model->alias] = array_merge($_defaults, $config);
        $Model->parent = ClassRegistry::init(get_parent_class($Model));
        $Model->inheritanceField = $this->settings[$Model->alias]["inheritanceField"];
        $Model->fieldAlias = $this->settings[$Model->alias]["fieldAlias"];
        if( $this->settings[$Model->alias]["method"] == "CTI" ) 
        {
            $this->classTableBindParent($Model);
        }

    }

    public function beforeFind($Model, $query)
    {
        if( $this->settings[$Model->alias]["method"] == "STI" ) 
        {
            $query = $this->_singleTableBeforeFind($Model, $query);
        }
        else
        {
            if( !empty($query["recursive"]) && $query["recursive"] < 0 ) 
            {
                unset($query["recursive"]);
                $query["contain"] = array( $Model->parent->alias );
            }

            if( !empty($query["contain"]) ) 
            {
                $this->_classTableBindContains($Model, $query["contain"]);
                if( empty($query["contain"][$Model->parent->alias]) && !in_array($Model->parent->alias, $query["contain"]) ) 
                {
                    array_unshift($query["contain"], $Model->parent->alias);
                }

            }

        }

        return $query;
    }

    public function afterFind($Model, $results = array(  ), $primary = false)
    {
        if( $this->settings[$Model->alias] !== "STI" && !empty($results) ) 
        {
            foreach( $results as $i => $res ) 
            {
                if( is_int($i) ) 
                {
                    if( !empty($res[$Model->parent->alias]) && !empty($res[$Model->alias]) ) 
                    {
                        $results[$i][$Model->alias] = array_merge($res[$Model->parent->alias], $res[$Model->alias]);
                        unset($results[$i][$Model->parent->alias]);
                    }
                    else
                    {
                        if( !empty($res[$Model->alias][$Model->parent->alias]) ) 
                        {
                            $results[$i][$Model->alias] = array_merge($res[$Model->alias][$Model->parent->alias], $res[$Model->alias]);
                            unset($results[$i][$Model->alias][$Model->parent->alias]);
                        }
                        else
                        {
                            if( !empty($res[$Model->alias][0]) ) 
                            {
                                foreach( $res[$Model->alias] as $j => $subRes ) 
                                {
                                    if( isset($subRes[$Model->parent->alias]) ) 
                                    {
                                        $results[$i][$Model->alias][$j] = array_merge($subRes[$Model->parent->alias], $subRes);
                                        unset($results[$i][$Model->alias][$j][$Model->parent->alias]);
                                    }

                                }
                            }

                        }

                    }

                }
                else
                {
                    if( $i == $Model->parent->alias ) 
                    {
                        $results = array_merge($results, $res);
                        unset($results[$i]);
                    }
                    else
                    {
                        if( $i == $Model->alias && array_key_exists(0, $res) ) 
                        {
                            foreach( $res as $j => $payload ) 
                            {
                                if( array_key_exists($Model->parent->alias, $payload) ) 
                                {
                                    $results[$i][$j] = array_merge($payload, $payload[$Model->parent->alias]);
                                    unset($results[$i][$j][$Model->parent->alias]);
                                }

                            }
                        }

                    }

                }

            }
        }

        return $results;
    }

    public function beforeSave($Model)
    {
        if( $this->settings[$Model->alias]["method"] == "STI" ) 
        {
            $this->_singleTableBeforeSave($Model);
        }

        return true;
    }

    public function afterSave($Model, $created = false)
    {
        if( $this->settings[$Model->alias]["method"] == "CTI" ) 
        {
            $this->_saveParentModel($Model);
        }

    }

    public function afterDelete($Model)
    {
        if( $this->settings[$Model->alias]["method"] == "CTI" ) 
        {
            $Model->parent->delete($Model->id);
        }

        return true;
    }

    public function beforeValidate($Model)
    {
        if( $this->settings[$Model->alias]["method"] == "CTI" && !empty($Model->parent->validate) ) 
        {
            $Model->validate = Set::merge($Model->parent->validate, $Model->validate);
        }

        return true;
    }

    protected function _singleTableBeforeFind($Model, $query)
    {
        extract($this->settings[$Model->alias]);
        if( isset($Model->_schema[$inheritanceField]) && $Model->alias != $Model->parent->alias ) 
        {
            $field = $Model->alias . "." . $inheritanceField;
            if( !isset($query["conditions"]) ) 
            {
                $query["conditions"] = array(  );
            }
            else
            {
                if( is_string($query["conditions"]) ) 
                {
                    $query["conditions"] = array( $query["conditions"] );
                }

            }

            if( is_array($query["conditions"]) ) 
            {
                if( !isset($query["conditions"][$field]) ) 
                {
                    $query["conditions"][$field] = array(  );
                }

                $query["conditions"][$field] = $fieldAlias;
            }

        }

        return $query;
    }

    protected function _singleTableBeforeSave($Model)
    {
        if( isset($Model->_schema[$Model->inheritanceField]) && $Model->alias != $Model->parent->alias ) 
        {
            if( !isset($Model->data[$Model->alias]) ) 
            {
                $Model->data[$Model->alias] = array(  );
            }

            $Model->data[$Model->alias][$Model->inheritanceField] = $Model->alias;
        }

        return true;
    }

    public function classTableBindParent($Model)
    {
        $bind = array( "belongsTo" => array( $Model->parent->alias => array( "type" => "INNER", "className" => $Model->parent->alias, "foreignKey" => $Model->primaryKey ) ) );
        $success = $Model->bindModel($bind, false);
        $assoc = $Model->belongsTo[$Model->parent->alias];
        unset($Model->belongsTo[$Model->parent->alias]);
        $Model->belongsTo = array_merge(array( $Model->parent->alias => $assoc ), $Model->belongsTo);
        return $success;
    }

    protected function _classTableBindContains($Model, $binds)
    {
        $assocs = array_flip($Model->parent->getAssociated("belongsTo"));
        foreach( $binds as $k => $alias ) 
        {
            if( is_array($alias) ) 
            {
                $alias = $k;
            }

            if( isset($assocs[$alias]) ) 
            {
                $foreignKey = Inflector::underscore($alias) . "_id";
                $bind = array( "belongsTo" => array( $alias => array( "conditions" => "" . $Model->parent->alias . "." . $foreignKey . " = " . $alias . ".id", "foreignKey" => false ) ) );
                $Model->bindModel($bind, true);
            }

        }
    }

    protected function _saveParentModel($Model)
    {
        $fields = array_keys($Model->parent->schema());
        $parentData = array( $Model->parent->primaryKey => $Model->id );
        foreach( $Model->data[$Model->alias] as $key => $value ) 
        {
            if( in_array($key, $fields) ) 
            {
                $parentData[$key] = $value;
            }

        }
        $result = $Model->parent->save($parentData, false);
        if( $result !== false ) 
        {
            $Model->data[$Model->alias] = Set::merge($Model->data[$Model->alias], $result[$Model->parent->alias]);
        }

        return true;
    }

}




?>