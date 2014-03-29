<script type="text/javascript">
    $(document).ready(function() {
        $.project_about_you();
        
            jss('#abtu_tab ul.token-input-list li', {
                margin: '0',
                padding:'0px 5px'
            });
            
            jss('.token-input-dropdown', {
               width:'208px'
            });
            
            jss('#token-input-UserCity', {
               width:'208px'
            });
        
        $("#UserCity").tokenInput(WEBSITE_URL+"projects/get_city",{
            animateDropdown: false,
            searchingText:false,
            tokenLimit: 1,
            hintText:false,
    <?php if (!empty($this->data['User']['city_json'])) { ?>
                    prePopulate: [<?php echo $this->data['User']['city_json']; ?>
                    ]
    <?php } ?>
            });   
        
        $("#ProfileImage").uploadify({
            'uploader': WEBSITE_IMG_URL+'front/uploadify.swf',
            'cancelImg': false,
            'script': WEBSITE_URL+'users/update_profile_image/'+'<?php echo $this->Session->read('Auth.User.id'); ?>',
            'buttonText': 'Select Files',
            'checkScript': false,
            'folder':'projects',
            'displayData': 'percentage',
            'auto' : true,
            'simUploadLimit': 1,
            'sizeLimit': (1024*1024*10),
            'onError': function(a, b, c, d, e){
				if(d.type=='File Size'){
					noty({
						"text":uploading_image_only_size,
						"theme":"noty_theme_default",
						"layout":"top",
						"type":"error",
						"animateOpen":{
							"height":"toggle"
						},
						"animateClose":{
							"height":"toggle"
						},
						"speed":500,
						"timeout":5000,
						"closeButton":true,
						"closeOnSelfClick":false,
						"closeOnSelfOver":false,
						"modal":true
					});    	
				} 
            },
            'onComplete': function(a, b, c, d, e){
                d = $.trim(d);
                if(d=='error'){
					noty({
						"text":uploading_image_only_jpg_png_gif,
						"theme":"noty_theme_default",
						"layout":"top",
						"type":"error",
						"animateOpen":{
							"height":"toggle"
						},
						"animateClose":{
							"height":"toggle"
						},
						"speed":500,
						"timeout":5000,
						"closeButton":true,
						"closeOnSelfClick":false,
						"closeOnSelfOver":false,
						"modal":true
					});   
					return false; 	
				} 
                $('#user_profile_uploaded_image').html('<img src="'+WEBSITE_IMG_URL+'image.php?image='+d+'&height=80px&width=80px" />');
            },
            'onAllComplete': function(event,data){
                //something here
            }
        });	
    });
   
</script>
<style type="text/css">
    #abtu_tab li.token-input-token p {
        padding:5px 0 6px;
    }
</style>
<div class="greybg_light">
    <div class="wrapper ptb15 aligncenter grey15_dark"> <span class="blue40 block"><?php __('project_edit_aboutu_little_bit');?></span><?php __('project_edit_aboutu_tell_ppl_who_ur');?></div>
</div>

<div class="wrapper grey14">
    <!-- Left Div -->
    <div class="fl pb80 greybrdrgt pt21 width68per pr50">
        <div id="about_you_errors" >
            <?php
            if (isset($user_error)) {
               
                if (!empty($user_error)) {
                    ?>
                    <div class="error pt10">
                        <?php
                        echo "<ul>";
                        foreach ($user_error as $error) {
                            ?>
                            <li><?php echo $error; ?></li>
                            <?php
                        }
                        echo "</ul>";
                        ?>
                    </div>
                <?php }
            } ?>
        </div>



        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7"><?php __('project_edit_user_image'); ?></div>
                <div class="fl width1490 grey12">
                    <div id="user_profile_uploaded_image" class="fl pr10">
						<?php  $user_array['User'] =   $this->data['User']; ?>
					<?php $user_image_url = $this->GeneralFunctions->get_user_profile_image_using_user_array($user_array,'80px','80px');
						echo $this->Html->image($user_image_url, array('width' => '80', 'height' => '80')); ?>
			
                    </div>
                    <div id="ProfileImage" class="fr pl10"><?php __('project_edit_problem_with_javascript'); ?></div>
                     <div class="clr"></div>
					<div class="mt5"><?php __('project_edit_project_image_description');?></div>
                </div>
                <div class="clr"></div>
            </div>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>
        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7"><?php __('project_edit_aboutu_faebook_connect'); ?></div>
                <div class="fl width1490 grey12">
                    <div id="fb_not_loged_in"  <?php if (!empty($this->data['User']['facebook_id'])) { ?> style="display:none;" <?php } ?>> 

                       <?php __('project_edit_aboutu_faebook_connect_title'); ?>
                        <div class="clr"></div>
						<div class="grey11">
							<a href="#" onclick="facebook_login()" >
								<?=$this->Html->image('front/LogInFB.png') ?>
							</a>
						</div>
                    </div>

                    <div id="fb_loged_in" class="mt5" <?php if (empty($this->data['User']['facebook_id'])) { ?> style="display:none;" <?php } ?>>

                        <?php __('project_edit_aboutu_connect_to_facebook');?> 
                    </div>



                </div>
                <div class="clr"></div>
            </div>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>
        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7"><?php __('biography'); ?></div>
                <div class="fl width1490 grey12">
<?php echo $this->Form->textarea('User.biography', array('class' => 'textarea600','maxlength' => '300', 'rows' => 5, 'cols' => 50)); ?>
				 <span class="character_counter_container"><span class="character_counter"></span>/300</span>
                </div>
                <div class="clr"></div>
            </div>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>
        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7"><?php __('project_edit_aboutu_location'); ?></div>
                <div class="fl width1490 grey12">
                    <span id="abtu_tab"><?php echo $this->Form->input('User.city', array('class' => 'input-text', 'label' => false, 'div' => false)); ?></span>
					<div class="clr"></div>
					<div class="pt5"><?php __('users_location_msg') ?></div>
                </div>
				
                <div class="clr"></div>
            </div>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>

        <div class="greybox mb12">
            <div class="p10">
                <div class="fl width160 pt7"><?php __('websites'); ?></div>
                <div class="fl width1490 grey12">

                    <div id="addwebsite" >
                        <div class="fl">
<?php echo $this->Form->text('website', array('class' => 'input-text', 'id' => 'website')); ?> (<?php __('profile_enter_url');?>)
                        </div>

                        <div class="fr addmore_but">
<?php echo $html->link(__('add', true), 'javascript:void(0);', array('onclick' => 'addMoreWebsite()', 'class' => 'ie_radius')); ?>
                        </div>
                        <div class="clr"></div>
                        <div class="fl mt5">
							<?php __('profile_enter_url_sub');?>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
                <div class="clr"></div>
                <div class="pr20">
                    <?php   $c = 0;
                    foreach ($this->data['User']['website'] as $value) {
                        ?>
                        <div id="web_<?php echo $c; ?>"  class="pt10 grey13 " >&nbsp;
                            <div  class="addmore fl ptb5 ml160 pl5">
                                <input type="hidden" name="data[User][website][]"  id="web_<?php echo $c; ?>" value='<?php echo $value; ?>' />
    <?php echo $value; ?> 
                                <a href="javascript:void(0)" onClick="remove_webssite('<?php echo $c; ?>')" class="remove_lnk fr pr10 "> X</a>

                            </div>
                        </div>
                        <?php $c++; } ?>
                    <div id="counterweb" >&nbsp;</div>
                </div>
            </div>
            <div class="greyboxtl"></div>
            <div class="greyboxtr"></div>
            <div class="greyboxbl"></div>
            <div class="greyboxbr"></div>
        </div>

    </div>
    <!-- Left Div -->
    <!-- Right Div --> 

    <div class="fr width23per pt21 pb80">
            <?php echo $right_panel_contents[3]['Page']['description'.$lang_var]; ?>
        <div class="clr"></div>
    </div>

    <!-- End Right Div -->
