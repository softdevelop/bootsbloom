<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 */

class BlogCategory extends AppModel
{
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "category_name", "type" => "string" ) );
    public $name = "BlogCategory";
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable", "Utils.Sluggable" => array(  ) );
    public $validate = array(  );

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array( "category_name" => array( "required" => array( "rule" => array( "notEmpty" ), "required" => true, "allowEmpty" => false, "message" => __d("blogs", "Please enter blog category name", true) ) ), "description" => array( "required" => array( "rule" => array( "notEmpty" ), "required" => true, "allowEmpty" => false, "message" => __d("blogs", "Please enter blog description", true) ) ) );
    }

    public function category_name($data)
    {
        return "Select category_name from BlogCategories WHERE category_name LIKE '%" . $data["category_name"] . "%'  AND field = 'BlogCategory.category_name' ";
    }

}




?>