<script type="text/javascript">
<?php if (isset($password_session)) { ?>
        var msg_text = '<?php echo $msg_text; ?>';
        var password_session = '<?php echo $password_session; ?>';
        var msg_type1 = $.trim(password_session);
        if(msg_type1 =='error'){
            var msg_type = 'error';
        }else{
            var msg_type = 'success';
        }
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
            "text": msg_text, 
            "type": msg_type,
            "model":true
        });
<?php } ?>
</script>
<div class="ptb21">
    <div class="wrapper">
        <!-- Signin Start -->	
        <div class="signin">
            <?php echo $this->Form->create($model, array('action' => 'login')); ?>
            <div class="heading_23"><?php __('sign_in'); ?></div>
            <div class="clr pt10"></div>
            <div class="grey13"><?php __('sign_in_to_continue') ?></div>
            <div class="clr pt20"></div>
            <?php if ($this->Session->check('Message.flash')) { ?>
                <div class="error pt10">
                    <?php
                    echo "<ul>";
                    ?>
                    <li><?php echo $this->Session->flash(); ?></li>
                    <?php
                    echo "</ul>";
                    ?>
                </div>
            <?php } ?>
            <div>
                <div class="grey14"><?php __('email'); ?><span class="mandatory_field">*</span></div>
                <div class="clr pt7"></div>
                <div>
                    <?php echo $this->Form->input('login_email', array('class' => 'input-text', 'id' => 'login_email', 'tabindex' => 1, 'label' => false, 'error' => FALSE)); ?>
                </div>
            </div>
            <div class="clr pt20"></div>
            <div>
                <div>
                    <div class="grey14 fl"><?php __('password'); ?><span class="mandatory_field">*</span></div>

                </div>
                <div class="clr pt7"></div>
                <div><?php echo $this->Form->password('login_password', array('class' => 'input-text password', 'id' => 'login_password', 'tabindex' => 2, 'label' => false, 'error' => FALSE)); ?></div>

                <div class="blue11 fr pt2"><?php echo $this->Html->link(__('i_forgot_password', true), 'javascript:void(0)', array('onclick' => 'forgot_password()')); ?></div>
            </div>
            <div class="clr pt15"></div>
            <div><div class="fl"><?php echo $this->Form->checkbox('remember_me', array('label' => false, 'value' => 1, 'div' => false)); ?></div>
                <div class="fl grey13 pl10"><?php __('remember_me'); ?></div>
            </div>
            <div class="clr pt15"></div>
            <div><?php echo $this->Form->submit(__('sign_me_in', true), array('class' => 'button ie_radius')); ?>
                <div class="clr"></div>
            </div>
            <?php echo $this->Form->end(); ?>
            <div class="pt5 grey14"><span class="mandatory_field">*</span> <?php echo __('sign_up_red_mark_mean'); ?></div>
        </div>

        <!-- Sign Up Start --> 
        <div class="signup">
            <?php echo $this->Form->create($model, array('action' => 'signup')); ?>
            <div class="heading_23"><?php __('new_to_boostbloom') ?></div>
            <div class="clr pt10"> </div>
            <?php if ($this->validationErrors) { ?>
                <div class="error pt10">
                    <?php echo "<ul>";
                    foreach ($this->validationErrors['User'] as $error) { ?>
                        <li><?php echo $error; ?></li>
                    <?php } echo "</ul>"; ?>
                </div>
            <?php } ?>
            <div class="grey13"><?php __('account_is_required_to_continue') ?></div>
            <div class="clr pt20"></div>
            <div>
                <div class="grey14"><?php __('cont_sender_name') ?><span class="mandatory_field">*</span></div>
                <div class="clr pt7"></div>
                <div><?php echo $this->Form->input('name', array('class' => 'input-text', 'id' => 'name', 'tabindex' => 5, 'label' => false, 'error' => FALSE)); ?></div>
            </div>
            <div class="clr pt15"></div>
            <div>
                <div class="grey14"><?php __('email') ?><span class="mandatory_field">*</span></div>
                <div class="clr pt7"></div>
                <div><?php echo $this->Form->input('email', array('class' => 'input-text', 'id' => 'email', 'tabindex' => 6, 'label' => false, 'error' => FALSE)); ?></div>
                <div class="clr pt5"></div>
            </div>
            <div class="clr pt15"></div>
            <div>
                <div class="grey14"><?php __('re_enter_email') ?><span class="mandatory_field">*</span></div>
                <div class="clr pt7"></div>
                <div><?php echo $this->Form->input('re_email', array('class' => 'input-text', 'id' => 're_email', 'tabindex' => 7, 'label' => false, 'error' => FALSE)); ?></div>
            </div>
            <div class="clr pt15"></div>
            <div id="password"></div>
            <div>
                <div>
                    <div class="grey14 fl"><?php __('password'); ?><span class="mandatory_field">*</span></div>
                </div>
                <div class="clr pt7"></div>
                <div>
                    <?php echo $this->Form->password('password', array('class' => 'input-text password', 'id' => 'register_password', 'tabindex' => 8, 'label' => false, 'error' => FALSE)); ?>
                </div>
            </div>
            <div class="clr pt15"></div>
            <div>
                <div>
                    <div class="grey14 fl"><?php __('re_enter_password'); ?><span class="mandatory_field">*</span></div>
                </div>
                <div class="clr pt7"></div>
                <div>
                    <?php echo $this->Form->password('re_password', array('class' => 'input-text password', 'id' => 're_password', 'tabindex' => 9, 'label' => false, 'error' => FALSE)); ?>
                </div>
            </div>
            <div class="clr pt15"></div>
            <div>
                <div class="fl"><?php echo $this->Form->checkbox('receive_weekly_newsletter', array('label' => false)); ?></div>
                <div class="fl grey13 pl10 width250"><strong><?php __('discover_new_projects'); ?></strong><br /><?php __('with_weekly_newsletter'); ?> </div>
            </div>
            <div class="clr pt15"></div>
            <div class="grey12"><?php __('by_signing_up') ?> <span class="blue11"><?php echo $this->Html->link(__('frnt_term_use', true), array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'display', 'terms-of-use'), array('escape' => false, 'target' => '_blank')); ?></span>. </div>
            <div class="clr pt15"></div>
            <div><?php echo $this->Form->submit(__('sign_me_up', true), array('class' => 'submit_but ie_radius fl')); ?>
                <div class="clr"></div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <!-- Facebook Connect -->
        <div class="signin ml75">
            <div class="heading_23"><?php __('sign_in_facebook') ?></div>
            <div class="clr pt10"></div>
            <div class="grey13"><?php __('its_fast_easy') ?></div>
            <div class="clr pt20"></div>
            <div class="grey11">
				<a href="#" onclick="facebook_login()" >
					<?=$this->Html->image('front/LogInFB.png') ?>
				</a>
            </div>
            <div class="clr pt20"></div>
            <div class="grey13 "><?php __('we_never_post') ?></div>
        </div>
        <div class="clr"></div>
    </div>
</div>