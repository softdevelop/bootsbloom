<?php 
//
// This source code was recovered by Recover-PHP.com
//

class TestimonialsController extends AppController
{
    public $name = "Testimonials";
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript", "Editor" );
    public $components = array( "Auth", "Session", "Email", "Cookie", "Search.Prg" );
    public $presetVars = array( array( "field" => "testimonial_title", "type" => "value" ), array( "field" => "from_name", "type" => "value" ) );

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
        $breadcrumb = array( "pages" => $pages, "active" => __d("users", "Testimonials", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) && isset($this->data["recordsPerPage"]) ) 
        {
            $limitValue = $limit = $this->data["recordsPerPage"];
            $this->Session->write($this->name . "." . $this->action . ".recordsPerPage", $limit);
        }
        else
        {
            $this->Prg->commonProcess();
        }

        $limitValue = $limit = $this->Session->read($this->name . "." . $this->action . ".recordsPerPage") ? $this->Session->read($this->name . "." . $this->action . ".recordsPerPage") : Configure::read("defaultPaginationLimit");
        $this->set("limitValue", $limitValue);
        $this->set("limit", $limit);
        $searchTerm = "";
        $this->{$this->modelClass}->data[$this->modelClass] = $this->passedArgs;
        $parsedConditions = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions;
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("result", $this->paginate());
    }

    public function admin_add_testimonial()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("users", "Testimonial", true)] = array( "plugin" => "testimonials", "testimonials" => "partners", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Staticimage", "Add Testimonial", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->Testimonial->set($this->data);
            if( $this->Testimonial->validates() ) 
            {
                $testimonial = array(  );
                $testimonial["slug"] = $this->Testimonial->createSlug($this->data["Testimonial"]["testimonial_title"]);
                $testimonial["from_name"] = $this->data["Testimonial"]["from_name"];
                $testimonial["testimonial_title"] = $this->data["Testimonial"]["testimonial_title"];
                $testimonial["testimonial_description"] = $this->data["Testimonial"]["testimonial_description"];
                $this->Testimonial->create();
                $this->Testimonial->save($testimonial);
                $this->Session->setFlash(__d("Testimonials", "Testimonial added successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index" ));
            }

        }

    }

    public function admin_edit_testimonial($id = null)
    {
        if( $id == null ) 
        {
            $this->redirect(array( "action" => "index" ));
        }

        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("Testimonial", "Testimonial", true)] = array( "plugin" => "testimonials", "controller" => "testimonials", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("partners", "Edit Testimonial", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->Testimonial->set($this->data);
            if( $this->Testimonial->validates() ) 
            {
                $testimonial = array(  );
                $testimonial["from_name"] = $this->data["Testimonial"]["from_name"];
                $testimonial["testimonial_title"] = $this->data["Testimonial"]["testimonial_title"];
                $testimonial["testimonial_description"] = $this->data["Testimonial"]["testimonial_description"];
                $this->Testimonial->save($testimonial);
                $this->Session->setFlash(__d("Testimonials", "Testimonial updated successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index" ));
            }

        }

        $testimonial = $this->Testimonial->findById($id);
        $this->data = $testimonial;
    }

    public function admin_delete_testimonial($id = null)
    {
        $this->Testimonial->delete($id);
        $this->Session->setFlash(__d("Testimonials", "Testimonial delete successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_change_testimonial_status($value = null, $id = null)
    {
        $Testimonial = array(  );
        if( $value == "1" ) 
        {
            $Testimonial["id"] = $id;
            $Testimonial["active"] = "0";
        }
        else
        {
            $Testimonial["id"] = $id;
            $Testimonial["active"] = "1";
        }

        $this->Testimonial->save($Testimonial, false);
        $this->Session->setFlash(__d("Testimonials", "Testimonial status updated successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_operate()
    {
        if( !empty($this->data[$this->modelClass]["operation"]) ) 
        {
            if( $this->data[$this->modelClass]["operation"] == "active" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "Testimonial.active" => "1" ), array( "Testimonial.id IN (" . $ids . ")" ));
                $message = sprintf(__d("testimonials", "Testimonials activated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "inactive" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => "0" ), array( "Testimonial.id IN (" . $ids . ")" ));
                $message = sprintf(__d("testimonials", "Testimonials inactivated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "delete" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->deleteAll(array( "Testimonial.id IN (" . $ids . ")" ));
                $message = sprintf(__d("testimonials", "Testimonials deleted successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect(array( "plugin" => "testimonials", "controller" => "testimonials", "action" => "index" ));
        }

    }

}




?>