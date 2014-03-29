<?php

class GeneralFunctionsHelper extends AppHelper {
    
    function get_category_dropdown($model, $field_name, $field_id='', $selected_id="", $class='', $style='', $other='') {

        if (empty($field_id) || !isset($field_id)) {
            $field_id = $field_name;
        }

        App::import('Model', 'Categories.Category');
        $category_obj = new Category();
        $str = "";
        $parent_categories = $category_obj->find('all', array('conditions' => array('Category.active' => 1, 'Category.is_deleted' => 0, 'Category.parent_id' => 0), 'order' => 'category_name ASC'));

        $str.="<select name=data[" . $model . "][" . $field_name . "] id='" . $field_id . "' class='" . (is_array($class) ? '' : $class) . "'  " . $style . " $other >";
        $str.="<option value='' >Select Category</option>";
        foreach ($parent_categories as $parent_category) {

            if ($parent_category['Category']['id'] == $selected_id) {
                $selected = "selected='selected'";
            } else {
                $selected = "";
            }

            $str.="<option value='" . $parent_category['Category']['id'] . "' " . $selected . ">" . $parent_category['Category']['category_name'] . "</option>";

            $child_categories = $category_obj->find('all', array('conditions' => array('Category.active' => 1, 'Category.is_deleted' => 0, 'Category.parent_id' => $parent_category['Category']['id']), 'order' => 'category_name'));
            if ($child_categories) {
                foreach ($child_categories as $child_category) {
                    if ($child_category['Category']['id'] == $selected_id) {
                        $selected = "selected='selected'";
                    } else {
                        $selected = "";
                    }
                    $str.="<option value='" . $child_category['Category']['id'] . "' " . $selected . ">" . "----" . $child_category['Category']['category_name'] . "</option>";
                }
            }
        }

        $str.="</select>";

        echo $str;
    }

    /* Return Days Left* */

    function dateDiffTs($start_ts, $end_ts) {
        if ($start_ts < $end_ts) {
            $diff = $end_ts - $start_ts;
            return round($diff / 86400);
        } else {
            return 0;
        }
    }

    function get_remainig_time($start_ts, $end_ts) {
        if ($start_ts < $end_ts) {
            $diff = $end_ts - $start_ts;
            return $diff;
        } else {
            return 0;
        }
    }

    function show_left_time($start_ts, $end_ts) {
        if ($start_ts < $end_ts) {
            $r = $this->dateDiffTs($start_ts, $end_ts);
            if ($r == 0) {
                $diff = $end_ts - $start_ts;
                $time = floor($diff / 3600);
                $unit = 'Hour(s)';
            } else {
                $time = $r;
                $unit = 'Day(s)';
            }
            $result['time'] = $time;
            $result['unit'] = $unit;
            return $result;
        } else {
            $time = 0;
            $unit = 'Hour(s)';
            $result['time'] = $time;
            $result['unit'] = $unit;
            return $result;
        }
    }

    function get_user_profile_image($user_id=null, $height='100px', $width='100px') {
        App::import('Model', 'Users.User');
        $user_obj = new User();
        $get_user_info = $user_obj->find('first', array('conditions' => array('User.id' => $user_id), 'fields' => array('User.fb_image_url', 'User.profile_image')));

        if (!empty($get_user_info['User']['profile_image'])) {
            return WEBSITE_IMG_URL . "image.php?image=" . $get_user_info['User']['profile_image'] . '&amp;height=' . $height . '&amp;width=' . $width;
        } else if (!empty($get_user_info['User']['fb_image_url'])) {
            return $get_user_info['User']['fb_image_url'];
        } else {
            return WEBSITE_IMG_URL . "image.php?image=" . 'missing_user_image.png' . '&height=' . $height . '&width=' . $width;
        }
    }

    function get_user_profile_image_using_user_array($user_array=null, $height='100px', $width='100px') {

        if (!empty($user_array['User']['profile_image'])) {
            return WEBSITE_IMG_URL . "image.php?image=" . $user_array['User']['profile_image'] . '&amp;height=' . $height . '&amp;width=' . $width . '&amp;zc=3';
        } else if (!empty($user_array['User']['fb_image_url'])) {
            return $user_array['User']['fb_image_url'];
        } else {
            return WEBSITE_IMG_URL . "image.php?image=" . 'missing_user_image.png' . '&amp;height=' . $height . '&amp;width=' . $width;
        }
    }

    function show_user_profile_image($user_image_name=null, $height='100px', $width='100px') {
        return WEBSITE_IMG_URL . "image.php?image=" . $user_image_name . '&height=' . $height . '&width=' . $width;
    }

    function get_project_image($project_id=null, $height='100px', $width='100px') {
        App::import('Model', 'Project');
        $project_obj = new Project();
        $get_project_info = $project_obj->find('first', array('conditions' => array('Project.id' => $project_id), 'fields' => array('Project.image')));

        if (!empty($get_project_info['Project']['image'])) {
            return WEBSITE_IMG_URL . "image.php?image=" . stripcslashes($get_project_info['Project']['image']) . '&amp;height=' . $height . '&amp;width=' . $width;
        } else {
            return WEBSITE_IMG_URL . "image.php?image=missing_full.png&amp;height=" . $height . '&amp;width=' . $width;
        }
    }

    function show_project_image($project_image_name=null, $height='100px', $width='100px') {
        if (empty($project_image_name)) {
            return WEBSITE_IMG_URL . "image.php?image=missing_full.png&amp;height=" . $height . '&amp;width=' . $width;
        } else {
            return WEBSITE_IMG_URL . "image.php?image=" . stripcslashes($project_image_name) . '&amp;height=' . $height . '&amp;width=' . $width;
        }
    }

    function get_total_pledge_amount($backer_array=array()) {
        $total_pledge_amount = 0;
        if (!empty($backer_array)) {
            foreach ($backer_array as $backer) {
                $total_pledge_amount = $total_pledge_amount + $backer['amount'];
            }
        }
        return $total_pledge_amount;
    }

    function get_total_pledge_amount_by_project_id($project_id=null) {
        App::import('Model', 'Backer');
        $backer_obj = new Backer();
        $total_pledge_amount = 0;
        $result = $backer_obj->find('first', array('fields' => array('sum(amount) as pledge_amount', 'conditions' => array('Backer.project_id' => $project_id))));
        return $result['pledge_amount'];
        // return $total_pledge_amount;
    }

    function get_total_backer_on_reward($reward_id=null, $backer_array=array()) {
        $backer_on_reward = 0;
        foreach ($backer_array as $backer) {
            if ($reward_id == $backer['reward_id']) {
                $backer_on_reward++;
            }
        }
        return $backer_on_reward;
    }

    function total_backers_left() {
        
    }

    function total_funded_percentage($project_id=null, $project_goal=null, $backer_array=array()) {
        $total_amount_pledge = $this->get_total_pledge_amount($backer_array);
        if ($project_goal > 0) {
            $total_funded_percentage = ($total_amount_pledge / $project_goal) * 100;
        } else {
            $total_funded_percentage = 0;
        }
        return round($total_funded_percentage);
    }

    function get_project_ending_date_format($end_date_time_stamp=null) {
        return date('D M d,h:i a e', $end_date_time_stamp);
    }

    /* Returns a string of the amount of time the integer (in seconds) refers
      to.

      $timeleft=time_left(86400);

      $timeleft='1 day'.

      Will not return anything higher than weeks. False if $integer=0 or fails.

     */

    function time_left($integer) {

        $seconds = $integer;

        if ($seconds / 60 >= 1) {

            $minutes = floor($seconds / 60);

            if ($minutes / 60 >= 1) { # Hours 
                $hours = floor($minutes / 60);

                if ($hours / 24 >= 1) { #days 
                    $days = floor($hours / 24);

                    if ($days / 7 >= 1) { #weeks 
                        $weeks = floor($days / 7);

                        if ($weeks >= 2)
                            $return = "$weeks Weeks";

                        else
                            $return="$weeks Week";
                    } #end of weeks 

                    $days = $days - (floor($days / 7)) * 7;

                    if ($weeks >= 1 && $days >= 1)
                        $return = "$return, ";

                    if ($days >= 2)
                        $return = "$return $days days";

                    if ($days == 1)
                        $return = "$return $days day";
                } #end of days

                $hours = $hours - (floor($hours / 24)) * 24;

                if ($days >= 1 && $hours >= 1)
                    $return = "$return, ";

                if ($hours >= 2)
                    $return = "$return $hours hours";

                if ($hours == 1)
                    $return = "$return $hours hour";
            } #end of Hours

            $minutes = $minutes - (floor($minutes / 60)) * 60;

            if ($hours >= 1 && $minutes >= 1)
                $return = "$return, ";

            if ($minutes >= 2)
                $return = "$return $minutes minutes";

            if ($minutes == 1)
                $return = "$return $minutes minute";
        } #end of minutes 

        $seconds = $integer - (floor($integer / 60)) * 60;

        if ($minutes >= 1 && $seconds >= 1)
            $return = "$return, ";

        if ($seconds >= 2)
            $return = "$return $seconds seconds";

        if ($seconds == 1)
            $return = "$return $seconds second";

        $return = "$return.";

        return $return;
    }

    function get_user_backed_projects($user_id=null) {
        App::import('Model', 'Backer');
        $backer_obj = new Backer();
        $user_backed_projects = $backer_obj->find('count', array('conditions' => array('Backer.user_id' => $user_id), 'group_by' => 'Backer.project_id'));
        return $user_backed_projects;
    }
	
    function get_user_created_projects($user_id=null) {
        App::import('Model', 'Project');
        $created_obj = new Project();
        $user_created_projects = $created_obj->find('count', array('conditions' => array('Project.user_id' => $user_id)));
        return $user_created_projects;
    }
    
    /**
     * Function to get count of Launched projects (which are approved and not cancelled by admin) 
     */
    
    function get_user_launched_projects($user_id=null) {
        App::import('Model', 'Project');
        $created_obj = new Project();
        $user_created_projects = $created_obj->find('count', array('conditions' => array('Project.user_id' => $user_id,'Project.active' => 1)));
        return $user_created_projects;
    }

    function get_user_info($user_id=null, $fields=array(), $user_img_height='40px', $user_img_width='40px') {
        App::import('Model', 'Users.User');
        $user_obj = new User();
        $user = $user_obj->find('first', array('conditions' => array('User.id' => $user_id), 'fields' => $fields));
        
        if($user)
        {
            if ((array_key_exists('profile_image', $user['User']) && array_key_exists('fb_image_url', $user['User']))) {
                $user['User']['profile_image_url'] = $this->get_user_profile_image_using_user_array($user, $user_img_height, $user_img_width);
            }
        }

        return $user;
    }

    function get_project_info($project_id=null, $fields=array()) {
        App::import('Model', 'Project');
        $project_obj = new Project();
        $project = $project_obj->find('first', array('conditions' => array('Project.id' => $project_id), 'fields' => $fields));

        return $project;
    }

    function get_blog_post_info($post_id=null, $fields=array()) {
        App::import('Model', 'blogs.BlogPost');
        $blogPostObj = new BlogPost();
        $post_info = $blogPostObj->find('first', array('conditions' => array('BlogPost.id' => $post_id), 'fields' => $fields));

        return $post_info;
    }

    function get_friends_from_backer($project_id=null, $friends=array(), $backers=array()) {
        $backer_array = array();
        foreach ($backers as $backer) {
            $backer_array[$backer['user_id']] = $backer['user_id'];
        }
        $friends_backed = array_intersect($friends, $backer_array);
        return $friends_backed;
    }

    /**
     * Function to get pages content by there ids arrange them on position basis
     */
    function get_page_content_by_id($ids =array(), $fields=array()) {
        App::import('Model', 'Pages.Page');
        $page_obj = new Page();
        $pages = $page_obj->find('all', array('conditions' => array('Page.id' => $ids), 'fields' => $fields, 'order' => 'Page.position asc'));
        return $pages;
    }

    function get_json_to_city_name($data) {
        $return = array('id' => '', 'city_name' => '', 'country_name' => '');
        if (!empty($data)) {
            $city_decode = json_decode($data, true);
            if (key_exists('id', $city_decode)) {
                $city_info = explode("##", $city_decode['id']);
                $return['id'] = $city_info[0];
                $return['city_name'] = $city_info[1];
                $return['country_name'] = $city_info[2];
            }
        }
        return $return;
    }

    /* Function to get all unread messages*/
    
    function get_unread_messages($user_id=0) {
          App::import('Model', 'Messages.Message');
          $message_obj  =   new Message();
          $unread_messages  =  $message_obj->find('count',array('conditions'=>array('Message.is_notified'=>0,'Message.to_user_id'=>$user_id)));
          return $unread_messages;
    }
    
    /* Function to get all unread notifications*/
    function get_unread_notifications($user_id=0) {
        App::import('Model', 'Notification');
          $notification_obj  =   new Notification();
          $unread_notifications  =  $notification_obj->find('count',array('conditions'=>array('Notification.is_read'=>0,'Notification.user_id'=>$user_id)));
          return $unread_notifications;
    }
	
	
	 /* Function to get project title*/
    function get_project_title($id=0,$flag=0) {
		App::import('Model', 'Project');
        $project_obj = new Project();
        $project_array = $project_obj->find('first', array('conditions' => array('Project.id' => $id), 'fields'=>'Project.title, Project.slug'));
		if($flag==1)
		return $project_array['Project']['slug'];
		else		
		return $project_array['Project']['title'];
    }
	
	 /* Function to get total comments from a use*/
    function get_usertotal_comments($id) {
		App::import('Model', 'ProjectComment');
		$projectComment_obj = new ProjectComment();
		$data	=	$projectComment_obj->find('count',array('conditions' => array('Project_comments.user_id' =>$id)));
		return $data;
    }
	
}
