<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Categories Plugin Category Model
 *
 * @package categories
 * @subpackage categories.models
 */

class Category extends CategoriesAppModel
{
    public $name = "Category";
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "category_name", "type" => "string" ), array( "name" => "parent_id", "type" => "value" ) );
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $validationSets = array( "admin_add_category" => array( "category_name" => array( "valid" => array( "rule" => "notEmpty", "required" => true, "allowEmpty" => false, "message" => "Please enter category name." ), "duplicate" => array( "rule" => "isUnique", "on" => "create", "message" => "Please enter a unique name." ) ) ), "admin_edit_category" => array( "category_name" => array( "valid" => array( "rule" => "notEmpty", "required" => true, "allowEmpty" => false, "message" => "Please enter category name." ), "duplicate" => array( "rule" => "isUnique", "on" => "create", "message" => "Please enter a unique name." ) ) ) );

    public function get_parent_category_list()
    {
        $parent_category_list = $this->find("list", array( "fields" => array( "id", "category_name" ), "conditions" => array( "parent_id" => 0 ) ));
        return $parent_category_list;
    }

}




?>