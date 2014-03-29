<?php echo $javascript->link('front/swfobject.js'); ?>
<script>
    $(document).ready(function(){
        $('#sharedata').hide();
        $("#share").click(function(){
            $('#sharedata').toggle();
        });
		$("#facebook_icon").click(function(){
            $('#sharedata').toggle();
        });
		$("#twitter_icon").click(function(){
            $('#sharedata').toggle();
        });	
    });
</script>
<?php if($this->data['User']['is_deleted']){ ?>
<div class="yellow_unsuccess_bg">
    <div class="wrapper ptb10 white_dark aligncenter">
        <span ><?php __('user_account_deactivated'); ?></span> 
        <div class="clr"></div>
    </div>
</div>
<?php } ?>
<div class="darkgreybg greybrdtop ">
    <div class="blackshade pt24 pb20 height_200">
        <div class="wrapper banner_wrp">
            <?php
            if ($this->params['action'] != "profile" && $this->params['action'] != "user_comments") {
                $class = "profileimg";
                $width = '150';
                $height = '150';
            } else {
                $class = "profileimgNew2";
                $width = '150';
                $height = '150';
            }
            ?>
            <div class="fl imgbrd  <?php echo $class; ?>">
                <?php
                $user_array = $this->data;
                $user_image_url = $this->GeneralFunctions->get_user_profile_image_using_user_array($user_array, $height, $width);
                echo $this->Html->image($user_image_url, array('width' => $width));
                ?>	
            </div> 
            <?php
            if ($this->params['action'] == "profile" || $this->params['action'] == "user_comments") {
                $width = 'width60per mr';
            } else {
                $width = 'width80per';
            }
            ?>
            <div class="fr <?php echo $width; ?> mt 10 " style="">
                <h2>
				<?php if($this->params['action'] == "profile"){  echo $this->data['User']['name']; }else{ echo $this->Html->link($this->data['User']['name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $this->params['slug']),array('class'=>'profile_link')); }?>
                   
                    <?php if($this->params['action'] == "profile"){$width= '600px';}else{$width=''; } ?>
                    <span class="mt70 grey14 user_bio2 word-wrap" style="width: <?php echo $width; ?>"><h4><?php
                            if ($this->params['action'] == "backed_projects") {
                                $backedprojects = count($projects);
                                echo __('backed') . ' ' . $backedprojects
                                ?> <?php echo __('projects'); ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php } ?> <?php echo $this->data['User']['country']; ?> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->data['User']['name']; ?>
                <?php __('joined_boostbloom_on'); ?>
                <?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $this->data['User']['created']); ?></h2> <br/>
                    <?php echo ucfirst($text->truncate($this->data['User']['biography'], 300, array('ending' => '...', 'exact' => false, 'html' => true))); ?>
                   <br /> </span> 
                </h2>
                <!--condition not to show menu on user comment page -->
                            <?php if ($this->params['action'] != "profile" && $this->params['action'] != "user_comments") { // if THis is tabs ?>
                    <div class="mt115">
                        <div class="fl">
                            <ul class="user_tabs">
                                <li <?php
                            if ($this->params['action'] == "activity") {
                                echo 'class="selected"';
                            }
                                ?> ><?php echo $this->Html->link(__('activity', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'activity', 'slug' => $this->params['slug'])); ?>
                                </li>
                                <?php $login = $this->Session->read('Auth.User.slug');
                                //if ($login != '' && $this->data['User']['id'] == $this->Session->read('Auth.User.id')) { ?>
                                    <li <?php
                                if ($this->params['action'] == "created_projects") {
                                    echo 'class="selected"';
                                }
                                    ?> ><?php echo $this->Html->link(__('created_projects', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'created_projects', 'slug' => $this->params['slug'])); ?></li>
                                    <?php //} ?>
                                <li <?php
                                if ($this->params['action'] == "backed_projects") {
                                    echo 'class="selected"';
                                }
                                    ?> ><?php echo $this->Html->link(__('backed_projects', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'backed_projects', 'slug' => $this->params['slug'])); ?></li>
                                <li <?php
                                if ($this->params['action'] == "starred_projects") {
                                    echo 'class="selected"';
                                }
                                ?> ><?php echo $this->Html->link(__('starred_projects', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'starred_projects', 'slug' => $this->params['slug'])); ?>
                                </li>

                            </ul>
                        </div>

                        <div class="clr"></div>
                    </div>
            <?php } // end tabs ?>
            </div> 
            <div class="clr"></div> 

<?php
if (($this->params['action'] == "profile") || ($this->params['action'] == "user_comments")) {
    $login = $this->Session->read('Auth.User.slug');
          if ($login == $this->params['slug']) {    // display share profile link to loggedin user
        ?>
                    <div class="collor_wrp3 pt12" >
                        <div id="facebook_icon" class="fl mt-5 cursor"><?php echo $this->Html->image('front/fb.png'); ?></div>
						<div id="twitter_icon" class="fl mt-2 cursor"><?php echo $this->Html->image('front/twt.png'); ?></div>
                        &nbsp;&nbsp;&nbsp;<span class="greyshare clickable" id="share"><?php echo __('share_your_profile') ?></span>&nbsp;&nbsp;&nbsp; 

                        <span><?php echo $this->Html->link(__('edit_your_profile', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'edit_profile', 'slug' => $this->params['slug']), array('class' => 'greyshare')); ?></span>
                    </div>	
                    <?php } ?>

                <div id="sharedata" class="collor_wrp2" >
                    <?php
                    //echo $user_image_url;die;
                    $title = urlencode($user_array['User']['slug'] . ' On ' . Configure::read('CONFIG_SITE_TITLE'));
                    $url = urlencode(WEBSITE_URL . 'users/profile/' . $user_array['User']['slug']);
                   // $url =  Router::url( $this->here, true ); 
                    $summary = urlencode('');
                    $image = urlencode($user_image_url);
                    ?>
                    <div class="sharebutton">
                        <a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title; ?>&amp;p[summary]=<?php echo $summary; ?>&amp;p[url]=<?php echo $url; ?>&amp;&p[images][0]=<?php echo $image; ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)"> 
						<?php echo $this->Html->image('front/face.png'); ?>
                        </a>				
                    </div>
                    <div class="sharebutton">
						<?php 
						$user_id	=	$this->Session->read('Auth.User.id');
						$created_projects = $this->GeneralFunctions->get_user_launched_projects($user_id);
						//echo $created_projects; ?>
                       <a target="_blank" href="https://twitter.com/intent/tweet?status=<?php echo __('i_have_backed',true).'('.$total_backed_project.')/'.__('launched',true).' ('.$created_projects.')'.__('projects_on',true).Configure::read('CONFIG_SITE_TITLE').'! '; echo WEBSITE_URL.'users/profile/'.$this->params['slug'];?>&amp;!url="><?php echo $this->Html->image('front/twt2.png'); ?></a>
                        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                    </div>
					

                </div>
				

<?php } ?>

        </div>
    </div>

</div>
