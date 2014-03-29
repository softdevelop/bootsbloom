<?php 
//
// This source code was recovered by Recover-PHP.com
//

class StaticimagesController extends StaticimagesAppController
{
    public $name = "Staticimages";
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript" );
    public $components = array( "Auth", "Session", "Email", "Cookie", "Search.Prg" );
    public $presetVars = array( array( "field" => "caption", "type" => "value" ) );
    public $caption = array( "Staticimages.Staticimage" );

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
        $breadcrumb = array( "pages" => $pages, "active" => __d("users", "Staticimage", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) && isset($this->data["recordsPerPage"]) ) 
        {
            $limitValue = $limit = $this->data["recordsPerPage"];
            $this->Session->write($this->caption . "." . $this->action . ".recordsPerPage", $limit);
        }
        else
        {
            $this->Prg->commonProcess();
        }

        $limitValue = $limit = $this->Session->read($this->caption . "." . $this->action . ".recordsPerPage") ? $this->Session->read($this->caption . "." . $this->action . ".recordsPerPage") : Configure::read("defaultPaginationLimit");
        $this->set("limitValue", $limitValue);
        $this->set("limit", $limit);
        $searchTerm = "";
        $this->{$this->modelClass}->data[$this->modelClass] = $this->passedArgs;
        $parsedConditions = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("result", $this->paginate());
    }

    public function admin_add_image()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("users", "Staticimage", true)] = array( "plugin" => "staticimages", "controller" => "staticimages", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Staticimage", "Add Image", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->Staticimage->set($this->data);
            $captions = $this->data["Staticimage"]["caption"];
            $count = 0;
            if( $this->Staticimage->validates() ) 
            {
                foreach( $this->data["Staticimage"]["File"] as $value ) 
                {
                    if( is_uploaded_file($value["tmp_name"]) ) 
                    {
                        $this->Staticimage->create();
                        $this->data["Staticimage"]["image_name"] = "staticImage_" . rand(0, 999999999) . time();
                        $this->data["Staticimage"]["image_type"] = strtolower(substr($value["name"], strpos($value["name"], ".") + 1));
                        $image_name = $this->data["Staticimage"]["image_name"] . "." . $this->data["Staticimage"]["image_type"];
                        move_uploaded_file($value["tmp_name"], UPLOAD_DIR . $image_name);
                        $this->data["Staticimage"]["caption"] = $captions[$count];
                        $this->data["Staticimage"]["slug"] = $this->Staticimage->createSlug($captions[$count]);
                        $this->Staticimage->save($this->data, false);
                        $count++;
                    }

                }
                $this->Session->setFlash(__("Image saved successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index" ));
            }

        }

    }

    public function admin_delete_image($id = null)
    {
        $data = $this->Staticimage->findById($id);
        $this->Staticimage->delete($id);
        $image_name = $data["Staticimage"]["image_name"] . "." . $data["Staticimage"]["image_type"];
        unlink(UPLOAD_DIR . $image_name);
        $this->Session->setFlash(__d("systemimages", "Image delete successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_download_image($file = "")
    {
        $this->downloadFile($file, UPLOAD_DIR);
        exit();
    }

}
