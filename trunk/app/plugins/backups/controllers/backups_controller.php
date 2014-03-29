<?php 
//
// This source code was recovered by Recover-PHP.com
//

class BackupsController extends BackupsAppController
{
    public $name = "Backups";
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
        $breadcrumb = array( "pages" => $pages, "active" => __d("backups", "Backup", true) );
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

    public function admin_backup()
    {
        $data["database_file"] = "dbbackups" . "-" . time() . ".sql";
        $this->data["fileName"] = $data["database_file"];
        $storeFile = DB_BACKUP_PATH . $data["database_file"];
        $dataSource = ConnectionManager::getdatasource("default");
        system(sprintf("mysqldump --host=%s --user=%s --password=%s %s  > %s", $dataSource->config["host"], $dataSource->config["login"], $dataSource->config["password"], $dataSource->config["database"], $storeFile));
        $this->Backup->save($this->data);
        $this->Session->setFlash(__d("backups", "Page added successfully.", true), "admin/success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_delete_backup()
    {
        $this->data = $this->Backup->read();
        $this->Backup->delete($id);
        $backup = $this->data["Backup"]["fileName"];
        unlink(DB_BACKUP_PATH . $backup);
        $this->Session->setFlash(__d("Backups", "Backup delete successfully.", true), "success");
        $this->redirect(array( "action" => "index" ));
    }

    public function admin_download_backup($file = "")
    {
        $this->autoRender = false;
        $this->downloadFile($file, DB_BACKUP_PATH);
        exit();
    }

}
