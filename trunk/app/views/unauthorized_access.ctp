<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Unauthorized Access</title>

<?php echo $html->css('front/error_pages.css'); ?>

</head>
<body>
    <?php echo $this->element("googleanalytics"); ?>
	<div class="content">
		<div class="blackbg">  
			<?php echo $this->Html->link($this->Html->image('front/logo.png'), WEBSITE_URL, array('escape' => false)); ?>
		</div>
		<div class="grey-frame">
			<div class="grey-frame-inner">
				<h1>Unauthorized Access</h1>
				<h2>OH MY GOODNESS</h2>
				<p>We apologize but something's gone wrong — an old link, a bad link, or some little glitch.</p>
				<p>Thankfully everyone is still safe.</p>
				<p>Would you like to: <a href="javascript:history.go(-1)">Go Back</a> or <?php echo $this->Html->link('Go to Home Page', WEBSITE_URL, array('escape' => false)); ?>?</p>
			</div>
		</div>
	</div>
</body>
</html>