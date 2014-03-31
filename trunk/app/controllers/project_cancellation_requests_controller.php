<?php 
//
// This source code was recovered by Recover-PHP.com
//


class ProjectCancellationRequestsController extends AppController
{
    public $name = "ProjectCancellationRequests";
    public $paginate = NULL;
    public $components = array( "RequestHandler" );
    public $presetVars = array( array( "field" => "title", "type" => "value" ) );
    public $uses = array( "ProjectCancellationRequest", "Project", "Backer" );

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
        }

    }

    public function admin_index()
    {
        if( !empty($this->data) && isset($this->data["recordsPerPage"]) ) 
        {
            $limitValue = $limit = $this->data["recordsPerPage"];
            $this->Session->write($this->title . "." . $this->action . ".recordsPerPage", $limit);
        }
        else
        {
            $this->Prg->commonProcess();
        }

        $limitValue = $limit = Configure::read("defaultPaginationLimit");
        $this->set("limitValue", $limitValue);
        $this->set("limit", $limit);
        $this->{$this->modelClass}->recursive = "2";
        $this->{$this->modelClass}->data[$this->modelClass] = $this->passedArgs;
        $parsedConditions = array(  );
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".modified" => "desc" );
        $this->set("result", $this->paginate($this->modelClass));
    }

    public function admin_cancel_project($cancellation_request_id = null, $project_id = null)
    {
        if( isset($project_id) && !is_null($project_id) ) 
        {
            $this->Project->id = $project_id;
            $this->Project->saveField("is_cancelled", "1");
            $this->Backer->updateAll(array( "is_cancelled" => 1 ), array( "Backer.project_id" => $project_id ));
            $this->{$this->modelClass}->id = $cancellation_request_id;
            $this->{$this->modelClass}->delete();
			
			
			/*Send mail*/
			$project = $this->Project->findById($project_id);
			$this->Notification->create_noti($project['User']['id'], 'project_cancelled', $project_id);
			
			$this->set("project", $project);
			$from = Configure::read("CONFIG_FROMNAME") . "<" . Configure::read("CONFIG_FROMEMAIL") . ">";
			$element = "project_cancellation_to_creator";
			$replyTo = "";
			$to = $project["User"]["email"];
			$subject = "Cancellation notification for " . $project["Project"]["title"];
			$this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
			
			foreach ($project['Backer'] as $backer) {
				$this->Notification->create_noti($user_id, 'project_successed', $project_id);
				$backer = $this->User->findById($backer['user_id']);
				$to = $backer["User"]["email"];
				$this->set("backer", $backer);
				$element = "project_cancellation_to_backer";
				$this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  ));
			}
			
            $this->Session->setFlash(__d("projects", "Project and all pledges regarding this project has been cancelled.", true), "admin/success");
            $this->redirect(array( "plugin" => false, "controller" => "project_cancellation_requests", "action" => "index" ));
        }

    }

}
