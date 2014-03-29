<?php 
	echo $this->Html->script(array(
		'front/ajaxupload.3.5', 
		'front/jquery.tokeninput.js',
		'front/jquery.zclip.js')
	);
	
	echo $this->Html->css(array('front/token-input.css')); 
?>

<script type="text/javascript">
	var count	=	<?php echo count($this->data['User']['website']); ?>;
<?php if (isset($success)) { ?>
        noty({
            "animateOpen":{
                "height":"toggle"
            },
            "animateClose":{
                "height":"toggle"
            },
            "force": true, 
            "closeButton":true,
            "layout" : "top", 
            "text": function_your_change_has_saved, 
            "type": 'success',
            "model":true
        });
<?php } ?>  
    $(document).ready(function() {
        jss('.character_counter', {
            position: 'relative',
            right: '0'
          
        });
        
        jss('textarea', {
            width: '340px',
            height: '110px'
        });
       $("#UserBiography").charCount({
            allowed:300,		
            warning: '',
            counterText: ''	
        });
        
		$("#UserCity").tokenInput(WEBSITE_URL+"projects/get_city",{
			animateDropdown: false,
			searchingText:false,
			tokenLimit: 1,
			searchText:'searching..',
			minChars: 1,
			hintText:false,
		<?php if (!empty($this->data['User']['city_json'])) { ?>
					prePopulate: [<?php echo $this->data['User']['city_json']; ?>]
		<?php } ?>
		});   
		$('a#copy-description').zclip({
			path:WEBSITE_URL+'js/front/ZeroClipboard.swf',
			copy:$('div#copy_vanity').text()
		});   
    });
</script>

<div class="darkgreybg greybrdtop">
    <div class="blackshade pt24">
        <div class="wrapper">
            <h2><?php __('edit_setting'); ?></h2>
            <div >
                <div class="fl">
                    <ul class="user_tabs">
                        <li class="selected"><?php echo $html->link(__('profile', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'edit_profile')); ?></li>
                        <li><?php echo $html->link(__('account', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'account_setting')); ?></li>
                        <li><?php echo $html->link(__('notification', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile_notification')); ?></li>
                    </ul>
                </div>
                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>
<div class="tab_container">																	
    <div id="tab1" class="tab_content">
        <div class="ptb21">
            <div class="wrapper">
                <div class="profileleft">
                    <?php echo $this->Form->create($model, array('url' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'edit_profile'))); ?>
                    <div class="profilewrapper">
                        <div class="line_height30" >
                            <div>
                                <?php if ($this->validationErrors) { ?>
                                    <div class="error pt10">
                                        <?php
                                        echo "<ul>";
                                        foreach ($this->validationErrors['User'] as $error) {
                                            ?>
                                            <li><?php echo $error; ?></li>
                                            <?php
                                        }
                                        echo "</ul>";
                                        ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clr pt15"></div>
                        <div class="line_height30">
                            <div class="grey14 fl width120 "><?php __('full_name'); ?><span class="mandatory_field">*</span></div>
                            <div><?php echo $this->Form->text('User.name', array('class' => 'input-text ')); ?></div>
                            <div class="grey14 fl width120 ">&nbsp;</div>
                            <span class="pl120">&nbsp;</span>
                        </div>
                        <div class="clr pt15"></div>
                        <div class="line_height25">
                            <div class="grey14 fl width120 "><?php __('user_location'); ?></div>
                            <div class="fr pr161">
                                <?php echo $this->Form->input('User.city', array('class' => 'input-text', 'label' => false, 'div' => false)); ?>
                            </div>
                            <div class="grey14 fl width120 ">&nbsp;</div>
                            <span class="pl120">&nbsp;</span>
                        </div>
                        <div class="clr pt15"></div>
                        <div class="line_height30">
                            <div class="grey14 fl width120 "><?php __('time_zone'); ?></div>
                            <div><?php echo $timezone->select('User.timezone', false); ?></div>
                            <span>&nbsp;</span>
                        </div>
                        <div class="clr pt15"></div>

                        <div class="line_height30">
                            <div class="grey14 fl width120 "><?php __('biography'); ?></div>
                            <div><?php echo $this->Form->textarea('User.biography', array('class' => 'input-text ', 'maxlength' => '300')); ?></div>
                            <span class="pl120"><?php __('character_300_limit'); ?></span>
                        </div>
                        <div class="clr pt15"></div>
                        <div class="clr">
                            <div class="grey14 fl width120 "><?php __('vanity_url'); ?></div>
							<div id="copy_vanity"><?php echo WEBSITE_URL . 'users/profile/' . $this->Session->read('Auth.User.slug'); ?></div>
						 </div>
						<div class="clr pt15"></div>
						 <div class="line_height30 clr">
                            <div class="fl width120 ">&nbsp;</div>
							<div class="pb10 addmore_but"><a class="pl10" href="javascript:void(0);" id="copy-description" style="float:left;"><?php echo __('copylink'); ?></a></div>
							<div class="clr pt15"></div>
						 </div>
                        <div class="clr pt15"></div>
                        <div class="border_none">
                            <div class="grey14 fl width120 pt6"><?php __('websites'); ?></div>
                            <div id="addwebsite" >
                                <div class="fl pb10">
                                    <?php echo $this->Form->text('User.website', array('class' => 'input-text', 'id' => 'website')); ?>
                                    <div class="pt10">(<?php __('profile_enter_url'); ?>)</div>
                                </div>
                                <div class="fr addmore_but ">
                                    <?php echo $html->link(__('add', true), 'javascript:void(0);', array('onclick' => 'addMore()', 'class' => 'ie_radius')); ?>
                                </div>
                            </div>
                            <?php
                            $c = 0;
                            foreach ($this->data['User']['website'] as $value) { ?>
                                <div id="web_<?php echo $c; ?>"  class=" fl pr112 pt10 grey13 " >&nbsp;
                                    <div  class="addmore fl ptb5 pl5 mr120">
                                        <input type="hidden" name="data[User][website][]"  id="web_<?php echo $c; ?>" value='<?php echo $value; ?>' />
                                        <?php echo $value; ?> 
                                        <a href="javascript:void(0)" onClick="remove_webssite('<?php echo $c; ?>')" class="remove_lnk fr pr10 "> X</a>
                                    </div>
                                </div>
                                <?php $c++; } ?>
                            <div id="counterweb" >&nbsp;</div>
                        </div>
                        <div class="clr pt15"></div>
                        <div class="pl120  pb20">  <?php echo $this->Form->submit(__('save_setting', true), array('class' => 'button ie_radius')); ?>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
                <div class="profileright">
                    <!--left bar here-->
                    <div class="line_height30 width560"></div>
                    <div class="clr pt15"></div>
                    <?php echo $this->Form->create($model, array('url' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'add_image'), 'id' => 'image_upload')); ?>
                    <div class="line_height19">
                        <div class="grey14 width58 fl " valign="top"><?php __('picture'); ?></div>
                        <div class="fl" id="new_image" >
                            <?php
                            /*                             * ***** profile image ******** */
                            $user_array['User'] = $this->data['User'];
                            ?>
                            <?php $user_image_url = $this->GeneralFunctions->get_user_profile_image_using_user_array($user_array, '125px', '125px');
                            echo $this->Html->image($user_image_url, array('width' => '125', 'height' => '125')); ?>

                            <?php /*   * **************remove image button***************** */ ?>
                            <div class="pl3 blue14"><?php echo $html->link(__('remove', true), 'javascript:void(0);', array('onclick' => 'remove_image()')); ?></div>
                            <?php /* * **************image name display here***************** */ ?>
                            <div id="image_display" class="width125" style="display:none;"></div>

                        <?php /* * **************upload image button***************** */ ?>
                        </div>
                        <div class="fl pl5" valign="top"><?php echo $html->link(__('upload', true), 'javascript:void(0);', array('class' => 'image_upload ie_radius')); ?></div><br/>
                        <?php /* * **************image uploding text display here ***************** */ ?>
                        <div id="status"></div>
                        <div class="clr"></div>		
                        <?php /* * **************image name hide button***************** */ ?>
                        <div id="image_hide" class="blue14 pl63" style="display:none;"><?php echo $html->link(__('hide', true), 'javascript:void(0);', array('onclick' => 'hide_name()')); ?></div>
						 <div class="clr"></div>	
						<div class="grey14"><?php __('image_ratio'); ?></div>
                    </div>
					
<?php echo $this->Form->end(); ?>
                    <div class="clr pt15"></div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </div>

</div>
