<?php 
//
// This source code was recovered by Recover-PHP.com
//


class CitiesController extends AppController
{
    public $name = "Cities";
    public $helpers = array( "Time" );
    public $paginate = NULL;
    public $uses = array( "City" );
    public $presetVars = array( array( "field" => "name", "type" => "value" ) );

    public function beforeFilter()
    {
        parent::beforefilter();
        $this->set("model", $this->modelClass);
        if( !Configure::read("App.defaultEmail") ) 
        {
            Configure::write("App.defaultEmail", Configure::read("noreply_email.email"));
        }

    }

    public function admin_index()
    {
        $condition = array(  );
        if( !empty($this->data) && isset($this->data["recordsPerPage"]) ) 
        {
            $limitValue = $limit = $this->data["recordsPerPage"];
            $this->Session->write($this->modelClass . "." . $this->action . ".recordsPerPage", $limit);
        }
        else
        {
            $this->Prg->commonProcess();
        }

        $limitValue = $limit = $this->Session->read($this->modelClass . "." . $this->action . ".recordsPerPage") ? $this->Session->read($this->modelClass . "." . $this->action . ".recordsPerPage") : Configure::read("CONFIG_PAGE_LIMIT");
        $this->set("limitValue", $limitValue);
        $this->set("limit", $limit);
        $this->{$this->modelClass}->data[$this->modelClass] = $this->passedArgs;
        if( isset($this->passedArgs["name"]) && $this->passedArgs["name"] == "Name" ) 
        {
            $this->passedArgs["name"] = "";
        }

        $parsedConditions = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
        $this->paginate[$this->modelClass]["conditions"] = $parsedConditions;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".modified" => "desc" );
        $this->paginate[$this->modelClass]["limit"] = $limitValue;
        $this->set("results", $this->paginate($this->modelClass));
    }

    public function admin_add()
    {
        $this->loadModel("Country");
        $countries = $this->Country->find("list", array( "fields" => array( "Country.iso3166_1", "Country.name" ) ));
        $this->set("countries", $countries);
        if( isset($this->data) ) 
        {
            $this->City->set($this->data);
            $this->City->setValidation("city_name");
            if( $this->City->validates() ) 
            {
                $this->City->save($this->data);
                $this->Session->setFlash("City Added Successfully.", "admin/success");
                $this->redirect(array( "action" => "index" ));
            }

        }

    }

    public function admin_edit($id = null)
    {
        $this->loadModel("Country");
        $countries = $this->Country->find("list", array( "fields" => array( "Country.iso3166_1", "Country.name" ) ));
        $this->set("countries", $countries);
        if( isset($this->data) ) 
        {
            $this->City->set($this->data);
            $this->City->setValidation("city_name");
            if( $this->City->validates() ) 
            {
                $this->City->save($this->data);
                $this->Session->setFlash("City Updated Successfully.", "admin/success");
                $this->redirect(array( "action" => "index" ));
                return NULL;
            }

        }
        else
        {
            $this->City->id = $id;
            $this->data = $this->City->read();
        }

    }

}
