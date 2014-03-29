<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 */

class BlogPostComment extends AppModel
{
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "comment", "type" => "string" ) );
    public $name = "BlogPostComment";
    public $belongsTo = array( "BlogPost", "Users.User" );
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable", "Utils.Sluggable" => array( "label" => "comment", "method" => "multibyteSlug" ) );
    public $validate = array(  );

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array( "comment" => array( "required" => array( "rule" => array( "notEmpty" ), "required" => true, "allowEmpty" => false, "message" => __d("blogs", "Please enter comment", true) ) ) );
    }

}




?>