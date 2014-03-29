<?php 
//
// This source code was recovered by Recover-PHP.com
//


class Faq extends AppModel
{
    public $name = "Faq";
    public $useTable = "help_categories";
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "category_name", "type" => "string" ) );
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $validationSets = array( "admin_add_category" => array( "category_name" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter category name." ), "category_name_hy" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter category name." ) ), "admin_edit_category" => array( "category_name" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter category name." ), "category_name_hy" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter category name in Armenian." ) ) );

}




?>