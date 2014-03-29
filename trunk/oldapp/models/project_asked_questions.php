<?php 
//
// This source code was recovered by Recover-PHP.com
//


class ProjectAskedQuestions extends AppModel
{
    public $name = "ProjectAskedQuestions";
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $validationSets = array( "project_faq" => array( "question" => array( "rule" => "notEmpty", "message" => "model_askquestion_please_enter_question" ), "answer" => array( "rule" => "notEmpty", "message" => "model_askquestion_please_enter_answer" ) ) );

}
