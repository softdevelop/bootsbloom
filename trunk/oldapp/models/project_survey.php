<?php 
//
// This source code was recovered by Recover-PHP.com
//


class ProjectSurvey extends AppModel
{
    public $name = "ProjectSurvey";
    public $belongsTo = array( "Project", "Reward", "User" => array( "foreignKey" => "owner_id" ) );
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $validationSets = array( "project_survey" => array( "survey_subject" => array( "rule" => "notEmpty", "message" => "model_survey_please_enter_subject", "required" => true ), "survey_message" => array( "rule" => "notEmpty", "message" => "model_survey_please_enter_message", "required" => true ) ) );

}
