<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title><?php echo $project_content['Project']['title']; ?></title>
	
<?php echo $html->css('front/error_pages.css'); ?>
</head>

<body>
	<div class="content">
		<div class="blackbg">  <?php echo $this->Html->link($this->Html->image('front/logo.png'), WEBSITE_URL, array('escape' => false)); ?></div>
		<div class="grey-frame">
			<div class="grey-frame-inner">
				<h1><?php echo $project_content['Project']['title']; ?></h1>
				<h2>Dear Backers,</h2>
				<p><?php echo vsprintf(__('project_cancelled',true),array($project_content['Project']['title'],  Configure::read('CONFIG_SITE_TITLE'))) ;?> </p>
			   
				<p><?php __('would_you_like');?> <a href="javascript:history.go(-1)"><?php __('go_back');?></a> or <?php echo $this->Html->link(__('go_to_home_page',true), WEBSITE_URL, array('escape' => false)); ?>?</p>
			</div>
		</div>
	</div>
</body>
</html>