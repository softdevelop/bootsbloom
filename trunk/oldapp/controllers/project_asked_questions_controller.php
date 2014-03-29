<?php 
//
// This source code was recovered by Recover-PHP.com
//


class ProjectAskedQuestionsController extends AppController
{
    public $name = "ProjectAskedQuestions";
    public $uses = array( "ProjectAskedQuestion", "Project" );

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
            $this->Auth->allow("ask_question");
        }

    }

    public function ask_question($user_slug = null, $project_slug = null)
    {
    }

}

