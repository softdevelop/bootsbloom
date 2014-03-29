<?php

class FacebookHelper extends AppHelper {

	function __construct($options = null) 
	{
        parent::__construct($options);
		Configure::load('facebook');
    }

	function init() 
	{
	
?>
<div id="fb-root"></div>
<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '<?=Configure::read('Facebook.appId') ?>',
			status     : true, // check login status
			cookie     : true, // enable cookies to allow the server to access the session
			xfbml      : true  // parse XFBML
		});
	};
	
	(function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
	
	function facebook_login() {
        FB.login(
			function(response) {
				if (response.authResponse) {
					window.location.href = "/users/fblogin";
				}
			},
			{
				scope: 'email,publish_stream,offline_access'
			}
		);
    }
</script>

<?
    }
	
    function renderLike($url) 
	{
		echo '<iframe src="//www.facebook.com/plugins/like.php?href='. urlencode($url) 
		. '&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&colorscheme=dark&amp;height=40&amp;appId=' . Configure::read('Facebook.appId')
		. '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:40px;" allowTransparency="true"></iframe>';
    }

}