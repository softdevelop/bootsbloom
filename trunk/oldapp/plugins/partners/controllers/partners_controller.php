<?php 
//
// This source code was recovered by Recover-PHP.com
//

class PartnersController extends AppController
{
    public $name = "Partners";
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript" );
    public $components = array( "Auth", "Session", "Email", "Cookie", "Search.Prg" );
    public $presetVars = array( array( "field" => "partner_name", "type" => "value" ) );
    public $partner_name = array( "Partners.Partner" );

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
            $this->Auth->allow("under_construction", "curated_page");
        }

    }

    public function admin_index()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("partners", "Curated Pages", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) && isset($this->data["recordsPerPage"]) ) 
        {
            $limitValue = $limit = $this->data["recordsPerPage"];
            $this->Session->write($this->partner_name . "." . $this->action . ".recordsPerPage", $limit);
        }
        else
        {
            $this->Prg->commonProcess();
        }

        $limitValue = $limit = $this->Session->read($this->partner_name . "." . $this->action . ".recordsPerPage") ? $this->Session->read($this->partner_name . "." . $this->action . ".recordsPerPage") : Configure::read("defaultPaginationLimit");
        $this->set("limitValue", $limitValue);
        $this->set("limit", $limit);
        $searchTerm = "";
        $this->{$this->modelClass}->data[$this->modelClass] = $this->passedArgs;
        $parsedConditions = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions;
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("result", $this->paginate());
    }

    public function admin_add_partner()
    {
        $pages[__d("users", "Partners", true)] = array( "plugin" => "partners", "controller" => "partners", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("partners", "Add Curated Page", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->Partner->set($this->data);
            if( $this->Partner->validates() ) 
            {
                $this->data["Partner"]["slug"] = $this->Partner->createSlug($this->data["Partner"]["partner_name"]);
                $tmpPath = $this->data["Partner"]["partner_images"]["tmp_name"];
                $imgName = $this->data["Partner"]["partner_images"]["name"];
                $imgName = str_replace(" ", "_", $imgName);
                $image_name = "partner_" . time() . $imgName;
                $this->data["Partner"]["partner_image"] = $image_name;
                move_uploaded_file($tmpPath, UPLOAD_DIR . $image_name);
                if( $this->Partner->save($this->data, false) ) 
                {
                    $this->Session->setFlash(__("Curated page saved successfully.", true), "admin/success");
                    $this->redirect(array( "action" => "index" ));
                }

            }

        }

    }

    public function admin_edit_partner($id = null)
    {
        if( $id == null ) 
        {
            $this->redirect(array( "action" => "index" ));
        }

        $pages[__d("Curated page", "Curated page", true)] = array( "plugin" => "partners", "controller" => "partners", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("partners", "Edit Curated Page", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->Partner->set($this->data);
            if( $this->data["Partner"]["partner_image"]["name"] == "" ) 
            {
                unset($this->Partner->validate["partner_image"]);
            }

            if( $this->Partner->validates() ) 
            {
                if( $this->data["Partner"]["partner_image"]["name"] != "" ) 
                {
                    $tmpPath = $this->data["Partner"]["partner_image"]["tmp_name"];
                    $imgName = $this->data["Partner"]["partner_image"]["name"];
                    $imgName = str_replace(" ", "_", $imgName);
                    $image_name = "partner_" . time() . $imgName;
                    $this->data["Partner"]["partner_image"] = $image_name;
                    move_uploaded_file($tmpPath, UPLOAD_DIR . $image_name);
                    unlink(UPLOAD_DIR . $this->data["Partner"]["image_update"]);
                    if( $this->Partner->save($this->data, false) ) 
                    {
                        $this->Session->setFlash(__("Curated page data updated successfully.", true), "admin/success");
                        $this->redirect(array( "action" => "index" ));
                    }

                }
                else
                {
                    $this->data["Partner"]["partner_image"] = $this->data["Partner"]["image_update"];
                    if( $this->Partner->save($this->data) ) 
                    {
                        $this->Session->setFlash(__("Curated page data updated successfully.", true), "admin/success");
                        $this->redirect(array( "action" => "index" ));
                    }

                }

            }

        }

        $partner = $this->Partner->findById($id);
        $this->set("partner_logo", $partner_logo = $partner["Partner"]["partner_image"]);
        $this->data = $partner;
    }

    public function admin_delete_partner($id = null)
    {
        $this->data = $this->Partner->findById($id);
        $this->Partner->delete($id);
        $partner_image = $this->data["Partner"]["partner_image"];
        unlink(UPLOAD_DIR . $partner_image);
        $this->Session->setFlash(__d("Curated page", "Curated page deleted successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_change_partner_status($value = null, $id = null)
    {
        if( $value == "1" ) 
        {
            $this->data["id"] = $id;
            $this->data["active"] = "0";
        }
        else
        {
            $this->data["id"] = $id;
            $this->data["active"] = "1";
        }

        $this->Partner->save($this->data, false);
        $this->Session->setFlash(__d("Curated page", "Curated page status updated successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_operate()
    {
        if( !empty($this->data[$this->modelClass]["operation"]) ) 
        {
            if( $this->data[$this->modelClass]["operation"] == "active" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 1 ), array( "Partner.id IN (" . $ids . ")" ));
                $message = sprintf(__d("partners", "Curated pages activated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "inactive" ) 
            {
                echo $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->updateAll(array( "active" => 0 ), array( "Partner.id IN (" . $ids . ")" ));
                $message = sprintf(__d("partners", "Curated pages inactivated successfully.", true));
            }

            if( $this->data[$this->modelClass]["operation"] == "delete" ) 
            {
                $ids = implode(",", $this->data["usersChk"]);
                $this->{$this->modelClass}->deleteAll(array( "Partner.id IN (" . $ids . ")" ));
                $message = sprintf(__d("partners", "Curated pages deleted successfully.", true));
            }

            $this->Session->setFlash($message, "admin/success");
            $this->redirect(array( "plugin" => "partners", "controller" => "partners", "action" => "index" ));
        }

    }

    public function curated_page()
    {
        $this->set("title_for_layout", __("curated_pages", true));
        $cat_list = $this->CommonFunction->get_category_subcat_list();
        $this->set("cat_list", $cat_list);
        $cities = $this->get_cities_of_projects();
        $this->set("cities", $cities);
        $conditions = array( "Partner.active" => "1" );
        $limit = Configure::read("CONFIG_PROJECT_LISTING");
        $this->get_loading("Partner", $conditions, "Partner.created DESC", "curatedpages", $limit);
        $this->set("load_more_action", $this->params["action"]);
        $this->set("filter_type", $this->params["action"]);
        if( $this->params["isAjax"] ) 
        {
            echo $this->render("/elements/curated_page_element");
            exit();
        }

    }

}
