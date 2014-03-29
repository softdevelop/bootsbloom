<?php 
//
// This source code was recovered by Recover-PHP.com
//


class UserFollow extends AppModel
{
    public $name = "UserFollow";
    public $belongsTo = array( 
		"User" => array( 
			"className" => "User", 
			"foreignKey" => "follow_user_id" 
		), 
		"Following" => array( 
			"className" => "User", 
			"foreignKey" => "user_id" 
		) 
	);

}
