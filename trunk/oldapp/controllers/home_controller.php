<?php 
//
// This source code was recovered by Recover-PHP.com
//


class HomeController extends AppController
{
    public $name = "Home";
    public $uses = array( "Project", "categories.Category", "Backer", "Pages.Page", "Partners.Partner" );
    public $components = array( "Auth", "Session", "Email", "Cookie", "Search.Prg", "CommonFunction" );

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
            $this->Auth->allow("index", "start", "change_country", "get_categories", "getpopular");
        }

    }

    public function index()
    {
        $this->set("title_for_layout", Configure::read("CONFIG_SITE_TITLE"));
        $this->set("keywords_for_layout", Configure::read("CONFIG_META_KEYWORDS"));
        $this->set("description_for_layout", Configure::read("CONFIG_META_DESCRIPTION"));
        $user = $this->Session->read("Auth.User");
        $this->change_country();
        $email_session = $this->Session->read("email_session");
        $email_msg = $this->Session->read("email_msg");
        $this->Category->recursive = 2;
        $this->Category->bindModel(array( "hasMany" => array( "Project" => array( "className" => "Project", "conditions" => array( "Project.active" => "1", "Project.is_recommended" => 1, "Project.submitted_status" => "1", "Project.is_cancelled" => "0" ), "order" => "Project.project_approved_by_admin_date DESC", "limit" => "2", "dependent" => true ) ) ));
        $categories = $this->Category->find("all", array( "conditions" => array( "Category.active" => 1, "Category.parent_id" => 0 ), "fields" => array( "Category.id", "Category.slug", "Category.category_name" ), "order" => array( "category_name ASC" ) ));
        $first_category = $categories["0"]["Category"]["category_name"];
        $this->set("first_category", $first_category);
        $this->set("slideerCategories", $categories);
        if( $this->Session->read("Auth.User.id") ) 
        {
            $user = $this->Session->read("Auth.User");
            if( !empty($user["facebook_id"]) ) 
            {
                $contain_fields = array( "UserFollow.follow_user_id", "UserFollow.follow_user_id" );
                $friend_users = $this->CommonFunction->get_user_followings($user["id"], "list", $contain_fields);
                $created_projects = $this->Project->find("list", array( "fields" => array( "Project.id" ), "conditions" => array( "Project.user_id" => $friend_users, "Project.active" => 1, "Project.submitted_status" => 1, "Project.is_cancelled" => "0" ), "limit" => 3, "order" => array( "rand()" ) ));
                $backed_project = $this->Backer->find("list", array( "fields" => array( "project_id" ), "conditions" => array( "Backer.user_id" => $friend_users ), "limit" => 3, "group" => "Backer.project_id", "order" => array( "rand()" ) ));
                $friend_project_ids = array_merge($created_projects, $backed_project);
                $project_cond = array( "Project.id" => $friend_project_ids );
                $friend_projects = $this->Project->find("all", array( "conditions" => $project_cond, "contain" => array( "User" => array( "fields" => array( "id", "name", "slug" ) ), "Backer" => array( "fields" => array( "id", "amount", "user_id" ) ), "Reward" => array( "fields" => array( "id", "pledge_amount" ) ) ) ));
                $this->set("friend_users", $friend_users);
                $this->set("friend_projects", $friend_projects);
            }

        }

        $this->Project->unBindModel(array( "hasMany" => array( "Reward", "Backer", "ProjectAskedQuestion" ) ));
        $random_users = $this->Project->find("all", array( "conditions" => array( "Project.submitted_status" => 1 ), "fields" => array( "Project.user_id", "User.name", "User.slug", "User.profile_image", "User.fb_image_url" ), "group" => "Project.user_id", "limit" => 16 ));
        $this->set("random_users", $random_users);
        $this->Project->unBindModel(array( "hasMany" => array( "Reward", "Backer", "ProjectAskedQuestion" ) ));
        $random_project_images = $this->Project->find("all", array( "conditions" => array( "Project.submitted_status" => 1, "Project.active" => 1, "Project.image <>" => "", "Project.is_cancelled" => "0" ), "fields" => array( "Project.id", "Project.title", "Project.image", "Project.slug", "User.slug" ), "order" => "rand()", "limit" => 30 ));
        $this->set("random_project_images", $random_project_images);
        if( isset($email_session) ) 
        {
            $this->set("msg_text", $email_msg);
            $this->set("email_session", $email_session);
            $this->Session->delete("email_msg");
            $this->Session->delete("email_session");
        }

        $curatedpages = $this->Partner->find("all", array( "fields" => array( "Partner.partner_name,Partner.partner_image,Partner.partner_site_link" ), "conditions" => array( "Partner.active" => "1" ), "order" => "rand()", "limit" => 8 ));
        $this->set("curatedpages", $curatedpages);
    }

    public function change_country()
    {
        $this->loadModel("Country");
        $this->loadModel("City");
        $user = $this->Session->read("Auth.User");
        $fields_to_find = array( "Project.title", "Project.slug", "Project.project_end_date", "Project.image", "Project.funding_goal", "Project.project_country", "Project.project_country_json", "Project.short_description", "User.name", "User.slug", "User.id", "Category.category_name", "Backer.id", "Backer.amount" );
        $fields_to_find = array(  );
        if( isset($this->params["form"]["city"]) ) 
        {
            $project_country = $this->Project->find("all", array( "conditions" => array( "Project.project_city" => trim($this->params["form"]["city"]), "Project.active" => "1", "Project.is_cancelled" => "0" ), "order" => "Project.project_approved_by_admin_date DESC", "contain" => array( "User" => array( "fields" => array( "id", "name", "slug" ) ), "Backer" => array( "fields" => array( "id", "amount" ) ), "Reward" => array( "fields" => array( "id", "pledge_amount" ) ) ) ));
            $this->set("project_countries", $project_country);
            echo $this->render("/elements/project_slider");
            exit();
        }

        $default_city = Configure::read("CONFIG_CITY");
        $project_country = $this->Project->find("all", array( "limit" => 7, "conditions" => array( "Project.project_city" => $default_city, "Project.active" => "1", "Project.is_cancelled" => "0" ), "order" => "rand()"));
        $country = $this->City->find("first", array( "conditions" => array( "City.id" => $default_city ), "fields" => array( "City.name" ) ));
        $this->set("user_country", $country["City"]["name"]);
        $this->set("project_countries", $project_country);
    }

    public function start()
    {
        $this->set("start_proj_class", "act");
        $this->set("title_for_layout", Configure::read("CONFIG_SITE_TITLE"));
        $this->set("keywords_for_layout", Configure::read("CONFIG_META_KEYWORDS"));
        $this->set("description_for_layout", Configure::read("CONFIG_META_DESCRIPTION"));
        $start_project_content = $this->Page->find("first", array( "conditions" => array( "Page.id" => 83 ) ));
        $user_projects = $this->CommonFunction->user_created_projects($this->Session->read("Auth.User.id"));
        if( $this->Session->check("project_success") ) 
        {
            $project_success = $this->Session->read("project_success");
            $project_success_msg = $this->Session->read("project_success_msg");
            $this->Session->delete("project_success");
            $this->Session->delete("project_success_msg");
            $this->set("project_success", $project_success);
            $this->set("project_success_msg", $project_success_msg);
        }

        $this->set("user_projects", $user_projects);
        $this->set("start_project_content", $start_project_content);
    }

    public function getpopular()
    {
        $week_range = $this->CommonFunction->get_week_range(date("d"), date("m"), date("y"));
        $start_date = $week_range["week_start_date"];
        $end_date = $week_range["week_end_date"];
        $conditions = array( "Project.active" => 1, "Project.submitted_status" => 1, "Project.is_cancelled" => "0" );
        $limit = 12;
        $this->get_loading_projects_by_backer("Backer", $conditions, "sum(Backer.amount) DESC", "popular", $limit, "Backer.project_id");
        $this->set("load_more_action", $this->params["action"] . "/" . $limit);
        $this->set("title_for_layout", __("frnt_popular", true));
        if( $this->params["isAjax"] ) 
        {
            $this->autoRender = false;
            $this->layout = "ajax";
            echo $this->render("/home/popular_projects");
            exit();
        }

        $this->render("getpopular");
    }

    public function optout_feature()
    {
    }

}
