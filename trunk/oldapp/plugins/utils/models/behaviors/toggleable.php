<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Toggleable Behavior
 *
 * @package utils
 * @subpackage utils.models.behaviors
 */

class ToggleableBehavior extends ModelBehavior
{
    public $settings = array(  );
    protected $_defaults = array( "fields" => array(  ), "checkRecord" => true );

    public function setup($Model, $config = array(  ))
    {
        $settings = array_merge($this->_defaults, $config);
        $this->settings[$Model->alias] = $settings;
        if( empty($this->settings[$Model->alias]["fields"]) ) 
        {
            throw InvalidArgumentException(__d("utils", "You need to define at least one field to be toggleable."), E_USER_ERROR);
        }

    }

    public function toggle($Model, $id = null, $field = null)
    {
        extract($this->settings[$Model->alias]);
        if( empty($field) && count($fields) == 1 ) 
        {
            $keys = array_keys($fields);
            $field = $keys[0];
        }

        if( !isset($fields[$field]) ) 
        {
            throw new InvalidArgumentException(sprintf(__d("utils", "The field %s is not in the list of toggleable fields."), $field), E_USER_ERROR);
        }

        if( count($fields[$field]) != 2 ) 
        {
            throw new InvalidArgumentException(sprintf(__d("utils", "The field %s does not have two toggleable states defined."), $field), E_USER_ERROR);
        }

        if( !empty($id) ) 
        {
            $Model->id = $id;
        }

        if( method_exists($Model, "beforeToggle") ) 
        {
            $Model->beforeToggle();
        }

        $currentState = $Model->field($field);
        if( $currentState == $fields[$field][0] ) 
        {
            $newState = $fields[$field][1];
        }
        else
        {
            $newState = $fields[$field][0];
        }

        if( $checkRecord != false && !$Model->exists(true) ) 
        {
            $message = __d("utils", "Invalid record");
            if( is_string($checkRecord) ) 
            {
                $message = $checkRecord;
            }

            throw new Exception($message, E_USER_WARNING);
        }

        if( !$Model->saveField($field, $newState) ) 
        {
            return false;
        }

        if( method_exists($Model, "afterToggle") ) 
        {
            $Model->afterToggle(compact("field", "newState"));
        }

        return $newState;
    }

}




?>