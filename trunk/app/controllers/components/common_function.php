<?php 
//
// This source code was recovered by Recover-PHP.com
//


class CommonFunctionComponent extends Object
{
    public function user_current_active_projects($user_id = null, $limit = 4)
    {
        App::import("Model", "Project");
        $projectObj = new Project();
        $projectObj->recursive = false;
        $current_projects = $projectObj->find("all", array( "conditions" => array( "Project.user_id" => $user_id, "Project.active" => 1 ), "limit" => $limit, "fields" => array( "Project.title", "Project.image", "Project.slug" ), "order" => "Project.id desc" ));
        return $current_projects;
    }

    public function user_created_projects($user_id = null, $limit = 4)
    {
        App::import("Model", "Project");
        $projectObj = new Project();
        $projectObj->recursive = false;
        $current_projects = $projectObj->find("all", array( "conditions" => array( "Project.user_id" => $user_id ), "limit" => $limit, "fields" => array( "Project.title", "Project.image", "Project.slug", "Project.created", "Project.id" ), "order" => "Project.id desc" ));
        return $current_projects;
    }

    public function get_last_week_start_end_date()
    {
        $week_start_date = strtotime("-6 days last Sunday");
        $week_end_date = strtotime("last Sunday");
        return $return_range = array( "week_start_date" => $week_start_date, "week_end_date" => $week_end_date );
    }

    public function get_week_range($day = "", $month = "", $year = "")
    {
        if( empty($day) ) 
        {
            $day = date("d");
        }

        if( empty($month) ) 
        {
            $month = date("m");
        }

        if( empty($year) ) 
        {
            $year = date("Y");
        }

        $weekday = date("w", mktime(0, 0, 0, $month, $day - 1, $year));
        $monday = $day - $weekday;
        $start_week = mktime(0, 0, 0, $month, $monday, $year);
        $end_week = mktime(0, 0, 0, $month, $monday + 6, $year);
        if( !empty($start_week) && !empty($end_week) ) 
        {
            return array( "week_start_date" => $start_week, "week_end_date" => $end_week );
        }

        return false;
    }

    public function get_category_subcat_list()
    {
        App::import("Model", "Categories.Category");
        $category_obj = new Category();
        $category_array = array(  );
        $parent_categories = $category_obj->find("all", array( "conditions" => array( "Category.active" => 1, "Category.is_deleted" => 0, "Category.parent_id" => 0 ), "order" => "category_name ASC" ));
        $c = 0;
        foreach( $parent_categories as $parent_category ) 
        {
            $category_array[$c]["Category"]["id"] = $parent_category["Category"]["id"];
            $category_array[$c]["Category"]["category_name"] = $parent_category["Category"]["category_name"];
            $category_array[$c]["Category"]["slug"] = $parent_category["Category"]["slug"];
            $child_categories = $category_obj->find("all", array( "conditions" => array( "Category.active" => 1, "Category.is_deleted" => 0, "Category.parent_id" => $parent_category["Category"]["id"] ), "order" => "category_name" ));
            if( $child_categories ) 
            {
                $s = 0;
                foreach( $child_categories as $child_category ) 
                {
                    $category_array[$c]["Category"]["subcategories"][$s]["id"] = $child_category["Category"]["id"];
                    $category_array[$c]["Category"]["subcategories"][$s]["category_name"] = $child_category["Category"]["category_name"];
                    $category_array[$c]["Category"]["subcategories"][$s]["slug"] = $child_category["Category"]["slug"];
                    $s++;
                }
            }

            $c++;
        }
        return $category_array;
    }

    public function get_category_child_ids($parent_id = null)
    {
        App::import("Model", "Categories.Category");
        $category_obj = new Category();
        $category_array = array(  );
        $parent_categories = $category_obj->find("all", array( "conditions" => array( "Category.active" => 1, "Category.is_deleted" => 0, "Category.parent_id" => $parent_id ), "order" => "category_name ASC" ));
        $c = 0;
        foreach( $parent_categories as $parent_category ) 
        {
            $category_array[] = $parent_category["Category"]["id"];
            $child_categories = $category_obj->find("all", array( "conditions" => array( "Category.active" => 1, "Category.is_deleted" => 0, "Category.parent_id" => $parent_category["Category"]["id"] ), "order" => "category_name" ));
            if( $child_categories ) 
            {
                $s = 0;
                foreach( $child_categories as $child_category ) 
                {
                    $category_array[] = $child_category["Category"]["id"];
                    $s++;
                }
            }

            $c++;
        }
        return $category_array;
    }

    public function get_user_followings($user_id = null, $type = "all", $fields = array(  ))
    {
        App::import("Model", "UserFollow");
        $UserFollowObj = new UserFollow();
        $user_follow_friends = $UserFollowObj->find($type, array( "conditions" => array( "UserFollow.user_id" => $user_id ), "fields" => $fields ));
        return $user_follow_friends;
    }

    public function get_user_blocked_users_list($user_id = null, $type = "list", $fields = array( "BlockedUser.blocked_user_id", "BlockedUser.blocked_user_id" ))
    {
        App::import("Model", "BlockedUser");
        $UserBlockedObj = new BlockedUser();
        $user_blocked_friends = $UserBlockedObj->find($type, array( "conditions" => array( "BlockedUser.user_id" => $user_id ), "fields" => $fields ));
        return $user_blocked_friends;
    }

    public function get_users_to_send_project_comment_notificaition($project_id = null)
    {
        App::import("Model", "Backer");
        $backerObj = new Backer();
        $backers = $backerObj->find("all", array( "conditions" => array( "Backer.project_id" => $project_id, "User.is_opt_out" => 0, "User.notify_created_project_comment" => 1 ), "fields" => array( "Backer.user_id", "Backer.user_id" ) ));
    }

    public function get_users_to_send_project_update_notificaition($project_id = null)
    {
        App::import("Model", "Backer");
        $backerObj = new Backer();
        $backers = $backerObj->find("all", array( "conditions" => array( "Backer.project_id" => $project_id, "User.is_opt_out" => 0, "User.notify_backing_project_update" => 1 ), "fields" => array( "Backer.user_id", "Backer.user_id" ) ));
    }

    public function get_total_pledge_amount($backer_array = array(  ))
    {
        $total_pledge_amount = 0;
        if( !empty($backer_array) ) 
        {
            foreach( $backer_array as $backer ) 
            {
                $total_pledge_amount = $total_pledge_amount + $backer["amount"];
            }
        }

        return $total_pledge_amount;
    }

    public function calculate_amount_for_project_owner($total_pledge_amount = 0, $admin_commission = 0, $paypal_commission = 0)
    {
        $return = array(  );
        $admin_commission_amount = (double) ($total_pledge_amount * $admin_commission / 100);
        $paypal_commission_amount = (double) ($total_pledge_amount * $paypal_commission / 100);
        $amount_to_project_owner = (double) $total_pledge_amount - (double) $admin_commission_amount + (double) $paypal_commission_amount;
        $return["admin_commission_percent"] = $admin_commission;
        $return["admin_commission_amount"] = $admin_commission_amount;
        $return["paypal_commission"] = $paypal_commission;
        $return["paypal_commission_amount"] = $paypal_commission_amount;
        $return["pledge_amount"] = $total_pledge_amount;
        $return["amount_for_project_owner"] = $amount_to_project_owner;
        return $return;
    }

    public function get_city_json_fomrat($data)
    {
        $city_vals = explode("##", $data);
        if( isset($city_vals[1]) && isset($city_vals[2]) && !empty($city_vals[2]) && !empty($city_vals[1]) ) 
        {
            $return["city_id"] = $city_vals[0];
            $return["city_json"] = "{\"id\":\"" . $data . "\",\"name\":\"" . $city_vals[1] . ", " . $city_vals[2] . "\"}";
            $return["country"] = $city_vals[2];
            $return["country_json"] = "";
        }
        else
        {
            App::import("Model", "City");
            $city_obj = new City();
            $city = $city_obj->find("first", array( "conditions" => array( "City.id" => $city_vals[0] ) ));
            $return["city_id"] = $city["City"]["id"];
            $return["city_json"] = "{\"id\":\"" . $city["City"]["id"] . "##" . $city["City"]["name"] . "##" . $city["City"]["iso3166_1"] . "\",\"name\":\"" . $city["City"]["name"] . ", " . $city["City"]["iso3166_1"] . "\"}";
            $return["country"] = $city["City"]["iso3166_1"];
            $return["country_json"] = "";
        }

        return $return;
    }

    public function get_json_to_city_fomrat($data)
    {
        $country_val = explode("##", $data);
        $return = "{id:\"" . $data . "\",\"name\":\"" . $country_val[1] . ", " . $country_val[2] . "\"}";
        return $return;
    }

    public function get_json_to_city_name($data)
    {
        $city_decode = json_decode($data, true);
        $city_info = explode(",", $city_decode["name"]);
        return $city_info[0];
    }

    public function get_project_info($project_id = null, $fields = array(  ))
    {
        App::import("Model", "Project");
        $project_obj = new Project();
        $project = $project_obj->find("first", array( "conditions" => array( "Project.id" => $project_id ), "fields" => $fields ));
        return $project;
    }

}
