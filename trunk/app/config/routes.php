<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
//Router::connect('/:lang/:controller/:action/*', array('lang' => 'en'), array('lang' => 'fre|en'));
//Router::connect('/:lang/:controller/:action/*', array('lang' => 'fre'), array('lang' => 'fre|en'));

/*Router::connect('/:language/:controller/:action/*',
                       array(''),
                       array('language' => '[a-z]{3}'));*/
 

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
$plugins_files = glob(PLUGINS_DIR . '*', GLOB_ONLYDIR);

foreach ($plugins_files as $file) {
    $routes = $file . DS . 'config' . DS . 'routes.php';

    if (file_exists($routes)) {
        include($routes);
    }
}

Router::connect('/', array('controller' => 'home', 'action' => 'index', 'home'));
Router::connect('/:language', array('controller' => 'home', 'action' => 'index'),array('language'=>'eng|hy'));
