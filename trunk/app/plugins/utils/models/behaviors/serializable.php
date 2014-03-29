<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Serializeable Behavior
 *
 * @package utils
 * @subpackage utils.models.behaviors
 */

class SerializableBehavior extends ModelBehavior
{
    public $settings = array(  );
    protected $_defaults = array( "engine" => "serialize", "field" => array(  ) );

    public function setup($Model, $config = array(  ))
    {
        $settings = array_merge($this->_defaults, $config);
        if( !is_array($settings["field"]) ) 
        {
            $settings["field"] = array( $settings["field"] );
        }

        $this->settings[$Model->alias] = $settings;
    }

    public function afterFind($Model, $results, $primary = false)
    {
        if( !empty($results) ) 
        {
            foreach( $results as $key => $result ) 
            {
                $results[$key] = $Model->deserialize($result);
            }
        }

        return $results;
    }

    public function beforeSave($Model, $options = array(  ))
    {
        $Model->data = $Model->serialize($Model->data);
        return true;
    }

    public function serialize($Model, $data)
    {
        if( empty($data[$Model->alias]) ) 
        {
            return $data;
        }

        $fields = $this->settings[$Model->alias]["field"];
        $engine = $this->settings[$Model->alias]["engine"];
        if( !empty($data[$Model->alias][0]) && array_intersect_key($fields, array_keys($data[$Model->alias][0])) ) 
        {
            foreach( $data[$Model->alias] as $key => $model ) 
            {
                $model = $Model->serialize(array( $Model->alias => $model ));
                $data[$Model->alias][$key] = $model[$Model->alias];
            }
        }
        else
        {
            foreach( $fields as $field ) 
            {
                if( isset($data[$Model->alias][$field]) && is_array($data[$Model->alias][$field]) ) 
                {
                    if( $engine == "json" ) 
                    {
                        $data[$Model->alias][$field] = @json_encode($data[$Model->alias][$field]);
                    }
                    else
                    {
                        $data[$Model->alias][$field] = @serialize($data[$Model->alias][$field]);
                    }

                }

            }
        }

        return $data;
    }

    public function deserialize($Model, $data)
    {
        if( empty($data[$Model->alias]) ) 
        {
            return $data;
        }

        $fields = $this->settings[$Model->alias]["field"];
        $engine = $this->settings[$Model->alias]["engine"];
        foreach( $fields as $field ) 
        {
            if( !empty($data[$Model->alias][$field]) ) 
            {
                if( is_string($data[$Model->alias][$field]) ) 
                {
                    if( $engine == "json" ) 
                    {
                        $data[$Model->alias][$field] = @json_decode($data[$Model->alias][$field], true);
                    }
                    else
                    {
                        $data[$Model->alias][$field] = @unserialize($data[$Model->alias][$field]);
                    }

                    if( $data[$Model->alias][$field] === false ) 
                    {
                        $data[$Model->alias][$field] = array(  );
                    }

                }

            }
            else
            {
                if( array_key_exists($field, $data[$Model->alias]) ) 
                {
                    $data[$Model->alias][$field] = array(  );
                }

            }

        }
        return $data;
    }

}




?>