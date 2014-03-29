<div style = "width:616px;">

	<div class="fl">
<?php
	$share_url = Router::url(array('plugin' => false, 'controller' => 'projects', 'action' => 'detail',$project_detail['User']['slug'],$project_detail['Project']['slug']), true);
	$this->Facebook->renderLike($share_url);
?>		
	</div>
	
	<div class="fl" style = "margin-left:10px;">		
		<div class="g-plusone" data-size="medium"></div>
		<script type="text/javascript">
		  (function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
	</div>
	
	<div class="fl" style = "margin-left:-23px;">
		<a name="fb_share" type="button_count" href="http://www.facebook.com/sharer.php">Share</a>
		<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
	</div>
	
	<div class="fl">
		<?php echo $this->Html->link('Tweet', 'https://twitter.com/share', array('class' => 'twitter-share-button','data-via'=>Configure::read('CONFIG_SITE_TITLE'))); ?>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> 
   </div>
   
</div>
<div class="clr"></div>