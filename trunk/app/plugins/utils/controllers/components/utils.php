<?php 
//
// This source code was recovered by Recover-PHP.com
//


/**
 * Utils Plugin
 *
 * Utils Util Component
 *
 * @package utils
 * @subpackage utils.controllers.components
 */

class UtilsComponent extends Object
{
    public $controller = NULL;

    public function startup($controller)
    {
        $this->controller =& $controller;
    }

    public function cleanHtml($text, $settings = "full")
    {
        App::import("Helper", "Utils.Cleaner");
        $cleaner =& new CleanerHelper();
        return $cleaner->clean($text, $settings);
    }

}
