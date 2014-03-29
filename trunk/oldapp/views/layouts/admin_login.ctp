<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo Configure::read("WEBSITE_NAME"); ?></title>
	
<?php 
	echo $this->Html->css(array(
		'admin/adminstyle.css',
		'jquery-ui-css/themes/base/jquery.ui.all.css'
	));
		
	echo $this->Html->script(array(
		'jquery-1.7.2.min.js',
		'jquery-ui-js/ui/jquery-ui-1.8.12.custom.js',
		'admin/jquery-login.js',
		'admin/function.js'
	));
?>

	<script type="text/javascript">
		$(document).ready(function() {
			// closing message
			$('.message').live("click",function(){
				$(this).animate({opacity: 0}, 250, function(){
					$(this).slideUp(250, function(){$(this).remove()})});
				return false;
				}
			);
		
			$("body").css("background-color", "#f7f7f7");
			
			var oh = $(".auth-form").outerHeight(),
				ow = $(".auth-form").outerWidth();
			$(".auth-form").css({top: -oh+"px", left: ($(window).width()-ow)/2 + "px"}).animate({top: ($(window).height() - oh)/2 + "px"}, 1000, "easeOutBack");
		});
	</script>

</head>
<body id="login">

<?php echo $content_for_layout; ?>
<?php echo $this->element('sql_dump'); ?>
</body>
</html>