<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo isset($title_for_layout) ? $title_for_layout : Configure::read('CONFIG_SITE_TITLE'); ?></title>

<?php
    if (!isset($keywords_for_layout)) {
        $keywords_for_layout = Configure::read('CONFIG_META_KEYWORDS');
    }
    if (!isset($description_for_layout)) {
        $description_for_layout = Configure::read('CONFIG_META_DESCRIPTION');
    }

    echo $this->Html->meta('keywords', $keywords_for_layout);
    echo $this->Html->meta('description', $description_for_layout);	
	echo $this->Html->meta($this->webroot . 'favicon.ico', $this->webroot . 'favicon.ico', array('type' => 'icon'));
	
	$lang = $this->Session->read('Config.language');
	if (empty($lang)) {
		$lang = 'eng';
	}

	switch ($lang)
	{
		case 'hy': 
			echo $this->Html->script(array('hy.js')); 
			break;
		case 'eng':
		default:
			echo $this->Html->script(array('eng.js'));
	}

	echo $this->Html->script(array(
			'jquery-1.7.2.min.js',
			'jquery.livequery.js',
			'jquery-ui-js/ui/jquery-ui-1.8.12.custom.js',
			'jquery-ui-js/jquery-ui-timepicker-addon.js',
			'front/functions.js',
			'front/jquery.nav.js',
			'front/jquery.scrollTo.js',
			'front/jquery.tokeninput.js',
			'front/jquery.multiFieldExtender-2.0.js',
			'front/jquery.simplemodal.js',
			'front/charCount.js',
			'front/swfobject.js',
			'front/jquery.uploadify.v2.1.4.js',
			'slider.js',
			'jss.js',
			'scroll/init.js',
			'scroll/jquery_002.js',
			'needim-noty/jquery.noty.js',
			'tinymce/tinymce.min.js'
		));

	echo $this->Html->css(array(
			'needim-noty/jquery.noty.css',
			'needim-noty/noty_theme_mitgux.css',
			'needim-noty/noty_theme_default.css',
			'needim-noty/buttons.css',
			'jquery-ui-css/themes/base/jquery.ui.all.css',
			'front/basic.css',
			'front/boostbloom.css', 
			'front/tabs.css',
			'front/token-input.css',
			'front/uploadify.css',
			'scroll/base.css', 
			'scroll/style.css',
		));	
?> 

    <script type="text/javascript">
        var WEBSITE_URL =   '<?php echo WEBSITE_URL; ?>';
        var WEBSITE_IMG_URL =   '<?php echo WEBSITE_IMG_URL; ?>';
        var HOST_URL    =   '<?php echo HOST_URL; ?>';
<?php if (isset($project_id) && !empty($project_id)) { ?>
        var project_id   =   '<?php echo $project_id ?>';
<?php } ?>
<?php if (isset($user_slug) && !empty($user_slug)) { ?>
        var user_slug   =   '<?php echo $user_slug; ?>';
<?php } ?>
    </script>
	
    <!--[if IE]>
        <style type="text/css">
			.ie_radius{behavior: url('<?php echo WEBSITE_URL; ?>/border-radius.htc');}
        </style>
	<![endif]-->

</head>
<body>
<?php 
	$this->Facebook->init();
    echo $this->element("googleanalytics");
    echo $this->element("project_header"); 

	echo $content_for_layout; 
?>
  
    <div style="display: none" id="saving-layer" class="modal_dialog spinning">
        <div class="modal_dialog_ie6_background"></div>
        <div class="modal_dialog_outer">
            <div class="modal_dialog_sizer">
                <div class="modal_dialog_inner">
                    <div class="modal_dialog_content"></div>
                </div>
                <span class="modal_dialog_ie_hack"></span>
            </div>
        </div>
    </div> 
<?php echo $this->element('sql_dump'); ?>
</body>
</html>