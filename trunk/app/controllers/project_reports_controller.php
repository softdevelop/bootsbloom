<?php 
//
// This source code was recovered by Recover-PHP.com
//


class ProjectReportsController extends AppController
{
    public $name = "ProjectReports";
    public $uses = array( "ProjectReport", "ProjectReportType", "Project", "Category" );

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
            $this->Auth->allow("report_project");
        }

    }

    public function report_project($user_slug = null, $project_slug = null)
    {
        $this->layout = "ajax";
        if( empty($user_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        if( empty($project_slug) || is_null($project_slug) ) 
        {
            $this->_404error();
        }

        $project_detail = $this->Project->find("first", array( "conditions" => array( "Project.slug" => $project_slug ), "fields" => array( "Project.slug", "Project.id", "Project.title", "User.id", "User.slug", "User.name", "Category.category_name" ) ));
        $this->set("project_detail", $project_detail);
        if( isset($this->data) ) 
        {
            $this->data["ProjectReport"]["project_id"] = $project_detail["Project"]["id"];
            $this->data["ProjectReport"]["user_id"] = $this->Session->read("Auth.User.id");
            if( !isset($this->data["ProjectReport"]["category_id"]) || empty($this->data["ProjectReport"]["category_id"]) ) 
            {
                $this->data["ProjectReport"]["category_id"] = "";
            }

            $this->ProjectReport->save($this->data);
            if( $this->data["ProjectReport"]["category_id"] != "" ) 
            {
                $category_name = $this->Category->find("first", array( "conditions" => array( "Category.id" => $this->data["ProjectReport"]["category_id"] ) ));
                $this->set("category_name", $category_name["Category"]["category_name"]);
                $this->set("project_category_name", $project_detail["Category"]["category_name"]);
            }

            $user_name = $this->Session->read("Auth.User.name");
            $project_name = $project_detail["Project"]["title"];
            $report_type = $this->ProjectReportType->find("first", array( "conditions" => array( "ProjectReportType.id" => $this->data["ProjectReport"]["report_id"] ) ));
            $report_title = $report_type["ProjectReportType"]["report_title"];
            $report = $report_type["ProjectReportType"]["report"];
            $project_slug = $project_detail["Project"]["slug"];
            $project_owner = $project_detail["User"]["slug"];
            $url = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "detail" ), true) . "/" . $project_detail["User"]["slug"] . "/" . $project_detail["Project"]["slug"];
            $ms = $url;
            $this->set(compact("user_name", "project_name", "report_title", "report", "ms"));
            $subject = "Project Report" . " " . $report_title;
            $to = Configure::read("CONFIG_EMAIL");
            $from = $this->Session->read("Auth.User.email");
            $body = "Project Report";
            $d["Emaillog"]["email_to"] = $to;
            $d["Emaillog"]["email_from"] = $from;
            $d["Emaillog"]["email_type"] = "C";
            $d["Emaillog"]["subject"] = $subject;
            $d["Emaillog"]["message"] = $body;
            $d["Emaillog"]["active"] = "1";
            $d["Emaillog"]["deleted"] = "0";
            $this->Email->from = $from;
            $this->Email->to = $to;
            $this->Email->subject = $subject;
            $element = "project_report";
            $replyTo = Configure::read("CONFIG_FROMEMAIL");
            if( $this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  )) ) 
            {
                $this->Emaillog->create();
                $this->Emaillog->set($d);
                $this->Emaillog->save();
            }

            echo "success";
            exit();
        }

        if( !$this->Session->check("Auth.User.id") ) 
        {
            $this->Session->write("login_redirect", "report_project");
            if( !empty($this->params["url"]["ref"]) ) 
            {
                $this->Session->write("redirect_to", $this->referer() . "?ref=" . $this->params["url"]["ref"]);
            }
            else
            {
                $this->Session->write("redirect_to", $this->referer());
            }

            echo $this->render("/elements/users/login");
            exit();
        }

        $this->Session->delete("login_redirect");
        $this->Session->delete("redirect_to");
        $project_report_types = $this->ProjectReportType->find("all", array( "fields" => array( "ProjectReportType.id", "ProjectReportType.report", "ProjectReportType.report_title" ) ));
        $this->set("project_report_types", $project_report_types);
        echo $this->render("/elements/project_reports/report_project");
        exit();
    }

}

