<?php 
//
// This source code was recovered by Recover-PHP.com
//

class SystemdocsController extends SystemdocsAppController
{
    public $name = "Systemdocs";
    public $helpers = array( "Html", "Form", "Session", "Time", "Text", "Utils.Gravatar", "Javascript" );
    public $components = array( "Auth", "Session", "Email", "Cookie", "Search.Prg" );

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
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("users", "Systemdoc", true) );
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
        $this->paginate[$this->modelClass]["limit"] = $limit;
        $this->paginate[$this->modelClass]["order"] = array( $this->modelClass . ".created" => "desc" );
        $this->set("result", $this->paginate());
    }

    public function admin_add_doc()
    {
        $pages[__d("users", "Dashboard", true)] = array( "plugin" => "", "controller" => "pages", "action" => "dashboard" );
        $pages[__d("users", "System docs", true)] = array( "plugin" => "systemdocs", "controller" => "systemdocs", "action" => "index" );
        $breadcrumb = array( "pages" => $pages, "active" => __d("Staticimage", "Add Doc", true) );
        $this->set("breadcrumb", $breadcrumb);
        if( !empty($this->data) ) 
        {
            $count = 0;
            foreach( $this->data["Systemdoc"]["doc_name"] as $value ) 
            {
                if( is_uploaded_file($value["tmp_name"]) ) 
                {
                    $doc_tmp_name = "systemdoc_" . rand(0, 999) . time();
                    $doc_tmp_type = strtolower(substr($value["name"], strpos($value["name"], ".") + 1));
                    if( $doc_tmp_type == "txt" || $doc_tmp_type == "xls" || $doc_tmp_type == "xlsx" || $doc_tmp_type == "doc" || $doc_tmp_type == "docx" || $doc_tmp_type == "pdf" ) 
                    {
                        $this->Systemdoc->create();
                        $this->data["Systemdoc"]["doc_name"] = $doc_tmp_name;
                        $this->data["Systemdoc"]["doc_type"] = $doc_tmp_type;
                        $doc_name = $this->data["Systemdoc"]["doc_name"] . "." . $this->data["Systemdoc"]["doc_type"];
                        move_uploaded_file($value["tmp_name"], UPLOAD_DIR . $doc_name);
                        $this->data["Systemdoc"]["active"] = 1;
                        $this->Systemdoc->save($this->data, false);
                        $count++;
                    }

                }

            }
            if( 0 < $count ) 
            {
                $this->Session->setFlash(__d("systemdocs", "System Document saved successfully.", true), "admin/success");
            }
            else
            {
                $this->Session->setFlash(__d("systemdocs", "You have some error in uploading files. Please try again!.", true), "admin/error");
            }

            $this->redirect(array( "action" => "index" ));
        }

    }

    public function admin_delete_doc($id = null, $file = "")
    {
        $this->data = $this->Systemdoc->read();
        $this->Systemdoc->delete($id);
        $doc_name = $this->data["Systemdoc"]["doc_name"] . "." . $this->data["Systemdoc"]["doc_type"];
        unlink(UPLOAD_DIR . $doc_name);
        $this->Session->setFlash(__d("systemdocs", "Document delete successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_download_doc($file = "")
    {
        $this->downloadFile($file, UPLOAD_DIR);
    }

}
