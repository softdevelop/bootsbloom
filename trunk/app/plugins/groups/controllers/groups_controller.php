<?php 
//
// This source code was recovered by Recover-PHP.com
//


class GroupsController extends GroupsAppController
{
    public $name = "Groups";
    public $components = array( "Auth", "Email", "Session", "RequestHandler" );
    public $helpers = array( "Html", "Form", "Session", "Time", "Text" );
    public $layout = "default";
    public $paginate = NULL;

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
        if( !empty($this->data) && isset($this->data["recordsPerPage"]) ) 
        {
            $limitValue = $limit = $this->data["recordsPerPage"];
            $this->Session->write($this->name . "." . $this->action . ".recordsPerPage", $limit);
        }

        $limitValue = $limit = $this->Session->read($this->name . "." . $this->action . ".recordsPerPage") ? $this->Session->read($this->name . "." . $this->action . ".recordsPerPage") : Configure::read("defaultPaginationLimit");
        $this->set("limitValue", $limitValue);
        $this->set("limit", $limit);
        $searchTerm = "";
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("results", $this->paginate());
    }

    public function admin_add()
    {
        if( isset($this->data) && isset($this->data) ) 
        {
            $this->Group->set($this->data);
            if( $this->Group->validates() ) 
            {
                $this->data["Group"]["slug"] = $this->Group->createSlug($this->data["Group"]["name"]);
                $this->Group->save($this->data);
                $message = sprintf(__d("groups", "%s added successfully.", true), $this->data["Group"]["name"]);
                $this->Session->setFlash($message, "admin/success");
                $this->redirect(array( "plugin" => "groups", "controller" => "groups", "action" => "index" ));
            }

        }

    }

    public function admin_edit($id = null)
    {
        if( $id == null ) 
        {
            $message = "You are using wrong link.";
            $this->Session->setFlash($message, "admin/error");
            $this->redirect(array( "plugin" => "groups", "controller" => "groups", "action" => "index" ));
        }

        if( empty($this->data) ) 
        {
            $this->Group->id = $id;
            $this->data = $this->Group->read();
        }
        else
        {
            if( isset($this->data) ) 
            {
                $this->Group->set($this->data);
                if( $this->Group->validates() ) 
                {
                    $this->Group->save($this->data);
                    $message = "Group updated successfully.";
                    $this->Session->setFlash($message, "admin/success");
                    $this->redirect(array( "plugin" => "groups", "controller" => "groups", "action" => "index" ));
                }

            }

        }

    }

    public function admin_operate()
    {
        if( !empty($this->data[$this->modelClass]["operation"]) ) 
        {
            if( $this->data[$this->modelClass]["operation"] == "active" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 1 ), array( "Group.id IN (" . $ids . ")" ));
                $message = sprintf(__d("groups", "Group activated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 0 ), array( "Group.id IN (" . $ids . ")" ));
                $message = sprintf(__d("groups", "Group inactivated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "restore" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "is_deleted" => 0 ), array( "Group.id IN (" . $ids . ")" ));
                $message = sprintf(__d("categories", "Group restored successfully.", true));
                $this->redirect(array( "plugin" => "groups", "controller" => "categories", "action" => "archive_categories" ));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect(array( "plugin" => "groups", "controller" => "groups", "action" => "index" ));
        }

    }

    public function admin_status_update($id = null, $status = 0)
    {
        if( $id == null ) 
        {
            $this->Session->setFlash("You are using wrong url.", "admin/error");
        }
        else
        {
            $this->Group->id = $id;
            $this->Group->saveField("active", $status);
            $this->Group->setFlash("Group status updated successfully.", "admin/success");
        }

        $this->redirect(array( "plugin" => "groups", "controller" => "groups", "action" => "index" ));
    }

}




?>