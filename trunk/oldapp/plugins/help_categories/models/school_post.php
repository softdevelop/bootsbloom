<?php 
//
// This source code was recovered by Recover-PHP.com
//


class SchoolPost extends AppModel
{
    public $name = "SchoolPost";
    public $useTable = "help_posts";
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "post_title", "type" => "string" ) );
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $belongsTo = array( "HelpCategory" => array( "className" => "HelpCategory", "foreignKey" => "parent_id" ) );
    public $validationSets = array( "admin_add_post" => array( "post_title" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter post title." ), "description" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter post description." ) ), "admin_add_post_hy" => array( "post_title_hy" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter post title1." ), "description_hy" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter post description." ) ) );

}




?>