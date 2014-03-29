<?php 
//
// This source code was recovered by Recover-PHP.com
//

class backupsAppModel extends AppModel
{
    public $plugin = "backups";
    public $actsAs = array( "Containable" );

    public function paginateCount($conditions = array(  ), $recursive = 0, $extra = array(  ))
    {
        $parameters = compact("conditions");
        if( $recursive != $this->recursive ) 
        {
            $parameters["recursive"] = $recursive;
        }

        if( isset($extra["type"]) && isset($this->_findMethods[$extra["type"]]) ) 
        {
            $extra["operation"] = "count";
            return $this->find($extra["type"], array_merge($parameters, $extra));
        }

        return $this->find("count", array_merge($parameters, $extra));
    }

}
