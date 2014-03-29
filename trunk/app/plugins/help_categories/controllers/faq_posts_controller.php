<?php 
//
// This source code was recovered by Recover-PHP.com
//


class FaqPostsController extends AppController
{
    public $name = "FaqPosts";
    public $components = array( "Auth", "Email", "Session", "RequestHandler" );
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Editor" );
    public $uses = array( "help_categories.FaqPost", "help_categories.Faq" );
    public $layout = "default";
    public $paginate = NULL;
    public $presetVars = array( array( "field" => "post_title", "type" => "value" ) );

    public function beforeFilter()
    {
        parent::beforefilter();
        $this->set("model", $this->modelClass);
        if( !Configure::read("App.defaultEmail") ) 
        {
            Configure::write("App.defaultEmail", Configure::read("noreply_email.email"));
        }

    }

    public function admin_index($parent_id = null)
    {
        $conditions = array(  );
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
        $conditions[$this->modelClass . ".parent_id"] = $parent_id;
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions + $conditions;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("result", $this->paginate());
        $this->set("parent_id", $parent_id);
        $category_name = $this->Faq->find("first", array( "conditions" => array( "Faq.id" => $parent_id ), "fields" => array( "category_name", "parent_id" ) ));
        $this->set("category_name", $category_name);
    }

    public function admin_add_faq_post($parent_id = null, $lang = "eng")
    {
        if( !isset($lang) ) 
        {
            $lang = "eng";
        }

        if( !empty($this->data) ) 
        {
            if( $lang == "eng" ) 
            {
                $this->FaqPost->set($this->data);
                $this->FaqPost->setValidation("admin_add_post");
                if( $this->FaqPost->validates() ) 
                {
                    $this->data["FaqPost"]["slug"] = $this->FaqPost->createSlug($this->data["FaqPost"]["post_title"]);
                    $this->Session->write("add_faq_post", $this->data);
                    $this->Session->setFlash(__d("help_posts", "Please complete franch tab too.", true), "admin/success");
                    $this->redirect(array( "plugin" => "help_categories", "controller" => "faq_posts", "action" => "admin_add_faq_post", $parent_id, "hy" ));
                }

            }
            else
            {
                if( $lang == "hy" ) 
                {
                    $this->FaqPost->set($this->data);
                    $this->FaqPost->setValidation("admin_add_post_hy");
                    if( $this->FaqPost->validates() ) 
                    {
                        $english_post = $this->Session->read("add_faq_post");
                        $this->data["FaqPost"]["slug_hy"] = $english_post["FaqPost"]["slug"];
                        $this->FaqPost->create();
                        $this->FaqPost->save($english_post);
                        $this->FaqPost->save($this->data);
                        $this->Session->delete("add_faq_post");
                        $this->Session->setFlash(__d("help_posts", "Post add successfully.", true), "admin/success");
                        $this->redirect(array( "plugin" => "help_categories", "controller" => "faq_posts", "action" => "index", $this->data["FaqPost"]["parent_id"] ));
                    }

                }

            }

        }

        $tab1_data = $this->Session->read("add_faq_post");
        if( isset($tab1_data) ) 
        {
            $this->data = $tab1_data;
        }

        $this->set("parent_id", $parent_id);
    }

    public function admin_edit_faq_post($id = null, $parent_id = null, $lang = null)
    {
        if( !isset($lang) ) 
        {
            $lang = "eng";
        }

        if( !empty($this->data) ) 
        {
            if( $lang == "eng" ) 
            {
                $this->FaqPost->set($this->data);
                $this->FaqPost->setValidation("admin_add_post");
                if( $this->FaqPost->validates() ) 
                {
                    $this->Session->write("edit_faq_post", $this->data);
                    $this->Session->setFlash(__d("help_post", "Please complete franch tab too.", true), "admin/success");
                    $this->redirect(array( "plugin" => "help_categories", "controller" => "faq_posts", "action" => "admin_edit_faq_post", $id, $parent_id, "hy" ));
                }

            }
            else
            {
                if( $lang == "hy" ) 
                {
                    $this->FaqPost->set($this->data);
                    $this->FaqPost->setValidation("admin_add_post_fr");
                    if( $this->FaqPost->validates() ) 
                    {
                        $this->data["FaqPost"]["id"] = $this->data["FaqPost"]["id"];
                        $english_post = $this->Session->read("edit_faq_post");
                        $this->FaqPost->save($english_post);
                        $this->FaqPost->save($this->data);
                        $this->Session->delete("edit_faq_post");
                        $this->Session->setFlash(__d("help_post", "Post updated successfully.", true), "admin/success");
                        $this->redirect(array( "plugin" => "help_categories", "controller" => "faq_posts", "action" => "index", $this->data["FaqPost"]["parent_id"] ));
                    }

                }

            }

        }

        $tab1_data = $this->Session->read("edit_faq_post");
        if( isset($tab1_data) ) 
        {
            $this->data = $tab1_data;
        }

        $help_post = $this->FaqPost->findById($id);
        $this->data = $help_post;
        $this->set("id", $id);
        $this->set("parent_id", $parent_id);
    }

    public function admin_delete_faq_post($id = null)
    {
        $this->FaqPost->delete($id);
        $this->Session->setFlash(__d("help_posts", "Post deleted successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_faq_post_status($value = null, $id = null)
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

        $this->FaqPost->save($letter, false);
        $this->Session->setFlash(__d("help_posts", "Post status updated successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_operate()
    {
        if( !empty($this->data[$this->modelClass]["operation"]) ) 
        {
            if( $this->data[$this->modelClass]["operation"] == "active" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->FaqPost->updateAll(array( "active" => 1 ), array( "FaqPost.id IN (" . $ids . ")" ));
                $message = sprintf(__d("help_posts", "Post activated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->FaqPost->updateAll(array( "active" => 0 ), array( "FaqPost.id IN (" . $ids . ")" ));
                $message = sprintf(__d("help_posts", "Post inactivated successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect($this->referer());
        }

    }

}




?>