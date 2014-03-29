<script type="text/javascript">   
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
            "text": accoun_setting_email_verified, 
            "type": 'success',
            "model":true
        });
<?php } ?> 

<?php if (isset($unsuccess)) { ?>
        $('#contact_us').load(WEBSITE_URL+'users/users/un_sccess',function(){
            noty(
            {
                "text":r,
                'type':'alert',
                "layout":"topCenter",
                "animateOpen":{
                    "height":"toggle"
                },
                "animateClose":{
                    "height":"toggle"
                },
                "speed":500,
                "timeout":90000,
                "closeButton":true,
                "closeOnSelfClick":false,
                "closeOnSelfOver":false,
                "modal":true,
                "buttons": [
                    {
                        "type": 'btn btn-primary', 
                        "text": 'Ok', 
                        click: function($noty) {
                            $noty.close();
                        }
                    },
    							   
                ]
            });    
        });
<?php } ?> 

</script>
<div class="darkgreybg greybrdtop">
    <div class="blackshade pt24">
        <div class="wrapper">
            <h2><?php __('editing_setting'); ?></h2>
            <div >
                <div class="fl">
                    <ul class="user_tabs">
                        <li class=""><?php echo $html->link(__('profile', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'edit_profile')); ?></li>
                        <li class="selected"><?php echo $html->link(__('account', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'account_setting')); ?></li>
                        <li><?php echo $html->link(__('notification', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile_notification')); ?></li>
                    </ul>
                </div>
                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>
<div class="tab_container">
    <?php if ($this->validationErrors) { ?>
        <div class="error pt10" style="margin-top:10px;margin-left:210px;margin-right:720px;">
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
    <div id="tab2" class="tab_content">
        <div class="pt40 pb30">
            <?php echo $this->Form->create($model, array('plugin' => 'users', 'controller' => 'users', 'action' => 'account_setting')); ?>
            <div class="wrapper">
                <div class="fl" >
                    <div class="line_height30"></div>
                    <div class="clr pt15"></div>
                    <div class="line_height30 pb20">
                        <div class="grey14 fl width160" ><?php __('email'); ?></div>
                        <div class="fl pl10 pr10"><?php echo $this->Form->text('email', array('class' => 'input-text ')); ?></div>
                        <?php if ($this->data['User']['email_authenticated'] == '0') { ?>
                            <br/><div class="fl grey14 pl167"><?php __('unverified'); ?></div>
                            <div class="pl240 blue14"><?php echo $html->link(__('email_verification', true), 'javascript:void(0);', array('onclick' => 'verification_email()')); ?></div>

                        <?php } else { ?>
                            <span>&nbsp;</span>
                        <?php } ?>
                    </div>
                    <div class="clr pt15"></div>

                    <div class="line_height30 pb20">
                        <div class="grey14 fl width160 " ><?php __('password'); ?></div>
                        <div class="fl pl10 pr10"><div class="pl3 blue14"><?php echo $html->link(__('change_password', true), 'javascript:void(0);', array('onclick' => 'show_password()')); ?></div></div>
                        <span>&nbsp;</span>
                    </div>
                    <div class="clr pt15"></div>

                    <div id="change_password" style="display:none;">
                        <div class="line_height30 pb20">
                            <div class="grey14 fl width160 " ><?php __('new_password'); ?></div>
                            <div class="fl pl10 pr10"><?php echo $this->Form->password('password', array('class' => 'input-text','autocomplete'=>'off')); ?></div>
                            <span>&nbsp;</span>
                        </div>
                        <div class="clr pt15"></div>

                        <div class="line_height30 pb20">
                            <div class="grey14 fl width160 " ><?php __('confirm_password'); ?></div>
                            <div class="fl pl10 pr10" ><?php echo $this->Form->password('con_password', array('class' => 'input-text')); ?></div>
                            <span>&nbsp;</span>
                        </div>					
                        <div class="clr pt15"></div>
                    </div>
                </div>
                <div class="fl pl70">
                    <div class="line_height30"></div>
                    <div class="clr pt15"></div>
                    <?php /** ******** second tab ********* */ ?>
                    <div class="line_height30 pb20">
                        <div class="grey14 fl width160 " ><?php __('facebook'); ?></div>
                        <div class="fl pl10 pr10 grey14">
                            <div id="fb_not_loged_in"  <?php if (!empty($this->data['User']['facebook_id'])) { ?> style="display:none;" <?php } ?>> 
								<div class="grey11">
									<a href="#" onclick="facebook_login()" >
										<?=$this->Html->image('front/LogInFB.png') ?>
									</a>
								</div>
                            </div>
                           
                            <div id="fb_loged_in" <?php if (empty($this->data['User']['facebook_id'])) { ?> style="display:none;" <?php } ?>>
                                  
                                <?php __('profile_connect_to'); ?> Facebook 
                            </div>
                        </div>
                        <span>&nbsp;</span>
                    </div>
                    <div class="clr pt15"></div>
                      <div class="line_height30">
                        <div class="grey14 fl width160 " ><?php __('delete_account'); ?></div>
                        <div class="fl pl10 pr10"><div class="pl3 blue14"><?php  echo $html->link(__('delete_account', true), array('plugin'=>'users','controller'=>'users','action'=>'delete_user_account'), array('onclick' => '')); ?></div></div>
                        <span>&nbsp;</span>
                    </div>
                    <div class="clr pt15"></div>
                </div>
                <div class="clr pt15" ></div>
                <div class="pl167 mr745 pb20"> 
                    <?php echo $html->link(__('save_setting', true), 'javascript:void(0);', array('onclick' => 'check_password()', 'class' => 'ie_radius save_link')); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>