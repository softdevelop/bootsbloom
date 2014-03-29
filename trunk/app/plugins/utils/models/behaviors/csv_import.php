<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Csv Import Behavior
 *
 * @package utils
 * @subpackage utils.models.behaviors
 */

class CsvImportBehavior extends ModelBehavior
{
    public $settings = array(  );
    public $errors = array(  );
    protected $_subscribers = array(  );

    public function setup($Model, $settings = array(  ))
    {
        if( !isset($this->settings[$Model->alias]) ) 
        {
            $this->settings[$Model->alias] = array( "delimiter" => ";", "enclosure" => "\"", "hasHeader" => true );
        }

        $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);
    }

    protected function _getCSVLine($Model, $handle)
    {
        if( $handle->eof() ) 
        {
            return false;
        }

        return $handle->fgetcsv($this->settings[$Model->alias]["delimiter"], $this->settings[$Model->alias]["enclosure"]);
    }

    protected function _getHeader($Model, $handle)
    {
        if( $this->settings[$Model->alias]["hasHeader"] === true ) 
        {
            $header = $this->_getCSVLine($Model, $handle);
        }
        else
        {
            $header = array_keys($Model->schema());
        }

        return $header;
    }

    public function importCSV($Model, $file, $fixed = array(  ), $returnSaved = false)
    {
        $handle = new SplFileObject($file, "rb");
        $header = $this->_getHeader($Model, $handle);
        $db = $Model->getDataSource();
        $db->begin($Model);
        $saved = array(  );
        for( $i = 0; ($row = $this->_getCSVLine($Model, $handle)) !== false; $i++ ) 
        {
            $data = array(  );
            foreach( $header as $k => $col ) 
            {
                if( strpos($col, ".") !== false ) 
                {
                    list($model, $field) = explode(".", $col);
                    $data[$model][$field] = isset($row[$k]) ? $row[$k] : "";
                }
                else
                {
                    $data[$Model->alias][$col] = isset($row[$k]) ? $row[$k] : "";
                }

            }
            $data = Set::merge($data, $fixed);
            $Model->create();
            $Model->id = isset($data[$Model->alias][$Model->primaryKey]) ? $data[$Model->alias][$Model->primaryKey] : false;
            if( method_exists($Model, "beforeImport") ) 
            {
                $data = $Model->beforeImport($data);
            }

            $error = false;
            $Model->set($data);
            if( !$Model->validates() ) 
            {
                $this->errors[$Model->alias][$i]["validation"] = $Model->validationErrors;
                $error = true;
                $this->_notify($Model, "onImportError", $this->errors[$Model->alias][$i]);
            }

            if( !$error && !$Model->saveAll($data, array( "validate" => false, "atomic" => false )) ) 
            {
                $this->errors[$Model->alias][$i]["save"] = sprintf(__d("utils", "%s for Row %d failed to save."), $Model->alias, $i);
                $error = true;
                $this->_notify($Model, "onImportError", $this->errors[$Model->alias][$i]);
            }

            if( !$error ) 
            {
                $this->_notify($Model, "onImportRow", $data);
                if( $returnSaved ) 
                {
                    $saved[] = $i;
                }

            }

        }
        $success = empty($this->errors);
        if( !$returnSaved && !$success ) 
        {
            $db->rollback($Model);
            return false;
        }

        $db->commit($Model);
        if( $returnSaved ) 
        {
            return $saved;
        }

        return true;
    }

    public function getImportErrors($Model)
    {
        if( empty($this->errors[$Model->alias]) ) 
        {
            return array(  );
        }

        return $this->errors[$Model->alias];
    }

    public function attachImportListener($Model, $listener)
    {
        $this->_subscribers[$Model->alias][] = $listener;
    }

    protected function _notify($Model, $action, $data = null)
    {
        if( empty($this->_subscribers[$Model->alias]) ) 
        {
            return NULL;
        }

        foreach( $this->_subscribers[$Model->alias] as $object ) 
        {
            if( method_exists($object, $action) ) 
            {
                $object->$action($data);
            }

            if( is_callable($object) ) 
            {
                call_user_func($object, $action, $data);
            }

        }
    }

}




?>