<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

class Staticimage extends AppModel
{
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "caption", "type" => "string" ) );
    public $name = "Staticimage";
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $validate = array(  );

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array( "caption" => array( "multiple" => array( "rule" => array( "multiple" ), "message" => "Please fill  caption field!" ) ), "File" => array( "1" => array( "rule" => "isUploadedFile", "message" => "Please upload image.", "last" => true, "on" => "create" ), "2" => array( "rule" => "isValidFileType", "message" => "Please choose jpg/jpeg/png/gif file format.", "last" => true, "on" => "create" ) ) );
    }

    public function isUploadedFile($params)
    {
        $val = array_shift($params);
        $check = false;
        foreach( $val as $value ) 
        {
            if( isset($value["error"]) && $value["error"] == 0 || !empty($value["tmp_name"]) && $value["tmp_name"] != "none" ) 
            {
                $check = true;
            }
            else
            {
                $check = false;
            }

        }
        return $check;
    }

    public function isValidFileType($field)
    {
        if( is_array($field) ) 
        {
            $val = array_values($field);
        }
        else
        {
            $val = $field;
        }

        foreach( $val as $value ) 
        {
            if( $value[0]["type"] == "image/jpeg" || $value[0]["type"] == "image/jpg" || $value[0]["type"] == "image/pjpeg" || $value[0]["type"] == "image/png" || $value[0]["type"] == "image/gif" ) 
            {
                return true;
            }

            return false;
        }
    }

    public function caption($data)
    {
        return "Select caption from staticimages WHERE value LIKE '%" . $data["caption"] . "%'  AND field = 'Staticimage.caption' ";
    }

}




?>