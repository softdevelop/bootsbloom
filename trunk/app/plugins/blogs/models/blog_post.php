<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 */

class BlogPost extends AppModel
{
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "title", "type" => "string" ), array( "name" => "blog_category_id", "type" => "int" ) );
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $belongsTo = array( "BlogCategory" => array( "className" => "BlogCategory", "foreignKey" => "blog_category_id" ) );
    public $hasMany = array( "BlogPostComment" => array( "className" => "BlogPostComment", "foreignKey" => "blog_post_id", "conditions" => array( "BlogPostComment.active" => "1" ), "order" => "BlogPostComment.created DESC" ) );
    public $validate = array(  );
    public $validationSets = array( "comments" => array( "comment" => array( "rule" => "notEmpty", "required" => true, "message" => "model_updatecomment_please_enter_comment" ) ), "add_post" => array( "title" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter title." ), "description" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter description." ), "blog_category_id" => array( "rule" => "notEmpty", "required" => true, "message" => "Please enter blog category id." ) ) );

}




?>