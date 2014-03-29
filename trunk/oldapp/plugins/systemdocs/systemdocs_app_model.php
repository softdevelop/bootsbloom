<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Copyright 2012, Gempulse Infotech Pvt. Ltd. (http://www.fullestop.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010, Cake Development Corporation (http://www.fullestop.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

class systemdocsAppModel extends AppModel
{
    public $plugin = "systemdocs";
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




?>