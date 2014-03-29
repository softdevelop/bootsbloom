<?php 
//
// This source code was recovered by Recover-PHP.com
//


class BlockedUser extends AppModel
{
    public $name = "BlockedUser";
    public $belongsTo = array( 
		"User" => array( 
			"className" => "User", 
			"foreignKey" => "user_id" 
		), 
		"BlockUserInfo" => array( 
			"className" => "User", 
			"foreignKey" => 
			"blocked_user_id" 
		) 
	);

}
