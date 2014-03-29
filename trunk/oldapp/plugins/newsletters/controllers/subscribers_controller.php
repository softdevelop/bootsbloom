<?php 
//
// This source code was recovered by Recover-PHP.com
//

class SubscribersController extends AppController
{
    public $name = "Subscribers";
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript" );
    public $components = array( "Auth", "Session", "Cookie", "Search.Prg", "Email" => array( "sendAs" => "html" ) );
    public $presetVars = array( array( "field" => "email", "type" => "value" ) );

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
            $this->Auth->allow("subscribe_newsletter");
        }

    }

    public function admin_index()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("subscribers", "Subscriber", true) );
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
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("result", $this->paginate());
    }

    public function admin_add_subscriber()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("Subscribers", "Subscribers", true)] = array( "plugin" => "subscribers", "controller" => "subscribers", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Subscribers", "Add Subscriber", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->Subscriber->set($this->data);
            $this->Subscriber->setValidation("add_new");
            if( $this->Subscriber->validates() ) 
            {
                $this->Subscriber->save($this->data);
                $this->Session->setFlash(__d("Subscribers", "Subscribers added successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index" ));
            }

        }

    }

    public function admin_edit_subscriber($id = null)
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("Subscribers", "Subscribers", true)] = array( "plugin" => "subscribers", "controller" => "subscribers", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Subscribers", "Edit Subscriber", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->Subscriber->set($this->data);
            $this->Subscriber->setValidation("add_new");
            if( $this->Subscriber->validates() ) 
            {
                $this->Subscriber->save($this->data);
                $this->Session->setFlash(__d("Subscribers", "Subscribers upate successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index" ));
            }

        }

        $newslatter = $this->Subscriber->findById($id);
        $this->data = $newslatter;
    }

    public function admin_change_subscriber_status($value = null, $id = null)
    {
        if( $value == "1" ) 
        {
            $letter = array(  );
            $letter["id"] = $id;
            $letter["active"] = "0";
        }
        else
        {
            $letter = array(  );
            $letter["id"] = $id;
            $letter["active"] = "1";
        }

        $this->Subscriber->save($letter, false);
        $this->Session->setFlash(__d("Subscribers", "Subscriber status updated successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_delete_subscriber($id = null)
    {
        $this->Subscriber->delete($id);
        $this->Session->setFlash(__d("Subscribers", "Subscriber delete successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_subscriber_send_mail()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("Subscribers", "Subscribers", true)] = array( "plugin" => "subscribers", "controller" => "subscribers", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Subscribers", "Send Mail", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->loadModel("Newsletter");
            $this->loadModel("Emaillog");
            $this->loadModel("SendEmailBackup");
            $this->Subscriber->set($this->data);
            $this->Subscriber->setValidation("emaillogo");
            if( $this->Subscriber->validates() ) 
            {
                foreach( $this->data["Subscriber"]["SelectedMail"] as $receiver ) 
                {
                    $this->Email->reset();
                    $mail_to = $this->Subscriber->find("first", array( "fields" => "email", "conditions" => array( "id" => $receiver ) ));
                    $complete_newsletter = $this->Newsletter->find("first", array( "conditions" => array( "Newsletter.id" => $this->data["Subscriber"]["template"] ) ));
                    $subject = $complete_newsletter["Newsletter"]["subject"];
                    $to = $mail_to["Subscriber"]["email"];
                    $body = $complete_newsletter["Newsletter"]["message"];
                    $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                    $d["Emaillog"]["email_to"] = $to;
                    $d["Emaillog"]["email_from"] = $from;
                    $d["Emaillog"]["email_type"] = "C";
                    $d["Emaillog"]["subject"] = $subject;
                    $d["Emaillog"]["message"] = $body;
                    $d["Emaillog"]["active"] = "1";
                    $d["Emaillog"]["deleted"] = "0";
                    $e["SendEmailBackup"]["email_to"] = $to;
                    $e["SendEmailBackup"]["email_from"] = $from;
                    $e["SendEmailBackup"]["flag"] = "0";
                    $e["SendEmailBackup"]["subject"] = $subject;
                    $e["SendEmailBackup"]["message"] = $body;
                    $e["SendEmailBackup"]["active"] = "1";
                    $e["SendEmailBackup"]["deleted"] = "0";
                    $e["SendEmailBackup"]["date"] = $complete_newsletter["Newsletter"]["created"];
                    $this->Emaillog->create();
                    $this->Emaillog->set($d);
                    $this->Emaillog->save();
                    $this->SendEmailBackup->create();
                    $this->SendEmailBackup->set($e);
                    $this->SendEmailBackup->save($e);
                    $this->Email->reset();
                }
                $this->Session->setFlash(__d("Subscribers", "mail sent successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index" ));
            }

        }

        $this->loadModel("Newsletter");
        $this->data = $this->Subscriber->find("list", array( "fields" => array( "email" ), "conditions" => array( "active" => "1" ) ));
        $this->set("data", $this->data);
        $templete = $this->Newsletter->find("list", array( "fields" => array( "subject" ), "conditions" => array( "active" => "1" ) ));
        $this->set("templete", $templete);
    }

    public function admin_operate()
    {
        if( !empty($this->data[$this->modelClass]["operation"]) ) 
        {
            if( $this->data[$this->modelClass]["operation"] == "active" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 1 ), array( "Subscriber.id IN (" . $ids . ")" ));
                $message = sprintf(__d("subscribers", "subscriber activated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 0 ), array( "Subscriber.id IN (" . $ids . ")" ));
                $message = sprintf(__d("subscribers", "subscriber inactivated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "delete" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->deleteAll(array( "Subscriber.id IN (" . $ids . ")" ));
                $message = sprintf(__d("subscribers", "newsletter deleted successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect(array( "plugin" => "newsletters", "controller" => "subscribers", "action" => "index" ));
        }

    }

    public function subscribe_newsletter()
    {
        $this->loadModel("User");
        $this->layout = false;
        $user_info = $this->Session->read("Auth.User.email");
        if( $user_info != "" ) 
        {
            $alrady_subscriber = $this->Subscriber->findByEmail($this->Session->read("Auth.User.email"));
            if( empty($alrady_subscriber) ) 
            {
                $this->data["Subscriber"]["email"] = $this->Session->read("Auth.User.email");
                $this->data["Subscriber"]["user_id"] = $this->Session->read("Auth.User.id");
                $this->Subscriber->save($this->data);
            }
            else
            {
                $this->data["Subscriber"]["user_id"] = $this->Session->read("Auth.User.id");
                $this->data["Subscriber"]["id"] = $alrady_subscriber["Subscriber"]["id"];
                $this->Subscriber->save($this->data);
            }

            $this->data["User"]["receive_weekly_newsletter"] = "1";
            $this->data["User"]["id"] = $this->Session->read("Auth.User.id");
            $this->Session->write("Auth.User.receive_weekly_newsletter", $this->data["User"]["receive_weekly_newsletter"]);
            if( $this->User->save($this->data) ) 
            {
                echo $success = "success" . "||" . "You have subscribed successfully for " . Configure::read("CONFIG_SITE_TITLE") . " newsletters.";
                exit();
            }

        }
        else
        {
            if( !empty($this->data) ) 
            {
                $this->Subscriber->set($this->data);
                $this->Subscriber->setValidation("add_new");
                if( $this->Subscriber->validates() ) 
                {
                    $this->Subscriber->save($this->data);
                    echo $success = "success" . "||" . "You have subscribed successfully for " . Configure::read("CONFIG_SITE_TITLE") . " newsletters.";
                    exit();
                }

                $errors = $this->Subscriber->invalidFields("email");
                echo $error = "error" . "||" . $errors["email"];
                exit();
            }

        }

    }

    public function unsubscriber_newsletter()
    {
    }

}
