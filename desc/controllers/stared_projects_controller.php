<?php 
//
// This source code was recovered by Recover-PHP.com
//


class StaredProjectsController extends AppController
{
    public $name = "StaredProjects";
    public $uses = array( "Project", "StaredProject" );

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
            $this->Auth->allow("remove_reminder");
        }

    }

    public function remove_reminder($email, $project_slug)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        if( !empty($email) && !empty($project_slug) ) 
        {
            $remove_email = base64_decode($email);
            $this->Project->recursive = "-1";
            $project = $this->Project->find("first", array( "conditions" => array( "Project.slug" => $project_slug ), "fields" => array( "Project.id" ) ));
            if( $project ) 
            {
                $this->StaredProject->deleteAll(array( "StaredProject.email" => $remove_email, "StaredProject.project_id" => $project["Project"]["id"] ));
                $this->Session->write("email_session", "success");
                $this->Session->write("email_msg", __("unsubscribed", true));
                $this->redirect(array( "plugin" => false, "controller" => "home", "action" => "index" ));
            }
            else
            {
                $this->redirect(array( "plugin" => false, "controller" => "home", "action" => "index" ));
                exit();
            }

        }
        else
        {
            $this->redirect(array( "plugin" => false, "controller" => "home", "action" => "index" ));
            exit();
        }

    }

}

