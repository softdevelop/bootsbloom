<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 */

class Group extends AppModel
{
    public $name = "Group";
    public $actsAs = array( "Containable", "MultiValidatable" );
    public $validate = array( "name" => array( "rule1" => array( "rule" => "/[A-Za-z ]+/", "message" => "Enter group name.", "required" => true ), "rule2" => array( "rule" => "isUnique", "message" => "This group already exists." ) ) );

}




?>