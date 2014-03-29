<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Keyvalue Behavior
 *
 * @package utils
 * @subpackage utils.models.behaviors
 */

class KeyvalueBehavior extends ModelBehavior
{
    public $settings = array(  );
    protected $_defaults = array( "foreignKey" => "user_id" );

    public function setup($model, $config = array(  ))
    {
        $settings = array_merge($this->_defaults, $config);
        $this->settings[$model->alias] = $settings;
    }

    public function getSection($Model, $foreignKey = null, $section = null)
    {
        $Model->recursive = 0 - 1;
        $results = $Model->find("all", array( "conditions" => array( $this->settings[$model->alias]["foreignKey"] => $foreignKey ) ), array( "fields" => array( "field", "value" ) ));
        foreach( $results as $result ) 
        {
            $details[] = array( "field" => $result[$model->alias]["field"], "value" => $result[$model->alias]["value"] );
        }
        $detailArray = array(  );
        foreach( $details as $value ) 
        {
            $key = preg_split("/\\./", $value["field"], 2);
            $detailArray[$key[0]][$key[1]] = $value["value"];
        }
        return $detailArray[$section];
    }

    public function saveSection($Model, $foreignKey = null, $data = null, $section = null)
    {
        foreach( $data as $model => $details ) 
        {
            foreach( $details as $key => $value ) 
            {
                $newDetail = array(  );
                $Model->recursive = 0 - 1;
                $tmp = $this->find("first", array( "conditions" => array( $this->settings[$model->alias]["foreignKey"] => $foreignKey, "field" => $section . "." . $key ), "fields" => array( "id" ) ));
                $newDetail[$Model->alias]["id"] = $tmp[$model->alias]["id"];
                $newDetail[$Model->alias]["field"] = $section . "." . $key;
                $newDetail[$Model->alias]["value"] = $value;
                $this->save($newDetail);
            }
        }
    }

}




?>