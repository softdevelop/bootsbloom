<?php 
//
// This source code was recovered by Recover-PHP.com
//


class FaqsController extends AppController
{
    public $name = "Faqs";
    public $components = array( "Auth", "Email", "Session", "RequestHandler" );
    public $helpers = array( "Html", "Form", "Session", "Time", "Text" );
    public $uses = array( "help_categories.Faq", "help_categories.HelpCategory", "help_posts.HelpPost" );
    public $layout = "default";
    public $paginate = NULL;
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
            $this->Auth->allow();
        }
        else
        {
            $this->Auth->allow("help", "help_detail", "get_post_title", "logo_download");
        }

    }

    public function admin_help_dashboard()
    {
    }

    public function admin_index($parent_id = null)
    {
        if( !isset($parent_id) ) 
        {
            $parent_id = "1";
        }

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
        $conditions[$this->modelClass . ".section"] = "faq";
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions + $conditions;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("result", $this->paginate("Faq"));
        $this->set("parent_id", $parent_id);
        if( isset($parent_id) && 1 < $parent_id ) 
        {
            $category_name = $this->HelpCategory->find("first", array( "conditions" => array( "HelpCategory.id" => $parent_id ), "fields" => array( "category_name", "parent_id" ) ));
            $this->set("category_name", $category_name);
        }

    }

    public function admin_add_category($parent_id = 0, $lang = null)
    {
        if( !isset($lang) ) 
        {
            $lang = "eng";
        }

        if( !empty($this->data) ) 
        {
            $this->Faq->set($this->data);
            $this->Faq->setValidation("admin_add_category");
            if( $this->Faq->validates() ) 
            {
                $this->data["Faq"]["slug"] = $this->HelpCategory->createSlug($this->data["Faq"]["category_name"], $this->data["Faq"]["id"]);
                $this->data["Faq"]["slug_hy"] = $this->data["Faq"]["slug"];
                $this->Faq->save($this->data, false);
                $this->Session->setFlash(__d("faqs", "Category added successfully.", true), "admin/success");
                $this->redirect(array( "plugin" => "help_categories", "controller" => "faqs", "action" => "index", $this->data["Faq"]["parent_id"] ));
            }

        }

        $add_category = $this->HelpCategory->findById($parent_id);
        $this->set("add_category", $add_category);
        $this->set("parent_id", $parent_id);
    }

    public function admin_edit_category($id = null)
    {
        if( !empty($this->data) ) 
        {
            $this->Faq->set($this->data);
            $this->Faq->setValidation("admin_edit_category");
            if( $this->Faq->validates() ) 
            {
                $this->Faq->save($this->data, false);
                $this->Session->setFlash(__d("faqs", "Category updated successfully.", true), "admin/success");
                $this->redirect(array( "plugin" => "help_categories", "controller" => "faqs", "action" => "index", 1 ));
            }

        }
        else
        {
            $help_category = $this->Faq->findById($id);
            $this->data = $help_category;
        }

        $this->set("id", $id);
    }

    public function admin_category_status($value = null, $id = null)
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

        $this->Faq->save($letter, false);
        $this->Session->setFlash(__d("faqs", "Category status updated successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_delete_category($id = null)
    {
        $this->Faq->delete($id);
        $this->Session->setFlash(__d("faqs", "Category deleted successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_operate()
    {
        $this->autoRender = false;
        if( !empty($this->data["Faqs"]["operation"]) ) 
        {
            if( $this->data["Faqs"]["operation"] == "active" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->Faq->updateAll(array( "active" => 1 ), array( "Faq.id IN (" . $ids . ")" ));
                $message = sprintf(__d("faqs", "Category activated successfully.", true));
            }

            if( $this->data["Faqs"]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->Faq->updateAll(array( "active" => 0 ), array( "Faq.id IN (" . $ids . ")" ));
                $message = sprintf(__d("faqs", "Category inactivated successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect($this->referer());
        }

    }

    public function help()
    {
        $this->set("title_for_layout", __("project_faq_help_center", true) . " &mdash; " . Configure::read("CONFIG_SITE_TITLE"));
        $faq_main_cat_id = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.section" => "faq", "HelpCategory.parent_id" => 0 ), "fields" => array( "HelpCategory.id", "HelpCategory.id" ) ));
        $faq_main_categories = $this->HelpCategory->find("all", array( "conditions" => array( "HelpCategory.section" => "faq", "HelpCategory.parent_id" => $faq_main_cat_id, "HelpCategory.active" => "1" ), "order" => "HelpCategory.id asc" ));
        $categories_and_posts = array(  );
        $c = 0;
        foreach( $faq_main_categories as $faq_main_category ) 
        {
            $categories_and_posts[$c] = $faq_main_category;
            $faq_cat_id = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.section" => "faq", "HelpCategory.parent_id" => $faq_main_category["HelpCategory"]["id"], "HelpCategory.active" => "1" ) ));
            $faq_posts = $this->HelpPost->find("all", array( "conditions" => array( "HelpPost.parent_id" => $faq_cat_id, "HelpPost.active" => "1" ), "limit" => "4", "order" => "HelpPost.id asc" ));
            $categories_and_posts[$c]["Posts"] = $faq_posts;
            $c++;
        }
        $this->set("faq_posts", $categories_and_posts);
        $bloom_subcate = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.section" => "faq", "HelpCategory.parent_id" => "9", "HelpCategory.active" => "1" ) ));
        $bloom_creaters = $this->HelpPost->find("all", array( "conditions" => array( "HelpPost.parent_id" => $bloom_subcate, "HelpPost.active" => "1" ), "limit" => "4" ));
        $this->set("bloom_creaters", $bloom_creaters);
        $bloom_subcate_backer = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.section" => "faq", "HelpCategory.parent_id" => "10", "HelpCategory.active" => "1" ) ));
        $bloom_backers = $this->HelpPost->find("all", array( "conditions" => array( "HelpPost.parent_id" => $bloom_subcate_backer, "HelpPost.active" => "1" ), "limit" => "4" ));
        $this->set("bloom_backers", $bloom_backers);
        $category_first = $this->HelpCategory->find("first", array( "conditions" => array( "HelpCategory.id" => "8" ) ));
        $category_second = $this->HelpCategory->find("first", array( "conditions" => array( "HelpCategory.id" => "9" ) ));
        $category_third = $this->HelpCategory->find("first", array( "conditions" => array( "HelpCategory.id" => "10" ) ));
        $this->set(compact("category_first", "category_second", "category_third"));
    }

    public function help_detail($section = null, $cat_slug = null)
    {
        $language = $this->Session->read("Config.language");
        if( empty($language) ) 
        {
            $language = "eng";
        }

        if( $language == "eng" ) 
        {
            $lang_var = "";
        }
        else
        {
            $lang_var = "_" . $language;
        }

        if( $section == "" ) 
        {
            $section = "faq";
        }

        if( $cat_slug == "" ) 
        {
            $this->redirect(array( "plugin" => "help_categories", "controller" => "faqs", "action" => "help" ));
        }

        $faq_main_cat_id = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.section" => "faq", "HelpCategory.parent_id" => 0 ), "fields" => array( "HelpCategory.id", "HelpCategory.id" ) ));
        $faq_main_categories = $this->HelpCategory->find("all", array( "conditions" => array( "HelpCategory.section" => "faq", "HelpCategory.parent_id" => $faq_main_cat_id, "HelpCategory.active" => "1" ), "order" => "HelpCategory.id asc" ));
        $faq_categories_and_subcategories = array(  );
        $c = 0;
        foreach( $faq_main_categories as $faq_main_category ) 
        {
            $faq_categories_and_subcategories[$c] = $faq_main_category;
            $faq_cat_id = $this->HelpCategory->find("all", array( "conditions" => array( "HelpCategory.section" => "faq", "HelpCategory.parent_id" => $faq_main_category["HelpCategory"]["id"], "HelpCategory.active" => "1" ) ));
            $faq_categories_and_subcategories[$c]["SubCategories"] = $faq_cat_id;
            $c++;
        }
        $this->set("faq_categories_and_subcategories", $faq_categories_and_subcategories);
        $category_id = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.section" => $section, "HelpCategory.slug" . $lang_var => $cat_slug, "HelpCategory.active" => "1" ) ));
        if( empty($category_id) ) 
        {
            $this->_404error();
        }

        $sub_category_id_r = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.section" => $section, "HelpCategory.active" => "1", "HelpCategory.parent_id" => $category_id ) ));
        if( empty($sub_category_id_r) ) 
        {
            $this->_404error();
        }

        $sub_category_id = $this->HelpCategory->find("all", array( "conditions" => array( "HelpCategory.section" => $section, "HelpCategory.active" => "1", "HelpCategory.parent_id" => $category_id ) ));
        $category_posts = $this->HelpPost->find("all", array( "conditions" => array( "HelpPost.parent_id" => $sub_category_id_r, "HelpPost.active" => "1" ) ));
        if( empty($category_posts) ) 
        {
            $this->_404error();
        }

        $category_name = $this->HelpCategory->find("first", array( "conditions" => array( "HelpCategory.slug" . $lang_var => $cat_slug ) ));
        $category_title = $category_name["HelpCategory"]["category_name" . $lang_var];
        $this->set("title_for_layout", $category_title . " &raquo; " . __("project_payment_frequently_asked_question", true) . " (FAQ) &mdash;" . Configure::read("CONFIG_SITE_TITLE"));
        $this->set("sub_category_id", $sub_category_id);
        $this->set("category_posts", $category_posts);
        $this->set("category_name", $category_name);
    }

    public function get_post_title()
    {
        $this->autoRender = false;
        $this->layout = false;
        $language = $this->Session->read("Config.language");
        if( empty($language) ) 
        {
            $language = "eng";
        }

        if( $language == "eng" ) 
        {
            $lang_var = "";
        }
        else
        {
            $lang_var = "_" . $language;
        }

        $search_param = $this->params["url"]["q"];
        $main_cat_faq = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.parent_id" => "1", "HelpCategory.active" => "1" ) ));
        $main_subcat_faq = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.parent_id" => $main_cat_faq, "HelpCategory.active" => "1" ) ));
        $post_titles = $this->HelpPost->find("all", array( "conditions" => array( "HelpPost.parent_id" => $main_subcat_faq, "HelpPost.post_title" . $lang_var . " like" => $search_param . "%" ), "fields" => array( "HelpPost.slug" . $lang_var, "HelpPost.post_title" . $lang_var, "HelpPost.id" ) ));
        $post_array = array(  );
        foreach( $post_titles as $post_title ) 
        {
            $post_detail = $this->HelpPost->find("first", array( "conditions" => array( "HelpPost.id" => $post_title["HelpPost"]["id"], "HelpPost.active" => "1" ) ));
            $category_id = $this->HelpCategory->find("first", array( "conditions" => array( "HelpCategory.id" => $post_detail["HelpPost"]["parent_id"], "HelpCategory.active" => "1" ) ));
            $main_cat_id = $this->HelpCategory->find("first", array( "conditions" => array( "HelpCategory.id" => $category_id["HelpCategory"]["parent_id"] ) ));
            $post_array[] = array( "id" => $post_title["HelpPost"]["id"] . "##" . $post_title["HelpPost"]["slug" . $lang_var] . "##" . $main_cat_id["HelpCategory"]["slug" . $lang_var], "name" => $post_title["HelpPost"]["post_title" . $lang_var] );
        }
        return json_encode($post_array);
    }

    public function search_post()
    {
        $faq_main_cat_id = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.section" => "faq", "HelpCategory.parent_id" => 0 ), "fields" => array( "HelpCategory.id", "HelpCategory.id" ) ));
        $faq_main_categories = $this->HelpCategory->find("all", array( "conditions" => array( "HelpCategory.section" => "faq", "HelpCategory.parent_id" => $faq_main_cat_id, "HelpCategory.active" => "1" ), "order" => "HelpCategory.id asc" ));
        $faq_categories_and_subcategories = array(  );
        $c = 0;
        foreach( $faq_main_categories as $faq_main_category ) 
        {
            $faq_categories_and_subcategories[$c] = $faq_main_category;
            $faq_cat_id = $this->HelpCategory->find("all", array( "conditions" => array( "HelpCategory.section" => "faq", "HelpCategory.parent_id" => $faq_main_category["HelpCategory"]["id"], "HelpCategory.active" => "1" ) ));
            $faq_categories_and_subcategories[$c]["SubCategories"] = $faq_cat_id;
            $c++;
        }
        $this->set("faq_categories_and_subcategories", $faq_categories_and_subcategories);
        if( !empty($this->data["HelpPost"]["post_title"]) ) 
        {
            $main_cat_faq = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.parent_id" => "1", "HelpCategory.active" => "1" ) ));
            $main_subcat_faq = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.parent_id" => $main_cat_faq, "HelpCategory.active" => "1" ) ));
            $post_titles = $this->HelpPost->find("all", array( "conditions" => array( "HelpPost.parent_id" => $main_subcat_faq, "HelpPost.post_title like" => "%" . $this->data["HelpPost"]["post_title"] . "%" ) ));
            $this->set("category_posts", $post_titles);
            $this->set("data_title", $this->data["HelpPost"]["post_title"]);
        }

    }

    public function design_page()
    {
        $this->set("title_for_layout", __("Style_Guide_Title", true) . " &mdash; " . Configure::read("CONFIG_SITE_TITLE"));
    }

    public function logo_download($image_name = "")
    {
        $this->layout = false;
        $this->autoRender = false;
        if( !isset($image_name) ) 
        {
            exit( "<b>404 File not found!</b>" );
        }

        $this->downloadFile($image_name, WWW_ROOT . "img/front/logo/");
    }

}




?>