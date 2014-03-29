<?php 
//
// This source code was recovered by Recover-PHP.com
//


class ProjectCommentThread extends AppModel
{
    public $name = "ProjectCommentThread";
    public $belongsTo = array( "User" => array( "className" => "User", "foreignKey" => "user_id" ) );

}
