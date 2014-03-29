<?php 
//
// This source code was recovered by Recover-PHP.com
//


class ProjectUpdateComment extends AppModel
{
    public $name = "ProjectUpdateComment";
    public $belongsTo = array( "User" => array( "className" => "User", "foreignKey" => "user_id" ) );
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $validationSets = array( "project_update_comment" => array( "comment" => array( "rule" => "notEmpty", "message" => "model_updatecomment_please_enter_comment", "required" => true ) ) );

}
