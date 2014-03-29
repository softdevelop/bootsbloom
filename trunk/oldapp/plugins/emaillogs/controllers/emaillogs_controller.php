<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Copyright 2012, Gempulse Infotech Pvt. Ltd. (http://www.fullestop.com)
 */

class EmaillogsController extends EmaillogsAppController
{
    public $name = "Emaillogs";
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript" );
    public $components = array( "Auth", "Session", "Email", "Cookie", "Search.Prg" );
    public $presetVars = array( array( "field" => "subject", "type" => "value" ), array( "field" => "email_to", "type" => "value" ) );

    public function beforeFilter()
    {
        parent::beforefilter();
        $this->set("model", $this->modelClass);
        if( !Configure::read("App.defaultEmail") ) 
        {
            Configure::write("App.defaultEmail", Configure::read("noreply_email.email"));
        }

    }

    public function admin_utilities_dashboard()
    {
    }

    public function admin_index()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("users", "Emaillogs", true) );
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

    public function admin_delete_email($id = null)
    {
        $this->Emaillog->delete($id);
        $this->Session->setFlash(__d("emaillogs", "Email delete successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_view_email($id = null)
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("Emaillogs", "Emaillogs", true)] = array( "plugin" => "emaillogs", "controller" => "emaillogs", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Emaillogs", "Email Deatils", true) );
        $this->set("breadcrumb", $breadcrumb);
        $this->data = $this->Emaillog->read();
        $this->set("emaillog_details", $this->data);
    }

    public function admin_operate()
    {
        if( !empty($this->data[$this->modelClass]["operation"]) ) 
        {
            if( $this->data[$this->modelClass]["operation"] == "delete" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->deleteAll(array( "Emaillog.id IN (" . $ids . ")" ));
                $message = sprintf(__d("emaillogs", "Emaillogs deleted successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect(array( "plugin" => "emaillogs", "controller" => "emaillogs", "action" => "index" ));
        }

    }

}




?>