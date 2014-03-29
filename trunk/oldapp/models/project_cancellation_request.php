<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Project Cancellation Request Model
 *
 * */

class ProjectCancellationRequest extends AppModel
{
    public $name = "ProjectCancellationRequest";
    public $belongsTo = array( "Project" => array( "className" => "Project", "foreignKey" => "project_id", "counterCache" => true ) );
    public $actsAs = array( "Containable", "MultiValidatable" );
    public $_findMethods = array( "search" => true );
    public $filterArgs = array(  );

}
