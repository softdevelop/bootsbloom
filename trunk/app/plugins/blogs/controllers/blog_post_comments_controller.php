<?php 
//
// This source code was recovered by Recover-PHP.com
//


class BlogPostCommentsController extends AppController
{
    public $name = "BlogPostComments";
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript" );
    public $components = array( "Auth", "Session", "Email", "Cookie", "Search.Prg" );
    public $presetVars = array( array( "field" => "comment", "type" => "value" ) );

    public function beforeFilter()
    {
        parent::beforefilter();
        $this->set("model", $this->modelClass);
        if( !Configure::read("App.defaultEmail") ) 
        {
            Configure::write("App.defaultEmail", Configure::read("noreply_email.email"));
        }

    }

    public function admin_index($post_id = null, $blog_id = null)
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("blogs", "Post Comment", true) );
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
        $parsedConditions[$this->modelClass . ".blog_id"] = $blog_id;
        $parsedConditions[$this->modelClass . ".blog_post_id"] = $post_id;
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("result", $this->paginate());
        $this->set("post_id", $post_id);
        $this->set("blog_id", $blog_id);
        $this->loadModel("BlogPost");
        $posts = $this->BlogPost->find("list", array( "fields" => array( "title" ), "conditions" => array( "id" => $post_id ) ));
        $this->set("posts", $posts);
    }

    public function admin_edit_comment($id = null, $blog_id = null)
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("blogs", "Post Comment", true)] = array( "plugin" => "blogs", "controller" => "blog_post_comments", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Blogs", "Edit Comment", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->BlogPostComment->set($this->data);
            if( $this->BlogPostComment->validates() ) 
            {
                $this->data["BlogPostComment"]["id"] = $id;
                $this->BlogPostComment->save($this->data);
                $this->Session->setFlash(__d("Blogs", "Blog comment updated successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index", $this->data["BlogPostComment"]["parent_id"], $id ));
            }

        }

        $category = $this->BlogPostComment->findById($id);
        $this->data = $category;
        $post_id = $category["BlogPostComment"]["blog_post_id"];
        $this->set("post_id", $post_id);
        $this->set("blog_id", $blog_id);
        $this->set("id", $id);
        $this->loadModel("BlogPost");
        $this->set("posts", $posts = $this->BlogPost->find("list", array( "fields" => array( "title" ), "conditions" => array( "BlogPost.id" => $blog_id ) )));
    }

    public function admin_delete_comment($id = null)
    {
        $this->BlogPostComment->delete($id);
        $this->Session->setFlash(__d("Blogs", "Comment delete successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_change_comment_status($value = null, $id = null)
    {
        if( $value == "1" ) 
        {
            $comment = array(  );
            $comment["id"] = $id;
            $comment["active"] = "0";
        }
        else
        {
            $comment = array(  );
            $comment["id"] = $id;
            $comment["active"] = "1";
        }

        $this->BlogPostComment->save($comment, false);
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
                $this->{$this->modelClass}->updateAll(array( "active" => 1 ), array( "BlogPostComment.id IN (" . $ids . ")" ));
                $message = sprintf(__d("blogs", "comment activated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 0 ), array( "BlogPostComment.id IN (" . $ids . ")" ));
                $message = sprintf(__d("blogs", "comment inactivated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "delete" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->deleteAll(array( "BlogPostComment.id IN (" . $ids . ")" ));
                $message = sprintf(__d("blogs", "comment deleted successfully.", true));
                $message = sprintf(__d("blogs", "comment deleted successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect($this->referer());
        }

    }

    public function admin_awaiting_comments()
    {
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
        $parsedConditions[$this->modelClass . ".active"] = 0;
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("result", $this->paginate());
    }

    public function admin_view_comment($id = null)
    {
        $post_comment = $this->BlogPostComment->find("first", array( "conditions" => array( "BlogPostComment.id" => $id, "BlogPostComment.active" => "0" ) ));
        $this->set("comment_details", $post_comment);
    }

}
