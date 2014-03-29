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
        $("#reset_password").click(function(){
            $.ajax({
                type: "POST",
                url: HOST_URL+$("#reset_password").attr('href')
             
            }).done(function(forgot_password) { 
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
                        "model":true
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
                        "model":true
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
                "model":true
            });
        }
        
        
        
    });
    
</script>    

<div class="ptb21">
    <div class="wrapper">
        <div class="small_inner_wrapper">
            <div id="cancel_project" class="greybrdbot">
                <div class="heading_23"><?php __('project_delete'); ?></div>
                <div class="clr pt10"></div>
                <div class="grey13">
                    <?php __('project_r_u_sure_to_delete'); ?>
                    <strong>
                        <?php
                        if (empty($project_info['Project']['title'])) {
                            echo 'Untitled';
                        } else {
                            echo $project_info['Project']['title'];
                        }
                        ?>
                    </strong>
                    <?php __('project_action_can_not_be_undo'); ?>
                </div>
                <div class="clr pt10"></div>
                <?php echo $this->Form->create('Project', array('action' => 'cancel_project/' . $project_info['User']['slug'] . '/' . $project_info['Project']['id'], 'id' => 'ProjectCancel')); ?>
                <div class="grey13"><?php __('project_delete_enter_ur'); ?><?php echo Configure::read('CONFIG_SITE_TITLE'); ?> <?php __('project_delete_password_verification'); ?></div>
                <div class="fl">

                    <?php echo $this->Form->password('password', array('class' => 'input-text password')); ?>
                </div>

                <div class="clr pt10"></div>
                <div class="fl">
                    <?php echo $this->Form->submit(__('project_delete_project', true), array('class' => 'submit_but ie_radius fl')); ?>
                </div>
                <div class="fl pl15 blue11 ml10 mt10"><?php echo $this->Html->link(__('project_no_never', true), array('plugin'=>false,'controller' => 'home', 'action' => 'start')); ?></div>
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
