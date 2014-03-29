<?php 
//
// This source code was recovered by Recover-PHP.com
//


class School extends AppModel
{
    public $name = "School";
    public $useTable = "help_categories";
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "category_name", "type" => "string" ) );
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $validationSets = array( "admin_add_category" => array( "category_name" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter category name." ), "category_name_hy" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter category name." ), "category_image" => array( "rule" => array( "extension", array( "gif", "jpeg", "png", "jpg" ) ), "message" => "Please upload image like gif,jpeg,png,jpg or do not leave blank ", "required" => true ) ), "admin_edit_category" => array( "category_name" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter category name." ), "category_name_hy" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter category name." ), "category_image" => array( "rule" => array( "extension", array( "gif", "jpeg", "png", "jpg" ) ), "message" => "Please upload image like gif,jpeg,png,jpg or do not leave blank" ) ) );

}




?>