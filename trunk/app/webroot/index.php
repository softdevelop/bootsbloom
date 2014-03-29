<?php
/**
 * Index
 *
 * The Front Controller for handling every request
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
 * @subpackage    cake.app.webroot
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Use the DS to separate the directories in other defines
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */
/**
 * The full path to the directory which holds "app", WITHOUT a trailing DS.
 *
 */
if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(dirname(__FILE__))));
}
/**
 * The actual directory name for the "app".
 *
 */
if (!defined('APP_DIR')) {
    define('APP_DIR', basename(dirname(dirname(__FILE__))));
}

/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 */
if (!defined('CAKE_CORE_INCLUDE_PATH')) {
    define('CAKE_CORE_INCLUDE_PATH', ROOT);
}


 
define("MAIN_FOLDER", '');

if (!defined('HOST_URL')) {
    define("HOST_URL", "http://" . $_SERVER['HTTP_HOST']  );
}

if (!defined('WEBSITE_URL')) {
    define("WEBSITE_URL", "http://" . $_SERVER['HTTP_HOST'] . '/' . MAIN_FOLDER);
}

if (!defined('WEBSITE_FRONT_URL')) {
    define("WEBSITE_FRONT_URL", "http://" . $_SERVER['HTTP_HOST'] . '/' . MAIN_FOLDER);
}

if (!defined('WEBSITE_IMG_URL')) {
    define("WEBSITE_IMG_URL", WEBSITE_URL . 'img' . '/');
}

if (!defined('ADMIN_FOLDER')) {
    define("ADMIN_FOLDER", "admin/");
}

if (!defined('WEBSITE_ADMIN_URL')) {
    define("WEBSITE_ADMIN_URL", WEBSITE_URL . ADMIN_FOLDER);
}

if (!defined('WEBROOT_DIR')) {
    define('WEBROOT_DIR', basename(dirname(__FILE__)));
}

if (!defined('WWW_ROOT')) {
    define('WWW_ROOT', dirname(__FILE__) . DS);
}

if (!defined('CORE_PATH')) {
    if (function_exists('ini_set') && ini_set('include_path', CAKE_CORE_INCLUDE_PATH . PATH_SEPARATOR . ROOT . DS . APP_DIR . DS . PATH_SEPARATOR . ini_get('include_path'))) {
        define('APP_PATH', null);
        define('CORE_PATH', null);
    } else {
        define('APP_PATH', ROOT . DS . APP_DIR . DS);
        define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
    }
}

if (!defined('ADMIN_DATE_FORMAT')) 
{
    define('ADMIN_DATE_FORMAT', 'M d,Y');
}

if (!defined('UPLOAD_DIR')) 
{
	define("UPLOAD_DIR", __DIR__ . DS . 'img' . DS . 'stuff' . DS);
}

if (!defined('UPLOAD_DIR_URL')) 
{
	define("UPLOAD_DIR_URL", WEBSITE_IMG_URL . 'stuff/');
}

if (!defined('DB_BACKUP_PATH')) 
{
    define('DB_BACKUP_PATH', ROOT . DS . APP_DIR . DS . 'cache' . DS . 'backup');
}



if (!include(ROOT . DS . APP_DIR . DS . 'config' . DS . 'config.php')) {
    trigger_error("CakePHP config could not be found.", E_USER_ERROR);
}

if (php_sapi_name() == 'cli-server') {
    $_SERVER['PHP_SELF'] = '/' . basename(__FILE__);
}
if (!include(CORE_PATH . 'cake' . DS . 'bootstrap.php')) {
    trigger_error("CakePHP core could not be found.  Check the value of CAKE_CORE_INCLUDE_PATH in APP/webroot/index.php.  It should point to the directory containing your " . DS . "cake core directory and your " . DS . "vendors root directory.", E_USER_ERROR);
}
if (isset($_GET['url']) && $_GET['url'] === 'favicon.ico') {
    return;
} else {
    $Dispatcher = new Dispatcher();
    $Dispatcher->dispatch();
}   
