<!DOCTYPE html>
<html>
<head>
<?php
	if (!isset($title_for_layout))
	{
		$title_for_layout = Configure::read('CONFIG_SITE_TITLE');
	}
?>
    <title><?php echo $title_for_layout; ?></title>
	
    <meta property="og:title" content="<?php echo $title_for_layout; ?>"/> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="medium" content="medium_type" />
    <?php if (!isset($og_image)) { ?>
        <meta property="og:image" content="<?php echo WEBSITE_IMG_URL; ?>front/Logo colored.jpg" />
    <?php } else { ?>
        <meta property="og:image" content="<?php echo $og_image; ?>" />         
    <?php } ?>
        <meta property="og:site_name" content="<?php echo Configure::read('CONFIG_SITE_TITLE'); ?>"/>
        <meta property="fb:app_id" content="<?php echo Configure::read('Facebook.appId'); ?>"/>
    <?php
    if (!isset($keywords_for_layout)) {
        $keywords_for_layout = Configure::read('CONFIG_META_KEYWORDS');        
    }
    if (!isset($description_for_layout)) {
        $description_for_layout = Configure::read('CONFIG_META_DESCRIPTION');
       
    }
    $keywords_for_l=$keywords_for_layout;
    $description_for_l=$description_for_layout;
    echo $this->Html->meta('keywords', $keywords_for_layout);
    echo $this->Html->meta('description', $description_for_layout);
   
    if($this->params['controller']=='projects' && $this->params['action']=='detail' ){
    ?>
    <meta property="og:type" content="boostbloom:project"/>
    <?php } ?>
    <meta property="og:description" content="<?php echo  $description_for_l; ?>"/>
    <script type="text/javascript">        
        var WEBSITE_URL =   '<?php echo WEBSITE_URL; ?>';
        var WEBSITE_IMG_URL =   '<?php echo WEBSITE_IMG_URL; ?>';
        var HOST_URL    =   '<?php echo HOST_URL; ?>';
    </script>

<?php
	echo $this->Html->meta(
            $this->webroot.'favicon.ico', $this->webroot.'favicon.ico', array('type' => 'icon')
    );

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
        'jquery-ui-js/ui/jquery-ui-1.8.12.custom.js',
        'jquery.blockUI.js',
        'front/jquery.nav.js',
        'front/jquery.scrollTo.js',
        'front/jquery.tokeninput.js',
        'front/jquery.montage.min.js',
        'front/charCount.js',
        'front/jquery.simplemodal.js',
		'front/functions.js',
        'slider.js',
        'jss.js',
		'needim-noty/jquery.noty.js',
    ));

    echo $this->Html->css(array(
		'front/boostbloom.css',
		'front/tabs.css',
		'front/basic.css',
		'front/token-input.css',
		'needim-noty/jquery.noty.css',
		'needim-noty/noty_theme_mitgux.css',
		'needim-noty/noty_theme_default.css',
		'needim-noty/buttons.css',
	));
?>
	<!--[if IE 9]>
		<?php echo $this->Html->css(array('ie9.css')); ?>
	<![endif]-->
	
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
    echo $this->element("header"); 

    $pages = $this->GeneralFunctions->get_page_content_by_id(array('21'),array('Page.id','Page.slug','Page.slug_hy')); 
?>
	<div class="what">
       
        <?php echo $this->Html->link($this->Html->image('front/what'.$lang_var.'.png'), array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'display',$pages[0]['Page']['slug'.$lang_var]), array('escape' => false)); ?>
    </div>

<?php 
	echo $content_for_layout;   
    echo $this->element("footer"); 
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