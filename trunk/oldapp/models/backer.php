<?php 
//
// This source code was recovered by Recover-PHP.com
//


class Backer extends AppModel
{
    public $name = "Backer";
    public $belongsTo = array( "User" => array( "className" => "User", "foreignKey" => "user_id" ), "Project" => array( "className" => "Project", "foreignKey" => "project_id" ), "Reward" => array( "className" => "Reward" ) );
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $validationSets = array( "pledge" => array( "amount" => array( "rule1" => array( "rule" => "notEmpty", "message" => "backer_project_pledge_amount" ), "rule2" => array( "rule" => "numeric", "message" => "backer_project_valid_pledge_amount" ), "rule3" => array( "rule" => array( "comparison", ">", 0 ), "message" => "backer_project_pledge_amount_should_grater_0" ), "rule4" => array( "rule" => "check_ammount", "message" => "backer_project_pledge_amount_should_integer_grater_0" ) ), "reward_id" => array( "rule1" => array( "rule" => "notEmpty", "message" => "project_payment_please_select_reward" ) ) ) );

    public function check_ammount($field)
    {
        if( $field["amount"] <= 0 ) 
        {
            return false;
        }

        if( preg_match("/[^0-9]/", $field["amount"]) ) 
        {
            return false;
        }

        return true;
    }

}
