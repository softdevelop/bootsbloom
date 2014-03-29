<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 */

class Newsletter extends NewslettersAppModel
{
    public $name = "Newsletter";
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "title", "type" => "string" ), array( "name" => "subject", "type" => "subquery", "field" => "subject", "method" => "subject", "allowEmpty" => false ) );
    public $validate = array(  );

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array( "title" => array( "rule" => "notEmpty", "message" => "title field cannot be left blank." ), "message" => array( "rule" => "notEmpty", "required" => true, "allowEmpty" => false, "message" => "Message field cannot be left blank.", "last" => true ), "subject" => array( "rule" => "notEmpty", "required" => true, "allowEmpty" => false, "message" => "subject field cannot be left blank.", "last" => true ), "newsletter_images" => array( "rule" => array( "extension", array( "gif", "jpeg", "png", "jpg" ) ), "message" => "Please upload image like gif,jpeg,png,jpg or do not leave blank " ) );
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

    public function title($data)
    {
        return "Select title from Newsletters WHERE title LIKE '%" . $data["title"] . "%'  AND field = 'Newsletter.title'";
    }

    public function subject($data)
    {
        return "Select subject from Newsletters WHERE subject LIKE '%" . $data["subject"] . "%'  ";
    }

}




?>