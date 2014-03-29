<?php 
//
// This source code was recovered by Recover-PHP.com
//


class MessagesController extends AppController
{
    public $name = "Messages";
    public $uses = array( "Message", "Project", "users.User" );

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
            $this->Auth->allow("send_message");
        }

    }

    public function index($userslug = null, $projectslug = null)
    {
        if( $userslug == null || $projectslug == null ) 
        {
            $inboxMessages = $this->{$this->modelClass}->query("SELECT message.*,COUNT(message.id) as replies, receiver.id AS id, receiver.slug, receiver.name, receiver.email, receiver.profile_image AS profile_image, sender.id AS id, sender.slug AS slug, sender.name AS user_name, sender.email AS user_email, sender.profile_image AS profile_image,project.title as title, project.slug as slug FROM (SELECT * FROM `messages` WHERE 1 ORDER BY `created` DESC) AS message INNER JOIN users AS sender ON (CASE WHEN message.to_user_id = " . $this->Session->read("Auth.User.id") . " THEN message.`from_user_id` WHEN message.from_user_id = " . $this->Session->read("Auth.User.id") . " THEN message.`to_user_id` END) = sender.id LEFT JOIN users AS receiver ON " . $this->Session->read("Auth.User.id") . "=receiver.id LEFT JOIN projects AS project ON project.id=message.project_id WHERE 1 GROUP BY CASE message.to_user_id WHEN " . $this->Session->read("Auth.User.id") . " THEN message.`from_user_id` ELSE message.`to_user_id` END, message.project_id");
            $this->set("inboxMessages", $inboxMessages);
        }
        else
        {
            $this->Project->recursive = 1;
            $threadProject = $this->Project->find("first", array( "fields" => array( "Project.id,Project.title,Project.slug,Project.user_id,Project.image,Project.project_end_date,User.name,User.slug" ), "conditions" => array( "Project.slug" => $projectslug ) ));
            $threadUser = $this->User->find("first", array( "fields" => array( "User.id,User.name,User.slug,User.email" ), "conditions" => array( "User.slug" => $userslug ) ));
            $user_id = $this->Session->read("Auth.User.id");
            $user_data = $this->User->find("first", array( "fields" => array( "User.id,User.name,User.slug,User.email" ), "conditions" => array( "User.id" => $user_id ) ));
            if( !empty($threadProject) && !empty($threadUser) ) 
            {
                if( $this->RequestHandler->isAjax() && !empty($this->data) ) 
                {
                    if( $this->data["Message"]["message"] == "" ) 
                    {
                        echo "error";
                        exit();
                    }

                    $data["Message"]["from_user_id"] = $this->Session->read("Auth.User.id");
                    $data["Message"]["to_user_id"] = $threadUser["User"]["id"];
                    $data["Message"]["project_id"] = $threadProject["Project"]["id"];
                    $data["Message"]["message"] = $this->data["Message"]["message"];
                    $data["Message"]["is_notified"] = 0;
                    $data["Message"]["is_spam"] = 0;
                    if( $this->Message->save($data, false) ) 
                    {
                        $emailVars["Project"]["title"] = $threadProject["Project"]["title"];
                        $emailVars["Project"]["link"] = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "detail" ), true) . DS . $threadProject["User"]["slug"] . DS . $threadProject["Project"]["slug"];
                        $emailVars["Sender"]["name"] = $this->Session->read("Auth.User.name");
                        $emailVars["Sender"]["slug"] = $user_data["User"]["slug"];
                        $emailVars["Message"]["reply_url"] = Router::url(array( "plugin" => "messages", "controller" => "messages", "action" => "index" ), true) . "/" . $user_data["User"]["slug"] . "/" . $threadProject["Project"]["slug"] . "?ref=email";
                        $emailVars["Message"]["message"] = $this->data["Message"]["message"];
                        $this->set("emailVars", $emailVars);
                        $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
                        $to = $threadUser["User"]["email"];
                        $element = "send_message";
                        $subject = "Message sent by " . $this->Session->read("Auth.User.name");
                        $this->_sendMail($to, $from, $replyTo = "", $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
                    }

                }

                $threadMessages = $this->{$this->modelClass}->query("SELECT message.*, receiver.id AS id, receiver.slug, receiver.name, receiver.email, sender.id AS id, sender.slug AS slug, sender.name AS user_name, sender.email AS user_email, sender.profile_image AS profile_image FROM `messages` AS message INNER JOIN users AS sender ON message.`from_user_id` = sender.id INNER JOIN users AS receiver ON message.to_user_id=receiver.id WHERE ((message.to_user_id = " . $this->Session->read("Auth.User.id") . " AND message.from_user_id = " . $threadUser["User"]["id"] . ") OR (message.from_user_id = " . $this->Session->read("Auth.User.id") . " AND message.to_user_id = " . $threadUser["User"]["id"] . ")) AND message.project_id = " . $threadProject["Project"]["id"] . " ORDER BY message.created DESC");
                $this->set("threadMessages", $threadMessages);
                $this->set("threadProject", $threadProject);
                $this->set("threadUser", $threadUser);
                $this->render("threadindex");
            }
            else
            {
                $this->redirect($this->referer());
            }

        }

    }

    public function send_message($user_slug = null, $project_slug = null)
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

        $project_detail = $this->Project->find("first", array( "conditions" => array( "Project.slug" => $project_slug ), "fields" => array( "Project.slug", "Project.id", "Project.title", "User.id", "User.slug", "User.name", "User.email" ) ));
        $this->set("project_detail", $project_detail);
        if( isset($this->params["url"]["ref"]) ) 
        {
            if( $this->params["url"]["ref"] == "ask_question" ) 
            {
                $this->set("pageTitle", __("message_title", true) . $project_detail["Project"]["title"]);
            }
            else
            {
                if( $this->params["url"]["ref"] == "send_message" ) 
                {
                    $this->set("pageTitle", __("message_send_message_to_poster", true));
                }

            }

        }

        if( $this->data ) 
        {
            $data["Message"]["from_user_id"] = $this->Session->read("Auth.User.id");
            $data["Message"]["to_user_id"] = $project_detail["User"]["id"];
            $data["Message"]["project_id"] = $project_detail["Project"]["id"];
            $data["Message"]["message"] = $this->data["ProjectAskedQuestion"]["question"];
            $data["Message"]["is_read"] = 0;
            $this->Message->save($data);
            $emailVars["Project"]["title"] = $project_detail["Project"]["title"];
            $emailVars["Project"]["link"] = Router::url(array( "plugin" => false, "controller" => "projects", "action" => "detail" ), true) . DS . $project_detail["Project"]["slug"];
            $emailVars["Sender"]["name"] = $this->Session->read("Auth.User.name");
            $emailVars["Message"]["message"] = $this->data["ProjectAskedQuestion"]["question"];
            $this->set("emailVars", $emailVars);
            $from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
            $to = $project_detail["User"]["email"];
            $this->Email->from = $from;
            $element = "send_message";
            $this->Email->sendAs = "html";
            $subject = __("message_send_message_by", true) . " " . $this->Session->read("Auth.User.name");
            $this->_sendMail($to, $from, $replyTo = "", $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
            echo "success";
            exit();
        }

        if( !$this->Session->check("Auth.User.id") ) 
        {
            $this->Session->write("login_redirect", "ask_question");
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
        echo $this->render("/elements/messages/send_message");
        exit();
    }

    public function getrecent()
    {
        $user_id = $this->Session->read("Auth.User.id");
        $this->layout = false;
        $recentMessages = $this->{$this->modelClass}->query("SELECT message.*, sender.id AS id, sender.slug AS slug, sender.name AS user_name, sender.email AS user_email,project.title as title, project.slug as slug FROM (SELECT * FROM `messages` WHERE messages.to_user_id =" . $this->Session->read("Auth.User.id") . " ORDER BY `created` DESC LIMIT 0, 5) AS message INNER JOIN users AS sender ON message.`from_user_id` = sender.id LEFT JOIN projects AS project ON project.id=message.project_id WHERE 1");
        $this->set("recentMessages", $recentMessages);
        $this->render("getrecent");
        $this->Message->updateAll(array( "Message.is_notified" => 1 ), array( "Message.to_user_id" => $user_id ));
    }

    public function reportspam($id = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $Message_data = $this->Message->find("first", array( "conditions" => array( "Message.id" => $id ) ));
        $data["Message"]["id"] = $id;
        $data["Message"]["is_spam"] = "1";
        if( $this->Message->save($data, false) ) 
        {
            echo "success";
            exit();
        }

    }

    public function report_spam($message_id = null)
    {
        $Message_data = $this->Message->find("first", array( "conditions" => array( "Message.id" => $message_id ) ));
        $threadMessages = $this->{$this->modelClass}->query("SELECT message.*, receiver.id AS id, receiver.slug, receiver.name, receiver.email, sender.id AS id, sender.slug AS slug, sender.name AS user_name, sender.email AS user_email, sender.profile_image AS profile_image FROM `messages` AS message INNER JOIN users AS sender ON message.`from_user_id` = sender.id INNER JOIN users AS receiver ON message.to_user_id=receiver.id WHERE ((message.id=" . $message_id . ")) AND message.project_id = " . $Message_data["Message"]["project_id"] . " ORDER BY message.created DESC");
        $this->set("threadMessages", $threadMessages);
        if( isset($this->data) ) 
        {
            pr($this->data);
        }

    }

}




?>