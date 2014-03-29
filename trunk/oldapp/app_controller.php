<?php 
//
// This source code was recovered by Recover-PHP.com
//


class AppController extends Controller
{
    public $components = array( "Auth", "Email", "Session", "RequestHandler", "Search.Prg", "Users.LogUtil", "Cookie", "Paypal", "CommonFunction" );
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Timezone", "Lang", "GeneralFunctions", "Time", "Number", "Facebook" );
    public $msg = "";
    public $sessiondata = "Auth.UserData";
    public $prefix = "";
    public $layout = "default";

    public function beforeRender()
    {
        if( $this->name == "CakeError" ) 
        {
            $this->layout = "";
        }

    }

    public function beforeFilter()
    {
        Security::sethash("md5");
        $heres = explode("/", $this->here);
        $this->Auth->autoRedirect = false;
        $Routingprefixes = Configure::read("Routing.prefixes");
        $loginAction = array( "plugin" => "users", "controller" => "users", "action" => "login" );
        if( isset($this->params["prefix"]) ) 
        {
            $Routingprefix = $this->params["prefix"];
            $loginAction[$Routingprefix] = true;
            $this->prefix = $loginRedirect = $logoutRedirect = $Routingprefix . "/";
            $this->layout = $Routingprefix;
            $this->sessiondata = "Auth." . $Routingprefix;
            $this->Auth->fields = array( "username" => "email", "password" => "passwd" );
            $this->Auth->loginRedirect = array( "plugin" => "users", "controller" => "users", "action" => "admin_dashboard" );
            $this->Auth->loginAction = $loginAction;
            $this->Auth->userScope = array( "User.is_admin" => 1, "User.active" => 1 );
        }
        else
        {
            $this->Auth->userScope = array( "User.is_admin" => 0, "User.active" => 1, "User.is_deleted" => 0 );
            $this->Auth->loginAction = $loginAction;
            $this->sessiondata = "Auth.User";
            $this->Auth->loginRedirect = array( "plugin" => false, "controller" => "home", "action" => "index" );
            $this->Auth->sessionKey = $this->sessiondata;
            $this->Auth->fields = array( "username" => "email", "password" => "passwd" );
        }

        $this->Auth->sessionKey = $this->sessiondata;
        $this->defineDbConstant();
        if( isset($this->params["prefix"]) ) 
        {
            if( $this->Session->read("Auth.admin.id") ) 
            {
                $right_panel = $this->admin_right_panel();
                $this->_getAllOnlineUsers();
                $this->set("right_panel", $right_panel);
                $allowed_to_all_users = array( "users/admin_dashboard", "users/admin_myaccount", "users/admin_logout" );
                if( $this->Session->read("Auth.admin.group_id") != 1 ) 
                {
                    $controller = $this->params["controller"];
                    $action = $this->params["action"];
                    $current_path = $controller . "/" . $action;
                    if( !in_array($current_path, $allowed_to_all_users) ) 
                    {
                        $this->checkAccess();
                    }

                }

            }

        }
        else
        {
            $this->_setLanguage();
        }

        $site_language = $this->Session->read("Config.language");
        if( empty($site_language) || $site_language == "eng" ) 
        {
            $site_language = "eng";
            $lang_var = "";
        }
        else
        {
            $lang_var = "_" . $site_language;
        }

        $this->set("lang_var", $lang_var);
        $this->set("lang", $site_language);
    }

    public function checkAccess()
    {
        $this->loadModel("group_privileges.GroupPrivilege");
        $group_id = $this->Session->read("Auth.admin.group_id");
        $modulePermissions = $this->GroupPrivilege->find("all", array( "conditions" => "GroupPrivilege.group_id=" . $group_id ));
        $controller = $this->params["controller"];
        $action = $this->params["action"];
        $allowed_permissions_array = $this->Session->read("Auth.admin.permissions");
        $current_path = $controller . "/" . $action;
        $allow_per = 0;
        if( !in_array($current_path, $allowed_permissions_array) ) 
        {
            $this->Session->setFlash("You are no autherized to access this page.", "admin/error");
            $this->redirect(array( "plugin" => "users", "controller" => "users", "action" => "dashboard" ));
        }

    }

    public function defineDbConstant()
    {
        $this->loadModel("Settings.Setting");
        $configs_array = $this->Setting->find("all");
        if( !empty($configs_array) ) 
        {
            foreach( $configs_array[0]["Setting"] as $key => $value ) 
            {
                $constant = "CONFIG_" . strtoupper($key);
                if( !defined($constant) ) 
                {
                    Configure::write($constant, $value);
                }

            }
        }

        $question_about_array = array( 
			"Problems with my Pledge" => __("problen_with_pledge", true), 
			"Boostbloom login" => __("BoostBloom_account_login", true), 
			"Images & Videos" => __("images_videos", true), 
			"My Project Idea" => __("my_project_idea", true), 
			"Getting Featured" => __("getting_featured", true), 
			"International" => __("international", true), 
			"Press" => __("press", true), 
			"Other" => __("other", true) 
				);
		
		
        $question_about_login_array = array( 
			"Problems with my Pledge" => __("problen_with_pledge", true), 
			"Boostbloom login" => __("BoostBloom_account_login", true), 
			"Images & Videos" => __("images_videos", true), 
			"My Project Idea" => __("my_project_idea", true), 
			"Getting Featured" => __("getting_featured", true), 
			"International" => __("international", true), 
			"Press" => __("press", true), 
			"Project Cancel Request" => __("cancelled_projects", true), 
			"Other" => __("other", true) 
		);
		
        Configure::write("question_about_array", $question_about_array);
        Configure::write("question_about_login_array", $question_about_login_array);
    }

    public function downloadFile($filename, $downloadPath, $alt_name = "")
    {
        $file = $downloadPath . $filename;
        if( !is_file($file) ) 
        {
            exit( "<b>404 File not found!</b>" );
        }

        $len = filesize($file);
        $filename = basename($file);
        $file_extension = strtolower(substr(strrchr($filename, "."), 1));
        switch( $file_extension ) 
        {
            case "pdf":
                $ctype = "application/pdf";
                break;
            case "exe":
                $ctype = "application/octet-stream";
                break;
            case "zip":
                $ctype = "application/zip";
                break;
            case "docx":
                $ctype = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
                break;
            case "doc":
                $ctype = "application/msword";
                break;
            case "xlsx":
                $ctype = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
                break;
            case "xls":
                $ctype = "application/vnd.ms-excel";
                break;
            case "ppt":
                $ctype = "application/vnd.ms-powerpoint";
                break;
            case "gif":
                $ctype = "image/gif";
                break;
            case "png":
                $ctype = "image/png";
                break;
            case "jpeg":
            case "jpg":
                $ctype = "image/jpg";
                break;
            case "mp3":
                $ctype = "audio/mpeg";
                break;
            case "wav":
                $ctype = "audio/x-wav";
                break;
            case "mpeg":
            case "mpg":
            case "mpe":
                $ctype = "video/mpeg";
                break;
            case "mov":
                $ctype = "video/quicktime";
                break;
            case "avi":
                $ctype = "video/x-msvideo";
                break;
            case "php":
            case "htm":
            case "html":
                exit( "<b>Cannot be used for " . $file_extension . " files!</b>" );
            default:
                $ctype = "application/force-download";
        }
        @ob_end_clean();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("" . "Content-Type: " . $ctype);
        if( $alt_name == "" ) 
        {
            $alt_name = $filename;
        }
        else
        {
            $alt_name = $alt_name . "." . $file_extension;
        }

        $header = "Content-Disposition: attachment; filename=" . $alt_name . ";";
        header($header);
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $len);
        @readfile($file);
        exit();
    }

    public function _sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ))
    {
        $toAraay = array(  );
        if( !is_array($to) ) 
        {
            $toAraay[] = $to;
        }
        else
        {
            $toAraay = $to;
        }

        foreach( $parsingParams as $key => $value ) 
        {
            $this->set($key, $value);
        }
        foreach( $toAraay as $email ) 
        {
            $this->Email->to = $email;
            $this->Email->subject = $subject;
            if( empty($replyTo) ) 
            {
                $replyTo = "no-reply@boostbloom.com";
            }

            $this->Email->from = $from;
            if( $attachments != "" ) 
            {
                $this->Email->attachments = array(  );
                $this->Email->attachments[0] = $attachments;
            }

            $this->Email->template = $element;
            $this->Email->sendAs = $sendAs;
            $this->Email->send();
            $this->Email->reset();
        }
    }

    public function admin_right_panel()
    {
        $this->loadModel("categories.Category");
        $this->loadModel("users.User");
        $this->loadModel("Project");
        $site_user = $this->User->find("count", array( "conditions" => array( "User.is_admin=0" ) ));
        $admin_user = $this->User->find("count", array( "conditions" => array( "User.is_admin=1" ) ));
        $categories = $this->Category->find("count", array( "conditions" => array(  ) ));
        $projects = $this->Project->find("count", array( "conditions" => array( "Project.submitted_status" => 1 ) ));
        $returnArray = array( "site_user" => $site_user, "admin_user" => $admin_user, "categories" => $categories, "projects" => $projects );
        return $returnArray;
    }

    public function recordActivity()
    {
        $this->loadModel("User");
        $this->User->id = $this->Session->read("Auth.User.id");
        $this->User->saveField("last_activity", time());
    }

    public function _getAllOnlineUsers()
    {
        $this->loadModel("users.User");
        $this->loadModel("groups.Group");
        $this->User->bindModel(array( "belongsTo" => array( "Group" => array(  ) ) ));
        $onlineUsersList = array(  );
        if( $this->Session->check("Auth.admin.id") ) 
        {
            $onlineUsersList = $this->User->find("all", array( "fields" => array( "User.id,User.name,User.is_login,User.active,User.profile_image,Group.name" ), "conditions" => array( "User.is_login" => "1", "User.active" => "1", "User.id !=" => $this->Session->read("Auth.admin.id"), "User.is_admin" => 1 ) ));
        }

        $this->set("onlineUsersList", $onlineUsersList);
    }

    public function _setLanguage()
    {
        if( !$this->Session->check("Config.language") && !$this->Cookie->read("lang") ) 
        {
            $this->Session->write("Config.language", Configure::read("CONFIG_SITE_DEFAULT_LANGUAGE"));
        }
        else
        {
            if( isset($this->params["language"]) && $this->params["language"] != $this->Session->read("Config.language") ) 
            {
                $this->Session->write("Config.language", $this->params["language"]);
                $this->Cookie->write("lang", $this->params["language"], false, "20 days");
                if( "/" . $this->Session->read("Config.language") == $this->referer() ) 
                {
                    return NULL;
                }

                $this->redirect($this->referer());
                exit();
            }

            if( $this->Cookie->read("lang") && !$this->Session->check("Config.language") ) 
            {
                $this->Session->write("Config.language", $this->Cookie->read("lang"));
            }

        }

    }

    public function _unauthorized_access()
    {
        $this->layout = "";
        echo $this->render("/unauthorized_access");
        exit();
    }

    public function _404error()
    {
        $this->layout = "";
        echo $this->render("/404error");
        exit();
    }

    public function get_file_extension($fileName = null)
    {
        $fileNameParts = explode(".", $fileName);
        $fileExtension = end($fileNameParts);
        return $fileExtension = strtolower($fileExtension);
    }

    public function getImageMimeType($filename)
    {
        if( !function_exists("getimagesize") ) 
        {
            debug("AppController::getImageMimeType" . " LibGD PHP Extension was not found, please refer to http://www.php.net/manual/en/book.image.php");
            exit();
        }

        $result = getimagesize($filename);
        if( isset($result["mime"]) ) 
        {
            return $result["mime"];
        }

        return false;
    }

    public function get_loading($model, $condition = array(  ), $order = "", $return_variable, $limit = 10, $group_by = "")
    {
        if( isset($this->params["named"]["page"]) ) 
        {
            $current_page = $this->params["named"]["page"];
        }
        else
        {
            $current_page = 1;
        }

        $page = $current_page;
        $page = $page - 1;
        $lt = $page * $limit;
        if( !empty($group_by) ) 
        {
            $total_records = $this->$model->find("count", array( "conditions" => $condition, "group" => $group_by, "order" => $order ));
        }
        else
        {
            $total_records = $this->$model->find("count", array( "conditions" => $condition ));
        }

        if( 0 < $total_records ) 
        {
            $lastpage = ceil($total_records / $limit);
        }
        else
        {
            $lastpage = 0;
        }

        $offset = "";
        if( 0 < $lt ) 
        {
            $offset = $lt . " , ";
        }

        $offset .= $limit;
        if( empty($order) ) 
        {
            $order = $model . ".id";
        }

        if( !empty($group_by) ) 
        {
            $data = $this->$model->find("all", array( "conditions" => $condition, "limit" => $offset, "order" => array( $order ), "group" => $group_by ));
        }
        else
        {
            $data = $this->$model->find("all", array( "conditions" => $condition, "limit" => $offset, "order" => array( $order ) ));
        }

        $this->set($return_variable, $data);
        $this->set("total_results", $total_records);
        $this->set("page", $current_page + 1);
        $this->set("last_page", $lastpage);
        $this->set("current_page", $current_page);
    }

    public function get_loading_projects_by_backer($model = "Backer", $condition = array(  ), $order = "", $return_variable, $limit = 10, $group_by = "")
    {
        $this->Backer->recursive = 2;
        if( isset($this->params["named"]["page"]) ) 
        {
            $current_page = $this->params["named"]["page"];
        }
        else
        {
            $current_page = 1;
        }

        $page = $current_page;
        $page = $page - 1;
        $lt = $page * $limit;
        if( !empty($group_by) ) 
        {
            $total_project_list = $this->Backer->find("all", array( "conditions" => $condition, "fields" => array( "Backer.id" ), "group" => "Backer.project_id" ));
            $total_records = count($total_project_list);
        }
        else
        {
            $total_records = $this->$model->find("count", array( "conditions" => $condition ));
        }

        $lastpage = ceil($total_records / $limit);
        $offset = "";
        if( 0 < $lt ) 
        {
            $offset = $lt . " , ";
        }

        $offset .= $limit;
        if( empty($order) ) 
        {
            $order = $model . ".id";
        }

        if( !empty($group_by) ) 
        {
            $data = $this->$model->find("all", array( "conditions" => $condition, "limit" => $offset, "order" => array( $order ), "group" => $group_by, "contain" => array( "Project" => array( "User" => array( "fields" => array( "id", "name", "slug" ) ), "Backer" => array( "fields" => array( "id", "amount", "user_id" ) ), "Reward" => array( "fields" => array( "id", "pledge_amount" ) ), "fields" => array( "Project.*" ) ) ) ));
        }
        else
        {
            $data = $this->$model->find("all", array( "conditions" => $condition, "limit" => $offset, "order" => array( $order ) ));
        }

        $this->set($return_variable, $data);
        $this->set("total_results", $total_records);
        $this->set("page", $current_page + 1);
        $this->set("last_page", $lastpage);
        $this->set("current_page", $current_page);
    }

    public function load_more_friends_backed_projects($friends = array(  ), $limit = "")
    {
        if( isset($this->params["named"]["page"]) ) 
        {
            $current_page = $this->params["named"]["page"];
        }
        else
        {
            $current_page = 1;
        }

        if( empty($limit) ) 
        {
            $limit = Configure::read("CONFIG_PAGE_LIMIT");
        }

        $page = $current_page;
        $page = $page - 1;
        $lt = $page * $limit;
        $total_project_list = $this->Backer->find("list", array( "conditions" => array( "Backer.user_id" => $friends ), "fields" => array( "Backer.id" ), "group" => "Backer.project_id" ));
        $total_records = count($total_project_list);
        $lastpage = ceil($total_records / $limit);
        $offset = "";
        if( 0 < $lt ) 
        {
            $offset = $lt . " , ";
        }

        $offset .= $limit;
        $conditions = array( "Backer.user_id" => $friends );
        $this->Backer->recursive = 2;
        $backed_project = $this->Backer->find("list", array( "fields" => array( "project_id" ), "conditions" => array( "Backer.user_id" => $friends ), "limit" => $offset, "group" => "Backer.project_id", "order" => array( "Backer.created DESC" ) ));
        $project_cond = array( "Project.id" => $backed_project );
        $data = $this->Project->find("all", array( "conditions" => $project_cond ));
        $return_array["data"] = $data;
        $return_array["current_page"] = $current_page;
        $return_array["total_records"] = $total_records;
        $return_array["lastpage"] = $lastpage;
        $return_array["page"] = $current_page + 1;
        return $return_array;
    }

    public function get_countries_of_projects()
    {
        $this->loadModel("Project");
        $this->loadModel("Country");
        $project_countries = $this->Project->find("list", array( "conditions" => array( "Project.project_country <> \"\"" ), "fields" => array( "Project.id", "Project.project_country" ), "group" => "Project.project_country", "order" => "Project.project_country ASC" ));
        $countries = $this->Country->find("all", array( "conditions" => array( "Country.iso3166_1" => $project_countries ), "fields" => array( "Country.name", "Country.iso3166_1" ) ));
        return $countries;
    }

    public function get_cities_of_projects()
    {
        $this->loadModel("Project");
        $this->loadModel("Country");
        $this->loadModel("City");
        $project_cities = $this->Project->find("list", array( "conditions" => array( "Project.project_city <> \"\"" ), "fields" => array( "Project.id", "Project.project_city" ), "group" => "Project.project_city", "order" => "Project.project_city ASC" ));
        $cities = $this->City->find("all", array( "conditions" => array( "City.id" => $project_cities ), "fields" => array( "City.id", "City.name" ) ));
        return $cities;
    }

}
