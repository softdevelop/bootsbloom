<?php
$config['WEBSITE_NAME'] = 'BoostBloom';
$config['defaultPaginationLimit'] = 10;
$config['pagingViews'] = array( '10', '20', '50' );
$config['default_email'] = array('name'=>'CAKEPHP','email'=>'admin@bloom.dev');
$config['noreply_email'] = array('name'=>'noreply','email'=>'noreply@bloom.dev');

$config['date_format'] = 'd.m.Y - H:i';
$config['allinonelogin'] = false;

$config['FRONT_UPDATES_DATE_FORMAT']    =   "F d, Y";

$config['languages'] = array('eng'=>'English','hy'=>'Armenian');
$config['currency_symbol'] = array('$'=>'$ (Dollar)','€'=>'€ (Euro)');
$config['currencies'] = array('USD'=>'USD','EUR'=>'EUR');

$config['allowed_video_files'] = array('wmv', 'avi', 'mpeg', 'mpg', 'mp4', 'mov', 'flv');
$config['allowed_image_files'] = array('jpg','png','jpeg','gif');

$config['allowed_image_mime_types'] = array('image/jpg','image/png','image/jpeg','image/gif');
$config['allowed_audio_mime_types'] = array('audio/mpeg', 'audio/x-mpeg', 'audio/mp3', 'audio/x-mp3', 'audio/mpeg3', 'audio/x-mpeg3','audio/mpg', 'audio/x-mpg', 'audio/x-mpegaudio','application/octet-stream');


$plugins_files 		= 	glob(PLUGINS_DIR .'*',GLOB_ONLYDIR );

foreach ( $plugins_files as $file ) {
	$global_constants = $file . DS . 'config'. DS . 'global_constants.php';
	
	if(file_exists($global_constants)){
		include($global_constants);
	}
}
