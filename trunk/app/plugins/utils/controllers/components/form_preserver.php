<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Form Preserver Component
 *
 * @package utils
 * @subpackage utils.controllers.components
 */

class FormPreserverComponent extends Object
{
    public $components = array( "Session", "Auth" );
    public $actions = array(  );
    public $sessionKey = "PreservedForms";
    public $sessionPath = null;
    public $redirectMessage = null;
    public $loginRedirect = null;
    public $directPost = false;

    public function __construct()
    {
        parent::__construct();
        $this->redirectMessage = __d("utils", "Your form data is preserved you'll be redirected to it after login.");
    }

    public function initialize($Controller)
    {
        $this->Controller = $Controller;
        $this->sessionPath = $this->sessionKey . "." . $Controller->name . "." . $Controller->action;
    }

    public function startUp($Controller)
    {
        if( in_array($Controller->action, $this->actions) ) 
        {
            if( empty($Controller->data) && $Controller->Session->check($this->sessionPath) ) 
            {
                if( $this->directPost == true ) 
                {
                    $Controller->data = $Controller->Session->read($this->sessionPath);
                    $Controller->Session->delete($this->sessionPath);
                    return NULL;
                }

            }
            else
            {
                if( !empty($Controller->data) && !$Controller->Auth->user() ) 
                {
                    $this->preserve($Controller->data);
                    if( empty($this->loginAction) && !empty($Controller->Auth->loginAction) ) 
                    {
                        $this->loginAction = $Controller->Auth->loginAction;
                        if( !empty($this->redirectMessage) ) 
                        {
                            $Controller->Session->setFlash($this->redirectMessage);
                        }

                        if( isset($Controller->Auth) ) 
                        {
                            $url = "";
                            if( isset($Controller->params["url"]["url"]) ) 
                            {
                                $url = $Controller->params["url"]["url"];
                            }

                            $url = Router::normalize($url);
                            if( !empty($Controller->params["url"]) && 2 <= count($Controller->params["url"]) ) 
                            {
                                $query = $Controller->params["url"];
                                unset($query["url"]);
                                unset($query["ext"]);
                                $url .= Router::querystring($query, array(  ));
                            }

                            $this->Session->write("Auth.redirect", $url);
                        }

                        $Controller->redirect($this->loginAction);
                    }

                }

            }

        }

    }

    public function preserve($data = null, $sessionPath = null)
    {
        $this->_overridPath($sessionPath);
        if( isset($data["_Token"]) ) 
        {
            unset($data["_Token"]);
        }

        return $this->Controller->Session->write($this->sessionPath, $data);
    }

    public function restore($sessionPath = null)
    {
        $this->_overridPath($sessionPath);
        if( empty($this->Controller->data) && $this->Controller->Session->check($this->sessionPath) ) 
        {
            if( !empty($this->Controller->data) ) 
            {
                $this->Controller->data = array_merge($this->Controller->Session->read($this->sessionPath), $this->Controller->data);
            }
            else
            {
                $this->Controller->data = $this->Controller->Session->read($this->sessionPath);
            }

            $this->Controller->Session->delete($this->sessionPath);
        }

    }

    protected function _overridPath($sessionPath = null)
    {
        if( !empty($sessionPath) ) 
        {
            $this->sessionPath = $this->sessionKey . "." . $sessionPath;
        }

    }

    public function beforeRender()
    {
        $this->restore();
    }

}




?>