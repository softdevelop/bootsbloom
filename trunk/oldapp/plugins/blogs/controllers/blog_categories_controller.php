<?php 
//
// This source code was recovered by Recover-PHP.com
//

class BlogCategoriesController extends AppController
{
    public $name = "BlogCategories";
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript" );
    public $components = array( "Auth", "Session", "Email", "Cookie", "Search.Prg" );
    public $presetVars = array( array( "field" => "category_name", "type" => "value" ) );

    public function beforeFilter()
    {
        parent::beforefilter();
        $this->set("model", $this->modelClass);
        if( !Configure::read("App.defaultEmail") ) 
        {
            Configure::write("App.defaultEmail", Configure::read("noreply_email.email"));
        }

    }

    public function admin_index($blog_id = null)
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("blogs", "Blogs", true)] = array( "plugin" => "blogs", "controller" => "blogs", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("blogs", "Blog Category", true) );
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
        $parsedConditions["blog_id"] = $blog_id;
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("result", $this->paginate());
        $this->set("blog_id", $blog_id);
        $this->loadModel("Blog");
        $this->set("blog", $blog = $this->Blog->find("list", array( "fields" => array( "name" ), "conditions" => array( "id" => $blog_id ) )));
    }

    public function admin_add_blog_category($blog_id = null)
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("blogs", "Blogs", true)] = array( "plugin" => "blogs", "controller" => "blogs", "action" => "index" );
        $pages[__d("blogs", "Blog Category", true)] = array( "plugin" => "blogs", "controller" => "blog_categories", "action" => "index", $blog_id );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Blog", "Add Blog Category", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->BlogCategory->set($this->data);
            if( $this->BlogCategory->validates() ) 
            {
                $this->data["BlogCategory"]["slug"] = $this->BlogCategory->createSlug($this->data["BlogCategory"]["category_name"]);
                $this->BlogCategory->create();
                $this->BlogCategory->save($this->data);
                $this->Session->setFlash(__d("Blogs", "Blog Category add successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index", $this->data["BlogCategory"]["blog_id"] ));
            }

        }

        $this->loadModel("Blog");
        $this->data = $this->BlogCategory->find("list", array( "fields" => array( "category_name " ), "conditions" => array( "active" => "1", "blog_id" => $blog_id ) ));
        $this->set("blog", $blog = $this->Blog->find("list", array( "fields" => array( "name" ), "conditions" => array( "id" => $blog_id ) )));
        $this->set("blog_id", $blog_id);
    }

    public function admin_edit_blog_category($id = null, $blog_id = null, $category_name = null)
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("blogs", "Blogs", true)] = array( "plugin" => "blogs", "controller" => "blogs", "action" => "index" );
        $pages[__d("blogs", "Blog Category", true)] = array( "plugin" => "blogs", "controller" => "blog_categories", "action" => "index", $blog_id );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Blogs", "Edit Category", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) && !empty($this->data) ) 
        {
            $this->BlogCategory->set($this->data);
            if( $this->BlogCategory->validates() ) 
            {
                $this->data["BlogCategory"]["blog_id"] = $this->data["BlogCategory"]["blog_id"];
                $this->data["BlogCategory"]["id"] = $this->data["BlogCategory"]["id"];
                $this->BlogCategory->save($this->data);
                $this->Session->setFlash(__d("Blogs", "Blog Category updated successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index", $this->data["BlogCategory"]["blog_id"] ));
            }

        }

        $category = $this->BlogCategory->findById($id);
        $this->data = $category;
        $this->set("blog_id", $blog_id);
        $this->set("id", $id);
        $this->set("category_name", $category_name = $this->BlogCategory->find("list", array( "fields" => array( "category_name" ), "conditions" => array( "id" => $id ) )));
    }

    public function admin_delete_blog_category($id = null)
    {
        if( !isset($id) && !is_numeric($id) ) 
        {
            $this->Session->setFlash(__d("Blogs", "Please Try again.", true), "admin/error");
            $this->redirect(array( "action" => "index" ));
        }

        $this->BlogCategory->delete($id);
        $this->Session->setFlash(__d("Blogs", "Blogs Category delete successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_change_category_status($value = null, $id = null)
    {
        if( $value == "1" ) 
        {
            $category = array(  );
            $category["id"] = $id;
            $category["active"] = "0";
        }
        else
        {
            $category = array(  );
            $category["id"] = $id;
            $category["active"] = "1";
        }

        $this->BlogCategory->save($category, false);
        $this->Session->setFlash(__d("Blogs", "Post status updated successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_operate()
    {
        if( !empty($this->data[$this->modelClass]["operation"]) ) 
        {
            if( $this->data[$this->modelClass]["operation"] == "active" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 1 ), array( "BlogCategory.id IN (" . $ids . ")" ));
                $message = sprintf(__d("blogs", "category activated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 0 ), array( "BlogCategory.id IN (" . $ids . ")" ));
                $message = sprintf(__d("blogs", "category inactivated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "delete" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->deleteAll(array( "BlogCategory.id IN (" . $ids . ")" ));
                $message = sprintf(__d("blogs", "category deleted successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect(array( "plugin" => "blogs", "controller" => "blog_categories", "action" => "index", $this->data["BlogCategory"]["category_id"] ));
        }

    }

}




?>