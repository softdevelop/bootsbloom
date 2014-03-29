<?php 
//
// This source code was recovered by Recover-PHP.com
//

class BlogsController extends BlogsAppController
{
    public $name = "Blogs";
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript" );
    public $components = array( "Auth", "Session", "Email", "Cookie", "Search.Prg" );
    public $presetVars = array( array( "field" => "name", "type" => "value" ) );

    public function beforeFilter()
    {
        parent::beforefilter();
        $this->set("model", $this->modelClass);
        if( !Configure::read("App.defaultEmail") ) 
        {
            Configure::write("App.defaultEmail", Configure::read("noreply_email.email"));
        }

        $this->Auth->allow("get_blog_categories");
    }

    public function admin_blog_dashboard()
    {
    }

    public function admin_index()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("blogs", "Blogs", true) );
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

    public function admin_add_blog()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("blogs", "Blog", true)] = array( "plugin" => "blogs", "controller" => "blogs", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Blog", "Add Blog", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) && !empty($this->data) ) 
        {
            $this->Blog->set($this->data);
            if( $this->Blog->validates() ) 
            {
                $this->data["Blog"]["slug"] = $this->Blog->createSlug($this->data["Blog"]["name"]);
                $this->Blog->save($this->data);
                $this->Session->setFlash(__d("Blog", "Blog added successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index" ));
            }

        }

    }

    public function admin_edit_blog($id = null)
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("blogs", "Blog", true)] = array( "plugin" => "blogs", "controller" => "blogs", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Blog", "Edit Blog", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) && !empty($this->data) ) 
        {
            if( $this->data["Blog"]["blog_images"]["name"] == "" ) 
            {
                unset($this->Blog->validate["blog_images"]);
            }

            $this->Blog->set($this->data);
            if( $this->Blog->validates() ) 
            {
                if( $this->data["Blog"]["blog_images"]["name"] != "" ) 
                {
                    $tmpPath = $this->data["Blog"]["blog_images"]["tmp_name"];
                    $imgName = $this->data["Blog"]["blog_images"]["name"];
                    $imgName = str_replace(" ", "_", $imgName);
                    $image_name = "Blog" . time() . $imgName;
                    $this->data["Blog"]["blog_image"] = $image_name;
                    move_uploaded_file($tmpPath, UPLOAD_DIR . $image_name);
                    unlink(UPLOAD_DIR . $this->data["Blog"]["image_update"]);
                    $this->Blog->save($this->data);
                    $this->Session->setFlash(__d("Blog", "Blog updated successfully.", true), "admin/success");
                    $this->redirect(array( "action" => "index" ));
                }
                else
                {
                    $this->data["Blog"]["blog_image"] = $this->data["Blog"]["image_update"];
                    $this->Blog->save($this->data);
                    $this->Session->setFlash(__d("Blog", "Blog updated successfully.", true), "admin/success");
                    $this->redirect(array( "action" => "index" ));
                }

            }

        }

        $blog = $this->Blog->findById($id);
        $this->set("blog_image", $blog_image = $blog["Blog"]["blog_image"]);
        $this->data = $blog;
        $this->set("blog", $blog_name = $this->Blog->find("list", array( "fields" => array( "name" ), "conditions" => array( "id" => $id ) )));
    }

    public function admin_delete_blog($id = null)
    {
        $this->Blog->delete($id);
        $this->Session->setFlash(__d("Blogs", "Blog delete successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_change_blog_status($value = null, $id = null)
    {
        if( $value == "1" ) 
        {
            $post["active"] = "0";
        }
        else
        {
            $post["active"] = "1";
        }

        $post["id"] = $id;
        $this->Blog->save($post, false);
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
                $this->{$this->modelClass}->updateAll(array( "active" => 1 ), array( "Blog.id IN (" . $ids . ")" ));
                $message = sprintf(__d("Blogs", "blogs activated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 0 ), array( "Blog.id IN (" . $ids . ")" ));
                $message = sprintf(__d("Blogs", "blogs inactivated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "delete" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->deleteAll(array( "Blog.id IN (" . $ids . ")" ));
                $message = sprintf(__d("Blogs", "blogs deleted successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect(array( "plugin" => "blogs", "controller" => "blogs", "action" => "index" ));
        }

    }

    public function get_blog_categories()
    {
        $this->autoRender = FALSE;
        $this->loadModel("BlogCategory");
        $categories = $this->BlogCategory->find("all", array( "conditions" => array( "BlogCategory.active" => 1 ), "fields" => array( "BlogCategory.id", "BlogCategory.slug", "BlogCategory.category_name" ), "order" => array( "category_name ASC" ) ));
        return $categories;
    }

}
