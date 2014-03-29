<?php 
//
// This source code was recovered by Recover-PHP.com
//


class Reward extends AppModel
{
    public $name = "Reward";
    public $belongsTo = array( "Project" => array( "className" => "Project", "foreignKey" => "project_id", "counterCache" => true ) );
    public $actsAs = array( "Containable", "MultiValidatable" );
    public $validate = array( "pledge_amount" => array( "rule1" => array( "rule" => "numeric", "message" => "model_project_pledge_amount_must_number", "required" => true ), "rule2" => array( "rule" => "check_pledge_amount", "message" => "model_project_pledge_amount_must_number_1_10000", "last" => true ) ), "description" => array( "rule" => "notEmpty", "message" => "model_project_description_is_required", "required" => true ), "est_delivery_month" => array( "rule" => "notEmpty", "message" => "model_project_delivery_month_required", "required" => true ), "est_delivery_year" => array( "rule" => "notEmpty", "message" => "model_project_delivery_year_required", "required" => true ), "limit_value" => array( "rule1" => array( "rule" => "check_limit_value", "message" => "project_please_enter_limit_value", "last" => true ), "rule2" => array( "rule" => "numeric", "message" => "project_please_enter_limit_interger", "allowEmpty" => true ) ) );

    public function check_limit_value($fields)
    {
        if( isset($this->data["Reward"]["limit"]) && $this->data["Reward"]["limit"] != 0 ) 
        {
            if( empty($this->data["Reward"]["limit_value"]) ) 
            {
                return false;
            }

            return true;
        }

        return true;
    }

    public function check_pledge_amount($fields)
    {
        if( $fields["pledge_amount"] <= 0 ) 
        {
            return false;
        }

        if( preg_match("/[^0-9]/", $fields["pledge_amount"]) ) 
        {
            return false;
        }

        return true;
    }

}
