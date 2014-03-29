<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Referer Component
 *
 * @package utils
 * @subpackage utils.controllers.components
 */

class RefererComponent extends Object
{
    public $Controller = NULL;

    public function initialize($controller)
    {
        $this->Controller = $controller;
    }

    public function startup($controller)
    {
        $this->setReferer();
    }

    public function setReferer($default = null)
    {
        if( empty($this->Controller->request->data["Data"]["referer"]) ) 
        {
            $referer = $this->Controller->request->referer();
            if( $referer == "/" && !empty($default) ) 
            {
                $referer = $default;
                if( is_array($referer) ) 
                {
                    $referer = Router::url($referer);
                }

            }

        }
        else
        {
            $referer = $this->Controller->request->data["Data"]["referer"];
        }

        $this->Controller->set(compact("referer"));
    }

    public function redirect($url, $status = null, $exit = true)
    {
        if( isset($this->Controller->data["Data"]["referer"]) ) 
        {
            $referer = $this->Controller->request->data["Data"]["referer"];
        }
        else
        {
            $referer = $this->Controller->request->referer();
        }

        if( strlen($referer) == 0 || $referer == "/" ) 
        {
            $this->Controller->redirect($url, $status, $exit);
        }
        else
        {
            $this->Controller->redirect($referer, $status, $exit);
        }

    }

}




?>