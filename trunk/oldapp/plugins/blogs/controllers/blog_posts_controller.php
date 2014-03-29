<?php 
//
// This source code was recovered by Recover-PHP.com
//

class BlogPostsController extends AppController
{
    public $name = "BlogPosts";
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript", "Editor" );
    public $components = array( "Auth", "Session", "Email", "Cookie", "Search.Prg" );
    public $presetVars = array( array( "field" => "title", "type" => "value" ), array( "field" => "blog_category_id", "type" => "value" ) );
    public $uses = array( "Blogs.BlogPost", "Blogs.BlogCategory", "Blogs.Blog", "Blogs.BlogPostComment", "Blogs.BlogFavProject", "users.User", "ProjectUpdate", "UserActivity" );

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
            $this->Auth->allow("blog", "detail", "category_project");
        }

    }

    public function admin_index($blog_id = null, $category_id = null)
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("blogs", "Posts", true) );
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
        if( isset($this->passedArgs["title"]) && $this->passedArgs["title"] == "Title" ) 
        {
            $this->passedArgs["title"] = "";
        }

        $parsedConditions = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
        $this->paginate[$this->modelClass]["limit"] = $limit;
        if( isset($category_id) ) 
        {
            $parsedConditions[$this->modelClass . ".blog_category_id"] = $category_id;
        }

        $parsedConditions[$this->modelClass . ".blog_id"] = $blog_id;
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("result", $this->paginate());
        $this->set("blog_id", $blog_id);
        $this->loadModel("Blog");
        $this->set("blog", $blog = $this->Blog->find("list", array( "fields" => array( "name" ), "conditions" => array( "Blog.id" => $blog_id ) )));
        $this->set("category_list", $category_list = $this->BlogCategory->find("list", array( "fields" => array( "category_name" ), "conditions" => array( "BlogCategory.blog_id" => $blog_id ) )));
    }

    public function admin_add_post($id = null)
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("blogs", "Blog Posts", true)] = array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "index", $id );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Blog", "Add Blog Post", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->BlogPost->set($this->data);
            $this->BlogPost->setValidation("add_post");
            if( $this->BlogPost->validates() ) 
            {
                $this->data["BlogPost"]["slug"] = $this->BlogPost->createSlug($this->data["BlogPost"]["title"]);
                $this->data["BlogPost"]["user_id"] = $this->Session->read("Auth.admin.id");
                $this->BlogPost->create();
                $this->BlogPost->save($this->data);
                $this->Session->setFlash(__d("Blogs", "Blog Post add successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index", $id ));
            }

        }

        $this->loadModel("BlogCategory");
        $this->loadModel("Blog");
        $this->data = $this->BlogCategory->find("list", array( "fields" => array( "category_name " ), "conditions" => array( "active" => "1", "blog_id" => $id ) ));
        $this->set("blog", $blog = $this->Blog->find("list", array( "fields" => array( "name" ), "conditions" => array( "id" => $id ) )));
        $this->set("data", $this->data);
        $this->set("blog_id", $id);
    }

    public function admin_edit_post($id = null, $parent_id = null)
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("blogs", "Blog Post", true)] = array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "index", $parent_id );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Blogs", "Edit Blog Post", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->BlogPost->set($this->data);
            $this->BlogPost->setValidation("add_post");
            if( $this->BlogPost->validates() ) 
            {
                $this->data["BlogPost"]["id"] = $this->data["BlogPost"]["id"];
                $this->data["BlogPost"]["blog_id"] = $this->data["BlogPost"]["parent_id"];
                $this->BlogPost->save($this->data);
                $this->Session->setFlash(__d("Blogs", "Blog post updated successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index", $this->data["BlogPost"]["parent_id"] ));
            }

            $this->loadModel("BlogCategory");
            $category = $this->BlogCategory->find("list", array( "fields" => array( "category_name" ), "conditions" => array( "parent_id" => $this->data["BlogPost"]["parent_id"] ) ));
            $this->set("category", $category);
        }

        $post = $this->BlogPost->findById($id);
        $this->data = $post;
        $category_list = $this->BlogCategory->find("list", array( "fields" => array( "category_name" ) ));
        $this->set("category_list", $category_list);
        $this->set("parent_id", $parent_id);
        $this->set("id", $id);
        $this->set("blog", $blog = $this->Blog->find("list", array( "fields" => array( "name" ), "conditions" => array( "id" => $parent_id ) )));
    }

    public function admin_delete_post($id = null)
    {
        if( !isset($id) && !is_numeric($id) ) 
        {
            $this->Session->setFlash(__d("Blogs", "Please Try again.", true), "admin/error");
            $this->redirect(array( "plugin" => "blogs", "controller" => "blogs", "action" => "index" ));
        }

        $this->BlogPost->delete($id);
        $this->Session->setFlash(__d("Blogs", "Post delete successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_change_post_status($value = null, $id = null)
    {
        if( !isset($id) && !is_numeric($id) ) 
        {
            $this->Session->setFlash(__d("Blogs", "Please Try again.", true), "admin/error");
            $this->redirect(array( "plugin" => "blogs", "controller" => "blogs", "action" => "index" ));
        }

        if( $value == "1" ) 
        {
            $post = array(  );
            $post["id"] = $id;
            $post["active"] = "0";
        }
        else
        {
            $post = array(  );
            $post["id"] = $id;
            $post["active"] = "1";
        }

        $this->BlogPost->save($post, false);
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
                $this->{$this->modelClass}->updateAll(array( "active" => 1 ), array( "BlogPost.id IN (" . $ids . ")" ));
                $message = sprintf(__d("blogs", "Post activated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 0 ), array( "BlogPost.id IN (" . $ids . ")" ));
                $message = sprintf(__d("blogs", "Post inactivated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "delete" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->deleteAll(array( "BlogPost.id IN (" . $ids . ")" ));
                $message = sprintf(__d("blogs", "Post deleted successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect(array( "plugin" => "blogs", "controller" => "blog_posts", "action" => "index", $this->data["BlogPost"]["blog_id"] ));
        }

    }

    public function blog()
    {
        $this->set("title_for_layout", "Blog");
        $conditions = array( "BlogPost.active" => 1, "BlogCategory.active" => "1" );
        $blog_list_pagging = Configure::read("CONFIG_BLOG_LISTING");
        $this->get_loading("BlogPost", $conditions, $order = "BlogPost.id DESC", "blogs", $blog_list_pagging);
        $projects_updates = $this->ProjectUpdate->find("all", array( "conditions" => array( "ProjectUpdate.active" => "1" ), "limit" => "10", "order" => array( "ProjectUpdate.created DESC" ) ));
        $blog_image = $this->Blog->find("first", array( "conditions" => array( "Blog.id" => "1" ) ));
        $this->set("blog_image", $blog_image);
		$fav_projects = $this->BlogFavProject->query(
			'SELECT `Project`.`id`, 
			        `Project`.`title`, 
					`Project`.`image`,
					`Project`.`slug`,
					`User`.`slug`
			FROM `blog_fav_projects` AS `BlogFavProject` 
			LEFT JOIN `projects` AS `Project` ON (`BlogFavProject`.`project_id` = `Project`.`id`)
			LEFT JOIN `users` AS `User` ON (`Project`.`user_id` = `User`.`id`)
		');
        $this->set("fav_projects", $fav_projects);
        $this->set("projects_updates", $projects_updates);
        if( $this->params["isAjax"] ) 
        {
            echo $this->render("/elements/front/load_more_blog_content");
            exit();
        }

        $this->set("title_for_layout", "The " . Configure::read("CONFIG_SITE_TITLE") . "  Blog &mdash; " . Configure::read("CONFIG_SITE_TITLE"));
        $this->loadModel("Project");
        $project_of_day = $this->Project->find("first", array( "conditions" => array( "Project.active" => "1" ), "order" => "rand()" ));
        $this->set("project_of_day", $project_of_day);
    }

    public function detail($slug = null)
    {
        if( $slug == null && $slug == "" ) 
        {
            $this->_404error();
        }
        else
        {
            $post_details = $this->BlogPost->find("first", array( "conditions" => array( "BlogPost.slug" => $slug, "BlogPost.active" => "1" ) ));
        }

        if( empty($post_details) ) 
        {
            $this->_404error();
        }

        $this->set("post_details", $post_details);
        $recent_posts = $this->BlogPost->find("all", array( "limit" => "8", "order" => array( "BlogPost.created DESC" ) ));
        $this->set("recent_posts", $recent_posts);
        $conditions = array( "BlogPostComment.blog_post_id" => $post_details["BlogPost"]["id"], "BlogPostComment.blog_category_id" => $post_details["BlogCategory"]["id"], "BlogPostComment.active" => "1" );
        $this->get_loading_comment("BlogPostComment", $conditions, $order = "BlogPostComment.id DESC", "post_comment", $slug);
        if( $this->params["isAjax"] ) 
        {
            echo $this->render("/elements/front/load_more_comment");
            exit();
        }

        $this->set("title_for_layout", $post_details["BlogPost"]["title"] . " &raquo; The " . Configure::read("CONFIG_SITE_TITLE") . "  Blog &mdash; " . Configure::read("CONFIG_SITE_TITLE"));
    }

    public function post_comment($slug = null)
    {
        if( $slug == null && $slug == "" ) 
        {
            $this->_404error();
        }
        else
        {
            $post_slug = $this->BlogPost->find("first", array( "conditions" => array( "BlogPost.slug" => $slug, "BlogPost.active" => "1" ) ));
        }

        if( empty($post_slug) ) 
        {
            $this->_404error();
        }

        $this->autoRender = false;
        if( !empty($this->data) ) 
        {
            $this->BlogPost->set($this->data);
            $this->BlogPost->setValidation("comments");
            if( $this->BlogPost->validates() ) 
            {
                $this->data["BlogPostComment"]["blog_id"] = $post_slug["BlogPost"]["blog_id"];
                $this->data["BlogPostComment"]["blog_post_id"] = $post_slug["BlogPost"]["id"];
                $this->data["BlogPostComment"]["user_id"] = $this->Session->read("Auth.User.id");
                $this->data["BlogPostComment"]["comment"] = $this->data["BlogPost"]["comment"];
                $this->data["BlogPostComment"]["blog_category_id"] = $post_slug["BlogPost"]["blog_category_id"];
                $activity["UserActivity"]["user_id"] = $this->Session->read("Auth.User.id");
                $activity["UserActivity"]["subject_type"] = "blog_post";
                $activity["UserActivity"]["subject_id"] = $post_slug["BlogPost"]["id"];
                $activity["UserActivity"]["activity_type"] = "blog_post_comment";
                $this->UserActivity->save($activity);
                $this->BlogPostComment->save($this->data);
                echo $success = "success" . "||" . __("blog_comment_posted_waiting_approval", true);
                exit();
            }

            $errors = $this->BlogPost->invalidFields("comments");
            echo $error = "error" . "||" . $errors["comment"];
            exit();
        }

    }

    public function category_project($category_slug = null)
    {
        if( isset($category_slug) && $category_slug != "" ) 
        {
            $category = $this->BlogCategory->find("first", array( "fields" => "BlogCategory.id,BlogCategory.category_name", "conditions" => array( "BlogCategory.slug" => $category_slug ) ));
            $this->set("title_for_layout", "Blog ::" . $category["BlogCategory"]["category_name"]);
        }
        else
        {
            $this->_404error();
        }

        $posts = $this->BlogPost->find("all", array( "conditions" => array( "BlogPost.blog_category_id" => $category["BlogCategory"]["id"], "BlogPost.active" => "1" ) ));
        $recent_posts = $this->BlogPost->find("all", array( "limit" => "8", "order" => array( "BlogPost.created DESC" ) ));
        $this->set("recent_posts", $recent_posts);
        $this->set("posts", $posts);
        $this->set("title_for_layout", $category["BlogCategory"]["category_name"] . " &raquo; The " . Configure::read("CONFIG_SITE_TITLE") . "  Blog &mdash; " . Configure::read("CONFIG_SITE_TITLE"));
    }

    public function get_loading_comment($model, $condition = array(  ), $order, $return_variable, $slug)
    {
        if( isset($this->params["named"]["page"]) ) 
        {
            $current_page = $this->params["named"]["page"];
        }
        else
        {
            $current_page = 1;
        }

        $limit = Configure::read("CONFIG_BLOG_COMMENTS");
        $page = $current_page;
        $page = $page - 1;
        $lt = $page * $limit;
        $total_records = $this->$model->find("count", array( "conditions" => $condition ));
        $lastpage = ceil($total_records / $limit);
        $offset = "";
        if( 0 < $lt ) 
        {
            $offset = $lt . " , ";
        }

        $offset .= $limit;
        if( $model == "BlogPostComment" ) 
        {
            $this->BlogPostComment->bindModel(array( "belongsTo" => array( "User" ) ));
        }

        $data = $this->$model->find("all", array( "conditions" => $condition, "limit" => $offset, "order" => array( $order ) ));
        $this->set($return_variable, $data);
        $this->set("page", $current_page + 1);
        $this->set("last_page", $lastpage);
        $this->set("current_page", $current_page);
        $this->set("slug", $slug);
    }

}
