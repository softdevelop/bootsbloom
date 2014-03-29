<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo Configure::read("CONFIG_SITE_TITLE"); ?>:<?php echo $title_for_layout; ?> </title>

<?php
	echo $this->Html->meta($this->webroot . 'favicon.ico', $this->webroot . 'favicon.ico', array('type' => 'icon'));
	
	echo $this->Html->css(array(
		'jquery-ui-css/themes/base/jquery.ui.all.css',
		'admin/adminstyle.css', 
		'admin/form.css',
		'admin/ui.selectmenu.css',
		'admin/tabs.css'
	));
				
	echo $this->Html->script(array(
		'jquery-1.7.2.min.js',
		'jquery.numeric.js',
		'jquery-ui-js/ui/jquery-ui-1.8.12.custom.js',
		'jquery-ui-js/jquery-ui-timepicker-addon.js',
		'admin/jqueryyext.js',
		'admin/function.js',
		'ui.selectmenu.js',
		'vtip.js',
		'jss.js',
		'eng.js',
		'tinymce/tinymce.min.js'
	));
?>

	<script type="text/javascript" language="javascript">
		var WEBSITE_ADMIN_URL   =   '<?php echo WEBSITE_ADMIN_URL; ?>';
		var WEBSITE_URL =   '<?php echo WEBSITE_URL; ?>';
		var WEBSITE_IMG_URL =   '<?php echo WEBSITE_IMG_URL; ?>';
		var HOST_URL    =   '<?php echo HOST_URL; ?>';
		var WEBSITE_URL =   '<?php echo WEBSITE_URL; ?>';
	</script>
		
</head>
<body>
	<div class="main">
		<?php echo $this->element("admin/header"); ?>
		<div class="clear"></div>
	</div>

<?php
	echo $this->element("admin/top_nav_" . $this->Session->read("Auth.admin.group_id"));
?>

	<div class="main equal">
		<div id="leftpanel" style="height: auto;">
			<?php echo $content_for_layout; ?>
		</div>
		<?php echo $this->element("admin/right_panel"); ?>
	</div>
	<div class="clear"></div>
	
<?php echo $this->element("admin/footer"); ?>
<?php echo $this->element('sql_dump'); ?>
</body>
</html>