<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 */

class Emaillog extends AppModel
{
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "subject", "type" => "string" ), array( "name" => "email_to", "type" => "subquery", "field" => "email_to", "method" => "email_to", "allowEmpty" => false ), array( "name" => "email_from", "type" => "subquery", "field" => "email_from", "method" => "email_from", "allowEmpty" => false ) );
    public $name = "Emaillog";
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable", "Utils.Sluggable" => array( "label" => "subject", "method" => "multibyteSlug" ) );
    public $validate = array(  );

    public function subject($data)
    {
        return "Select subject from emaillogs WHERE subject LIKE '%" . $data["subject"] . "%'  AND field = 'Emaillogs.subject' ";
    }

    public function email_to($data)
    {
        return "Select email_to from emaillogs WHERE email_to LIKE '%" . $data["email_to"] . "%'   ";
    }

    public function email_from($data)
    {
        return "Select email_from from emaillogs WHERE email_to LIKE '%" . $data["email_from"] . "%'   ";
    }

}




?>