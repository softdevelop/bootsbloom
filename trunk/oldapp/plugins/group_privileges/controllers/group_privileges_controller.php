<?php 
//
// This source code was recovered by Recover-PHP.com
//


class GroupPrivilegesController extends GroupPrivilegesAppController
{
    public $name = "GroupPrivileges";
    public $components = array( "Auth", "Email", "Session", "RequestHandler" );
    public $helpers = array( "Html", "Form", "Session", "Time", "Text" );
    public $layout = "default";
    public $uses = array( "group_privileges.GroupPrivilege", "group_privileges.Module", "groups.Group" );
    public $paginate = NULL;

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
        $searchTerm = "";
        $this->set("results", $this->Group->find("all", array( "conditions" => array( "Group.id <> 1", "Group.id <> 3" ) )));
    }

    public function admin_privileges($group_id = null)
    {
        $this->loadModel("users.User");
        if( empty($group_id) || $group_id == null ) 
        {
            $this->Session->setFlash(__d("group_privileges", "Please setlect a group first.", true), "admin/error");
            $this->redirect(array( "plugin" => "group_privileges", "controller" => "group_privileges", "action" => "index" ));
        }

        $privileges = $this->GroupPrivilege->find("all", array( "conditions" => "GroupPrivilege.group_id='" . $group_id . "'" ));
        $checked_modules = array(  );
        foreach( $privileges as $privilege ) 
        {
            $checked_modules[] = $privilege["GroupPrivilege"]["module_id"];
        }
        if( !isset($this->data) ) 
        {
            $modules = $this->Module->find("all", array( "conditions" => "Module.parent_id=0" ));
            $module_list_array = array(  );
            foreach( $modules as $module ) 
            {
                if( !empty($module["Module"]["plugin"]) ) 
                {
                    $has_child = $this->Module->find("count", array( "conditions" => "Module.plugin='" . $module["Module"]["plugin"] . "' AND Module.parent_id='" . $module["Module"]["id"] . "'" ));
                    if( $has_child ) 
                    {
                        $module_list_array["Plugin"][$module["Module"]["id"]]["id"] = $module["Module"]["id"];
                        $module_list_array["Plugin"][$module["Module"]["id"]]["name"] = $module["Module"]["module"];
                        $sub_menus = $this->Module->find("all", array( "conditions" => "Module.plugin='" . $module["Module"]["plugin"] . "' AND Module.parent_id='" . $module["Module"]["id"] . "'" ));
                        foreach( $sub_menus as $sub_menu ) 
                        {
                            $sub_menu_checked = "";
                            if( in_array($sub_menu["Module"]["id"], $checked_modules) ) 
                            {
                                $sub_menu_checked = "checked='checked'";
                            }

                            $module_list_array["Plugin"][$module["Module"]["id"]]["controllers"][$sub_menu["Module"]["id"]]["id"] = $sub_menu["Module"]["id"];
                            $module_list_array["Plugin"][$module["Module"]["id"]]["controllers"][$sub_menu["Module"]["id"]]["name"] = $sub_menu["Module"]["module"];
                            $actions = $this->Module->find("all", array( "conditions" => "Module.parent_id='" . $sub_menu["Module"]["id"] . "'" ));
                            $action_array = array(  );
                            foreach( $actions as $action ) 
                            {
                                $action_array[$action["Module"]["id"]] = $action["Module"]["module"];
                            }
                            $module_list_array["Plugin"][$module["Module"]["id"]]["controllers"][$sub_menu["Module"]["id"]]["action"] = $action_array;
                        }
                    }

                }

            }
            $this->set("checked_modules", $checked_modules);
            $this->set("group_id", $group_id);
            $this->set("module_list", $module_list_array);
        }
        else
        {
            if( isset($this->data) ) 
            {
                $this->GroupPrivilege->Query("Delete From group_privileges where group_id='" . $group_id . "'");
                $privilegeDataArray = array(  );
                foreach( $this->data["Admin"]["privileges"] as $checked_module ) 
                {
                    $privilegeDataArray["GroupPrivilege"]["group_id"] = $group_id;
                    $privilegeDataArray["GroupPrivilege"]["module_id"] = $checked_module;
                    $this->GroupPrivilege->save($privilegeDataArray);
                    $this->GroupPrivilege->create();
                }
                $this->Session->setFlash(__d("group_privileges", "Group Privileges updated successfully.", true), "admin/success");
                $this->redirect(array( "controller" => "group_privileges", "action" => "index" ));
                exit();
            }

        }

    }

}
