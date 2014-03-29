<?php 
//
// This source code was recovered by Recover-PHP.com
//

class NewslettersController extends NewslettersAppController
{
    public $name = "Newsletters";
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript", "Editor" );
    public $components = array( "Auth", "Session", "Email", "Cookie", "Search.Prg" );
    public $presetVars = array( array( "field" => "title", "type" => "value" ), array( "field" => "subject", "type" => "value" ) );

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
            $this->Auth->allow("get_latest_newsletter", "newsletter_detail", "newsletters");
        }

    }

    public function admin_newsletters_dashboard()
    {
    }

    public function admin_index()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("users", "Newsletter", true) );
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

    public function admin_add_newsletter()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("Newsletters", "Newsletters", true)] = array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Newsletters", "Add Newsletter", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->Newsletter->set($this->data);
            if( $this->Newsletter->validates() ) 
            {
                $tmpPath = $this->data["Newsletter"]["newsletter_images"]["tmp_name"];
                $imgName = $this->data["Newsletter"]["newsletter_images"]["name"];
                $imgName = str_replace(" ", "_", $imgName);
                $image_name = "newsletter_" . time() . $imgName;
                $this->data["Newsletter"]["newsletter_image"] = $image_name;
                move_uploaded_file($tmpPath, UPLOAD_DIR . $image_name);
                $this->data["Newsletter"]["slug"] = $this->Newsletter->createSlug($this->data["Newsletter"]["title"]);
                $this->Newsletter->save($this->data);
                $this->Session->setFlash(__d("newslettes", "Template added successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index" ));
            }

        }

    }

    public function admin_edit_newsletter($id = null)
    {
        if( !empty($this->data) ) 
        {
            $this->Newsletter->set($this->data);
            if( $this->data["Newsletter"]["newsletter_images"]["name"] == "" ) 
            {
                unset($this->Newsletter->validate["newsletter_images"]);
            }

            if( $this->Newsletter->validates() ) 
            {
                if( $this->data["Newsletter"]["newsletter_images"]["name"] != "" ) 
                {
                    $tmpPath = $this->data["Newsletter"]["newsletter_images"]["tmp_name"];
                    $imgName = $this->data["Newsletter"]["newsletter_images"]["name"];
                    $imgName = str_replace(" ", "_", $imgName);
                    $image_name = "newletter_" . time() . $imgName;
                    $this->data["Newsletter"]["newsletter_image"] = $image_name;
                    move_uploaded_file($tmpPath, UPLOAD_DIR . $image_name);
                    unlink(UPLOAD_DIR . $this->data["Newsletter"]["image_update"]);
                    $this->Newsletter->save($this->data);
                    $this->Session->setFlash(__d("newslettes", "Template updated successfully.", true), "admin/success");
                    $this->redirect(array( "action" => "index" ));
                }
                else
                {
                    $this->data["Newsletter"]["newsletter_image"] = $this->data["Newsletter"]["image_update"];
                    $this->Newsletter->save($this->data);
                    $this->Session->setFlash(__d("newslettes", "Template updated successfully.", true), "admin/success");
                    $this->redirect(array( "action" => "index" ));
                }

            }

        }

        $newslatter = $this->Newsletter->findById($id);
        $this->set("newslatter_image", $newslatter_image = $newslatter["Newsletter"]["newsletter_image"]);
        $this->data = $newslatter;
    }

    public function admin_change_newsletter_status($value = null, $id = null)
    {
        $letter = array(  );
        if( $value == "1" ) 
        {
            $letter["id"] = $id;
            $letter["active"] = "0";
        }
        else
        {
            $letter["id"] = $id;
            $letter["active"] = "1";
        }

        $this->Newsletter->save($letter, false);
        $this->Session->setFlash(__d("newsletters", "Template status updated successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_delete_newsletter($id = null)
    {
        $this->Newsletter->delete($id);
        $this->Session->setFlash(__d("newsletters", "Template deleted successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_operate()
    {
        if( !empty($this->data[$this->modelClass]["operation"]) ) 
        {
            if( $this->data[$this->modelClass]["operation"] == "active" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 1 ), array( "Newsletter.id IN (" . $ids . ")" ));
                $message = sprintf(__d("newsletters", "newsletter activated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 0 ), array( "Newsletter.id IN (" . $ids . ")" ));
                $message = sprintf(__d("newsletters", "newsletter inactivated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "delete" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->deleteAll(array( "Newsletter.id IN (" . $ids . ")" ));
                $message = sprintf(__d("newsletters", "newsletter deleted successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect(array( "plugin" => "newsletters", "controller" => "newsletters", "action" => "index" ));
        }

    }

    public function newsletters()
    {
        $this->set("title_for_layout", " Newsletters &mdash; " . Configure::read("CONFIG_SITE_TITLE"));
        $conditions = array( "Newsletter.active" => 1 );
        $limit = Configure::read("CONFIG_NEWSLETTER");
        $this->get_loading("Newsletter", $conditions, $order = "Newsletter.id DESC", "newsletter_lists", $limit);
        if( $this->params["isAjax"] ) 
        {
            echo $this->render("/elements/front/load_more_newsletter");
            exit();
        }

    }

    public function newsletter_detail($slug = null)
    {
        if( $slug == "" ) 
        {
            $this->_404error();
        }
        else
        {
            $news_details = $this->Newsletter->find("first", array( "conditions" => array( "Newsletter.active" => "1", "Newsletter.slug" => $slug ) ));
            $neighbors = $this->Newsletter->find("neighbors", array( "field" => "id", "value" => $news_details["Newsletter"]["id"] ));
        }

        if( $news_details != "" ) 
        {
            $this->set("news_details", $news_details);
            $this->set("neighbors", $neighbors);
        }
        else
        {
            $this->_404error();
        }

        $this->set("title_for_layout", " Newsletters: " . $news_details["Newsletter"]["title"] . "&raquo; Newsletter &mdash; " . Configure::read("CONFIG_SITE_TITLE"));
    }

    public function get_latest_newsletter()
    {
        $this->autoRender = FALSE;
        $newsletter = $this->Newsletter->find("first", array( "conditions" => array( "Newsletter.active" => "1" ), "order" => array( "Newsletter.created DESC" ) ));
        return $newsletter;
    }

}
