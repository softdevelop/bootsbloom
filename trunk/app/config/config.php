<?php
/**
 * Index
 *
 * The Front Controller for handling every request
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org
 * @package       cake
 * @subpackage    cake.app.webroot
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Use the DS to separate the directories in other defines
 */
 
 	define('WWW_FRONT_ROOT', '');
	define('MEMORY_TO_ALLOCATE',	'100M');
	define('DEFAULT_QUALITY',		90);
	define('CURRENT_DIR',			dirname(__FILE__));
	define('CACHE_DIR_NAME',		'/imagecache/');
	define('CACHE_DIR',				WWW_FRONT_ROOT .'imagecache' . DS);
	//define('DOCUMENT_ROOT',			$_SERVER['DOCUMENT_ROOT']);
	define('DOCUMENT_ROOT',			dirname(__FILE__));
	define('TMP_IMAGE_DIR',				WWW_FRONT_ROOT .'imagecache' . DS);
	define('PLUGINS_DIR',				ROOT .DS.'app' .DS . 'plugins' .DS );
        define('WEBROOT_JS_PATH',WEBSITE_URL."js");
	//echo ROOT.DS .'app' .DS . 'plugins' .DS;exit;
	$plugins_files 		= 	glob(PLUGINS_DIR .'*',GLOB_ONLYDIR );
	
	foreach ( $plugins_files as $file ) {
		$config_file = $file . DS . 'config'. DS . 'config.php';
		
		if(file_exists($config_file)){
			include($config_file);
		}
	}
       
       
       
	
	
	//$banner_files 		= 	glob(ROOT .'app' .DS . 'plugins' .  "*.{jpg,swf}", GLOB_BRACE);
	
	/*define('FRAME_IMAGE_DIR',				WWW_FRONT_ROOT .'uploads' . DS .'frames'.DS);
	define('FRAME_IMAGE_HTTP',				WEBSITE_URL .'uploads/frames/');
	define('CAR_IMAGE_DIR',				WWW_FRONT_ROOT .'uploads' . DS .'images'.DS);*/
