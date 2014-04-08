<?php 
//
// This source code was recovered by Recover-PHP.com
//


class Project extends AppModel
{
    public $name = "Project";
    public $belongsTo = array( "User" => array( "className" => "User", "foreignKey" => "user_id" ), "Category" => array( "className" => "Category" ) );
    public $hasMany = array( "Reward" => array( "order" => "pledge_amount asc" ), "Backer" => array(  ), "ProjectAskedQuestion" => array( "conditions" => "ProjectAskedQuestion.answer!=\"\"" ), "ProjectSurvey" => array( "order" => "created desc" ) );
    public $_findMethods = array( "search" => true );
    public $filterArgs = array( array( "name" => "title", "type" => "string" ) );
    public $actsAs = array( "Containable", "MultiValidatable", "Search.Searchable" );
    public $validationSets = array( "basic_tab" => array( "title" => array( "rule" => "/[A-Za-z ]+/", "message" => "model_project_project_title_require", "required" => true ), "category_id" => array( "rule" => "notEmpty", "message" => "model_project_category_require", "required" => true ), "short_description" => array( "rule" => "notEmpty", "message" => "model_project_short_blurb_require", "required" => true ), "project_city" => array( "rule" => "notEmpty", "message" => "model_project_location_is_require", "required" => true ), "end_date" => array( "rule" => "check_goal_date", "message" => "model_project_date_less_30_days" ), "duration_type" => array( "rule1" => array( "rule" => "check_funding_duration", "message" => "model_project_days_should_less_30_days" ) ), "funding_goal" => array( "rule" => "check_goal", "message" => "model_project_funding_should_garter_0" ) ), "story_tab" => array( "description" => array( "rule" => "check_description", "message" => "model_project_enter_project_description" ) ), "stared_project" => array( "email" => array( "rule" => array( "email", true ), "message" => "model_project_please_enter_email" ) ), "backer_comment" => array( "comment" => array( "rule" => "notEmpty", "message" => "model_updatecomment_please_enter_comment" ) ), "creator_reply" => array( "message" => array( "rule" => "notEmpty", "message" => "model_updatecomment_please_enter_reply" ) ), "project_faq" => array( "question" => array( "rule" => "notEmpty", "message" => "Please enter question." ), "answer" => array( "rule" => "notEmpty", "message" => "Please enter answer." ) ) );

    public function check_funding_duration($field)
    {
        if( $field["duration_type"] == "no_of_days" ) 
        {
            if( empty($this->data["Project"]["no_of_day"]) ) 
            {
                return false;
            }

            if( $this->data["Project"]["no_of_day"] < 1 || 29 <= $this->data["Project"]["no_of_day"] ) 
            {
                return false;
            }

            return true;
        }

        return true;
    }

    public function check_goal($field)
    {
        if( $field["funding_goal"] <= 0 ) 
        {
            return false;
        }

        if( preg_match("/[^0-9]/", $field["funding_goal"]) ) 
        {
            return false;
        }

        return true;
    }

    public function check_goal_date($field)
    {
        if( $this->data["Project"]["duration_type"] == "date_and_time" ) 
        {
            $date = $this->get_end_date_to_time($field["end_date"]);
            $start_ts = time();
            $diff = $date - $start_ts;
            $days = round($diff / 86400);
            if( empty($field["end_date"]) ) 
            {
                return false;
            }

            if( 29 <= $days ) 
            {
                return false;
            }

            return true;
        }

        return true;
    }

    public function check_description($field)
    {
        if( empty($field["description"]) ) 
        {
            return false;
        }

        return true;
    }

    public function get_end_date_to_time($end_date)
    {
        $time = strtotime($end_date);
        return $time;
    }

    public function get_time_to_date($end_time)
    {
        return date("m/d/Y H:i", $end_time);
    }

    public function get_end_date_by_days($days)
    {
        $time = mktime(23, 59, 59, date("m"), date("d") + $days, date("Y"));
        return $time;
    }
    
    public function get_total_pledge_amount($backer_array=array()) {
        $total_pledge_amount = 0;
        if (!empty($backer_array)) {
            foreach ($backer_array as $backer) {
                $total_pledge_amount = $total_pledge_amount + $backer['amount'];
            }
        }
        return $total_pledge_amount;
    }
}
