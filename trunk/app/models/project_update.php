<?php 
//
// This source code was recovered by Recover-PHP.com
//


class ProjectUpdate extends AppModel
{
    public $name = "ProjectUpdate";
    public $belongsTo = array( "Project", "User" );
    public $hasMany = array( "ProjectUpdateComment" => array( "className" => "ProjectUpdateComment", "foreignKey" => "update_id" ) );
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $validationSets = array( "project_update" => array( "title" => array( "rule" => "notEmpty", "message" => "model_update_please_enter_title", "required" => true ), "description" => array( "rule" => "notEmpty", "message" => "model_update_please_enter_description", "required" => true ) ) );

}
