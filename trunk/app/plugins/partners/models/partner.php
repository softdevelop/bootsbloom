<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 */

class Partner extends AppModel
{
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "partner_name", "type" => "string" ) );
    public $name = "Partner";
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array( "partner_name" => array( "multiple" => array( "rule" => array( "multiple" ), "message" => "Please fill curated page name field!" ) ), "partner_site_link" => array( "multiple" => array( "rule" => array( "url", true ), "message" => "Please fill  curated page link field!" ) ), "partner_images" => array( "1" => array( "rule" => "isUploadedFile", "message" => "Please upload image.", "last" => true, "on" => "create" ), "2" => array( "rule" => "isValidFileType", "message" => "Please choose jpg/jpeg/png/gif file format.", "last" => true, "on" => "create" ) ) );
    }

    public function isUploadedFile($params)
    {
        $value = array_shift($params);
        $check = false;
        if( isset($value["error"]) && $value["error"] == 0 || !empty($value["tmp_name"]) && $value["tmp_name"] != "none" ) 
        {
            $check = true;
        }
        else
        {
            $check = false;
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
            if( $value["type"] == "image/jpeg" || $value["type"] == "image/jpg" || $value["type"] == "image/pjpeg" || $value["type"] == "image/png" || $value["type"] == "image/gif" ) 
            {
                return true;
            }

            return false;
        }
    }

    public function partner_name($data)
    {
        return "Select partner_name from parents WHERE value LIKE '%" . $data["partner_name"] . "%'  AND field = 'Parent.partner_name'";
    }

}




?>