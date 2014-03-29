<?php 
//
// This source code was recovered by Recover-PHP.com
//


class SchoolsController extends AppController
{
    public $name = "Schools";
    public $components = array( "Auth", "Email", "Session", "RequestHandler" );
    public $helpers = array( "Html", "Form", "Session", "Time", "Text" );
    public $uses = array( "help_categories.School", "help_posts.HelpPost" );
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
            $this->Auth->allow("school");
        }

    }

    public function admin_index($parent_id = 2)
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
        $conditions[$this->modelClass . ".section"] = "School";
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions + $conditions;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("result", $this->paginate("School"));
        $this->set("parent_id", $parent_id);
        if( 2 < $parent_id ) 
        {
            $category_name = $this->HelpCategory->find("first", array( "conditions" => array( "HelpCategory.id" => $parent_id ), "fields" => array( "category_name", "parent_id" ) ));
            $this->set("category_name", $category_name);
        }

    }

    public function admin_add_category($parent_id = 0, $lang = null)
    {
        if( !empty($this->data) ) 
        {
            $this->School->set($this->data);
            $this->School->setValidation("admin_add_category");
            if( $this->School->validates() ) 
            {
                $this->data["School"]["slug"] = $this->School->createSlug($this->data["School"]["category_name"]);
                $tmpPath = $this->data["School"]["category_image"]["tmp_name"];
                $imgName = $this->data["School"]["category_image"]["name"];
                $imgName = str_replace(" ", "_", $imgName);
                $image_name = "school_category_" . time() . $imgName;
                $this->data["School"]["category_image"] = $image_name;
                move_uploaded_file($tmpPath, UPLOAD_DIR . $image_name);
                $this->data["School"]["slug_hy"] = $this->data["School"]["slug"];
                $this->School->save($this->data, false);
                $this->Session->setFlash(__d("schools", "Category added successfuly.", true), "admin/success");
                $this->School->save($this->data, false);
                $this->redirect(array( "plugin" => "help_categories", "controller" => "schools", "action" => "index", $this->data["School"]["parent_id"] ));
            }

        }

        $tab1_data = $this->Session->read("school_add_category");
        if( isset($tab1_data) ) 
        {
            $this->data = $tab1_data;
        }

        $add_category = $this->School->findById($parent_id);
        $this->set("add_category", $add_category);
        $this->set("parent_id", $parent_id);
    }

    public function admin_edit_category($id = null, $lang = null)
    {
        if( !empty($this->data) ) 
        {
            $this->School->set($this->data);
            $this->School->setValidation("admin_edit_category");
            if( $this->School->validates() ) 
            {
                $this->Session->write("edit_school_category", $this->data);
                $this->Session->setFlash(__d("HelpCategory", "Please complete Armenian tab too .", true), "admin/success");
                $this->redirect(array( "plugin" => "help_categories", "controller" => "schools", "action" => "admin_edit_category", $id, "hy" ));
            }

            $this->School->set($this->data);
            if( $this->data["School"]["category_image"]["name"] == "" ) 
            {
                unset($this->School->validate["category_image"]);
            }

            if( $this->School->validates() ) 
            {
                if( $this->data["School"]["category_image"]["name"] != "" ) 
                {
                    $tmpPath = $this->data["School"]["category_image"]["tmp_name"];
                    $imgName = $this->data["School"]["category_image"]["name"];
                    $imgName = str_replace(" ", "_", $imgName);
                    $image_name = "school_category__" . time() . $imgName;
                    $this->data["School"]["category_image"] = $image_name;
                    move_uploaded_file($tmpPath, UPLOAD_DIR . $image_name);
                    unlink(UPLOAD_DIR . $this->data["School"]["Schoolimage_update"]);
                    $this->data["School"]["id"] = $this->data["School"]["id"];
                    $english_tab = $this->Session->read("edit_school_category");
                    $this->School->save($english_tab);
                    $this->School->save($this->data);
                    $this->Session->setFlash(__d("HelpCategory", "Category updated successfully.", true), "admin/success");
                    $this->redirect(array( "plugin" => "help_categories", "controller" => "schools", "action" => "index", $this->data["HelpCategory"]["parent_id"] ));
                }
                else
                {
                    $this->data["School"]["category_image"] = $this->data["School"]["Schoolimage_update"];
                    $this->data["School"]["id"] = $this->data["School"]["id"];
                    $english_tab = $this->Session->read("edit_school_category");
                    $this->School->save($english_tab);
                    $this->School->save($this->data);
                    $this->Session->setFlash(__d("HelpCategory", "Category updated successfully.", true), "admin/success");
                    $this->redirect(array( "plugin" => "help_categories", "controller" => "schools", "action" => "index", $this->data["HelpCategory"]["parent_id"] ));
                }

            }

        }
        else
        {
            $tab1_data = $this->Session->read("edit_school_category");
            if( isset($tab1_data) ) 
            {
                $this->data = $tab1_data;
            }

            $help_category = $this->School->findById($id);
            $this->set("category_image", $partner_logo = $help_category["School"]["category_image"]);
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

        $this->School->save($letter, false);
        $this->Session->setFlash(__d("faqs", "Category status updated successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_delete_catrgory($id = null)
    {
        $this->School->delete($id);
        $this->Session->setFlash(__d("schools", "Category deleted successfully.", true), "admin/success");
        $this->redirect($this->referer());
    }

    public function admin_operate()
    {
        $this->autoRender = false;
        if( !empty($this->data["Schools"]["operation"]) ) 
        {
            if( $this->data["Schools"]["operation"] == "active" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->School->updateAll(array( "active" => 1 ), array( "School.id IN (" . $ids . ")" ));
                $message = sprintf(__d("schools", "Post activated successfully.", true));
            }

            if( $this->data["Schools"]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->School->updateAll(array( "active" => 0 ), array( "School.id IN (" . $ids . ")" ));
                $message = sprintf(__d("schools", "Post inactivated successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect($this->referer());
        }

    }

    public function school_home()
    {
        $this->loadModel("HelpCategory");
        $school_categories = $this->HelpCategory->find("all", array( "conditions" => array( "HelpCategory.section" => "school", "HelpCategory.parent_id" => "2", "HelpCategory.active" => "1" ) ));
        $this->set("school_categories", $school_categories);
        $this->set("title_for_layout", __("school_best_practices", true) . " &mdash; " . Configure::read("CONFIG_SITE_TITLE"));
    }

    public function school($section = null, $cat_slug = null)
    {
        if( $section == "" ) 
        {
            $section = "school";
        }

        if( $cat_slug == "" ) 
        {
            $cat_slug = "define-your-project";
        }

        $this->loadModel("HelpCategory");
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
        $school_categories = $this->HelpCategory->find("all", array( "conditions" => array( "HelpCategory.section" => "school", "HelpCategory.parent_id" => "2", "HelpCategory.active" => "1" ) ));
        $school_category_id = $this->HelpCategory->find("list", array( "conditions" => array( "HelpCategory.section" => $section, "HelpCategory.slug" => $cat_slug ) ));
        if( empty($school_category_id) ) 
        {
            $this->_404error();
        }

        $school_posts = $this->HelpPost->find("all", array( "conditions" => array( "HelpPost.parent_id" => $school_category_id, "HelpPost.active" => "1" ) ));
        $school_category_title = $this->HelpCategory->find("first", array( "conditions" => array( "HelpCategory.section" => $section, "HelpCategory.slug" => $cat_slug ) ));
        $this->HelpCategory->id = $school_category_title["HelpCategory"]["id"];
        $neighbors_caterogy = $this->HelpCategory->find("neighbors", array( "order" => array( "HelpCategory.order" => "DESC" ), "fields" => array( "id", "slug", "category_name", "slug_hy", "category_name_hy" ), "conditions" => array( "HelpCategory.section" => $section, "HelpCategory.active" => "1", "HelpCategory.parent_id <>" => "0" ) ));
        $language = $this->Session->read("Config.language");
        $this->set("neighbors_caterogy", $neighbors_caterogy);
        $this->set("category_title", $school_category_title);
        $this->set("school_posts", $school_posts);
        $this->set("school_categories", $school_categories);
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

        $school_category_title = $school_category_title["HelpCategory"]["category_name" . $lang_var];
        $this->set("title_for_layout", $school_category_title . "- &mdash; " . Configure::read("CONFIG_SITE_TITLE"));
    }

}
