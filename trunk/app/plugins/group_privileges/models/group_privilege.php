<?php 
//
// This source code was recovered by Recover-PHP.com
//


class GroupPrivilege extends AppModel
{
    public $name = "GroupPrivilege";
    public $belongsTo = array( "Module" => array( "className" => "Module", "foreignKey" => "module_id" ), "Group" => array( "className" => "Group", "foreignKey" => "group_id" ) );

}




?>