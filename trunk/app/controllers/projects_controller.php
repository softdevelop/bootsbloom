<?php 
//
// This source code was recovered by Recover-PHP.com
//


class ProjectsController extends AppController
{
    public $name = "Projects";
    public $helpers = array( "Time", "Editor" );
    public $uses = array( 
		"Project", 
		"Pages.Page", 
		"Users.User", 
		"Categories.Category", 
		"Reward", 
		"Country", 
		"StaredProject", 
		"Backer", 
		"PaymentLog", 
		"ProjectComment", 
		"ProjectUpdate", 
		"ProjectAskedQuestions", 
		"Emaillog", 
		"UserActivity", 
		"Rewards", 
		"ProjectTransaction", 
		"ProjectSurvey", 
		"ProjectCancellationRequest", 
        "Notification"
	);
    public $paginate = NULL;
    public $components = array( "RequestHandler" );
    public $presetVars = array( array( "field" => "title", "type" => "value" ) );
    public $title = array( "Projects.Project" );

    public function beforeFilter()
    {
        parent::beforefilter();
        $this->set("model", $this->modelClass);
        if( !Configure::read("App.defaultEmail") ) 
        {
            Configure::write("App.defaultEmail", Configure::read("noreply_email.email"));
        }

        if( !isset($this->params["prefix"]) ) 
        {
            $this->Auth->allow("detail", "save_project_image", "save_project_video", "remove_project_video", "get_countries", "widget", "draft", "stared_project", "delete_stared_project", "project_backers", "backer_comment", "ProjectUpdate", "updates", "project_update_detail", "discover", "index", "staff_picks", "category_projects", "reauthorize_payment_token", "get_city", "show_all_reply");
        }

    }

    public function admin_dashboard()
    {
    }

    public function admin_index($user_id = null)
    {
        if( !empty($this->data) && isset($this->data["recordsPerPage"]) ) 
        {
            $limitValue = $limit = $this->data["recordsPerPage"];
            $this->Session->write($this->title . "." . $this->action . ".recordsPerPage", $limit);
        }
        else
        {
            $this->Prg->commonProcess();
        }

        $limitValue = $limit = $this->Session->read($this->title . "." . $this->action . ".recordsPerPage") ? $this->Session->read($this->title . "." . $this->action . ".recordsPerPage") : Configure::read("defaultPaginationLimit");
        $this->set("limitValue", $limitValue);
        $this->set("limit", $limit);
        $projec_condition = "1";
        $project_filter = array( 
			"1" => "All Projects", 
			"2" => "Funded Projects", 
			"3" => "Success Projects", 
			"4" => "Approved Projects", 
			"5" => "Unapproved Projects", 
			"6" => "Pending Projects", 
			"7" => "Recommended Projects" 
		);
        if( isset($this->params["form"]["filters"]) ) 
        {
            $this->passedArgs["searchFor"] = $this->params["form"]["filters"];
        }

        if( isset($this->passedArgs["searchFor"]) && $this->passedArgs["searchFor"] != "" ) 
        {
            $projec_condition = $this->passedArgs["searchFor"];
        }

        $this->set("project_filter", $project_filter);
        $this->set("projec_condition", $projec_condition);
        $condition = array(  );
        if( !isset($ser_id) ) 
        {
            switch( $projec_condition ) 
            {
                case "2":
                    $condition = array( "Project.is_funded" => "1" );
                    break;
                case "3":
                    $condition = array( "Project.is_successful" => "1" );
                    break;
                case "4":
                    $condition = array( "Project.active" => "1" );
                    break;
                case "5":
                    $condition = array( "Project.active" => "2" );
                    break;
                case "6":
                    $condition = array( "Project.active" => "0" );
                    break;
                case "7":
                    $condition = array( "Project.is_recommended" => "1" );
                    break;
                default:
                    break;
            }
        }
        else
        {
            switch( $projec_condition ) 
            {
                case "2":
                    $condition = array( "Project.is_funded" => "1", "Project.user_id" => $user_id );
                    break;
                case "3":
                    $condition = array( "Project.is_successful" => "1", "Project.user_id" => $user_id );
                    break;
                case "4":
                    $condition = array( "Project.active" => "1", "Project.user_id" => $user_id );
                    break;
                case "5":
                    $condition = array( "Project.active" => "2", "Project.user_id" => $user_id );
                    break;
                case "6":
                    $condition = array( "Project.active" => "0", "Project.user_id" => $user_id );
                    break;
                default:
                    break;
            }
        }

        $this->{$this->modelClass}->data[$this->modelClass] = $this->passedArgs;
        $parsedConditions = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
        $this->paginate[$this->modelClass]["limit"] = $limit;
        if( !isset($user_id) ) 
        {
            if( $projec_condition != 5 ) 
            {
                $this->paginate[$this->modelClass]["conditions"] = $parsedConditions + array( $this->modelClass . ".submitted_status" => "1" );
            }
            else
            {
                $this->paginate[$this->modelClass]["conditions"] = $parsedConditions;
            }

        }
        else
        {
            $this->paginate[$this->modelClass]["conditions"] = $parsedConditions + array( $this->modelClass . ".submitted_status" => "1", $this->modelClass . ".user_id" => $user_id );
            $this->set("user_id", $user_id);
            $user_name = $this->User->find("first", array( "conditions" => array( "User.id" => $user_id ) ));
            $this->set("project_owner", $user_name["User"]["name"]);
        }

        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".modified" => "desc" );
        $this->set("result", $this->paginate($this->modelClass, $condition));
    }

    public function admin_edit($id = null)
    {
        $countries_list = $this->Country->find("list", array( "fields" => array( "iso3166_1", "name" ) ));
        $country_array = array(  );
        foreach( $countries_list as $country => $val ) 
        {
            $country_array[$country . "##" . $val] = $val . ", " . $country;
        }
        $countries = $country_array;
        $this->set("id", $id);
        $this->set("countries", $countries);
        if( !isset($this->data) ) 
        {
            $this->Project->id = $id;
            $this->data = $this->Project->find("first", array( "conditions" => array( "Project.id" => $id ) ));
            if( !empty($this->data["Project"]["project_country"]) ) 
            {
                $con_jaon = json_decode($this->data["Project"]["project_country_json"], true);
                $this->data["Project"]["project_country"] = $con_jaon["id"];
            }

        }
        else
        {
            $basic_validates = 0;
            $rewards_validates = 0;
            $story_validates = 0;
            $account_validates = 0;
            $validattion_errors = array(  );
            $this->data["Project"]["id"] = $id;
            if( $this->data["Project"]["image_val"]["name"] != "" ) 
            {
                $this->data["Project"]["image"] = $this->data["Project"]["image_val"];
            }

            $this->Project->setValidation("basic_tab");
            $this->Project->set($this->data);
            if( $this->Project->validates() ) 
            {
                $basic_validates = 1;
            }
            else
            {
                $validattion_errors = $this->Project->invalidFields();
            }

            $this->Project->setValidation("story_tab");
            $this->Project->set($this->data);
            if( $this->Project->validates() ) 
            {
                $story_validates = 1;
            }
            else
            {
                $validattion_errors = $validattion_errors + $this->Project->invalidFields();
            }

            if( !empty($validattion_errors) ) 
            {
                $this->Project->validationErrors = $validattion_errors;
                $project_rewards = $this->Project->find("first", array( "conditions" => array( "Project.id" => $id ) ));
                $this->data["Reward"] = $project_rewards["Reward"];
            }
            else
            {
                $this->data["Project"]["id"] = $id;
                if( $this->data["Project"]["duration_type"] == "date_and_time" ) 
                {
                    $time = $this->Project->get_end_date_to_time($this->data["Project"]["end_date"]);
                    $this->data["Project"]["end_date"] = $time;
                    $this->data["Project"]["project_end_date"] = $time;
                }

                if( $this->data["Project"]["duration_type"] == "no_of_days" ) 
                {
                    $this->data["Project"]["project_end_date"] = $this->Project->get_end_date_by_days($this->data["Project"]["no_of_day"]);
                }

                if( !empty($this->data["Project"]["project_city"]) ) 
                {
                    $result = $this->CommonFunction->get_city_json_fomrat($this->data["Project"]["project_city"]);
                    $this->data["Project"]["project_city"] = $result["city_id"];
                    $this->data["Project"]["project_city_json"] = $result["city_json"];
                    $this->data["Project"]["project_country"] = $result["country"];
                    $this->data["Project"]["project_country_json"] = $country_val["country_json"];
                }

                if( isset($this->data["Project"]["image"]) ) 
                {
                    if( $this->data["Project"]["image"]["name"] != "" ) 
                    {
                        $tempFile = $this->data["Project"]["image"]["tmp_name"];
                        $targetPath = UPLOAD_DIR;
                        $filename = "project_" . $id . time() . $this->data["Project"]["image"]["name"];
                        $targetFile = $targetPath . $filename;
                        move_uploaded_file($tempFile, $targetFile);
                        $project_old_img = $this->Project->find("first", array( "conditions" => array( "Project.id" => $id ), "fields" => array( "Project.image" ) ));
                        @unlink(UPLOAD_DIR . DS . $project_old_img["Project"]["image"]);
                        $this->data["Project"]["image"] = $filename;
                    }
                    else
                    {
                        unset($this->data["Project"]["image"]);
                    }

                }
                else
                {
                    unset($this->data["Project"]["image"]);
                }

                if( $this->data["Project"]["video_file"]["name"] != "" ) 
                {
                    $allowed_extension = Configure::read("allowed_video_files");
                    $fileExtension = $this->get_file_extension($this->data["Project"]["video_file"]["name"]);
                    $extension = "ffmpeg";
                    $extension_soname = $extension . "." . PHP_SHLIB_SUFFIX;
                    $extension_fullname = PHP_EXTENSION_DIR . "/" . $extension_soname;
                    $tempFile = $this->data["Project"]["video_file"]["tmp_name"];
                    $targetPath = PROJECT_VIDEO_DIR_PATH;
                    $filename = "project_" . $id . "_" . time() . $this->data["Project"]["video_file"]["name"];
                    $targetFile = $targetPath . $filename;
                    if( $fileExtension == "avi" || $fileExtension == "wmv" || $fileExtension == "mpeg" || $fileExtension == "mpg" || $fileExtension == "mov" || $fileExtension == "mp4" || $fileExtension == "flv" ) 
                    {
                        move_uploaded_file($tempFile, $targetFile);
                        $flv_convert_file_path = PROJECT_FLV_VIDEO_DIR_PATH;
                        $flv_file_name = "project_" . $id . "_" . time() . ".flv";
                        $image_file_name = "project_" . $id . "_" . time() . ".jpg";
                        $directory_path_full = $targetFile;
                        if( $fileExtension == "avi" || $fileExtension == "mpg" || $fileExtension == "mpeg" || $fileExtension == "wmv" ) 
                        {
                            exec("ffmpeg -i " . $targetFile . "  -sameq -f flv " . $flv_convert_file_path . "/" . $flv_file_name);
                        }

                        if( $fileExtension == "mp4" ) 
                        {
                            exec("ffmpeg -i " . $targetFile . " -sameq -f flv " . $flv_convert_file_path . "/" . $flv_file_name);
                        }

                        if( $fileExtension == "flv" ) 
                        {
                            exec("ffmpeg -i " . $targetFile . " -sameq -f flv " . $flv_convert_file_path . "/" . $flv_file_name);
                        }

                        if( $fileExtension == "mov" ) 
                        {
                            exec("ffmpeg -i" . $targetFile . " -sameq -f flv " . $flv_convert_file_path . "/" . $flv_file_name);
                        }

                        exec("ffmpeg -i " . $targetFile . " -f image2 -vframes 1 " . PROJECT_VIDEO_IMG_DIR_PATH . $image_file_name);
                        $this->data["Project"]["video"] = $filename;
                        $this->data["Project"]["flv_file_name"] = $flv_file_name;
                        $this->data["Project"]["video_image"] = $image_file_name;
                        echo $image_file_name;
                    }
                    else
                    {
                        echo "error";
                        exit();
                    }

                }

                $this->Project->save($this->data);
                $this->Session->setFlash(__d("projects", "Project updated successfully.", true), "admin/success");
                $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "index" ));
            }

        }

        if( empty($this->data["Project"]["end_date"]) || is_null($this->data["Project"]["end_date"]) ) 
        {
            $this->data["Project"]["end_date"] = mktime();
        }

        $end_date_time_stamp = $this->data["Project"]["end_date"];
        $this->set("end_date_time_stamp", $end_date_time_stamp);
    }

    public function admin_change_project_status($value = null, $id = null)
    {
        $letter = array(  );
        if( $value == "1" ) 
        {
            $letter["id"] = $id;
            $letter["active"] = "2";
            $letter["submitted_status"] = 0;
            $this->UserActivity->deleteAll(array( "UserActivity.subject_id" => $id, "UserActivity.subject_type" => "project", "UserActivity.activity_type" => "created" ));
        }
        else
        {
            $project_days = $this->Project->find("first", array( "conditions" => array( "Project.id" => $id ), "fields" => array( "Project.id", "Project.no_of_day" ) ));
            $letter["id"] = $id;
            $letter["active"] = "1";
            $letter["project_approved_by_admin_date"] = time();
            $letter["project_end_date"] = $this->Project->get_end_date_by_days($project_days["Project"]["no_of_day"]);
        }

        if( $this->Project->save($letter, false) ) 
        {
            $project_details = $this->Project->find("first", array( "conditions" => array( "Project.id" => $letter["id"] ) ));
            $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
            $to = $project_details["User"]["email"];
            $body = "Your Project has been approved";
            $d["Emaillog"]["email_to"] = $to;
            $d["Emaillog"]["email_from"] = $from;
            $d["Emaillog"]["email_type"] = "E";
            $d["Emaillog"]["subject"] = $subject;
            $d["Emaillog"]["message"] = $body;
            $d["Emaillog"]["active"] = "1";
            $d["Emaillog"]["deleted"] = "0";
            $this->Email->from = $from;
            $this->Email->to = $to;
            $project_title = $project_details["Project"]["title"];
            $project_owner = $project_details["User"]["name"];
            $this->set("project_title", $project_title);
            $this->set("project_owner", $project_owner);
            if( $project_details["Project"]["active"] == 2 ) 
            {
                $element = "project_unapproved";
                $subject = "Project unapproved";
            }
            else
            {
                $element = "project_approved";
                $subject = "Project Approved";
                $data["UserActivity"]["user_id"] = $project_details["User"]["id"];
                $data["UserActivity"]["project_id"] = $project_details["Project"]["id"];
                $data["UserActivity"]["subject_id"] = $project_details["Project"]["id"];
                $data["UserActivity"]["subject_type"] = "project";
                $data["UserActivity"]["activity_type"] = "created";
                $this->UserActivity->save($data, false);
                $this->loadModel("TempUserNotification");
                $temp_user_notification = array(  );
                $temp_user_notification["TempUserNotification"]["user_id"] = $project_details["User"]["id"];
                $temp_user_notification["TempUserNotification"]["activity_type"] = "created";
                $temp_user_notification["TempUserNotification"]["subject_id"] = $project_details["Project"]["id"];
                $temp_user_notification["TempUserNotification"]["subject_type"] = "project";
                $this->TempUserNotification->save($temp_user_notification);
            }

            $this->Email->sendAs = "html";
            $this->Email->subject = $subject;
            $this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
            $this->Emaillog->create();
            $this->Emaillog->set($d);
            $this->Emaillog->save();
            $this->Email->reset();
        }

        $this->Session->setFlash(__d("projects", "Project status updated successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_set_recommended($id = null, $recommend_status = 0)
    {
        if( is_null($id) ) 
        {
            redirect(array( "plugin" => false, "controller" => "projects", "action" => "index" ));
            $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "index" ));
            exit();
        }

        $this->Project->id = $id;
        $save_array = array(  );
        $save_array["Project"]["id"] = $id;
        $save_array["Project"]["is_recommended"] = $recommend_status;
        $save_array["Project"]["recommended_date"] = time();
        $this->Project->save($save_array);
        $this->Session->setFlash(__d("projects", "Project recommend status updated successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }
	
	public function admin_cancel_project($id = null)
    {
        if( is_null($id) ) 
        {
            redirect(array( "plugin" => false, "controller" => "projects", "action" => "index" ));
            $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "index" ));
            exit();
        }

        $this->Project->id = $id;
		$this->Project->saveField("is_cancelled", "1");
		$this->Backer->updateAll(array( "Backer.is_cancelled" => "1" ), array( "Backer.project_id" => $id ));
	
		/*Send mail*/
		$project = $this->Project->findById($id);
		$this->Notification->create_noti($project['User']['id'], 'project_cancelled', $project_id);
		
		$this->set("project", $project);
		$from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
		$element = "project_cancellation_to_creator";
		$replyTo = "";
		$to = $project["User"]["email"];
		$subject = "Cancellation notification for " . $project["Project"]["title"];
		$this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
			
        //$backers = $this->Backer->findAllByProjectId((int)$id);
        // create notification for backers
        //foreach($project['Backer'] as $key => $backer)
        foreach($project['Backer'] as $backer)
        {
            $this->Notification->create_noti($backer['User']['id'], 'project_cancelled', $backer['Project']['id']);
			$backer = $this->User->findById($backer['user_id']);
			$to = $backer["User"]["email"];
			$this->set("backer", $backer);
			$this->set("project", $project);
			$element = "project_cancellation_to_backer";
			$this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
        }
		$this->Session->setFlash(__d("projects", "Project and all pledges regarding this project has been cancelled.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_project_backer_detail($project_id = null)
    {
        $project_detail = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
        $project_backers = $this->Backer->find("all", array( "conditions" => array( "Backer.project_id" => $project_id ) ));
        $this->set("project_backers", $project_backers);
        $this->set("project_detail", $project_detail);
    }

    public function admin_find_user()
    {
        $this->autoRender = false;
        $this->layout = false;
        $search_param = $this->params["url"]["q"];
        $user_name = $this->User->find("all", array( "conditions" => array( "User.name LIKE" => $search_param . "%" ), "fields" => array( "name", "id" ) ));
        $name_array = array(  );
        foreach( $user_name as $name ) 
        {
            $name_array[] = array( "id" => $name["User"]["id"], "name" => $name["User"]["name"] );
        }
        return json_encode($name_array);
    }

    public function admin_reports()
    {
        if( !empty($this->data) && isset($this->data["recordsPerPage"]) ) 
        {
            $limitValue = $limit = $this->data["recordsPerPage"];
            $this->Session->write($this->title . "." . $this->action . ".recordsPerPage", $limit);
        }
        else
        {
            $this->Prg->commonProcess();
        }

        $condition = array(  );
        $category_id = "";
        if( isset($this->params["named"]["category_id"]) ) 
        {
            $condition[] = "Project.category_id=" . $this->params["named"]["category_id"];
            $category_id = $this->params["named"]["category_id"];
        }

        $this->set("category_id", $category_id);
        $limitValue = $limit = $this->Session->read($this->title . "." . $this->action . ".recordsPerPage") ? $this->Session->read($this->title . "." . $this->action . ".recordsPerPage") : Configure::read("defaultPaginationLimit");
        $limit = 1;
        $this->set("limitValue", $limitValue);
        $this->set("limit", $limit);
        $categories = $this->Category->find("list", array( "conditions" => array( "Category.parent_id" => 0, "Category.active" => 1 ), "fields" => array( "Category.id", "Category.category_name" ) ));
        $this->set("categories", $categories);
        $successfully_funded_amount = $this->Backer->find("all", array( "conditions" => array( "Project.is_successful" => 1, "Project.active" => 1, "Project.project_end_date <" => time() ), "fields" => array( "sum(Backer.amount) as total_successful_fund" ) ));
        if( empty($successfully_funded_amount[0][0]["total_successful_fund"]) ) 
        {
            $successfully_funded_amount[0][0]["total_successful_fund"] = 0;
        }

        $unsuccessfully_funded_amount = $this->Backer->find("all", array( "conditions" => array( "Project.is_successful" => 0, "Project.active" => 1, "Project.project_end_date <" => time() ), "fields" => array( "sum(Backer.amount) as total_unsuccessful_fund" ) ));
        if( empty($unsuccessfully_funded_amount[0][0]["total_unsuccessful_fund"]) ) 
        {
            $unsuccessfully_funded_amount[0][0]["total_unsuccessful_fund"] = 0;
        }

        $running_funded_amount = $this->Backer->find("all", array( "conditions" => array( "Project.is_successful" => 0, "Project.active" => 1, "Project.project_end_date >" => time() ), "fields" => array( "sum(Backer.amount) as total_running_fund" ) ));
        if( empty($running_funded_amount[0][0]["total_running_fund"]) ) 
        {
            $running_funded_amount[0][0]["total_running_fund"] = 0;
        }

        $this->set("successfully_funded_amount", $successfully_funded_amount[0][0]["total_successful_fund"]);
        $this->set("running_funded_amount", $running_funded_amount[0][0]["total_running_fund"]);
        $this->set("unsuccessfully_funded_amount", $unsuccessfully_funded_amount[0][0]["total_unsuccessful_fund"]);
        $condition[] = $this->modelClass . ".submitted_status=1";
        $results = $this->paginate($this->modelClass, $condition);
        $this->set("result", $results);
    }

    public function admin_pending_projects()
    {
        if( !empty($this->data) && isset($this->data["recordsPerPage"]) ) 
        {
            $limitValue = $limit = $this->data["recordsPerPage"];
            $this->Session->write($this->title . "." . $this->action . ".recordsPerPage", $limit);
        }
        else
        {
            $this->Prg->commonProcess();
        }

        $limitValue = $limit = $this->Session->read($this->title . "." . $this->action . ".recordsPerPage") ? $this->Session->read($this->title . "." . $this->action . ".recordsPerPage") : Configure::read("defaultPaginationLimit");
        $this->set("limitValue", $limitValue);
        $this->set("limit", $limit);
        $this->{$this->modelClass}->data[$this->modelClass] = $this->passedArgs;
        $parsedConditions = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions + array( $this->modelClass . ".active" => "0", $this->modelClass . ".submitted_status" => "1" );
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".modified" => "desc" );
        $this->set("result", $this->paginate($this->modelClass));
    }

    public function admin_successful_projects()
    {
        if( !empty($this->data) && isset($this->data["recordsPerPage"]) ) 
        {
            $limitValue = $limit = $this->data["recordsPerPage"];
            $this->Session->write($this->title . "." . $this->action . ".recordsPerPage", $limit);
        }
        else
        {
            $this->Prg->commonProcess();
        }

        $limitValue = $limit = $this->Session->read($this->title . "." . $this->action . ".recordsPerPage") ? $this->Session->read($this->title . "." . $this->action . ".recordsPerPage") : Configure::read("defaultPaginationLimit");
        $this->set("limitValue", $limitValue);
        $this->set("limit", $limit);
        $this->{$this->modelClass}->data[$this->modelClass] = $this->passedArgs;
        $parsedConditions = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions + array( $this->modelClass . ".is_successful" => "1", $this->modelClass . ".submitted_status" => "1", $this->modelClass . ".active" => "1" );
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".project_success_date" => "desc" );
        $this->set("result", $this->paginate($this->modelClass));
    }

    public function admin_payment_info($project_id = null)
    {
        $this->Project->unBindModel(array( "hasMany" => array( "Reward", "Backer", "ProjectAskedQuestion" ) ));
        $project_info = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
        $ProjectTransaction = $this->ProjectTransaction->find("first", array( "conditions" => array( "ProjectTransaction.project_id" => $project_id ) ));
        $this->set("project_transaction", $ProjectTransaction);
        $this->set("project_info", $project_info);
        if( !empty($this->data) ) 
        {
            $project_transaction = $this->data;
            $this->data["ProjectTransaction"] = $project_transaction["ProjectTransaction"];
            $this->data["ProjectTransaction"]["pledge_amount"] = $ProjectTransaction["ProjectTransaction"]["pledge_amount"];
            $total_pleadge = $ProjectTransaction["ProjectTransaction"]["pledge_amount"];
            $admin_commission = $this->data["ProjectTransaction"]["admin_commission_percent"];
            $paypal_commission = $this->data["ProjectTransaction"]["paypal_commission"];
            $result = $this->CommonFunction->calculate_amount_for_project_owner($total_pleadge, $admin_commission, $paypal_commission);
            $ProjectTransaction_array["ProjectTransaction"] = $result;
            if( isset($this->data["ProjectTransaction"]["is_paid"]) && $this->data["ProjectTransaction"]["is_paid"] == 1 ) 
            {
                $ProjectTransaction_array["ProjectTransaction"]["is_paid"] = 1;
                $ProjectTransaction_array["ProjectTransaction"]["payment_date"] = strtotime($this->data["ProjectTransaction"]["payment_date"]);
            }

            $ProjectTransaction_array["ProjectTransaction"]["id"] = $ProjectTransaction["ProjectTransaction"]["id"];
            $ProjectTransaction_array["ProjectTransaction"]["project_id"] = $project_id;
            $this->ProjectTransaction->save($ProjectTransaction_array);
            $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "successful_projects" ));
        }
        else
        {
            $this->data = $project_info;
            $this->data["ProjectTransaction"] = $ProjectTransaction["ProjectTransaction"];
        }

    }

    public function admin_get_city()
    {
        $this->autoRender = false;
        $this->layout = false;
        $search_param = $this->params["url"]["q"];
        $this->loadModel("City");
        $country = Configure::read("CONFIG_COUNTRY");
        $cities = $this->City->find("list", array( "conditions" => array( "City.name like" => $search_param . "%", "City.iso3166_1" => $country ), "fields" => array( "id", "name" ) ));
        $city_array = array(  );
        foreach( $cities as $city => $val ) 
        {
            $city_array[] = array( "id" => $city . "##" . $val . "##" . $country, "name" => $val . ", " . $country );
        }
        return json_encode($city_array);
    }

    public function detail($user = null, $project_slug = null)
    {
        $this->loadModel("Country");
        if( empty($user) || is_null($user) ) 
        {
            $this->_404error();
        }

        if( empty($project_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->get_project_detail($project_slug);
        if( $project_detail["Project"]["is_cancelled"] == 1 ) 
        {
            $this->show_project_cancellation_layout($project_detail);
        }

    }

    public function get_project_detail($project_slug)
    {
        $project_detail = $this->Project->find("first", array( "conditions" => array( "Project.slug" => $project_slug ) ));
        if( !$this->Session->read("Auth.admin.id") && $project_detail["Project"]["active"] != 1 ) 
        {
            $this->_404error();
        }

        $project_country = $this->Country->find("first", array( "conditions" => array( "Country.iso3166_1" => $project_detail["Project"]["project_country"] ), "fields" => array( "Country.name" ) ));
        $project_detail["Project"]["project_country_code"] = $project_detail["Project"]["project_country"];
        $project_detail["Project"]["project_country"] = $project_country["Country"]["name"];
        $project_detail["Project"]["total_pledge"] = $this->CommonFunction->get_total_pledge_amount($project_detail["Backer"]);
        $country = $this->Country->find("first", array( "conditions" => array( "Country.iso3166_1" => $project_detail["User"]["country"] ), "fields" => array( "Country.name" ) ));
        $project_detail["User"]["country_code"] = $project_detail["User"]["country"];
        $project_detail["User"]["country"] = $country["Country"]["name"];
        $backed_projects = $this->_get_user_backed_projects($project_detail["User"]["id"]);
        $project_detail["User"]["backed_projects"] = $backed_projects;
        $current_projects = $this->_user_current_active_projects($project_detail["User"]["id"]);
        $project_detail["User"]["user_current_projects"] = $current_projects;
        $count_comment = $this->ProjectUpdate->find("count", array( "conditions" => array( "ProjectUpdate.project_id" => $project_detail["Project"]["id"] ) ));
        $backer_comments = $this->ProjectComment->find("all", array( "conditions" => array( "ProjectComment.project_id" => $project_detail["Project"]["id"] ) ));
        if( $this->Session->check("Auth.User.id") ) 
        {
            $is_user_login = 1;
        }
        else
        {
            $is_user_login = 0;
        }

        if( isset($this->params["url"]["ref"]) && $this->Session->check("login_redirect") && ($this->params["url"]["ref"] == "ask_question" || $this->params["url"]["ref"] == "send_message") ) 
        {
            $open_ask_question = 1;
        }
        else
        {
            $open_ask_question = 0;
        }

        if( isset($this->params["url"]["ref"]) && $this->Session->check("login_redirect") && $this->params["url"]["ref"] == "report_project" ) 
        {
            $open_report_project = 1;
        }
        else
        {
            $open_report_project = 0;
        }

        $this->set("alrady_stared", 0);
        if( $this->Session->check("Auth.User.id") ) 
        {
            $alrady_stared_check = $this->StaredProject->find("first", array( "conditions" => array( "StaredProject.project_id" => $project_detail["Project"]["id"], "StaredProject.email" => $this->Session->read("Auth.User.email") ) ));
            if( !empty($alrady_stared_check) ) 
            {
                $this->set("alrady_stared", 1);
            }
            else
            {
                $this->set("alrady_stared", 0);
            }

        }

        App::import("Helper", "GeneralFunctions");
        $general_function_class_obj = new GeneralFunctionsHelper();
        $remaining_time = $general_function_class_obj->get_remainig_time(time(), $project_detail["Project"]["project_end_date"]);
        $project_detail["Project"]["remaining_time"] = $remaining_time;
        $this->set("is_user_login", $is_user_login);
        $this->set("project_detail", $project_detail);
        $this->set("title_for_layout", $project_detail["Project"]["title"]);
        $this->set("keywords_for_layout", $project_detail["Project"]["title"]);
        $this->set("description_for_layout", $project_detail["Project"]["short_description"]);
        $this->set("open_ask_question", $open_ask_question);
        $this->set("open_report_project", $open_report_project);
        $this->set("backer_comments", $backer_comments);
        $this->set("count_comment", $count_comment);
        if( !empty($project_detail["Project"]["image"]) ) 
        {
            $this->set("og_image", UPLOAD_DIR_URL . $project_detail["Project"]["image"]);
        }

        $project_faqs = $this->ProjectAskedQuestions->find("all", array( "conditions" => array( "ProjectAskedQuestions.project_id" => $project_detail["Project"]["id"], "ProjectAskedQuestions.user_id" => $project_detail["User"]["id"] ), "order" => array( "ProjectAskedQuestions.id DESC" ) ));
        $this->set("project_faqs", $project_faqs);
        return $project_detail;
    }

    public function show_project_cancellation_layout($project_detail)
    {
        $this->layout = false;
        $this->set("project_content", $project_detail);
        echo $this->render("/elements/projects/show_project_cancellation_layout");
        exit();
    }

    public function guidelines()
    {
        $this->set("title_for_layout", " Guidelines & Requirements &mdash; " . Configure::read("CONFIG_SITE_TITLE"));
        $this->loadModel("Pages.Page");
        $right_panel_contents = $this->Page->find("first", array( "conditions" => array( "Page.id" => array( 84 ) ) ));
        $page_content = $this->Page->find("first", array( "conditions" => array( "Page.id" => 18 ) ));
        $this->set("title_for_layout", $page_content["Page"]["title"]);
        $this->set("right_panel_contents", $right_panel_contents);
        $this->set("keywords_for_layout", $page_content["Page"]["metakeyword"]);
        $this->set("description_for_layout", $page_content["Page"]["metadescription"]);
        $this->set("page_content", $page_content);
    }

    public function create()
    {
        if( $this->data ) 
        {
            $user_id = $this->Session->read("Auth.User.id");
            $user_slug = $this->Session->read("Auth.User.slug");
            $project = array(  );
            $project["Project"]["user_id"] = $user_id;
            $this->Project->save($project);
            $project_id = $this->Project->id;
            $to = $this->Session->read("Auth.User.email");
            $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
            $subject = "You’ve started a project on " . Configure::read("CONFIG_SITE_TITLE") . "!";
            $replyTo = Configure::read("CONFIG_FROMEMAIL");
            $element = "project_started";
            $this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
            $this->redirect("/projects/edit/" . $user_slug . "/" . $project_id . "#basics");
        }

    }

    public function edit($user_slug = null, $project_id = null)
    {
        $this->set("title_for_layout", __("project_edit_ur_project", true) . "&mdash; " . Configure::read("CONFIG_SITE_TITLE"));
        $this->layout = "project";
        $this->Session->delete("project_submision_error");
        $right_panel_contents = $this->Page->find("all", array( "conditions" => array( "Page.id" => array( 84, 85, 86, 87, 88 ) ) ));
        if( empty($user_slug) || is_null($user_slug) ) 
        {
            $this->_unauthorized_access();
            exit();
        }

        if( empty($project_id) || is_null($project_id) ) 
        {
            $this->_unauthorized_access();
            exit();
        }

        if( $user_slug != $this->Session->read("Auth.User.slug") ) 
        {
            $this->_unauthorized_access();
            exit();
        }

        $project_content = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
        if( empty($project_content) ) 
        {
            $this->_unauthorized_access();
            exit();
        }

        if( $project_content["Project"]["submitted_status"] == 1 && $project_content["Project"]["active"] == 0 ) 
        {
            $this->project_under_review($project_content);
            exit();
        }

        $page_content = $this->Page->find("first", array( "conditions" => array( "Page.id" => 18 ) ));
        $review_page_content = $this->Page->find("first", array( "conditions" => array( "Page.id" => 26 ) ));
        $this->data = $project_content;
        if( empty($project_content["Project"]["end_date"]) || is_null($project_content["Project"]["end_date"]) ) 
        {
            $project_content["Project"]["end_date"] = mktime();
        }

        $this->data["Project"]["end_date"] = date("m/d/Y H:i", $project_content["Project"]["end_date"]);
        $end_date_time_stamp = $project_content["Project"]["end_date"];
        if( empty($this->data["Project"]["duration_type"]) || is_null($this->data["Project"]["duration_type"]) ) 
        {
            $this->data["Project"]["duration_type"] = "no_of_days";
        }

        if( !empty($this->data["User"]["website"]) ) 
        {
            $this->data["User"]["website"] = explode(",", $this->data["User"]["website"]);
        }
        else
        {
            $this->data["User"]["website"] = array(  );
        }

        $this->set("page_content", $page_content);
        $this->set("review_page_content", $review_page_content);
        $this->set("project_id", $project_id);
        $this->set("user_slug", $user_slug);
        $this->set("end_date_time_stamp", $end_date_time_stamp);
        $this->set("right_panel_contents", $right_panel_contents);
    }

    public function project_under_review($project_content)
    {
        $this->layout = "";
        $this->set("project_content", $project_content);
        echo $this->render("/elements/projects/project_under_review");
        exit();
    }

    public function save_project_image($project_id = null)
    {
        $this->autoRender = false;
        $this->layout = "project";
        if( !empty($_FILES) ) 
        {
            $allowed_extension = Configure::read("allowed_image_files");
            $fileExtension = $this->get_file_extension($_FILES["Filedata"]["name"]);
            if( !in_array($fileExtension, $allowed_extension) ) 
            {
                echo "error";
                exit();
            }

            $allowed_mime_types = Configure::read("allowed_image_mime_types");
            $filename = $_FILES["Filedata"]["tmp_name"];
            $mime_type = $this->getImageMimeType($filename);
            if( empty($mime_type) || !in_array($mime_type, $allowed_mime_types) ) 
            {
                echo "error";
                exit();
            }

            $tempFile = $_FILES["Filedata"]["tmp_name"];
            $targetPath = UPLOAD_DIR;
            $file = stripslashes(str_replace("'", "_", $_FILES["Filedata"]["name"]));
            $filename = "project_" . $project_id . time() . $file;
            $targetFile = $targetPath . $filename;
            move_uploaded_file($tempFile, $targetFile);
            $this->Project->id = $project_id;
            $project_old_img = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ), "fields" => array( "Project.image" ) ));
            @unlink(UPLOAD_DIR . DS . $project_old_img["Project"]["image"]);
            $this->Project->saveField("image", stripslashes($filename));
            echo $filename;
        }

    }

    public function remove_project_video($project_id = null)
    {
        $this->autoRender = false;
        $this->layout = "project";
        $this->Project->id = $project_id;
        $project_array = array("Project" => array());
        $project_array["Project"]["video"] = "";
        $project_array["Project"]["id"] = $project_id;
        $project_array["Project"]["flv_file_name"] = "";
        $project_array["Project"]["video_image"] = "";
        $this->Project->save($project_array);
        echo "Success";
    }

    public function save_project_video($project_id = null)
    {
        $this->autoRender = false;
        $this->layout = "project";
        if( !empty($_FILES) ) 
        {
            $allowed_extension = Configure::read("allowed_video_files");
            $fileExtension = $this->get_file_extension($_FILES["Filedata"]["name"]);
            if( !in_array($fileExtension, $allowed_extension) ) 
            {
                echo "error";
                exit();
            }

            $extension = "ffmpeg";
            $extension_soname = $extension . "." . PHP_SHLIB_SUFFIX;
            $extension_fullname = PHP_EXTENSION_DIR . "/" . $extension_soname;
            $tempFile = $_FILES["Filedata"]["tmp_name"];
            $targetPath = PROJECT_VIDEO_DIR_PATH;
            $filename = "project_" . $project_id . "_" . time() . $_FILES["Filedata"]["name"];
            $targetFile = $targetPath . $filename;
            if( $fileExtension == "avi" || $fileExtension == "wmv" || $fileExtension == "mpeg" || $fileExtension == "mpg" || $fileExtension == "mov" || $fileExtension == "mp4" || $fileExtension == "flv" ) 
            {
                move_uploaded_file($tempFile, $targetFile);
                $flv_convert_file_path = PROJECT_FLV_VIDEO_DIR_PATH;
                $flv_file_name = "project_" . $project_id . "_" . time() . ".flv";
                $image_file_name = "project_" . $project_id . "_" . time() . ".jpg";
                $directory_path_full = $targetFile;
                if( $fileExtension == "wmv" ) 
                {
                    exec("ffmpeg -i " . $targetFile . "  -sameq -acodec libmp3lame -ar 22050 -ab 96000 -deinterlace -nr 500 -s 320x240 -aspect 4:3 -r 20 -g 500 -me_range 20 -b 270k -deinterlace -f flv -y " . $flv_convert_file_path . "/" . $flv_file_name);
                }

                if( $fileExtension == "avi" || $fileExtension == "mpg" || $fileExtension == "mpeg" ) 
                {
                    exec("ffmpeg -i " . $targetFile . "  -sameq -f flv " . $flv_convert_file_path . "/" . $flv_file_name);
                }

                if( $fileExtension == "mp4" ) 
                {
                    exec("ffmpeg -i " . $targetFile . " -sameq -f flv " . $flv_convert_file_path . "/" . $flv_file_name);
                }

                if( $fileExtension == "flv" ) 
                {
                    exec("ffmpeg -i " . $targetFile . " -sameq -f flv " . $flv_convert_file_path . "/" . $flv_file_name);
                }

                if( $fileExtension == "mov" ) 
                {
                    exec("ffmpeg -i" . $targetFile . " -sameq -f flv " . $flv_convert_file_path . "/" . $flv_file_name);
                }

                exec("ffmpeg -i " . $targetFile . " -f image2 -vframes 1 " . PROJECT_VIDEO_IMG_DIR_PATH . $image_file_name);
                $this->Project->id = $project_id;
                $project_old_img = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ), "fields" => array( "Project.image" ) ));
                $project_array["Project"]["video"] = $filename;
                $project_array["Project"]["id"] = $project_id;
                $project_array["Project"]["flv_file_name"] = $flv_file_name;
                $project_array["Project"]["video_image"] = $image_file_name;
                $this->Project->save($project_array);
                echo $image_file_name;
            }
            else
            {
                echo "error";
                exit();
            }

        }

    }

    public function basics($project_id = null)
    {
        $this->autoRender = false;
        $this->layout = false;
        $right_panel_contents = $this->Page->find("all", array( "conditions" => array( "Page.id" => array( 84, 85, 86, 87, 88 ) ) ));
        $this->set("right_panel_contents", $right_panel_contents);
        if( $this->RequestHandler->isAjax() ) 
        {
            $this->layout = "ajax";
            if( $this->data ) 
            {
                $this->Project->setValidation("basic_tab");
                $this->Project->set($this->data);
                if( $this->Project->validates() ) 
                {
                    $this->save_basic_tabs($project_id, $this->data);
                    $project_content = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
                    $this->data = $project_content;
                    $end_date_time_stamp = $this->data["Project"]["end_date"];
                    $this->set("end_date_time_stamp", $end_date_time_stamp);
                    $this->data["Project"]["end_date"] = date("m/d/Y h:i a", $project_content["Project"]["end_date"]);
                    echo "success" . "###" . $this->render("/elements/projects/basic");
                    exit();
                }

                $project_content = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
                $this->data["Project"]["id"] = $project_id;
                $this->data["Project"]["image"] = $project_content["Project"]["image"];
                if( !empty($this->data["Project"]["project_city"]) ) 
                {
                    $pc_val = explode("##", $this->data["Project"]["project_city"]);
                    $this->data["Project"]["project_city_json"] = "{\"id\":\"" . $this->data["Project"]["project_city"] . "\",\"name\":\"" . $pc_val[1] . ", " . $pc_val[2] . "\"}";
                }

                $this->data["Backer"] = $project_content["Backer"];
                $this->data["User"]["name"] = $project_content["User"]["name"];
                $end_date_time_stamp = $this->Project->get_end_date_to_time($this->data["Project"]["end_date"]);
                $this->set("end_date_time_stamp", $end_date_time_stamp);
                echo "error" . "###" . $this->render("/elements/projects/basic");
                exit();
            }

        }

    }

    public function save_basic_tabs($project_id, $post_data = array(  ))
    {
        $this->data = $post_data;
        if( $this->data["Project"]["active"] == 0 ) 
        {
            if( $this->data["Project"]["duration_type"] == "date_and_time" ) 
            {
                $time = $this->Project->get_end_date_to_time($this->data["Project"]["end_date"]);
                $this->data["Project"]["end_date"] = $time;
                $this->data["Project"]["project_end_date"] = $time;
            }

            if( $this->data["Project"]["duration_type"] == "no_of_days" ) 
            {
                $this->data["Project"]["project_end_date"] = $this->Project->get_end_date_by_days($this->data["Project"]["no_of_day"]);
            }

        }

        $this->Project->id = $project_id;
        if( !empty($this->data["Project"]["project_city"]) ) 
        {
            $result = $this->CommonFunction->get_city_json_fomrat($this->data["Project"]["project_city"]);
            $this->data["Project"]["project_city"] = $result["city_id"];
            $this->data["Project"]["project_city_json"] = $result["city_json"];
            $this->data["Project"]["project_country"] = $result["country"];
            $this->data["Project"]["project_country_json"] = $result["country_json"];
        }

        $this->Project->save($this->data["Project"], false);
        return 1;
    }

    public function rewards($project_id = null)
    {
        $this->autoRender = false;
        $this->layout = false;
        $right_panel_contents = $this->Page->find("all", array( "conditions" => array( "Page.id" => array( 84, 85, 86, 87, 88 ) ) ));
        $this->set("right_panel_contents", $right_panel_contents);
        if( $this->RequestHandler->isAjax() ) 
        {
            $project = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
            $this->loadModel("Reward");
            $this->layout = "ajax";
            if( $this->data ) 
            {
                $data = $this->data;
                if( !isset($this->data["Reward"]["pledge_amount"]) ) 
                {
                    $this->data["Reward"]["pledge_amount"][0] = 0;
                    $this->data["Reward"]["description"][0] = "";
                    $this->data["Reward"]["est_delivery_month"][0] = "";
                    $this->data["Reward"]["est_delivery_year"][0] = "";
                    $this->data["Reward"]["project_id"][0] = $project_id;
                }

                $total_rewards_sent = count($this->data["Reward"]["pledge_amount"]);
                $rewards_array = array(  );
                $rewards_array["Project"]["id"] = $project_id;
                for( $tr = 0; $tr < $total_rewards_sent; $tr++ ) 
                {
                    if( !empty($this->data["Reward"]["id"][$tr]) ) 
                    {
                        $rewards_array["Reward"][$tr]["id"] = $this->data["Reward"]["id"][$tr];
                    }

                    $rewards_array["Reward"][$tr]["pledge_amount"] = $this->data["Reward"]["pledge_amount"][$tr];
                    $rewards_array["Reward"][$tr]["description"] = $this->data["Reward"]["description"][$tr];
                    $rewards_array["Reward"][$tr]["est_delivery_month"] = $this->data["Reward"]["est_delivery_month"][$tr];
                    $rewards_array["Reward"][$tr]["est_delivery_year"] = $this->data["Reward"]["est_delivery_year"][$tr];
                    $rewards_array["Reward"][$tr]["project_id"] = $project_id;
                    if( isset($this->data["Reward"]["limit"][$tr]) ) 
                    {
                        $rewards_array["Reward"][$tr]["limit"] = $this->data["Reward"]["limit"][$tr];
                        $rewards_array["Reward"][$tr]["limit_value"] = $this->data["Reward"]["limit_value"][$tr];
                    }
                    else
                    {
                        $rewards_array["Reward"][$tr]["limit"] = 0;
                        $rewards_array["Reward"][$tr]["limit_value"] = "";
                    }

                }
                if( $this->Project->saveAll($rewards_array, array( "validate" => "first" )) ) 
                {
                    if( !empty($this->data["Reward"]["remove_ids"]) ) 
                    {
                        $this->Reward->deleteAll("Reward.id IN (" . $this->data["Reward"]["remove_ids"] . ") AND Reward.project_id=" . $project_id);
                    }

                    $rewards = $this->Reward->find("all", array( "conditions" => array( "Reward.project_id" => $project_id ), "order" => "Reward.pledge_amount asc" ));
                    $rewards_array = array(  );
                    $c = 0;
                    foreach( $rewards as $reward ) 
                    {
                        $rewards_array["Reward"][$c] = $reward["Reward"];
                        $c++;
                    }
                    $this->data = $rewards_array;
                    $this->data["Project"] = $data["Project"];
                    $this->data["Backer"] = $project["Backer"];
                    echo "success" . "###" . $this->render("/elements/projects/rewards");
                    exit();
                }

                $total_rewards_sent = count($this->data["Reward"]["pledge_amount"]);
                $rewards_array = array(  );
                for( $tr = 0; $tr < $total_rewards_sent; $tr++ ) 
                {
                    if( !empty($this->data["Reward"]["id"][$tr]) ) 
                    {
                        $rewards_array[$tr]["id"] = $this->data["Reward"]["id"][$tr];
                    }

                    $rewards_array[$tr]["pledge_amount"] = $this->data["Reward"]["pledge_amount"][$tr];
                    $rewards_array[$tr]["description"] = $this->data["Reward"]["description"][$tr];
                    $rewards_array[$tr]["est_delivery_month"] = $this->data["Reward"]["est_delivery_month"][$tr];
                    $rewards_array[$tr]["est_delivery_year"] = $this->data["Reward"]["est_delivery_year"][$tr];
                    $rewards_array[$tr]["project_id"] = $project_id;
                    if( isset($this->data["Reward"]["limit"][$tr]) ) 
                    {
                        $rewards_array[$tr]["limit"] = $this->data["Reward"]["limit"][$tr];
                        $rewards_array[$tr]["limit_value"] = $this->data["Reward"]["limit_value"][$tr];
                    }
                    else
                    {
                        $rewards_array[$tr]["limit"] = 0;
                        $rewards_array[$tr]["limit_value"] = "";
                    }

                }
                $this->data["Reward"] = $rewards_array;
                $this->data["Project"] = $data["Project"];
                $this->data["Backer"] = $project["Backer"];
                echo "error" . "###" . $this->render("/elements/projects/rewards");
                exit();
            }

            $rewards = $this->Reward->find("all", array( "conditions" => array( "Reward.project_id" => $project_id ), "order" => "Reward.pledge_amount asc" ));
            $rewards_array = array(  );
            $c = 0;
            foreach( $rewards as $reward ) 
            {
                $rewards_array["Reward"][$c] = $reward["Reward"];
                $c++;
            }
            $this->data = $rewards_array;
            $this->data["Project"] = $data["Project"];
            $this->data["Backer"] = $project["Backer"];
            echo "success" . "###" . $this->render("/elements/projects/rewards");
            exit();
        }

    }

    public function story($project_id = null)
    {
        $this->autoRender = false;
        $this->layout = false;
        $right_panel_contents = $this->Page->find("all", array( "conditions" => array( "Page.id" => array( 84, 85, 86, 87, 88 ) ) ));
        $this->set("right_panel_contents", $right_panel_contents);
        if( $this->RequestHandler->isAjax() ) 
        {
            $this->layout = "ajax";
            if( $this->data ) 
            {
                $this->Project->setValidation("story_tab");
                $this->Project->set($this->data);
                if( $this->Project->validates() ) 
                {
                    $this->save_story_tab($project_id, $this->data);
                    $project_content = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
                    $this->data = $project_content;
                    echo "success" . "###" . $this->render("/elements/projects/story");
                    exit();
                }

                echo "error" . "###" . $this->render("/elements/projects/story");
                exit();
            }

        }

    }

    public function save_story_tab($project_id, $data)
    {
        $data["Project"]["id"] = $project_id;
        $data["Project"]["description"] = $this->data["Project"]["description"];
        $this->Project->save($data, false);
        return 1;
    }

    public function about_you($project_id = null)
    {
        $this->autoRender = false;
        $this->layout = false;
        $right_panel_contents = $this->Page->find("all", array( "conditions" => array( "Page.id" => array( 84, 85, 86, 87, 88 ) ) ));
        $this->set("right_panel_contents", $right_panel_contents);
        if( $this->RequestHandler->isAjax() ) 
        {
            $this->layout = "ajax";
            if( $this->data ) 
            {
                $user_error = array(  );
                if( empty($this->data["User"]["biography"]) ) 
                {
                    $user_error["biography"] = "Please enter biography";
                }

                if( empty($this->data["User"]["city"]) ) 
                {
                    $user_error["city"] = __("user_city_error", true);
                }

                if( empty($user_error) ) 
                {
                    $this->save_about_you($this->data);
                    if( !empty($this->data["User"]["website"]) ) 
                    {
                        $this->data["User"]["website"] = explode(",", $this->data["User"]["website"]);
                    }
                    else
                    {
                        $this->data["User"]["website"] = array(  );
                    }

                    $project_content = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
                    $this->data["Project"]["image"] = $project_content["Project"]["image"];
                    $this->data = $project_content;
                    if( !empty($this->data["User"]["website"]) ) 
                    {
                        $this->data["User"]["website"] = explode(",", $this->data["User"]["website"]);
                    }
                    else
                    {
                        $this->data["User"]["website"] = array(  );
                    }

                    $this->Session->write("Auth.User.biography", $this->data["User"]["biography"]);
                    $this->Session->write("Auth.User.country", $this->data["User"]["country"]);
                    $this->Session->write("Auth.User.country_json", $this->data["User"]["country_json"]);
                    $this->Session->write("Auth.User.city", $this->data["User"]["city"]);
                    $this->Session->write("Auth.User.city_json", $this->data["User"]["city_json"]);
                    $this->Session->write("Auth.User.website", $this->data["User"]["website"]);
                    echo "success" . "###" . $this->render("/elements/projects/about_you");
                    exit();
                }

                $project_content = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
                $this->data["Project"]["image"] = $project_content["Project"]["image"];
                $this->data["User"]["profile_image"] = $project_content["User"]["profile_image"];
                $this->data["User"]["fb_image_url"] = $project_content["User"]["fb_image_url"];
                if( !empty($project_content["User"]["website"]) ) 
                {
                    $this->data["User"]["website"] = explode(",", $project_content["User"]["website"]);
                }
                else
                {
                    $this->data["User"]["website"] = array(  );
                }

                if( !empty($this->data["User"]["city"]) ) 
                {
                    $result = $this->CommonFunction->get_json_to_city_fomrat($this->data["User"]["city"]);
                    $this->data["User"]["city_json"] = $result;
                }

                $this->set("user_error", $user_error);
                echo "error" . "###" . $this->render("/elements/projects/about_you");
                exit();
            }

        }

    }

    public function save_about_you($user_array = array(  ))
    {
        $this->data = $user_array;
        $this->data["User"]["id"] = $this->Session->read("Auth.User.id");
        if( !empty($this->data["User"]["website"]) ) 
        {
            $this->data["User"]["website"] = implode(",", $this->data["User"]["website"]);
        }
        else
        {
            $this->data["User"]["website"] = "";
        }

        if( !empty($this->data["User"]["city"]) ) 
        {
            $result = $this->CommonFunction->get_city_json_fomrat($this->data["User"]["city"]);
            $this->data["User"]["city"] = $result["city_id"];
            $this->data["User"]["city_json"] = $result["city_json"];
            $this->data["User"]["country"] = $result["country"];
            $this->data["User"]["country_json"] = $result["country_json"];
        }

        $this->User->save($this->data, false);
        return 1;
    }

    public function account($project_id = null)
    {
        $this->autoRender = false;
        $this->layout = false;
        $right_panel_contents = $this->Page->find("all", array( "conditions" => array( "Page.id" => array( 84, 85, 86, 87, 88 ) ) ));
        $this->set("right_panel_contents", $right_panel_contents);
        if( $this->RequestHandler->isAjax() ) 
        {
            $this->layout = "ajax";
            if( $this->data ) 
            {
                if( !empty($this->data["User"]["city"]) ) 
                {
                    $result = $this->CommonFunction->get_city_json_fomrat($this->data["User"]["city"]);
                    $this->data["Project"]["city"] = $result["city_id"];
                    $this->data["Project"]["country"] = $result["city_json"];
                    $this->data["Project"]["project_country"] = $result["country"];
                    $this->data["Project"]["country_json"] = $result["country_json"];
                }

                $this->User->id = $this->Session->read("Auth.User.id");
                if( $this->User->saveField("paypal_email", $this->data["User"]["paypal_email"]) ) 
                {
                    $project_content = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
                    $this->data = $project_content;
                    echo "success" . "###" . $this->render("/elements/projects/account");
                    exit();
                }

                $project_content = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
                $this->data["User"]["email_authenticated"] = $project_content["User"]["email_authenticated"];
                if( !empty($this->data["User"]["city"]) ) 
                {
                    $result = $this->CommonFunction->get_json_to_city_fomrat($this->data["Project"]["city"]);
                    $this->data["User"]["city_json"] = $result;
                }

                echo "success" . "###" . $this->render("/elements/projects/account");
                exit();
            }

        }

    }

    public function preview($project_id = null)
    {
        if( $this->RequestHandler->isAjax() ) 
        {
            $this->autoRender = false;
            $this->layout = false;
            $this->loadModel("Country");
            $project_content = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
            $this->data = $project_content;
            $project_detail = $project_content;
            $country = $this->Country->find("first", array( "conditions" => array( "Country.iso3166_1" => $project_detail["User"]["country"] ), "fields" => array( "Country.name" ) ));
            $project_detail["User"]["country_code"] = $project_detail["User"]["country"];
            $project_detail["User"]["country"] = $country["Country"]["name"];
            App::import("Helper", "GeneralFunctions");
            $general_function_class_obj = new GeneralFunctionsHelper();
            $remaining_time = $general_function_class_obj->get_remainig_time(time(), $project_detail["Project"]["project_end_date"]);
            $project_detail["Project"]["remaining_time"] = $remaining_time;
            $backed_projects = $this->_get_user_backed_projects($project_detail["User"]["id"]);
            $project_detail["User"]["backed_projects"] = $backed_projects;
            $current_projects = $this->_user_current_active_projects($project_detail["User"]["id"]);
            $project_detail["User"]["user_current_projects"] = $current_projects;
            $this->set("project_detail", $project_detail);
            echo "success" . "###" . $this->render("/elements/projects/preview");
            exit();
        }

    }

    public function save_project($project_id = null)
    {
        if( $this->RequestHandler->isAjax() ) 
        {
            $this->layout = "ajax";
            if( $this->data ) 
            {
                $error_array = array(  );
                $error_tabs = array(  );
                $story_tab = 0;
                $basic_tab = 0;
                $about_you = 0;
                $account = 0;
                $rewards = 0;
                $this->Project->setValidation("basic_tab");
                $this->Project->set($this->data);
                $get_project_video_image = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ), "fields" => array( "Project.flv_file_name", "Project.image", "User.*" ) ));
                if( $this->Project->validates() ) 
                {
                    if( empty($get_project_video_image["Project"]["image"]) ) 
                    {
                        $image_error = array( "image" => __("model_project_please_upload_image", true) );
                        $error_tabs["basics"] = "basic";
                        $error_array["basics"] = $image_error;
                    }
                    else
                    {
                        $basic_tab = 1;
                    }

                }
                else
                {
                    $error_tabs["basics"] = "basic";
                    $basic_erors = array(  );
                    if( empty($get_project_video_image["Project"]["image"]) ) 
                    {
                        $image_error = array( "flv_file_name" => __("model_project_please_upload_image", true) );
                        $basic_erors = $this->Project->invalidFields() + $image_error;
                    }
                    else
                    {
                        $basic_erors = $this->Project->invalidFields();
                    }

                    $error_array["basics"] = $basic_erors;
                }

                $this->Project->setValidation("story_tab");
                $this->Project->set($this->data);
                $user_error = array(  );
                if( empty($this->data["User"]["biography"]) ) 
                {
                    $user_error["biography"] = "Please enter biography";
                }

                if( empty($this->data["User"]["city"]) ) 
                {
                    $user_error["country"] = "Please enter city";
                }

                if( empty($user_error) ) 
                {
                    $this->save_about_you($this->data);
                    $about_you = 1;
                }
                else
                {
                    $error_tabs["about_you"] = "about_you";
                    $error_array["about_you"] = $user_error;
                }

                if( $this->data["Project"]["active"] == 0 ) 
                {
                    if( !isset($this->data["Reward"]["pledge_amount"]) ) 
                    {
                        $this->data["Reward"]["pledge_amount"][0] = 0;
                        $this->data["Reward"]["description"][0] = "";
                        $this->data["Reward"]["est_delivery_month"][0] = "";
                        $this->data["Reward"]["est_delivery_year"][0] = "";
                        $this->data["Reward"]["project_id"][0] = $project_id;
                    }

                    $total_rewards_sent = count($this->data["Reward"]["pledge_amount"]);
                    $rewards_array = array(  );
                    $rewards_array["Project"]["id"] = $project_id;
                    for( $tr = 0; $tr < $total_rewards_sent; $tr++ ) 
                    {
                        if( !empty($this->data["Reward"]["id"][$tr]) ) 
                        {
                            $rewards_array["Reward"][$tr]["id"] = $this->data["Reward"]["id"][$tr];
                        }

                        $rewards_array["Reward"][$tr]["pledge_amount"] = $this->data["Reward"]["pledge_amount"][$tr];
                        $rewards_array["Reward"][$tr]["description"] = $this->data["Reward"]["description"][$tr];
                        $rewards_array["Reward"][$tr]["est_delivery_month"] = $this->data["Reward"]["est_delivery_month"][$tr];
                        $rewards_array["Reward"][$tr]["est_delivery_year"] = $this->data["Reward"]["est_delivery_year"][$tr];
                        $rewards_array["Reward"][$tr]["project_id"] = $project_id;
                        if( isset($this->data["Reward"]["limit"][$tr]) ) 
                        {
                            $rewards_array["Reward"][$tr]["limit"] = $this->data["Reward"]["limit"][$tr];
                            $rewards_array["Reward"][$tr]["limit_value"] = $this->data["Reward"]["limit_value"][$tr];
                        }
                        else
                        {
                            $rewards_array["Reward"][$tr]["limit"] = 0;
                            $rewards_array["Reward"][$tr]["limit_value"] = "";
                        }

                    }
                    if( !$this->Project->saveAll($rewards_array, array( "validate" => "first" )) ) 
                    {
                        $error_tabs["rewards"] = "rewards";
                        $error_array["rewards"] = $this->Project->invalidFields();
                    }
                    else
                    {
                        $rewards = 1;
                    }

                }

                if( !empty($error_array) ) 
                {
                    $this->Session->write("project_submision_error", $error_array);
                    echo json_encode($error_tabs);
                    exit();
                }

                $this->data["Project"]["slug"] = $this->Project->createSlug($this->data["Project"]["title"]);
                $this->save_basic_tabs($project_id, $this->data);
                $this->save_story_tab($project_id, $this->data);
                $this->Session->write("project_success", 1);
                if( $this->data["Project"]["active"] != 1 ) 
                {
                }
                else
                {
                    $this->Session->write("project_success_msg", __("project_detail_update_successfully", true));
                }

                echo "success";
                exit();
            }

        }

    }

    public function final_review($user_slug = null, $project_id = null)
    {
        $this->layout = "project";
        $page_detail = $this->Page->findById("89");
        $this->set("page_detail", $page_detail);
        $this->set("user_slug", $user_slug);
        $this->set("project_id", $project_id);
        $project_info = $this->Project->findById($project_id);
        if( isset($this->data) ) 
        {
            $update_project = array(  );
            $update_project["Project"]["id"] = $project_info["Project"]["id"];
            $update_project["Project"]["submitted_status"] = 1;
            $update_project["Project"]["active"] = 0;
            $this->Project->save($update_project, false);
            $this->Session->write("project_success_msg", __("project_created_successfully_wait_admin_approval", true));
            $this->redirect(array( "plugin" => "users", "controller" => "users", "action" => "profile", "slug" => $user_slug ));
        }

    }

    public function show_validation_errors($project_id = null, $tab = null)
    {
        $this->autoRender = false;
        $this->layout = false;
        $validation_errors = $this->Session->read("project_submision_error");
        $return_str = "";
        if( !empty($validation_errors[$tab]) ) 
        {
            $return_str = "<div class='error pt10'><ul>";
            foreach( $validation_errors[$tab] as $field => $error ) 
            {
                if( !is_array($error) ) 
                {
                    $return_str .= " <li>" . $error . " </li>";
                }
                else
                {
                    foreach( $error as $reward_index => $err ) 
                    {
                        $return_str .= "<strong>Follwoing Errors In Reward " . $reward_index + 1 . "</strong> <br />";
                        foreach( $err as $e ) 
                        {
                            $return_str .= " <li>" . $e . " </li>";
                        }
                    }
                }

            }
            $return_str .= "</ul></div>";
        }

        echo $return_str;
        exit();
    }

    public function get_countries()
    {
        $this->autoRender = false;
        $this->layout = false;
        $search_param = $this->params["url"]["q"];
        $this->loadModel("Country");
        $countries = $this->Country->find("list", array( "conditions" => array( "Country.name like" => $search_param . "%" ), "fields" => array( "iso3166_1", "name" ) ));
        $country_array = array(  );
        foreach( $countries as $country => $val ) 
        {
            $country_array[] = array( "id" => $country . "##" . $val, "name" => $val . ", " . $country );
        }
        return json_encode($country_array);
    }

    public function get_city()
    {
        $this->autoRender = false;
        $this->layout = false;
        $search_param = $this->params["url"]["q"];
        $this->loadModel("City");
        $country = Configure::read("CONFIG_COUNTRY");
        $cities = $this->City->find("list", array( "conditions" => array( "City.name like" => $search_param . "%", "City.iso3166_1" => $country ), "fields" => array( "id", "name" ) ));
        $city_array = array(  );
        foreach( $cities as $city => $val ) 
        {
            $city_array[] = array( "id" => $city . "##" . $val . "##" . $country, "name" => $val . ", " . $country );
        }
        return json_encode($city_array);
    }

    public function _get_user_backed_projects($user_id = null)
    {
        $this->loadModel("Backer");
        $user_backed_projects = $this->Backer->find("count", array( "conditions" => array( "Backer.user_id" => $user_id ), "group_by" => "Backer.project_id" ));
        return $user_backed_projects;
    }

    public function _user_current_active_projects($user_id = null, $limit = 5)
    {
        $this->Project->recursive = false;
        $current_projects = $this->Project->find("all", array( "conditions" => array( "Project.user_id" => $user_id, "Project.active" => 1 ), "limit" => $limit, "fields" => array( "Project.title", "Project.image", "Project.slug" ), "order" => "Project.id desc" ));
        return $current_projects;
    }

    public function _user_created_projects($user_id = null, $limit = 5)
    {
        $this->Project->recursive = false;
        $current_projects = $this->Project->find("all", array( "conditions" => array( "Project.user_id" => $user_id ), "limit" => $limit, "fields" => array( "Project.title", "Project.image", "Project.slug", "Project.created", "Project.user_id", "Project.id", "Project.project_end_date", "Project.active" ), "order" => "Project.id desc" ));
        return $current_projects;
    }

    public function widget($user_slug = null, $project_slug = null)
    {
        $this->layout = FALSE;
        $project_detail = $this->Project->find("first", array( "conditions" => array( "Project.slug" => $project_slug ) ));
        $this->loadModel("Country");
        $country = $this->Country->find("first", array( "conditions" => array( "Country.iso3166_1" => $project_detail["Project"]["project_country"] ), "fields" => array( "Country.name" ) ));
        $project_detail["Project"]["project_country"] = $country["Country"]["name"];
        $this->set("project_detail", $project_detail);
        if( $project_detail["Project"]["is_cancelled"] == 1 ) 
        {
            $this->show_project_cancellation_layout($project_detail);
        }

    }

    public function add_more_rewards($project_id = 0, $new_div_id = 0, $reward_counter)
    {
        $this->layout = "ajax";
        $this->autoRender = false;
        $this->set("new_div_id", $new_div_id);
        $this->set("reward_counter", $reward_counter);
        $this->render("/elements/projects/add_more_rewards");
    }

    public function share($project_id = 0)
    {
        $this->autoRender = false;
        $this->layout = false;
        $token = array(  );
        $project_info = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ), "fields" => array( "Project.project_preview_token", "User.slug" ) ));
        $token["Project"]["id"] = $project_id;
        if( empty($project_info["Project"]["project_preview_token"]) ) 
        {
            $token["Project"]["project_preview_token"] = $this->Project->RandomPasswordGenerator();
        }
        else
        {
            $token["Project"]["project_preview_token"] = "";
        }

        $this->Project->save($token);
        $return_array["share_token"] = $token["Project"]["project_preview_token"];
        $return_array["url"] = WEBSITE_URL . "projects/draft/" . $project_info["User"]["slug"] . "/" . $project_info["Project"]["id"] . "/" . $token["Project"]["project_preview_token"];
        return json_encode($return_array);
    }

    public function cancel_project($user_slug = null, $project_id = null)
    {
        $this->layout = "project";
        if( empty($user_slug) || is_null($user_slug) ) 
        {
            $this->_unauthorized_access();
            exit();
        }

        if( empty($project_id) || is_null($project_id) ) 
        {
            $this->_unauthorized_access();
            exit();
        }

        if( $user_slug != $this->Session->read("Auth.User.slug") ) 
        {
            $this->_unauthorized_access();
            exit();
        }

        //$project_info = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ), "fields" => array( "Project.project_preview_token", "User.slug", "Project.title", "Project.image", "Project.video", "Project.flv_file_name", "Project.video_image" ) ));
        //$project_info = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
		$project_info = $this->Project->findById($project_id);
        if( $this->data ) 
        {
            if( $this->data["Project"]["password"] != $this->Session->read("Auth.User.password_token") ) 
            {
                $this->set("invalid_password", "1");
            }
            else
            {
                $this->Project->id = $project_id;
                $this->Project->delete($project_id);
                $this->Reward->deleteAll("Reward.project_id=" . $project_id);
                $this->Session->write("project_success", 1);
				
				foreach($project_info['Backer'] as $backer)
				{
					$this->Notification->create_noti($backer['User']['id'], 'project_cancelled', $backer['Project']['id']);
					
					$from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
					$replyTo = "";
					$to = $project["User"]["email"];
					$subject = "Cancellation notification for " . $project["Project"]["title"];
					$backer = $this->User->findById($backer['user_id']);
					$to = $backer["User"]["email"];
					$this->set("backer", $backer);
					$this->set("project", $project_info);
					$element = "project_cancellation_to_backer_by_creator";
					$this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
				}
				
                if( empty($project_info["Project"]["title"]) ) 
                {
                    $projetc_title = __("profile_untitle_project", true);
                }
                else
                {
                    $projetc_title = $project_info["Project"]["title"];
                }

                $this->Session->write("project_success_msg", sprintf(__("project_deleted_successfully", true), $projetc_title));
                $this->redirect(array( "plugin" => false, "controller" => "home", "action" => "start" ));
            }

        }

        $this->set("project_info", $project_info);
    }

    public function draft($user_slug = null, $project_id = null, $token_id = null)
    {
        $this->layout = "project";
        if( empty($project_id) || is_null($project_id) ) 
        {
            $this->_unauthorized_access();
            exit();
        }

        $project_content = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ) ));
        $this->data = $project_content;
        $project_detail = $project_content;
        $country = $this->Country->find("first", array( "conditions" => array( "Country.iso3166_1" => $project_detail["User"]["country"] ), "fields" => array( "Country.name" ) ));
        $project_detail["User"]["country"] = $country["Country"]["name"];
        $backed_projects = $this->_get_user_backed_projects($project_detail["User"]["id"]);
        $project_detail["User"]["backed_projects"] = $backed_projects;
        $current_projects = $this->_user_current_active_projects($project_detail["User"]["id"]);
        $project_detail["User"]["user_current_projects"] = $current_projects;
        $this->set("project_detail", $project_detail);
        $this->render("/elements/projects/preview");
    }

    public function stared_project($project_slug = null)
    {
        $this->layout = false;
        $project_info = $this->Project->find("first", array( "conditions" => array( "Project.slug" => $project_slug ), "fields" => array( "Project.id" ) ));
        $project_id = $project_info["Project"]["id"];
        if( $this->Session->check("Auth.User.id") ) 
        {
            $check_already_stared = $this->StaredProject->find("first", array( "conditions" => array( "StaredProject.email" => $this->Session->read("Auth.User.email"), "StaredProject.project_id" => $project_id ) ));
            if( $check_already_stared ) 
            {
                echo $success = "already_exists";
                exit();
            }

            $this->data["StaredProject"]["user_id"] = $this->Session->read("Auth.User.id");
            $this->data["StaredProject"]["project_id"] = $project_id;
            $this->data["StaredProject"]["email"] = $this->Session->read("Auth.User.email");
            if( $this->StaredProject->save($this->data) ) 
            {
                echo $success = "success";
                exit();
            }

        }

        if( !empty($this->data) ) 
        {
            $this->data["Project"]["email"] = $this->data["StaredProject"]["email"];
            $this->Project->set($this->data);
            $this->Project->setValidation("stared_project");
            if( $this->Project->validates() ) 
            {
                $check_already_stared = $this->StaredProject->find("first", array( "conditions" => array( "StaredProject.email" => $this->data["StaredProject"]["email"], "StaredProject.project_id" => $project_id ) ));
                if( $check_already_stared ) 
                {
                    echo "already_exists" . "||" . "1";
                    exit();
                }

                $this->data["StaredProject"]["user_id"] = "0";
                $this->data["StaredProject"]["project_id"] = $project_id;
                if( $this->StaredProject->save($this->data) ) 
                {
                    echo "success" . "||" . "1";
                    exit();
                }

            }

        }

        $this->set("project_id", $project_id);
    }

    public function delete_stared_project($id = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        if( isset($id) && $this->StaredProject->delete($id) ) 
        {
            if( $this->params["isAjax"] ) 
            {
                echo $success = "success" . "||" . "";
                exit();
            }

            $this->Session->write("project_success", 1);
            $this->Session->write("project_success_msg", __("stared_project_removed_successfully", true));
            $this->redirect(array( "plugin" => "users", "controller" => "users", "action" => "starred_projects", "slug" => $this->Session->read("Auth.User.slug") ));
        }

    }

    public function get_user_created_projects()
    {
        $this->layout = false;
        $user_id = $this->Session->read("Auth.User.id");
        $projects = $this->_user_created_projects($user_id, 5);
        $this->set("projects", $projects);
    }

    public function pledge($slug = null, $id = null)
    {
        $this->layout = "project";
        if( is_null($slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->get_project_detail($slug);
        if( $project_detail["Project"]["is_cancelled"] == 1 ) 
        {
            $this->show_project_cancellation_layout($project_detail);
        }

        $project_id = $project_detail["Project"]["id"];
        $user_id = $this->Session->read("Auth.User.id");
        $this->set("id", $id);
        if( $this->Session->read("Auth.User.id") == $project_detail["User"]["id"] ) 
        {
            $this->Session->setFlash(__("project_ur_owner_you_can_not_back_project", true), "default", array( "class" => "example_class" ));
            $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "detail", $this->Session->read("Auth.User.slug"), $slug ));
        }

        if( $project_detail["Project"]["remaining_time"] <= 0 ) 
        {
            $this->Session->setFlash(__("project_funding_this_project_has_closed", true), "default");
            $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "detail", $project_detail["User"]["slug"], $slug ));
        }

        if( is_null($id) || !isset($id) || $id == 0 ) 
        {
            $pledge_session = $this->Session->read("pledge_session");
            $is_backed = $this->Backer->find("count", array( "conditions" => array( "Backer.project_id" => $project_id, "Backer.user_id" => $user_id ) ));
            if( 0 < $is_backed ) 
            {
                $this->Session->setFlash(__("project_you_already_backed_this_project", true), "default");
                $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "detail", $this->Session->read("Auth.User.slug"), $slug ));
            }

        }

        if( empty($this->data) ) 
        {
            if( is_null($id) || !isset($id) || $id == 0 ) 
            {
                if( isset($pledge_session[$user_id][$project_id]) ) 
                {
                    $this->data["Backer"]["id"] = 0;
                    $this->data["Backer"]["amount"] = $pledge_session[$user_id][$project_id]["Pledge"]["amount"];
                    $this->data["Backer"]["reward_id"] = $pledge_session[$user_id][$project_id]["Pledge"]["reward"]["id"];
                    return NULL;
                }

            }
            else
            {
                $back_info = $this->Backer->find("first", array( "conditions" => array( "Backer.id" => $id ) ));
                if( $back_info["Backer"]["user_id"] != $this->Session->read("Auth.User.id") ) 
                {
                    $this->_unauthorized_access();
                }

                $this->data = $back_info;
                return NULL;
            }

        }
        else
        {
            if( !empty($this->data) ) 
            {
                if( $this->data["Backer"]["reward_id"] != 0 && empty($this->data["Backer"]["amount"]) ) 
                {
                    foreach( $project_detail["Reward"] as $reward ) 
                    {
                        if( $reward["id"] == $this->data["Backer"]["reward_id"] ) 
                        {
                            $this->data["Backer"]["amount"] = $reward["pledge_amount"];
                        }

                    }
                }

                $this->Backer->setValidation("pledge");
                $this->Backer->set($this->data);
                if( $this->Backer->validates() ) 
                {
                    foreach( $project_detail["Reward"] as $reward ) 
                    {
                        if( $reward["id"] == $this->data["Backer"]["reward_id"] && $this->data["Backer"]["amount"] < $reward["pledge_amount"] ) 
                        {
                            $this->Backer->validationErrors["amount"] = __("project_sorry_you_must_pledge_least", true) . $reward["pledge_amount"] . " " . __("project_to_select_that_reward", true);
                        }

                    }
                    if( $this->Backer->validates() ) 
                    {
                        if( $this->data["Backer"]["reward_id"] != 0 ) 
                        {
                            foreach( $project_detail["Reward"] as $reward ) 
                            {
                                if( $reward["id"] == $this->data["Backer"]["reward_id"] ) 
                                {
                                    $pledge_session[$user_id][$project_id]["Pledge"]["reward"] = $reward;
                                }

                            }
                        }
                        else
                        {
                            $reward["id"] = $this->data["Backer"]["reward_id"];
                            $reward["description"] = __("project_pledger_no_want_to_help_project", true);
                            $pledge_session[$user_id][$project_id]["Pledge"]["reward"] = $reward;
                        }

                        $pledge_session[$user_id][$project_id]["Pledge"]["backer_id"] = $id;
                        $pledge_session[$user_id][$project_id]["Pledge"]["amount"] = $this->data["Backer"]["amount"];
                        $this->Session->write("pledge_session", $pledge_session);
                        if( !isset($id) || is_null($id) ) 
                        {
                            $id = 0;
                        }

                        $this->redirect(array( "controller" => "projects", "action" => "view_payment_detail", $slug, $id ));
                        return NULL;
                    }

                }
                else
                {
                    if( !isset($this->data["Backer"]["reward_id"]) ) 
                    {
                        $this->Backer->validationErrors["reward_id"] = __("project_payment_please_select_reward", true);
                    }

                }

            }

        }

    }

    public function view_payment_detail($slug = null, $id = null)
    {
        $this->layout = "project";
        if( is_null($slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->get_project_detail($slug);
        $project_id = $project_detail["Project"]["id"];
        $user_id = $this->Session->read("Auth.User.id");
        if( $project_detail["Project"]["remaining_time"] <= 0 ) 
        {
            $this->Session->setFlash(__("project_funding_this_project_has_closed", true), "default");
            $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "detail", $project_detail["User"]["slug"], $slug ));
        }

        $pledge_session = $this->Session->read("pledge_session");
        
        if( empty($pledge_session[$user_id][$project_id]) ) 
        {
            $this->redirect(array( "controller" => "projects", "action" => "detail", $project_detail["User"]["slug"], $project_detail["Project"]["slug"] ));
        }

        $this->set("id", $id);
        $this->set("pledge_info", $pledge_session[$user_id][$project_id]["Pledge"]);
    }

    public function processPayment($slug = null, $step = 1)
    {
        $this->layout = "project";
        if( is_null($slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->get_project_detail($slug);
        if( $project_detail["Project"]["is_cancelled"] == 1 ) 
        {
            $this->show_project_cancellation_layout($project_detail);
        }

        $project_id     = $project_detail["Project"]["id"];
        $user_id        = $this->Session->read("Auth.User.id");
        $pledge_session = $this->Session->read("pledge_session");

        if( empty($pledge_session[$user_id][$project_id]) ) 
        {
            $this->redirect(array( "controller" => "projects", "action" => "detail", $project_detail["User"]["slug"], $project_detail["Project"]["slug"] ));
        }

        $pledge_info = $pledge_session[$user_id][$project_id]["Pledge"];
        $reward_info = $this->Reward->find("first", array( "conditions" => array( "Reward.id" => $pledge_info["reward"]["id"] ) ));
        if( $pledge_info["backer_id"] != 0 && 1 < $step ) 
        {
            $backer_info          = $this->Backer->find("first", array( "conditions" => array( "Backer.id" => $pledge_info["backer_id"] ) ));
            $paymentInfo["token"] = $backer_info["Backer"]["transaction_id"];
            $do_void_result       = $this->Paypal->processPayment($paymentInfo, "DoVoid");
            $ack_do_void          = strtoupper($do_void_result["ACK"]);
            
            if( $ack_do_void != "SUCCESS" ) 
            {
                $ack_do_error = $do_void_result["L_LONGMESSAGE0"];
                $this->Session->setFlash($ack_do_error);
                $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "view_payment_detail", $slug, $pledge_info["backer_id"] ));
                exit();
            }

            $cancel_pay_log["PaymentLog"]["project_id"] = $project_id;
            $cancel_pay_log["PaymentLog"]["backer_id"] = $pledge_info["backer_id"];
            $cancel_pay_log["PaymentLog"]["user_id"] = $user_id;
            $cancel_pay_log["PaymentLog"]["payment_log_message"] = "Old Payment cancelled before update the pledge.";
            $this->PaymentLog->save($cancel_pay_log);
        }

        $this->set("step", $step);
        if( $step == 1 ) 
        {
            $paymentInfo["amount"] = $pledge_info["amount"];
            $paymentInfo["type"] = "Authorization";
            $paymentInfo["currency"] = Configure::read("CONFIG_CURRENCY");
            $paymentInfo["item_name"] = $project_detail["Project"]["title"];
            $paymentInfo["returnUrl"] = WEBSITE_URL . "projects/processPayment/" . $slug . "/2";
            $paymentInfo["cancelUrl"] = WEBSITE_URL . "projects/cancel_payment_process/" . $slug . "/2";
            $result = $this->Paypal->processPayment($paymentInfo, "SetExpressCheckout");
            $ack = strtoupper($result["ACK"]);
            if( $ack != "SUCCESS" ) 
            {
                $error = $result["L_LONGMESSAGE0"];
                $this->Session->setFlash($error);
                $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "view_payment_detail", $slug ));
                exit();
            }

            $token = urldecode($result["TOKEN"]);
            $payPalURL = PAYPAL_URL . $token;
            $this->redirect($payPalURL);
        }
        else
        {
            if( $step == 2 ) 
            {
                $token = $this->params["url"]["token"];
                $PAYERID = $this->params["url"]["PayerID"];
                $result = $this->Paypal->processPayment($token, "GetExpressCheckoutDetails");
                $result["PAYERID"] = $PAYERID;
                $result["TOKEN"] = $token;
                $result["ORDERTOTAL"] = $pledge_info["amount"];
                $result["PAYMENTACTION"] = "Authorization";
                $result["CURRENCYCODE"] = Configure::read("CONFIG_CURRENCY");
                $ack = strtoupper($result["ACK"]);
                if( $ack != "SUCCESS" ) 
                {
                    $error = $result["L_LONGMESSAGE0"];
                    $this->set("error", $error);
                    return NULL;
                }

                $this->set("result", $this->Session->read("result"));
                $this->Session->write("result", $result);
                $result_payment = $this->Paypal->processPayment($result, "DoExpressCheckoutPayment");
                $payment_ack = strtoupper($result["ACK"]);
                if( $ack != "SUCCESS" ) 
                {
                    $error = $result["L_LONGMESSAGE0"];
                    $this->set("error", $error);
                    return NULL;
                }

                App::import("Helper", "GeneralFunctions");
                $genral_function_obj = new GeneralFunctionsHelper();
                $user = $this->Session->read("Auth.User.id");
                if( $pledge_info["backer_id"] != 0 ) 
                {
                    $backer["Backer"]["id"] = $pledge_info["backer_id"];
                }

                $backer["Backer"]["project_id"] = $project_id;
                $backer["Backer"]["user_id"] = $user_id;
                $backer["Backer"]["reward_id"] = $pledge_info["reward"]["id"];
                $backer["Backer"]["amount"] = $pledge_info["amount"];
                $backer["Backer"]["currency"] = Configure::read("CONFIG_CURRENCY");
                $backer["Backer"]["paypal_payment_token_id"] = $result_payment["TOKEN"];
                $backer["Backer"]["transaction_id"] = $result_payment["TRANSACTIONID"];
                $backer["Backer"]["payment_status"] = "authorized";
                $this->Backer->save($backer);
                $activity["UserActivity"]["user_id"] = $user_id;
                $activity["UserActivity"]["subject_type"] = "project";
                $activity["UserActivity"]["subject_id"] = $project_id;
                $activity["UserActivity"]["activity_type"] = "backed";
                $this->UserActivity->save($activity);
                $pay_log["PaymentLog"]["project_id"] = $project_id;
                $pay_log["PaymentLog"]["backer_id"] = $this->Backer->id;
                $pay_log["PaymentLog"]["user_id"] = $user_id;
                $pay_log["PaymentLog"]["payment_log_message"] = "Payment Authorized.";
                $this->PaymentLog->save($pay_log);
                $this->Session->delete("pledge_session." . $user_id . "." . $project_id);
                $email_temp["user_name"] = $this->Session->read("Auth.User.name");
                $email_temp["project_name"] = $project_detail["Project"]["title"];
                $email_temp["project_owner_name"] = $project_detail["User"]["name"];
                $email_temp["amount"] = $backer["Backer"]["amount"];
                $email_temp["link"] = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "detail" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"];
                $email_temp["transaction_id"] = $backer["Backer"]["transaction_id"];
                $email_temp["funding_date"] = $genral_function_obj->get_project_ending_date_format($project_detail["Project"]["project_end_date"]);
                $this->set("email_temp", $email_temp);
                $this->set("pledge_info", $pledge_info);
                $this->set("reward_info", $reward_info);
                $replyTo = Configure::read("CONFIG_FROMEMAIL");
                $to = $this->Session->read("Auth.User.email");
                $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                if( $pledge_info["backer_id"] != 0 ) 
                {
                    $subject = "Pledge amount Updated Successfully.";
                    $element = "payment_updated_success";
                    $subject_project_owner = "Project Pledge Updated by " . $this->Session->read("Auth.User.name");
                    $element_project_owner = "payment_updated_success_project_owner";
                }
                else
                {
                    $this->loadModel("TempUserNotification");
                    $temp_user_notification = array(  );
                    $temp_user_notification["TempUserNotification"]["user_id"] = $this->Session->read("Auth.User.id");
                    $temp_user_notification["TempUserNotification"]["activity_type"] = "backed";
                    $temp_user_notification["TempUserNotification"]["subject_id"] = $project_detail["Project"]["id"];
                    $temp_user_notification["TempUserNotification"]["subject_type"] = "project";
                    $this->TempUserNotification->save($temp_user_notification);
                    $this->loadModel("TempProjectNotification");
                    $temp_array = array(  );
                    $temp_array["TempProjectNotification"]["project_id"] = $project_detail["Project"]["id"];
                    $temp_array["TempProjectNotification"]["activity_type"] = "backed";
                    $temp_array["TempProjectNotification"]["subject_id"] = $this->Backer->id;
                    $temp_array["TempProjectNotification"]["user_id"] = $this->Session->read("Auth.User.id");
                    $this->TempProjectNotification->save($temp_array);
                    $subject = "Project Backed Successfully.";
                    $element = "payment_success";
                    $subject_project_owner = "Project Backed by " . $this->Session->read("Auth.User.name");
                    $element_project_owner = "payment_success_project_owner";
                }

                $this->_sendMail($to, $from, $replyTo, $subject, $element);
                $this->Email->reset();
                if( $project_detail["User"]["notify_created_project_pledges"] == 1 ) 
                {
                    $to = $project_detail["User"]["email"];
                    $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                    $this->_sendMail($to, $from, $replyTo, $subject_project_owner, $element_project_owner);
                    $notification_array = array(  );
                    $notification_array["Notification"]["user_id"] = $project_detail["User"]["notify_created_project_pledges"];
                    $notification_array["Notification"]["notification_type"] = "backed_own_project";
                    $notification_array["Notification"]["subject_id"] = $project_detail["Project"]["id"];
                    $notification_array["Notification"]["subject_type"] = "project";
                    $notification_array["Notification"]["is_read"] = 0;
                    $notification_array["Notification"]["friend_id"] = $this->Session->read("Auth.User.id");
                }

                $this->Session->write("project_success", 1);
                $this->Session->write("project_success_msg", __("project_backed_the_project_successfully", true));
                $this->redirect(array( "plugin" => "users", "controller" => "users", "action" => "backed_projects", "slug" => $this->Session->read("Auth.User.slug") ));
            }

        }

    }

    public function cancel_pledge($id = null, $slug = null)
    {
        $this->layout = "project";
        if( is_null($slug) ) 
        {
            $this->_404error();
        }

        if( is_null($id) ) 
        {
            $this->_404error();
        }

        $backer_info = $this->Backer->find("first", array( "conditions" => array( "Backer.id" => $id ) ));
        if( $backer_info["Backer"]["user_id"] != $this->Session->read("Auth.User.id") ) 
        {
            $this->_unauthorized_access();
        }

        $project_detail = $this->get_project_detail($slug);
        if( isset($this->data["Reward"]["cancel_pledge"]) ) 
        {
            $paymentInfo["token"] = $backer_info["Backer"]["transaction_id"];
            $result = $this->Paypal->processPayment($paymentInfo, "DoVoid");
            $ack = strtoupper($result["ACK"]);
            if( $ack != "SUCCESS" ) 
            {
                $error = $result["L_LONGMESSAGE0"];
                $this->set("error", $error);
            }
            else
            {
                $pay_log["PaymentLog"]["project_id"] = $project_detail["Project"]["id"];
                $pay_log["PaymentLog"]["backer_id"] = $id;
                $pay_log["PaymentLog"]["user_id"] = $this->Session->read("Auth.User.id");
                $pay_log["PaymentLog"]["payment_log_message"] = "Autherized Payment Cancelled.";
                $this->PaymentLog->save($pay_log);
				
                $this->Backer->id = $id;
                $this->Backer->delete();
				
                $email_temp["Backer_info"] = $backer_info;
                $email_temp["Project_info"] = $project_detail["Project"];
                $email_temp["Project_info"]["link"] = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "detail" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"];
                $this->set("email_temp", $email_temp);
                $subject = "Pledge Removed Successfully.";
                $to = $this->Session->read("Auth.User.email");
                $replyTo = Configure::read("CONFIG_FROMEMAIL");
                $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                $element = "pledge_removed_backer";
                $this->_sendMail($to, $from, $replyTo, $subject, $element);
                $this->Email->reset();
				
                $subject = "Pledge removed by " . $backer_info["User"]["name"];
                $to = $project_detail["User"]["email"];
                $element = "pledge_removed_project_owner";
                $this->_sendMail($to, $from, $replyTo, $subject, $element);
                $this->Email->reset();
				
                $to = Configure::read("CONFIG_EMAIL");
                $element = "pledge_removed_project_owner";
                $this->_sendMail($to, $from, $replyTo, $subject, $element);
				
                $this->Session->write("project_success", 1);
                $this->Session->write("project_success_msg", __("project_update_backer_project_removed_successfully", true));
                $this->redirect(array( "plugin" => "users", "controller" => "users", "action" => "backed_history", "slug" => $this->Session->read("Auth.User.slug") ));
            }

        }

        $this->set("backer_info", $backer_info);
        $this->set("project_detail", $project_detail);
    }

    public function cancel_payment_process($slug = null)
    {
        $project_detail = $this->get_project_detail($slug);
        $project_id = $project_detail["Project"]["id"];
        $user_id = $this->Session->read("Auth.User.id");
        $this->Session->delete("pledge_session." . $user_id . "." . $project_id);
        $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "detail", $project_detail["User"]["slug"], $slug ));
    }

    public function project_backers($user = null, $project_slug = null)
    {
        $this->set("title_for_layout", __("project_backer_project_backer", true) . "&mdash; " . " " . Configure::read("CONFIG_SITE_TITLE"));
        $this->loadModel("Country");
        $this->loadModel("StaredProject");
        $this->loadModel("ProjectUpdate");
        if( empty($user) || is_null($user) ) 
        {
            $this->_404error();
        }

        if( empty($project_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->get_project_detail($project_slug);
        $conditions = array( "Backer.project_id" => $project_detail["Project"]["id"], "Backer.is_cancelled" => 0 );
        $this->get_loading_backer("Backer", $conditions, $order = "Backer.id DESC", "project_backers");
        if( $this->params["isAjax"] ) 
        {
            echo $this->render("/elements/load_more_backers");
            exit();
        }

        $count_comment = $this->ProjectUpdate->find("count", array( "conditions" => array( "ProjectUpdate.project_id" => $project_detail["Project"]["id"] ) ));
        $backer_comments = $this->ProjectComment->find("all", array( "conditions" => array( "ProjectComment.project_id" => $project_detail["Project"]["id"] ) ));
        $this->set("backer_comments", $backer_comments);
        $this->set("count_comment", $count_comment);
    }

    public function project_reward_survey($user = null, $project_slug = null)
    {
        $this->set("title_for_layout", __("project_backer_project_backer", true) . "&mdash; " . " " . Configure::read("CONFIG_SITE_TITLE"));
        $this->loadModel("Country");
        $this->loadModel("StaredProject");
        $this->loadModel("ProjectSurvey");
        $currency = Configure::read("CONFIG_CURRENCY");
        if( empty($user) || is_null($user) ) 
        {
            $this->_404error();
        }

        if( empty($project_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->get_project_detail($project_slug);
        $selectRewardData = array(  );
        if( 0 < count($project_detail["Reward"]) ) 
        {
            foreach( $project_detail["Reward"] as $rewardData ) 
            {
                $selectRewardData[$rewardData["id"]] = sprintf(__("backers_of_pledge_amount", true), $rewardData["pledge_amount"], $currency);
            }
        }

        $this->set("selectRewardData", $selectRewardData);
        if( !empty($this->data) ) 
        {
            $this->ProjectSurvey->set($this->data);
            $this->ProjectSurvey->setValidation("project_survey");
            if( $this->ProjectSurvey->validates() ) 
            {
                $this->data["ProjectSurvey"]["project_id"] = $project_detail["Project"]["id"];
                $this->data["ProjectSurvey"]["backers_count"] = count($project_detail["Backer"]);
                $this->data["ProjectSurvey"]["owner_id"] = $project_detail["User"]["id"];
                if( $this->ProjectSurvey->save($this->data, false) ) 
                {
                    $this->Session->write("stared_project_session", true);
                    $this->Session->write("stared_project_msg", __("project_survey_posted_successfully", true));
                    $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "project_reward_survey", $user, $project_slug ));
                }

            }

        }

        $project_surveys = $this->ProjectSurvey->find("all", array( "conditions" => array( "ProjectSurvey.project_id" => $project_detail["Project"]["id"] ), "order" => array( "ProjectSurvey.id DESC" ) ));
        $this->set("project_surveys", $project_surveys);
        if( $this->Session->check("stared_project_session") ) 
        {
            $this->set("stared_project_session", true);
            $this->set("stared_project_msg", $this->Session->read("stared_project_msg"));
            $this->Session->delete("stared_project_session");
            $this->Session->delete("stared_project_msg");
        }

    }

    public function backer_comment($user = null, $project_slug = null)
    {
        $this->loadModel("Country");
        $this->loadModel("StaredProject");
        $this->loadModel("ProjectUpdate");
        if( empty($user) || is_null($user) ) 
        {
            $this->_404error();
        }

        if( empty($project_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->get_project_detail($project_slug);
        $this->loadModel("ProjectComment");
        $conditions = array( "ProjectComment.project_id" => $project_detail["Project"]["id"] );
        $this->get_loading_backer_comment("ProjectComment", $conditions, $order = "ProjectComment.id DESC", "project_backer_comments");
        if( $this->params["isAjax"] ) 
        {
            echo $this->render("/elements/load_more_backer_comment");
            exit();
        }

        $count_comment = $this->ProjectUpdate->find("count", array( "conditions" => array( "ProjectUpdate.project_id" => $project_detail["Project"]["id"] ) ));
        $project_backers = $this->Backer->find("list", array( "conditions" => array( "Backer.project_id" => $project_detail["Project"]["id"] ), "fields" => "user_id" ));
        $backer_comments = $this->ProjectComment->find("all", array( "conditions" => array( "ProjectComment.project_id" => $project_detail["Project"]["id"] ) ));
        $this->set("backer_comments", $backer_comments);
        $this->set("project_backers", $project_backers);
        $this->set("count_comment", $count_comment);
    }

    public function project_backer_comment($project_slug = null)
    {
        $this->loadModel("ProjectComment");
        if( empty($project_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->Project->find("first", array( "conditions" => array( "Project.slug" => $project_slug ) ));
        if( !$this->Session->read("Auth.admin.id") && !$project_detail["Project"]["active"] ) 
        {
            $this->_404error();
        }

        if( !empty($this->data) ) 
        {
            $this->Project->set($this->data);
            $this->Project->setValidation("backer_comment");
            if( $this->Project->validates() ) 
            {
                $project_comment["ProjectComment"]["project_id"] = $project_detail["Project"]["id"];
                $project_comment["ProjectComment"]["user_id"] = $this->Session->read("Auth.User.id");
                $project_comment["ProjectComment"]["comment"] = $this->data["Project"]["comment"];
                if( $this->ProjectComment->save($project_comment, false) ) 
                {
                    if( $project_detail["User"]["notify_created_project_comment"] == 1 ) 
                    {
                        $subject_project_owner = "Comment received by " . $this->Session->read("Auth.User.name") . "on project " . $project_detail["Project"]["title"];
                        $to = $project_detail["User"]["email"];
                        $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                        $element_project_owner = "notify_getting_new_comment_on_project";
                        $project_detail["Project"]["link"] = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "detail" ), true) . "/" . $project_detail["Project"]["slug"];
                        $this->set("project_detail", $project_detail);
                        $this->set("project_comment", $project_comment);
                        $this->set("user", $this->Session->read("Auth.User"));
                        $this->_sendMail($to, $from, $replyTo = "", $subject_project_owner, $element_project_owner);
                        $notification_array = array(  );
                        $notification_array["Notification"]["user_id"] = $project_detail["User"]["notify_created_project_pledges"];
                        $notification_array["Notification"]["notification_type"] = "comment_own_project";
                        $notification_array["Notification"]["subject_id"] = $project_detail["Project"]["id"];
                        $notification_array["Notification"]["subject_type"] = "project";
                        $notification_array["Notification"]["is_read"] = 0;
                        $notification_array["Notification"]["friend_id"] = $this->Session->read("Auth.User.id");
                    }

                    $activity["UserActivity"]["user_id"] = $this->Session->read("Auth.User.id");
                    $activity["UserActivity"]["subject_type"] = "project";
                    $activity["UserActivity"]["subject_id"] = $project_detail["Project"]["id"];
                    $activity["UserActivity"]["activity_type"] = "project_comment";
                    $this->UserActivity->save($activity);
                    $this->loadModel("TempProjectNotification");
                    $temp_array = array(  );
                    $temp_array["TempProjectNotification"]["project_id"] = $project_detail["Project"]["id"];
                    $temp_array["TempProjectNotification"]["activity_type"] = "project_comment";
                    $temp_array["TempProjectNotification"]["subject_id"] = $this->ProjectComment->id;
                    $this->TempProjectNotification->save($temp_array);
                    echo "success ";
                    exit();
                }

            }

        }

    }

    public function project_creator_reply($project_slug = null, $comment_id = null)
    {
        $this->set("comment_id", $comment_id);
        $this->loadModel("ProjectComment");
        $this->loadModel("ProjectCommentThread");
        if( empty($project_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->Project->find("first", array( "conditions" => array( "Project.slug" => $project_slug ) ));
        if( !$this->Session->read("Auth.admin.id") && !$project_detail["Project"]["active"] ) 
        {
            $this->_404error();
        }

        if( !empty($this->data) ) 
        {
            $this->Project->set($this->data);
            $this->Project->setValidation("creator_reply");
            if( $this->Project->validates() ) 
            {
                $project_comment["ProjectCommentThread"]["project_id"] = $project_detail["Project"]["id"];
                $project_comment["ProjectCommentThread"]["project_comment_id"] = $this->data["Project"]["comment_id"];
                $project_comment["ProjectCommentThread"]["user_id"] = $this->Session->read("Auth.User.id");
                $project_comment["ProjectCommentThread"]["message"] = $this->data["Project"]["message"];
                if( $this->ProjectCommentThread->save($project_comment, false) ) 
                {
                    $userInfo = $this->ProjectComment->find("first", array( "fields" => array( "ProjectComment.user_id", "User.email", "User.name" ), "conditions" => array( "ProjectComment.id" => $this->data["Project"]["comment_id"] ) ));
                    $to = $userInfo["User"]["email"];
                    $from = $this->Session->read("Auth.User.email");
                    $subject = "Replied on your comment";
                    $element_commment_reply = "reply_comment_email";
                    $userInfo["Project"]["link"] = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "backer_comment" ), true) . "/" . $this->Session->read("Auth.User.slug") . "/" . $project_detail["Project"]["slug"];
                    $this->set("userInfo", $userInfo);
                    $this->_sendMail($to, $from, $replyTo = "", $subject, $element_commment_reply);
                    echo "success ";
                    exit();
                }

            }

        }

    }

    public function show_all_reply($comment_id = null)
    {
        $this->loadModel("ProjectCommentThread");
        $all_reply = array(  );
        $all_reply = $this->ProjectCommentThread->find("all", array( "conditions" => array( "ProjectCommentThread.project_comment_id" => $comment_id, "ProjectCommentThread.message_type" => "Reply" ) ));
        $this->set("all_reply", $all_reply);
        $this->render("/elements/show_all_reply_of_comment");
    }

    public function updates($user = null, $project_slug = null)
    {
        $this->loadModel("Country");
        $this->loadModel("StaredProject");
        $this->loadModel("ProjectUpdate");
        $this->loadModel("Project");
        $this->loadModel("ProjectComment");
        if( empty($user) || is_null($user) ) 
        {
            $this->_404error();
        }

        if( empty($project_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->get_project_detail($project_slug);
        $conditions = array( "ProjectUpdate.project_id" => $project_detail["Project"]["id"] );
        $limit = Configure::read("CONFIG_PROJECT_UPDATE");
        $this->get_loading("ProjectUpdate", $conditions, $order = "ProjectUpdate.id DESC", "project_updates", $limit);
        if( $this->params["isAjax"] ) 
        {
            echo $this->render("/elements/load_more_updates");
            exit();
        }

        $count_comment = $this->ProjectUpdate->find("count", array( "conditions" => array( "ProjectUpdate.project_id" => $project_detail["Project"]["id"] ) ));
        $backer_comments = $this->ProjectComment->find("all", array( "conditions" => array( "ProjectComment.project_id" => $project_detail["Project"]["id"] ) ));
        $this->set("backer_comments", $backer_comments);
        $this->set("count_comment", $count_comment);
        $project_update_session = $this->Session->read("project_update_session");
        $project_update_msg = $this->Session->read("project_update_msg");
        if( isset($project_update_session) ) 
        {
            $this->set("stared_project_session", $project_update_session);
            $this->set("stared_project_msg", $project_update_msg);
            $this->Session->delete("project_update_session");
            $this->Session->delete("project_update_msg");
        }

    }

    public function project_update($user = null, $project_slug = null, $update_id = null)
    {
        $this->loadModel("Country");
        $this->loadModel("StaredProject");
        $this->loadModel("ProjectUpdate");
        if( empty($user) || is_null($user) ) 
        {
            $this->_404error();
        }

        if( empty($project_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->get_project_detail($project_slug);
        if( !empty($this->data) ) 
        {
            $this->ProjectUpdate->set($this->data);
            $this->ProjectUpdate->setValidation("project_update");
            if( $this->ProjectUpdate->validates() ) 
            {
                if( $update_id == "" ) 
                {
                    $last_update_number = $this->ProjectUpdate->find("first", array( "conditions" => array( "ProjectUpdate.project_id" => $project_detail["Project"]["id"] ), "fields" => array( "MAX(ProjectUpdate.project_update_number)as last_update_number" ) ));
                    $new_update_number = $last_update_number[0]["last_update_number"] + 1;
                    $this->data["ProjectUpdate"]["project_update_number"] = $new_update_number;
                    $this->data["ProjectUpdate"]["project_id"] = $project_detail["Project"]["id"];
                    $this->data["ProjectUpdate"]["user_id"] = $this->Session->read("Auth.User.id");
                }
                else
                {
                    $this->data["ProjectUpdate"]["id"] = $update_id;
                }

                if( $this->ProjectUpdate->save($this->data, false) ) 
                {
                    $this->Session->write("project_update_session", "success");
                    if( !isset($update_id) && $update_id == "" ) 
                    {
                        $this->loadModel("TempProjectNotification");
                        $temp_array = array(  );
                        $temp_array["TempProjectNotification"]["project_id"] = $project_detail["Project"]["id"];
                        $temp_array["TempProjectNotification"]["activity_type"] = "update_posted";
                        $temp_array["TempProjectNotification"]["subject_id"] = $this->ProjectUpdate->id;
                        $temp_array["TempProjectNotification"]["user_id"] = $this->Session->read("Auth.User.id");
                        $this->TempProjectNotification->save($temp_array);
                        $this->Session->write("project_update_msg", __("project_update_posted_successfully", true));
                    }
                    else
                    {
                        $this->Session->write("project_update_msg", __("project_update_posted_update_successfully", true));
                    }

                    $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "project_update", $user, $project_slug ));
                }

            }

        }

        $this->loadModel("ProjectUpdateComment");
        $count_comment = $this->ProjectUpdate->find("count", array( "conditions" => array( "ProjectUpdate.project_id" => $project_detail["Project"]["id"] ) ));
        $backer_comments = $this->ProjectComment->find("all", array( "conditions" => array( "ProjectComment.project_id" => $project_detail["Project"]["id"] ) ));
        $project_faqs = $this->ProjectAskedQuestions->find("all", array( "conditions" => array( "ProjectAskedQuestions.project_id" => $project_detail["Project"]["id"], "ProjectAskedQuestions.user_id" => $project_detail["User"]["id"] ), "order" => array( "ProjectAskedQuestions.id DESC" ) ));
        $project_updates = $this->ProjectUpdate->find("all", array( "conditions" => array( "ProjectUpdate.project_id" => $project_detail["Project"]["id"] ), "order" => array( "ProjectUpdate.id DESC" ) ));
        $this->set("project_updates", $project_updates);
        $this->set("project_faqs", $project_faqs);
        $this->set("backer_comments", $backer_comments);
        $this->set("count_comment", $count_comment);
        $this->set("project_detail", $project_detail);
        $this->set("update_id", $update_id);
        if( isset($update_id) ) 
        {
            $edit_detail = $this->ProjectUpdate->find("first", array( "conditions" => array( "ProjectUpdate.id" => $update_id ) ));
            $this->data = $edit_detail;
        }

        $project_update_session = $this->Session->read("project_update_session");
        $project_update_msg = $this->Session->read("project_update_msg");
        if( isset($project_update_session) ) 
        {
            $this->set("stared_project_session", $project_update_session);
            $this->set("stared_project_msg", $project_update_msg);
            $this->Session->delete("project_update_session");
            $this->Session->delete("project_update_msg");
        }

    }

    public function project_update_detail($user = null, $project_slug = null, $update_id = null)
    {
        $this->loadModel("Country");
        $this->loadModel("StaredProject");
        $this->loadModel("ProjectUpdate");
        $this->loadModel("ProjectUpdateComment");
        if( empty($user) || is_null($user) ) 
        {
            $this->_404error();
        }

        if( empty($project_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->get_project_detail($project_slug);
        if( !empty($this->data) ) 
        {
            $this->ProjectUpdateComment->set($this->data);
            $this->ProjectUpdateComment->setValidation("project_update_comment");
            if( $this->ProjectUpdateComment->validates() ) 
            {
                $this->data["ProjectUpdateComment"]["project_id"] = $project_detail["Project"]["id"];
                $this->data["ProjectUpdateComment"]["user_id"] = $this->Session->read("Auth.User.id");
                $this->data["ProjectUpdateComment"]["update_id"] = $update_id;
                if( $this->ProjectUpdateComment->save($this->data, false) ) 
                {
                    $this->Session->write("update_comment", "success");
                    $this->Session->write("pass_msg", __("project_update_comment_posted_successfully", true));
                    $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "project_update_detail", $user, $project_slug, $update_id ));
                }

            }

        }

        $this->ProjectUpdateComment->bindModel(array( "belongsTo" => array( "User" ) ));
        $project_update_detail = $this->ProjectUpdate->find("first", array( "conditions" => array( "ProjectUpdate.id" => $update_id ) ));
        $this->set("project_update_detail", $project_update_detail);
        $conditions = array( "ProjectUpdateComment.update_id" => $update_id );
        $limit = Configure::read("CONFIG_PROJECT_LISTING");
        $this->get_loading("ProjectUpdateComment", $conditions, $order = "ProjectUpdateComment.id DESC", "project_update_comment", $limit);
        $count_comment = $this->ProjectUpdate->find("count", array( "conditions" => array( "ProjectUpdate.project_id" => $project_detail["Project"]["id"] ) ));
        $backer_comments = $this->ProjectComment->find("all", array( "conditions" => array( "ProjectComment.project_id" => $project_detail["Project"]["id"] ) ));
        $this->set("backer_comments", $backer_comments);
        $this->set("count_comment", $count_comment);
        if( $this->params["isAjax"] ) 
        {
            echo $this->render("/elements/load_more_updates_comment");
            exit();
        }

        $this->set("title_for_layout", $project_update_detail["ProjectUpdate"]["title"]);
        $this->set("description_for_layout", strip_tags($project_update_detail["ProjectUpdate"]["description"]));
        $update_comment = $this->Session->read("update_comment");
        $comment_msg = $this->Session->read("pass_msg");
        if( isset($update_comment) ) 
        {
            $this->set("msg_text", $comment_msg);
            $this->set("update_comment", $update_comment);
            $this->Session->delete("pass_msg");
            $this->Session->delete("update_comment");
        }

    }

    public function project_faq($user = null, $project_slug = null, $faq_id = null)
    {
        $this->loadModel("Country");
        $this->loadModel("StaredProject");
        $this->loadModel("ProjectUpdate");
        $this->loadModel("ProjectUpdateComment");
        if( empty($user) || is_null($user) ) 
        {
            $this->_404error();
        }

        if( empty($project_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->get_project_detail($project_slug);
        if( !empty($this->data) ) 
        {
            $this->ProjectAskedQuestions->set($this->data);
            $this->ProjectAskedQuestions->setValidation("project_faq");
            if( $this->ProjectAskedQuestions->validates() ) 
            {
                $this->data["ProjectAskedQuestions"]["project_id"] = $project_detail["Project"]["id"];
                $this->data["ProjectAskedQuestions"]["user_id"] = $this->Session->read("Auth.User.id");
                if( isset($faq_id) && $faq_id != "" ) 
                {
                    $this->data["ProjectAskedQuestions"]["id"] = $faq_id;
                }

                if( $this->ProjectAskedQuestions->save($this->data, false) ) 
                {
                    $this->Session->write("project_faq", "success");
                    if( isset($faq_id) && $faq_id != "" ) 
                    {
                        $this->Session->write("pass_msg", __("project_faq_question_update_successfily", true));
                        $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "project_faq", $user, $project_slug ));
                    }
                    else
                    {
                        $this->Session->write("pass_msg", __("project_faq_question_post_successfily", true));
                        $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "project_faq", $user, $project_slug ));
                    }

                }

            }

        }

        if( isset($faq_id) && $faq_id != "" ) 
        {
            $edit_faq = $this->ProjectAskedQuestions->find("first", array( "conditions" => array( "ProjectAskedQuestions.id" => $faq_id ) ));
            $this->data = $edit_faq;
            $this->set("faq_id", $faq_id);
        }

        $this->ProjectUpdateComment->bindModel(array( "belongsTo" => array( "User" ) ));
        $count_comment = $this->ProjectUpdate->find("count", array( "conditions" => array( "ProjectUpdate.project_id" => $project_detail["Project"]["id"] ) ));
        $backer_comments = $this->ProjectComment->find("all", array( "conditions" => array( "ProjectComment.project_id" => $project_detail["Project"]["id"] ) ));
        $project_faqs = $this->ProjectAskedQuestions->find("all", array( "conditions" => array( "ProjectAskedQuestions.project_id" => $project_detail["Project"]["id"], "ProjectAskedQuestions.user_id" => $project_detail["User"]["id"] ), "order" => array( "ProjectAskedQuestions.id DESC" ) ));
        $this->set("project_faqs", $project_faqs);
        $this->set("backer_comments", $backer_comments);
        $this->set("count_comment", $count_comment);
        $project_update_session = $this->Session->read("project_faq");
        $project_update_msg = $this->Session->read("pass_msg");
        if( isset($project_update_session) ) 
        {
            $this->set("stared_project_session", $project_update_session);
            $this->set("stared_project_msg", $project_update_msg);
            $this->Session->delete("project_faq");
            $this->Session->delete("pass_msg");
        }

    }

    public function project_faq_delete($user = null, $project_slug = null, $faq_id = null)
    {
        $this->loadModel("Country");
        $this->loadModel("StaredProject");
        $this->loadModel("ProjectUpdate");
        $this->loadModel("ProjectUpdateComment");
        if( empty($user) || is_null($user) ) 
        {
            $this->_404error();
        }

        if( empty($project_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->get_project_detail($project_slug);
        if( isset($faq_id) && $faq_id != "" && $this->ProjectAskedQuestions->delete($faq_id, true) ) 
        {
            $this->Session->write("project_faq", "success");
            $this->Session->write("pass_msg", __("project_faq_question_deleted_successfily", true));
            $this->redirect(array( "plugin" => false, "controller" => "projects", "action" => "project_faq", $user, $project_slug ));
        }

        $project_update_session = $this->Session->read("project_faq");
        $project_update_msg = $this->Session->read("pass_msg");
        if( isset($project_update_session) ) 
        {
            $this->set("stared_project_session", $project_update_session);
            $this->set("stared_project_msg", $project_update_msg);
            $this->Session->delete("project_faq");
            $this->Session->delete("pass_msg");
        }

    }

    public function discover()
    {
        $week_range = $this->CommonFunction->get_week_range(date("d"), date("m"), date("y"));
        $start_date = $week_range["week_start_date"];
        $end_date = $week_range["week_end_date"];
        $staff_projects = $this->Project->find("all", array( "conditions" => array( "Project.submitted_status" => 1, "Project.active" => 1, "Project.is_recommended" => 1 ), "order" => "Project.project_approved_by_admin_date DESC", "limit" => 3 ));
        $most_pledge_this_week = $this->Backer->find("all", array( "order" => "sum(Backer.amount) DESC", "group" => "Backer.project_id", "limit" => 6, "contain" => array( "Project" => array( "User" => array( "fields" => array( "id", "name", "slug" ) ), "Backer" => array( "fields" => array( "id", "amount", "user_id" ) ), "Reward" => array( "fields" => array( "id", "pledge_amount" ) ), "fields" => array( "Project.*" ) ) ) ));
        $recently_funded_projects = $this->Project->find("all", array( "conditions" => array( "Project.is_successful" => 1, "Project.is_funded" => 1 ), "order" => "Project.project_end_date DESC", "limit" => 6 ));
        $this->ProjectUpdate->recursive = 2;
        $projects_updates = $this->ProjectUpdate->find("all", array( "conditions" => array( "ProjectUpdate.active" => 1 ), "contain" => array( "Project" => array( "User" => array( "fields" => array( "id", "name", "slug" ) ), "fields" => array( "Project.id", "Project.title", "Project.slug", "Project.image", "Project.project_country" ) ), "ProjectUpdateComment" => array( "fields" => array( "ProjectUpdateComment.id" ) ) ), "order" => "ProjectUpdate.created DESC", "limit" => 6 ));
        $most_pledge_projects = $this->Backer->find("all", array( "order" => "sum(Backer.amount) DESC", "group" => "Backer.project_id", "limit" => 6, "contain" => array( "Project" => array( "User" => array( "fields" => array( "id", "name", "slug" ) ), "Backer" => array( "fields" => array( "id", "amount", "user_id" ) ), "Reward" => array( "fields" => array( "id", "pledge_amount" ) ), "fields" => array( "Project.*" ) ) ) ));
        $cat_list = $this->CommonFunction->get_category_subcat_list();
        $cities = $this->get_cities_of_projects();
        $this->set("cities", $cities);
        $this->set("cat_list", $cat_list);
        $this->set("staff_projects", $staff_projects);
        $this->set("most_pledge_this_week", $most_pledge_this_week);
        $this->set("most_pledge_projects", $most_pledge_projects);
        $this->set("recently_funded_projects", $recently_funded_projects);
        $this->set("projects_updates", $projects_updates);
    }

    public function index($type = "", $search_country = "")
    {
        $this->autoRender = false;
        if( $type == "popular" ) 
        {
            $week_range = $this->CommonFunction->get_week_range(date("d"), date("m"), date("y"));
            $start_date = $week_range["week_start_date"];
            $end_date = $week_range["week_end_date"];
            $conditions = array( "Backer.created BETWEEN ? AND ?" => array( $start_date, $end_date ), "Backer.is_cancelled" => 0 );
            $limit = Configure::read("CONFIG_PROJECT_LISTING");
            $this->get_loading_projects_by_backer("Backer", $conditions, "Backer.id DESC", "staff_projects", $limit, "Backer.project_id");
            $this->set("load_more_action", $this->params["action"] . "/" . $type);
            $this->set("title_for_layout", __("discover_project", true) . " &raquo;" . __("frnt_popular", true));
            $this->set("breadcrum", __("frnt_popular", true));
            $this->set("filter_type", $type);
            $this->set("tag_line", __("most_pledge_this_week", true));
            if( $this->params["isAjax"] ) 
            {
                echo $this->render("/elements/projects/load_more_search_projects_by_backer");
                exit();
            }

        }
        else
        {
            if( $type == "recently_launched" ) 
            {
                $conditions = array( "Project.submitted_status" => 1, "Project.active" => 1, "Project.is_cancelled" => 0 );
                $limit = Configure::read("CONFIG_PROJECT_LISTING");
                $this->get_loading("Project", $conditions, "Project.project_approved_by_admin_date DESC", "staff_projects", $limit);
                $this->set("load_more_action", $this->params["action"] . "/" . $type);
                $this->set("title_for_layout", __("discover_project", true) . "&raquo;" . __("recent_launched", true));
                $this->set("breadcrum", __("recent_launched", true));
                $this->set("filter_type", $type);
                $this->set("tag_line", __("news_fresh_project", true) . Configure::read("CONFIG_SITE_TITLE") . "!");
                if( $this->params["isAjax"] ) 
                {
                    echo $this->render("/elements/projects/load_more_search_projects");
                    exit();
                }

            }
            else
            {
                if( $type == "ending_soon" ) 
                {
                    $conditions = array( "Project.submitted_status" => 1, "Project.active" => 1, "Project.project_end_date >" . time(), "Project.is_cancelled" => 0 );
                    $limit = Configure::read("CONFIG_PROJECT_LISTING");
                    $this->get_loading("Project", $conditions, "Project.project_end_date ASC", "staff_projects", $limit);
                    $this->set("load_more_action", $this->params["action"] . "/" . $type);
                    $this->set("title_for_layout", __("discover_project", true) . "&raquo;" . __("ending-soon", true));
                    $this->set("breadcrum", __("ending-soon", true));
                    $this->set("filter_type", $type);
                    $this->set("tag_line", __("time_out_deadline_reached", true));
                    if( $this->params["isAjax"] ) 
                    {
                        echo $this->render("/elements/projects/load_more_search_projects");
                        exit();
                    }

                }
                else
                {
                    if( $type == "small_projects" ) 
                    {
                        $conditions = array( "Project.submitted_status" => 1, "Project.active" => 1, "Project.project_end_date >" . time(), "Project.funding_goal <=1000", "Project.is_cancelled" => 0 );
                        $limit = Configure::read("CONFIG_PROJECT_LISTING");
                        $this->get_loading("Project", $conditions, "Project.funding_goal ASC", "staff_projects", $limit);
                        $this->set("load_more_action", $this->params["action"] . "/" . $type);
                        $this->set("title_for_layout", __("discover_project", true) . "&raquo;" . __("small_project", true));
                        $this->set("breadcrum", __("small_project", true));
                        $this->set("filter_type", $type);
                        $this->set("tag_line", "");
                        if( $this->params["isAjax"] ) 
                        {
                            echo $this->render("/elements/projects/load_more_search_projects");
                            exit();
                        }

                    }
                    else
                    {
                        if( $type == "most_funded" ) 
                        {
                            $conditions = array( "Project.submitted_status" => 1, "Project.active" => 1, "Project.is_cancelled" => 0 );
                            $this->get_loading_projects_by_backer("Backer", $conditions, "count(Backer.id) DESC", "staff_projects", Configure::read("CONFIG_PROJECT_LISTING"), "Backer.project_id");
                            $this->set("load_more_action", $this->params["action"] . "/" . $type);
                            $this->set("title_for_layout", __("discover_project", true) . "&raquo;" . __("most_funded", true));
                            $this->set("breadcrum", __("most_funded", true));
                            $this->set("filter_type", $type);
                            $this->set("tag_line", "");
                            if( $this->params["isAjax"] ) 
                            {
                                echo $this->render("/elements/projects/load_more_search_projects_by_backer");
                                exit();
                            }

                        }
                        else
                        {
                            if( $type == "country" ) 
                            {
                                $conditions = array( "Project.submitted_status" => 1, "Project.active" => 1, "Project.project_country" => $search_country, "Project.is_cancelled" => 0 );
                                $limit = Configure::read("CONFIG_PROJECT_LISTING");
                                $this->get_loading("Project", $conditions, "Project.project_approved_by_admin_date DESC", "staff_projects", $limit);
                                $this->set("load_more_action", $this->params["action"] . "/" . $type . "/" . $search_country);
                                $this->set("title_for_layout", __("discover_project", true) . "&raquo;" . $search_country);
                                $this->set("breadcrum", __("most_funded", true));
                                $this->set("filter_type", $type);
                                $this->set("tag_line", __("most_funded_project_in", true) . " " . Configure::read("CONFIG_SITE_TITLE") . " " . __("history", true));
                                $this->set("search_country", $search_country);
                                if( $this->params["isAjax"] ) 
                                {
                                    echo $this->render("/elements/projects/load_more_search_projects");
                                    exit();
                                }

                            }
                            else
                            {
                                if( $type == "city" ) 
                                {
                                    $this->loadModel("City");
                                    $conditions = array( "Project.submitted_status" => 1, "Project.active" => 1, "Project.project_city" => $search_country, "Project.is_cancelled" => 0 );
                                    $city_name = $this->City->find("first", array( "conditions" => array( "City.id" => $search_country ) ));
                                    $limit = Configure::read("CONFIG_PROJECT_LISTING");
                                    $this->get_loading("Project", $conditions, "Project.project_approved_by_admin_date DESC", "staff_projects", $limit);
                                    $this->set("load_more_action", $this->params["action"] . "/" . $type . "/" . $search_country);
                                    $this->set("title_for_layout", __("discover_project", true) . "&raquo;" . $city_name["City"]["name"]);
                                    $this->set("breadcrum", __("Search", true));
                                    $this->set("filter_type", $type);
                                    $this->set("tag_line", "");
                                    $this->set("search_country", $search_country);
                                    if( $this->params["isAjax"] ) 
                                    {
                                        echo $this->render("/elements/projects/load_more_search_projects");
                                        exit();
                                    }

                                }
                                else
                                {
                                    if( isset($this->data) || $type == "keyword" && !empty($search_country) ) 
                                    {
                                        $type = "keyword";
                                        if( isset($this->data["Project"]["search"]) ) 
                                        {
                                            $search_country = $this->data["Project"]["search"];
                                        }

                                        $or_cond = array( "Project.title LIKE" => "" . "%" . $search_country . "%", "Project.short_description LIKE" => "" . "%" . $search_country . "%" );
                                        $conditions = array( "Project.submitted_status" => 1, "Project.active" => 1, "Project.is_cancelled" => 0, "OR" => $or_cond );
                                        $limit = Configure::read("CONFIG_PROJECT_LISTING");
                                        $this->get_loading("Project", $conditions, "Project.project_approved_by_admin_date DESC", "staff_projects", $limit);
                                        $this->set("load_more_action", $this->params["action"] . "/" . $type . "/" . $search_country);
                                        $this->set("title_for_layout", __("discover_project", true) . "&raquo;" . __("Search", true));
                                        $this->set("breadcrum", __("Search", true));
                                        $this->set("tag_line", " " . __("project_funded_for", true) . " \"" . $search_country . "\"");
                                        if( $this->params["isAjax"] ) 
                                        {
                                            echo $this->render("/elements/projects/load_more_search_projects");
                                            exit();
                                        }

                                    }
                                    else
                                    {
                                        $conditions = array( "Project.submitted_status" => 1, "Project.active" => 1, "Project.is_cancelled" => 0 );
                                        $limit = Configure::read("CONFIG_PROJECT_LISTING");
                                        $this->get_loading("Project", $conditions, "Project.project_approved_by_admin_date DESC", "staff_projects", $limit);
                                        $this->set("load_more_action", $this->params["action"]);
                                        $this->set("title_for_layout", __("discover_project", true));
                                        $this->set("breadcrum", __("Search", true));
                                        $this->set("tag_line", "");
                                        if( $this->params["isAjax"] ) 
                                        {
                                            echo $this->render("/elements/projects/load_more_search_projects");
                                            exit();
                                        }

                                    }

                                }

                            }

                        }

                    }

                }

            }

        }

        $cat_list = $this->CommonFunction->get_category_subcat_list();
        $countries = $this->get_countries_of_projects();
        $cities = $this->get_cities_of_projects();
        $this->set("cities", $cities);
        $this->set("countries", $countries);
        $this->set("cat_list", $cat_list);
        $this->render("/projects/project_filter");
    }

    public function staff_picks()
    {
        $this->autoRender = false;
        $conditions = array( "Project.submitted_status" => 1, "Project.active" => 1, "Project.is_recommended" => 1, "Project.is_cancelled" => 0 );
        $limit = Configure::read("CONFIG_PROJECT_LISTING");
        $this->get_loading("Project", $conditions, "Project.recommended_date DESC,Project.project_approved_by_admin_date DESC", "staff_projects", $limit);
        $this->set("load_more_action", $this->params["action"]);
        if( $this->params["isAjax"] ) 
        {
            echo $this->render("/elements/projects/load_more_search_projects");
            exit();
        }

        $cat_list = $this->CommonFunction->get_category_subcat_list();
        $cities = $this->get_cities_of_projects();
        $this->set("cities", $cities);
        $this->set("title_for_layout", __("discover_project", true) . " &raquo;" . __("staff_picker", true));
        $this->set("breadcrum", __("staff_picker", true));
        $this->set("tag_line", __("staff_pcker_we_like_they_r_creative_inspiring", true));
        $this->set("cat_list", $cat_list);
        $this->render("/projects/project_filter");
    }

    public function category_projects($category = null)
    {
        $this->autoRender = false;
        $category_info = $this->Category->find("first", array( "conditions" => array( "Category.slug" => $category ), "fields" => array( "Category.id", "Category.parent_id", "Category.category_name" ) ));
        $category_id = $category_info["Category"]["id"];
        $get_cat_child = $this->CommonFunction->get_category_child_ids($category_id);
        $get_cat_child[] = $category_id;
        $this->set("load_more_action", $this->params["action"] . "/" . $category);
        $this->set("active_category", $category);
        $conditions = array( "Project.submitted_status" => 1, "Project.active" => 1, "Project.is_cancelled" => 0, "Project.category_id" => $get_cat_child );
        $limit = Configure::read("CONFIG_PROJECT_LISTING");
        $this->get_loading("Project", $conditions, "Project.project_approved_by_admin_date DESC", "staff_projects", $limit);
        if( $this->params["isAjax"] ) 
        {
            echo $this->render("/elements/projects/load_more_search_projects");
            exit();
        }

        $cat_list = $this->CommonFunction->get_category_subcat_list();
        $cities = $this->get_cities_of_projects();
        $this->set("cities", $cities);
        $this->set("title_for_layout", __("discover_project", true) . " &raquo; " . $category_info["Category"]["category_name"]);
        $this->set("breadcrum", $category_info["Category"]["category_name"]);
        $this->set("category_info", $category_info);
        $this->set("cat_list", $cat_list);
        $this->render("/projects/project_filter");
    }

    public function get_loading_backer_comment($model, $condition = array(  ), $order, $return_variable)
    {
        if( isset($this->params["named"]["page"]) ) 
        {
            $current_page = $this->params["named"]["page"];
        }
        else
        {
            $current_page = 1;
        }

        $limit = Configure::read("CONFIG_PROJECT_COMMENT");
        $page = $current_page;
        $page = $page - 1;
        $lt = $page * $limit;
        $total_records = $this->$model->find("count", array( "conditions" => $condition ));
        $lastpage = ceil($total_records / $limit);
        $offset = "";
        if( 0 < $lt ) 
        {
            $offset = $lt . " , ";
        }

        $offset .= $limit;
        $this->ProjectComment->bindModel(array( "belongsTo" => array( "User" ) ));
        $data = $this->$model->find("all", array( "conditions" => $condition, "limit" => $offset, "order" => array( $order ) ));
        $this->set($return_variable, $data);
        $this->set("page", $current_page + 1);
        $this->set("last_page", $lastpage);
        $this->set("current_page", $current_page);
    }

    public function get_loading_backer($model, $condition = array(  ), $order, $return_variable)
    {
        if( isset($this->params["named"]["page"]) ) 
        {
            $current_page = $this->params["named"]["page"];
        }
        else
        {
            $current_page = 1;
        }

        $limit = Configure::read("CONFIG_PROJECT_BACKERS");
        $page = $current_page;
        $page = $page - 1;
        $lt = $page * $limit;
        $total_records = $this->$model->find("count", array( "conditions" => $condition ));
        $lastpage = ceil($total_records / $limit);
        $offset = "";
        if( 0 < $lt ) 
        {
            $offset = $lt . " , ";
        }

        $offset .= $limit;
        $data = $this->$model->find("all", array( "conditions" => $condition, "limit" => $offset, "order" => array( $order ) ));
        $this->set($return_variable, $data);
        $this->set("page", $current_page + 1);
        $this->set("last_page", $lastpage);
        $this->set("current_page", $current_page);
    }

    public function friend_projects()
    {
        $user = $this->Session->read("Auth.User");
        $contain_fields = array( "UserFollow.follow_user_id", "UserFollow.follow_user_id" );
        $friend_users = $this->CommonFunction->get_user_followings($user["id"], "list", $contain_fields);
        $result = $this->load_more_friends_backed_projects($friend_users);
        $this->set("total_records", $result["total_records"]);
        $this->set("staff_projects", $result["data"]);
        $this->set("current_page", $result["current_page"]);
        $this->set("last_page", $result["lastpage"]);
        $this->set("page", $result["page"]);
        $this->set("load_more_action", "friend_projects");
        if( $this->params["isAjax"] ) 
        {
            echo $this->render("/elements/projects/load_more_search_projects");
            exit();
        }

    }

    public function cancel_funding($user_slug = null, $project_id = null)
    {
        $this->layout = "project";
        if( empty($user_slug) || is_null($user_slug) ) 
        {
            $this->_unauthorized_access();
            exit();
        }

        if( empty($project_id) || is_null($project_id) ) 
        {
            $this->_unauthorized_access();
            exit();
        }

        if( $user_slug != $this->Session->read("Auth.User.slug") ) 
        {
            $this->_unauthorized_access();
            exit();
        }

        $project_info = $this->Project->find("first", array( "conditions" => array( "Project.id" => $project_id ), "fields" => array( "Project.project_preview_token", "User.slug", "Project.title", "Project.image", "Project.video", "Project.flv_file_name", "Project.video_image" ) ));
        if( $this->data ) 
        {
            if( $this->data["Project"]["password"] != $this->Session->read("Auth.User.password_token") ) 
            {
                $this->set("invalid_password", "1");
            }
            else
            {
                $this->Project->id = $project_id;
                $this->Project->saveField("cancellation_request_sent", 1);
                $cancel_request = array(  );
                $cancel_request["ProjectCancellationRequest"]["project_id"] = $project_id;
                $this->ProjectCancellationRequest->save($cancel_request);
                $this->Session->write("project_success", 1);
                if( empty($project_info["Project"]["title"]) ) 
                {
                    $projetc_title = __("profile_untitle_project", true);
                }
                else
                {
                    $projetc_title = $project_info["Project"]["title"];
                }

                $subject = "Project Cancellation Request";
                $to = Configure::read("CONFIG_EMAIL");
                $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                $body .= "Dear Admin, <br />";
                $body .= $project_info["User"]["name"] . " sent request for project <strong>" . $project_info["User"]["name"] . "</strong> cancellation.";
                $element = "cron_email_notification";
                $replyTo = Configure::read("CONFIG_FROMEMAIL");
                $this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
                $this->Session->write("project_success_msg", sprintf(__("project_cancel_request_sent", true), $projetc_title));
                $this->redirect(array( "plugin" => false, "controller" => "home", "action" => "start" ));
            }

        }

        $this->set("project_info", $project_info);
    }
}
