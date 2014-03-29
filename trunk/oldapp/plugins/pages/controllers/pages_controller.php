<?php 
//
// This source code was recovered by Recover-PHP.com
//

class PagesController extends PagesAppController
{
    public $name = "Pages";
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript", "Editor" );
    public $uses = array( "Pages.Page", "Project", "ProjectCancellationRequest", "Partner" );
    public $components = array( "Auth", "Session", "Cookie", "Search.Prg", "Email" => array( "sendAs" => "html" ) );
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
            $this->Auth->allow("display", "contact_us", "under_construction");
        }

    }

    public function admin_index()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("users", "Pages", true) );
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

    public function admin_add_page($lang = null)
    {
        if( !isset($lang) ) 
        {
            $lang = "eng";
        }

        if( !empty($this->data) ) 
        {
            if( $lang == "eng" ) 
            {
                $this->Page->set($this->data);
                $this->Page->setValidation("add_page");
                if( $this->Page->validates() ) 
                {
                    $this->data["Page"]["slug"] = $this->Page->createSlug($this->data["Page"]["title"]);
                    $this->Session->write("add_pages", $this->data);
                    $this->Session->setFlash(__d("pages", "Please complete Armenian tab too.", true), "admin/success");
                    $this->redirect(array( "plugin" => "pages", "controller" => "pages", "action" => "admin_add_page", "hy" ));
                    return NULL;
                }

            }
            else
            {
                if( $lang == "hy" ) 
                {
                    $this->Page->set($this->data);
                    $this->Page->setValidation("add_page_hy");
                    if( $this->Page->validates() ) 
                    {
                        $english_page = $this->Session->read("add_pages");
                        $this->data["Page"]["slug_hy"] = $english_page["Page"]["slug"];
                        $this->Page->save($this->data, false);
                        $this->Page->save($english_page, false);
                        $this->Session->delete("add_pages");
                        $this->Session->setFlash(__d("pages", "Page added successfully.", true), "admin/success");
                        $this->redirect(array( "plugin" => "pages", "controller" => "pages", "action" => "index" ));
                        return NULL;
                    }

                }

            }

        }
        else
        {
            $tab1_data = $this->Session->read("add_pages");
            if( isset($tab1_data) ) 
            {
                $this->data["Page"]["title"] = $tab1_data["Page"]["title"];
                $this->data["Page"]["description"] = $tab1_data["Page"]["description"];
                $this->data["Page"]["metakeyword"] = $tab1_data["Page"]["metakeyword"];
                $this->data["Page"]["metadescription"] = $tab1_data["Page"]["metadescription"];
            }

        }

    }

    public function admin_add_page_kapil()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("users", "Pages", true)] = array( "plugin" => "Pages", "controller" => "pages", "action" => "admin_index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("users", "add page", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->Page->set($this->data);
            $this->Page->setValidation("add_page");
            if( $this->Page->validates() ) 
            {
                $this->data["Page"]["slug"] = $this->Page->createSlug($this->data["Page"]["title"]);
                $this->Page->save($this->data);
                $this->Session->setFlash(__d("pages", "Page added successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index" ));
            }

        }

    }

    public function admin_delete_page($id = null)
    {
        $this->Page->delete($id);
        $this->Session->setFlash(__d("pages", "Page delete successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_edit_page($id = null, $lang = null)
    {
        if( !isset($lang) ) 
        {
            $lang = "eng";
        }

        if( !empty($this->data) ) 
        {
            if( $lang == "eng" ) 
            {
                $this->Page->set($this->data);
                $this->Page->setValidation("add_page");
                if( $this->Page->validates() ) 
                {
                    $this->data["Page"]["id"] = $id;
                    $this->Session->write("edit_pages", $this->data);
                    $this->Page->save($this->data, false);
                    $this->Session->setFlash(__d("pages", "Please complete edit Armenian tab too.", true), "admin/success");
                    $this->redirect(array( "plugin" => "pages", "controller" => "pages", "action" => "admin_edit_page", $id, "hy" ));
                }

            }
            else
            {
                if( $lang == "hy" ) 
                {
                    $this->Page->set($this->data);
                    $this->Page->setValidation("add_page_hy");
                    if( $this->Page->validates() ) 
                    {
                        $english_page = $this->Session->read("edit_pages");
                        $this->data["Page"]["id"] = $id;
                        $this->Page->save($this->data, false);
                        if( isset($english_page) ) 
                        {
                            $this->Page->save($english_page, false);
                        }

                        $this->Session->delete("edit_pages");
                        $this->Session->setFlash(__d("pages", "Page updated successfully.", true), "admin/success");
                        $this->redirect(array( "plugin" => "pages", "controller" => "pages", "action" => "index" ));
                    }

                }

            }

        }
        else
        {
            $user = $this->Page->findById($id);
            $tab1_data = $this->Session->read("edit_pages");
            if( isset($tab1_data) ) 
            {
                $this->data["Page"]["title"] = $tab1_data["Page"]["title"];
                $this->data["Page"]["description"] = $tab1_data["Page"]["description"];
                $this->data["Page"]["metakeyword"] = $tab1_data["Page"]["metakeyword"];
                $this->data["Page"]["metadescription"] = $tab1_data["Page"]["metadescription"];
                $this->data["Page"]["title_hy"] = $user["Page"]["title_hy"];
                $this->data["Page"]["description_hy"] = $user["Page"]["description_hy"];
                $this->data["Page"]["metakeyword_hy"] = $user["Page"]["metakeyword_hy"];
                $this->data["Page"]["metadescription_hy"] = $user["Page"]["metadescription_hy"];
                $this->data["Page"]["home_page"] = $user["Page"]["home_page"];
                $this->data["Page"]["position"] = $user["Page"]["position"];
                $this->data["Page"]["active"] = $user["Page"]["active"];
            }
            else
            {
                $this->data = $user;
            }

        }

        $this->set("page_id", $id);
    }

    public function admin_edit_page_kapil($id = null)
    {
        $pages[__d("pages", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("pages", "Pages", true)] = array( "plugin" => "Pages", "controller" => "pages", "action" => "admin_index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("pages", "Edit page", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $this->Page->set($this->data);
            $this->Page->setValidation("add_page");
            if( $this->Page->validates() ) 
            {
                $this->Page->save($this->data);
                $this->Session->setFlash(__d("pages", "Page updated successfully.", true), "admin/success");
                $this->redirect(array( "action" => "index" ));
            }

        }

        $user = $this->Page->findById($id);
        $this->data = $user;
    }

    public function admin_change_status($value = null, $id = null)
    {
        if( $value == "1" ) 
        {
            $Pages = array(  );
            $Pages["id"] = $id;
            $Pages["active"] = "0";
        }
        else
        {
            $Pages = array(  );
            $Pages["id"] = $id;
            $Pages["active"] = "1";
        }

        $this->Page->save($Pages, false);
        $this->Session->setFlash(__d("pages", "Page status change successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function display($page_slug = null)
    {
        $language = $this->Session->read("Config.language");
        if( $page_slug == null )		
        {
			exit();
		}
		
		$slug_field = ( $language != "hy" ) ? 'slug' : 'slug_hy';

		$page_data = $this->Page->find("first", array( "conditions" => array( $slug_field => $page_slug, "Page.active" => "1" ) ));
		if( $language != "hy" ) 
		{
			$this->set("title_for_layout", $page_data["Page"]["title"]);
			$this->set("keywords_for_layout", $page_data["Page"]["metakeyword"]);
			$this->set("description_for_layout", $page_data["Page"]["metadescription"]);
		}
		else
		{
			$this->set("title_for_layout", $page_data["Page"]["title_hy"]);
			$this->set("keywords_for_layout", $page_data["Page"]["metakeyword_hy"]);
			$this->set("description_for_layout", $page_data["Page"]["metadescription_hy"]);
		}

		$this->set("page_data", $page_data);

    }

    public function contact_us()
    {
        $userloginId = $this->Session->read("Auth.User.id");
        if( $userloginId != "" && "0" < $userloginId ) 
        {
            $time = time();
            $projects = $this->Project->find("list", array( "conditions" => array( "Project.is_successful" => "0", "Project.submitted_status" => "1", "Project.active" => "1", "Project.is_cancelled " => "0", "Project.user_id " => $userloginId, "Project.cancellation_request_sent" => 0, "Project.end_time >" . $time ), "fields" => array( "Project.id", "Project.title" ) ));
            $this->set("project_list", $projects);
        }

        $this->loadModel("Emaillog");
        if( !empty($this->data) ) 
        {
            $this->Page->set($this->data);
            $this->Page->setValidation("contact_us");
            if( $this->data["Page"]["question_about"] == "project cancel request" && empty($this->data["Page"]["cancel_project"]) ) 
            {
                $this->Page->validationErrors["cancel_project"] = __("Please_choose_one_project_for_cancel", true);
            }

            $projects_title = $this->Project->find("first", array( "conditions" => array( "Project.id" => $this->data["Page"]["cancel_project"] ), "fields" => array( "Project.title" ) ));
            if( $this->Page->validates() ) 
            {
                if( !empty($this->data["Page"]["cancel_project"]) ) 
                {
                    $data = array(  );
                    $data["ProjectCancellationRequest"]["project_id"] = $this->data["Page"]["cancel_project"];
                    $this->ProjectCancellationRequest->save($data, false);
                    $this->Project->id = $data["ProjectCancellationRequest"]["project_id"];
                    $this->Project->saveField("cancellation_request_sent", 1);
                    $subject = "Project Cancellation Request for " . $projects_title["Project"]["title"];
                }
                else
                {
                    $subject = "New Inquiry";
                }

                $to = Configure::read("CONFIG_EMAIL");
                $from = $this->data["Page"]["email"];
                $body = $this->data["Page"]["details"];
                $d["Emaillog"]["email_to"] = $to;
                $d["Emaillog"]["email_from"] = $from;
                $d["Emaillog"]["email_type"] = "C";
                $d["Emaillog"]["subject"] = $subject;
                $d["Emaillog"]["message"] = $body;
                $d["Emaillog"]["active"] = "1";
                $d["Emaillog"]["deleted"] = "0";
                $this->Email->from = $from;
                $this->Email->to = $to;
                $this->Email->subject = $subject;
                $this->Email->template = "contact_us_email";
                $element = "contact_us_email";
                $replyTo = Configure::read("CONFIG_FROMEMAIL");
                if( $this->_sendMail($to, $from, $replyTo, $subject, $element, $parsingParams = array(  ), $attachments = "", $sendAs = "html", $bcc = array(  )) ) 
                {
                    $this->Emaillog->create();
                    $this->Emaillog->set($d);
                    $this->Emaillog->save();
                }

                echo "success";
                exit();
            }

        }

    }

    public function under_construction()
    {
        $this->layout = "";
        echo $this->render("/under_construction");
        exit();
    }

}
