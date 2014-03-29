<?php 
//
// This source code was recovered by Recover-PHP.com
//

class SettingsController extends SettingsAppController
{
    public $name = "Settings";
    public $uses = array( "settings.Setting" );
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Javascript" );

    public function beforeFilter()
    {
        parent::beforefilter();
        $this->set("model", $this->modelClass);
        if( !Configure::read("App.defaultEmail") ) 
        {
            Configure::write("App.defaultEmail", Configure::read("noreply_email.email"));
        }

    }

    public function admin_index()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Setting", "Setting Management", true) );
        $this->set("breadcrumb", $breadcrumb);
        $this->loadModel("Country");
        $this->loadModel("City");
        $countries = $this->Country->find("list", array( "fields" => array( "Country.iso3166_1", "Country.name" ), "order" => array( "Country.name asc" ) ));
        $this->set("countries", $countries);
        if( !empty($this->data) ) 
        {
            $this->Setting->set($this->data);
            if( $this->Setting->validates() ) 
            {
                $res = $this->CommonFunction->get_city_json_fomrat($this->data["Setting"]["city"]);
                $this->data["Setting"]["city"] = $res["city_id"];
                $this->data["Setting"]["city_json"] = $res["city_json"];
                $this->data["Setting"]["id"] = 1;
                if( is_array($this->data["Setting"]["country"]) ) 
                {
                    $this->data["Setting"]["country"] = implode(",", $this->data["Setting"]["country"]);
                }

                if( !empty($this->data["Setting"]["start_project_video_file"]["name"]) ) 
                {
                    $allowed_extension = Configure::read("allowed_video_files");
                    $fileExtension = $this->get_file_extension($this->data["Setting"]["start_project_video_file"]["name"]);
                    $extension = "ffmpeg";
                    $extension_soname = $extension . "." . PHP_SHLIB_SUFFIX;
                    $extension_fullname = PHP_EXTENSION_DIR . "/" . $extension_soname;
                    $tempFile = $this->data["Setting"]["start_project_video_file"]["tmp_name"];
                    $targetPath = START_PROJECT_ORIGIONAL_VIDEO_DIR_PATH;
                    $filename = "start_project_" . "_" . time() . $this->data["Setting"]["start_project_video_file"]["name"];
                    $targetFile = $targetPath . $filename;
                    if( $fileExtension == "avi" || $fileExtension == "wmv" || $fileExtension == "mpeg" || $fileExtension == "mpg" || $fileExtension == "mov" || $fileExtension == "mp4" || $fileExtension == "flv" ) 
                    {
                        move_uploaded_file($tempFile, $targetFile);
                        $flv_convert_file_path = START_PROJECT_FLV_VIDEO_DIR_PATH;
                        $flv_file_name = "project" . "_" . time() . ".flv";
                        $image_file_name = "project" . "_" . time() . ".jpg";
                        $directory_path_full = $targetFile;
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

                        exec("ffmpeg -i " . $targetFile . " -f image2 -vframes 1 " . START_PROJECT_FLV_VIDEO_HTTP_PATH . $image_file_name);
                        $this->data["Setting"]["start_project_video"] = $flv_file_name;
                    }

                }

                if( $this->Setting->save($this->data) ) 
                {
                    $this->Session->setFlash(__d("Setting", "Setting saved  successfully.", true), "admin/success");
                    $this->redirect(array( "action" => "index" ));
                    return NULL;
                }

            }
            else
            {
                if( !empty($this->data["Setting"]["country"]) ) 
                {
                    $res = $this->CommonFunction->get_city_json_fomrat($this->data["Setting"]["city"]);
                    $this->data["Setting"]["city"] = $res["city_id"];
                    $this->data["Setting"]["city_json"] = $res["city_json"];
                    return NULL;
                }

            }

        }
        else
        {
            $config = $this->Setting->find();
            $cities = array(  );
            if( !empty($config["Setting"]["country"]) ) 
            {
                $country = explode(",", $config["Setting"]["country"]);
            }

            $this->data = $config;
        }

    }

    public function admin_get_cities($country)
    {
        $this->autoRender = false;
        $this->layout = false;
        $search_param = $this->params["url"]["q"];
        $this->loadModel("City");
        $cities = $this->City->find("list", array( "conditions" => array( "City.name like" => $search_param . "%", "City.iso3166_1" => $country ), "fields" => array( "id", "name" ) ));
        $city_array = array(  );
        foreach( $cities as $city => $val ) 
        {
            $city_array[] = array( "id" => $city . "##" . $val . "##" . $country, "name" => $val . ", " . $country );
        }
        return json_encode($city_array);
    }

}




?>