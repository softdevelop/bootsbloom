<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Lookupable Behavior
 *
 * @package utils
 * @subpackage utils.models.behaviors
 */

class LookupableBehavior extends ModelBehavior
{
    public $settings = array(  );
    protected $_defaults = array( "types" => array(  ) );

    public function setup($Model, $settings = array(  ))
    {
        $settings = array_merge($this->_defaults, $settings);
        $this->settings[$Model->alias] = $settings;
    }

    public function findExistingRecord($Model, $modelClass, $name)
    {
        return $Model->$modelClass->find("first", array( "contain" => array(  ), "conditions" => array( $modelClass . "." . $Model->$modelClass->displayField => $name ) ));
    }

    public function saveLookupRecord($Model, $modelClass, $data)
    {
        $Model->$modelClass->create();
        return $Model->$modelClass->save(array( $modelClass => $data ), array( "validate" => false, "callbacks" => true ));
    }

    public function lookup($Model, $type = null, $name = null)
    {
        extract($this->settings[$Model->alias]);
        $type = strtolower($type);
        $modelClass = Inflector::classify($type);
        if( !in_array($modelClass, $types) || empty($name) ) 
        {
            return false;
        }

        $result = $Model->findExistingRecord($modelClass, $name);
        if( empty($result) ) 
        {
            $fieldName = $Model->$modelClass->displayField;
            $data = array( $fieldName => $name );
            if( isset($Model->data[$modelClass]) ) 
            {
                $data = Set::merge($Model->data[$modelClass], $data);
            }

            $result = $Model->saveLookupRecord($modelClass, $data);
            $Model->data[$modelClass]["id"] = $Model->$modelClass->id;
            $Model->data[$modelClass]["name"] = $name;
            $Model->data[$Model->alias][$type . "_id"] = $Model->$modelClass->id;
        }
        else
        {
            $Model->data[$modelClass] = $result[$modelClass];
            $Model->data[$Model->alias][$type . "_id"] = $result[$modelClass]["id"];
        }

        return true;
    }

    public function afterFind($Model, $results, $primary)
    {
        extract($this->settings[$Model->alias]);
        foreach( $results as $key => $record ) 
        {
            foreach( $types as $submodel ) 
            {
                $submodel = Inflector::camelize($submodel);
                $viewField = Inflector::underscore($submodel . "_" . $Model->$submodel->displayField);
                if( isset($record[$submodel][$Model->$submodel->displayField]) ) 
                {
                    $results[$key][$Model->alias][$viewField] = $record[$submodel][$Model->$submodel->displayField];
                }

            }
        }
        return $results;
    }

    public function afterSave($Model, $created)
    {
        extract($this->settings[$Model->alias]);
        $resave = false;
        foreach( $types as $submodel ) 
        {
            $viewField = Inflector::underscore($submodel . "_" . $Model->{Inflector::classify($submodel)}->displayField);
            if( isset($Model->data[$Model->alias][$viewField]) && !empty($Model->data[$Model->alias][$viewField]) && $Model->lookup($submodel, $Model->data[$Model->alias][$viewField]) ) 
            {
                $resave = true;
            }

        }
        if( $resave ) 
        {
            $result = $Model->save($Model->data, array( "validate" => false, "callbacks" => false ));
            $Model->data = $result;
        }

    }

}




?>