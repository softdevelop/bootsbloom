<?php 
//
// This source code was recovered by Recover-PHP.com
//


class ProjectUpdatesController extends AppController
{
    public $name = "ProjectUpdates";
    public $helpers = array( "Time" );
    public $uses = array( "Project", "ProjectUpdate" );
    public $presetVars = array( array( "field" => "title", "type" => "value" ) );

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

    }

    public function index()
    {
        $this->set("title_for_layout", __("discover_project", true) . " &mdash; " . Configure::read("CONFIG_SITE_TITLE"));
        $conditions = array( "ProjectUpdate.active" => "1" );
        $limit = Configure::read("CONFIG_PROJECT_LISTING");
        $this->get_loading("ProjectUpdate", $conditions, $order = "ProjectUpdate.id DESC", "projects_updates", $limit);
        $cat_list = $this->CommonFunction->get_category_subcat_list();
        $this->set("cat_list", $cat_list);
        if( $this->params["isAjax"] ) 
        {
            echo $this->render("/elements/projects/load_more_project_update");
            exit();
        }

        $cities = $this->get_cities_of_projects();
        $this->set("cities", $cities);
    }

}

