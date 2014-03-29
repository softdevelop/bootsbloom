<script type="text/javascript">
    var invalid_password=0;
<?php if (isset($invalid_password)) {
    if ($invalid_password == 1) { ?>
                invalid_password=1;
                                
        <?php
    }
}
?>
    $(document).ready(function() {
        $
        $("#reset_password").click(function(){
            $('#saving-layer').show();
            $.ajax({
                type: "POST",
                url: HOST_URL+$("#reset_password").attr('href')
             
            }).done(function(forgot_password) {
                $('#saving-layer').hide();
                var password =   $.trim(forgot_password);
                if(password!='success'){
                    noty({
                        "animateOpen":{
                            "height":"toggle"
                        },
                        "animateClose":{
                            "height":"toggle"
                        },
                        "force": true, 
                        "layout" : "top", 
                        "text": project_cancel_you_r_not_registered_user, 
                        "type": 'error',
                        "model":true,
                        "closeButton":true
                    });
                }else{
                    noty({
                        "animateOpen":{
                            "height":"toggle"
                        },
                        "animateClose":{
                            "height":"toggle"
                        },
                        "force": true, 
                        "layout" : "top", 
                        "text": project_cancel_instruction_to_reset_password, 
                        "type": 'information',
                        "model":true,
                        "closeButton":true
                    });
                }
            });
            
            return false;
        });
        
        if(invalid_password==1){
            noty({
                "animateOpen":{
                    "height":"toggle"
                },
                "animateClose":{
                    "height":"toggle"
                },
                "force": true, 
                "layout" : "top", 
                "text": project_cancel_your_password_didnot_match, 
                "type": 'error',
                "model":true,
                "closeButton":true
            });
        }
        
        
        
    });
    
</script>    

<div class="ptb21">
    <div class="wrapper">
        <div class="small_inner_wrapper">
            <div id="cancel_project" class="greybrdbot">
                <div class="heading_23"><?php __('delete_account'); ?></div>
                <div class="clr pt10"></div>
                <div class="grey13">
                    <?php echo vsprintf(__('account_r_u_sure_to_delete',true),array(Configure::read('CONFIG_SITE_TITLE'))) ; ?>
                    
                </div>
                <div class="clr pt10"></div>
                <div class="grey13">
                    <?php
                     echo vsprintf(__('account_if_you_launch',true),array(Configure::read('CONFIG_SITE_TITLE'),Configure::read('CONFIG_SITE_TITLE'))) ;
                    ?>
                    
                </div>
                <?php echo $this->Form->create('User', array('action' => 'delete_user_account', 'id' => 'ProjectCancel')); ?>
                <div class="grey13"><?php __('project_delete_enter_ur'); ?><?php echo Configure::read('CONFIG_SITE_TITLE'); ?> <?php __('project_delete_password_confirmation'); ?></div>
                <div class="fl">

                    <?php echo $this->Form->password('password', array('class' => 'input-text password')); ?>
                </div>

                <div class="clr pt10"></div>
                <div class="fl">
                    <?php echo $this->Form->submit(__('delete_account', true), array('class' => 'submit_but ie_radius fl')); ?>
                </div>
                <div class="fl pl15 blue11 ml10 mt10"><?php echo $this->Html->link(__('project_no_never', true), array('plugin'=>'users','controller' => 'users', 'action' => 'profile','slug'=>$this->Session->read('Auth.User.slug'))); ?></div>
                <?php echo $this->Form->end(); ?>    

                <div class="clr pt10"></div>
            </div>
            <div class="clr pt10"></div>
            <div id="forgot_password">
                <div class="heading_23"><?php __('project_forgot_password'); ?></div>
                <div class="fl">
                    <?php echo $this->Html->link(__('project_send_email_reset', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'forgot_password'), array('class' => 'submit_but ie_radius fl', 'id' => 'reset_password')); ?>
                </div>
            </div>
        </div>
        <div class="clr" ></div>
    </div>
</div>
