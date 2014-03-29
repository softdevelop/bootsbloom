<?php 
//
// This source code was recovered by Recover-PHP.com
//


class ProjectComment extends AppModel
{
    public $name = "Project_comments";
    public $belongsTo = array( "User" => array( "className" => "User", "foreignKey" => "user_id" ) );

}
