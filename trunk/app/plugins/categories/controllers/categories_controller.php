<?php 
//
// This source code was recovered by Recover-PHP.com
//


class CategoriesController extends CategoriesAppController
{
    public $name = "Categories";
    public $components = array( "Auth", "Email", "Session", "RequestHandler", "Search.Prg", "Users.LogUtil" );
    public $layout = "default";
    public $paginate = NULL;
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript" );
    public $presetVars = array( array( "field" => "category_name", "type" => "value" ) );

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
            $this->Auth->allow("get_main_categories");
        }

    }

    public function admin_index($parent_id = 0)
    {
        $conditions = array(  );
        $conditions["Category.is_deleted"] = 0;
        if( isset($this->passedArgs["parent_id"]) ) 
        {
            $parent_id = $this->passedArgs["parent_id"];
        }

        if( isset($parent_id) && 0 < $parent_id ) 
        {
            $conditions["Category.parent_id"] = $parent_id;
            $category = $this->Category->find("first", array( "conditions" => array( "Category.id" => $parent_id ), "fields" => array( "category_name", "parent_id" ) ));
            $this->set("category", $category);
        }
        else
        {
            $conditions["Category.parent_id"] = 0;
        }

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
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions + $conditions;
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("parent_id", $parent_id);
        $categories = $this->paginate();
        $this->set("categories", $categories);
    }

    public function admin_add_category($parent_id = 0)
    {
        $this->set("parent_id", $parent_id);
        if( empty($this->data) ) 
        {
            if( 0 < $parent_id && isset($parent_id) && 0 < $parent_id ) 
            {
                $parent_category_name = $this->Category->find("first", array( "conditions" => array( "Category.id" => $parent_id, "Category.parent_id" => "0" ) ));
                $this->set("parent_category_name", $parent_category_name["Category"]["category_name"]);
                return NULL;
            }

        }
        else
        {
            if( isset($this->data) ) 
            {
                $parent_id = $this->data["Category"]["parent_id"];
                $this->Category->setValidation("admin_add_category");
                $this->Category->set($this->data);
                if( $this->Category->validates() ) 
                {
                    $this->data["Category"]["slug"] = $this->Category->createSlug($this->data["Category"]["category_name"]);
                    $this->data["Category"]["parent_id"] = $this->data["Category"]["parent_id"];
                    $this->Category->create();
                    $this->Category->save($this->data);
                    if( isset($parent_id) && 0 < $parent_id ) 
                    {
                        $message = sprintf(__d("categories", "Category added successfully.", true));
                    }
                    else
                    {
                        $message = sprintf(__d("categories", "Subcategory added successfully.", true));
                    }

                    $this->Session->setFlash($message, "admin/success");
                    $this->redirect(array( "plugin" => "categories", "controller" => "categories", "action" => "index" ));
                }

            }

        }

    }

    public function admin_edit($id = null)
    {
        if( $id == null ) 
        {
            $this->Session->setFlash("You are using wrong url.", "admin/error");
        }

        if( empty($this->data) ) 
        {
            $this->Category->id = $id;
            $this->data = $this->Category->read();
        }
        else
        {
            if( isset($this->data) && isset($this->data) ) 
            {
                $this->Category->setValidation("admin_edit_category");
                $this->Category->set($this->data);
                if( $this->Category->validates() ) 
                {
                    $this->Category->save($this->data);
                    $message = sprintf(__d("categories", "Category updated successfully.", true));
                    $this->Session->setFlash($message, "admin/success");
                    $this->redirect(array( "plugin" => "categories", "controller" => "categories", "action" => "index", $this->data["Category"]["parent_id"] ));
                }

            }

        }

    }

    public function admin_status_update($category_id = null, $parent_id = 0, $status = 0)
    {
        $this->autoRender = false;
        if( empty($category_id) || $category_id == null ) 
        {
            $message = sprintf(__d("categories", "Please select category.", true));
            $this->Session->setFlash($message, "admin/error");
            $this->redirect(array( "plugin" => "categories", "controller" => "categories", "action" => "index" ));
        }

        $this->Category->id = $category_id;
        $this->Category->saveField("active", $status);
        $message = sprintf(__d("categories", "Category status updated successfully.", true));
        $this->Session->setFlash($message, "admin/success");
        $this->redirect(array( "plugin" => "categories", "controller" => "categories", "action" => "index", $parent_id ));
    }

    public function admin_view_sub_categories($parent_id = null)
    {
    }

    public function admin_operate()
    {
        if( !empty($this->data[$this->modelClass]["operation"]) ) 
        {
            if( $this->data[$this->modelClass]["operation"] == "active" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 1 ), array( "Category.id IN (" . $ids . ")" ));
                $message = sprintf(__d("categories", "Category activated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 0 ), array( "Category.id IN (" . $ids . ")" ));
                $message = sprintf(__d("categories", "Category inactivated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "restore" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "is_deleted" => 0 ), array( "Category.id IN (" . $ids . ")" ));
                $message = sprintf(__d("categories", "Category restored successfully.", true));
                $this->redirect(array( "plugin" => "categories", "controller" => "categories", "action" => "archive_categories" ));
            }

            if( $this->data[$this->modelClass]["operation"] == "delete" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->deleteAll(array( "Category.id IN (" . $ids . ")" ));
                $message = sprintf(__d("categories", "Category deleted successfully.", true));
                $this->redirect(array( "plugin" => "categories", "controller" => "categories", "action" => "archive_categories" ));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect(array( "plugin" => "categories", "controller" => "categories", "action" => "index" ));
        }

    }

    public function admin_delete($id, $type)
    {
        if( $type == "permanent" ) 
        {
            $this->Category->id = $id;
            $this->Category->delete();
        }

        if( $type == "temp" ) 
        {
            $this->Category->id = $id;
            $this->Category->saveField("is_deleted", 1);
        }

        $message = sprintf(__d("categories", "Category deleted successfully.", true));
        $this->Session->setFlash($message, "admin/success");
        echo "success";
        exit();
    }

    public function admin_archive_categories()
    {
        $conditions = array(  );
        $conditions["Category.is_deleted"] = 1;
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
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions + $conditions;
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $categories = $this->paginate();
        $this->set("categories", $categories);
    }

    public function admin_total_categories()
    {
        $this->autoRender = false;
        $total_categories = $this->Category->find("count", array( "conditions" => array(  ) ));
        return $total_categories;
    }

    public function get_main_categories()
    {
        $this->autoRender = FALSE;
        $categories = $this->Category->find("all", array( "conditions" => array( "Category.active" => 1, "Category.parent_id" => 0 ), "fields" => array( "Category.id", "Category.slug", "Category.category_name" ), "order" => array( "category_name ASC" ) ));
        return $categories;
    }

}




?>