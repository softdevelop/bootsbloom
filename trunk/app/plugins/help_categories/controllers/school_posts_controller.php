<?php 
//
// This source code was recovered by Recover-PHP.com
//


class SchoolPostsController extends AppController
{
    public $name = "SchoolPosts";
    public $components = array( "Auth", "Email", "Session", "RequestHandler" );
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Editor" );
    public $uses = array( "help_categories.SchoolPost", "help_categories.School" );
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
        $category_name = $this->School->find("first", array( "conditions" => array( "School.id" => $parent_id ), "fields" => array( "category_name", "parent_id" ) ));
        $this->set("category_name", $category_name);
    }

    public function admin_add_post($parent_id = null, $lang = null)
    {
        if( !isset($lang) ) 
        {
            $lang = "eng";
        }

        if( !empty($this->data) ) 
        {
            if( $lang == "eng" ) 
            {
                $this->SchoolPost->set($this->data);
                $this->SchoolPost->setValidation("admin_add_post");
                if( $this->SchoolPost->validates() ) 
                {
                    $this->data["SchoolPost"]["slug"] = $this->SchoolPost->createSlug($this->data["SchoolPost"]["post_title"]);
                    $this->Session->write("school_add_post", $this->data);
                    $this->Session->setFlash(__d("school_posts", "Please complete Armenian tab too .", true), "admin/success");
                    $this->redirect(array( "plugin" => "help_categories", "controller" => "school_posts", "action" => "admin_add_post", $parent_id, "hy" ));
                }

            }
            else
            {
                if( $lang == "hy" ) 
                {
                    $this->SchoolPost->set($this->data);
                    $this->SchoolPost->setValidation("admin_add_post_hy");
                    if( $this->SchoolPost->validates() ) 
                    {
                        $english_tab = $this->Session->read("school_add_post");
                        $this->data["SchoolPost"]["slug_hy"] = $english_tab["SchoolPost"]["slug"];
                        $this->SchoolPost->create();
                        $this->SchoolPost->save($english_tab);
                        $this->SchoolPost->save($this->data);
                        $this->Session->delete("school_add_post");
                        $this->Session->setFlash(__d("school_posts", "Post added successfully.", true), "admin/success");
                        $this->redirect(array( "plugin" => "help_categories", "controller" => "school_posts", "action" => "index", $this->data["SchoolPost"]["parent_id"] ));
                    }

                }

            }

        }

        $tab1_data = $this->Session->read("school_add_post");
        if( isset($tab1_data) ) 
        {
            $this->data = $tab1_data;
        }

        $this->set("parent_id", $parent_id);
    }

    public function admin_edit_post($id = null, $parent_id = null, $lang = null)
    {
        if( !isset($lang) ) 
        {
            $lang = "eng";
        }

        if( !empty($this->data) ) 
        {
            if( $lang == "eng" ) 
            {
                $this->SchoolPost->set($this->data);
                $this->SchoolPost->setValidation("admin_add_post");
                if( $this->SchoolPost->validates() ) 
                {
					$this->data["SchoolPost"]["slug"] = $this->data["SchoolPost"]["slug_hy"] = $this->SchoolPost->createSlug($this->data["SchoolPost"]["post_title"]);
                    $this->Session->write("school_edit_post", $this->data);
                    $this->Session->setFlash(__d("school_post", "Please complete Armenian tab too .", true), "admin/success");
                    $this->redirect(array( "plugin" => "help_categories", "controller" => "school_posts", "action" => "admin_edit_post", $id, $parent_id, "hy" ));
                }

            }
            else
            {
                if( $lang == "hy" ) 
                {
                    $this->SchoolPost->set($this->data);
                    $this->SchoolPost->setValidation("admin_add_post_hy");
                    if( $this->SchoolPost->validates() ) 
                    {
                        $this->data["SchoolPost"]["id"] = $this->data["SchoolPost"]["id"];
                        $english_tab = $this->Session->read("school_edit_post");
                        $this->SchoolPost->save($english_tab);
                        $this->SchoolPost->save($this->data);
                        $this->Session->delete("school_edit_post");
                        $this->Session->setFlash(__d("school_post", "Category updated successfully.", true), "admin/success");
                        $this->redirect(array( "plugin" => "help_categories", "controller" => "school_posts", "action" => "index", $this->data["SchoolPost"]["parent_id"] ));
                    }

                }

            }

        }

        $tab1_data = $this->Session->read("school_add_post");
        if( isset($tab1_data) ) 
        {
            $this->data = $tab1_data;
        }

        $help_post = $this->SchoolPost->findById($id);
        $this->data = $help_post;
        $this->set("id", $id);
        $this->set("parent_id", $parent_id);
    }

    public function admin_delete_post($id = null)
    {
        $this->SchoolPost->delete($id);
        $this->Session->setFlash(__d("school_posts", "Post deleted successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_post_status($value = null, $id = null)
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

        $this->SchoolPost->save($letter, false);
        $this->Session->setFlash(__d("school_posts", "Post status updated successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_operate()
    {
        if( !empty($this->data[$this->modelClass]["operation"]) ) 
        {
            if( $this->data[$this->modelClass]["operation"] == "active" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->SchoolPost->updateAll(array( "active" => 1 ), array( "SchoolPost.id IN (" . $ids . ")" ));
                $message = sprintf(__d("school_posts", "Post activated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->SchoolPost->updateAll(array( "active" => 0 ), array( "SchoolPost.id IN (" . $ids . ")" ));
                $message = sprintf(__d("school_posts", "Post inactivated successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect($this->referer());
        }

    }

}
