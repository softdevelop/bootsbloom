<?php echo $javascript->link('front/swfobject.js'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var project_success =   0;
        var project_success_msg =   "";
<?php if (isset($project_success) && isset($project_success_msg)) { ?>
            project_success =   '<?php echo $project_success; ?>';
            project_success_msg =   '<?php echo $project_success_msg; ?>';
<?php } ?>
        if((project_success==1)){
        
            noty({
                "text":project_success_msg,
                "theme":"noty_theme_default",
                "layout":"top",
                "type":"success",
                "animateOpen":{
                    "height":"toggle"
                },
                "animateClose":{
                    "height":"toggle"
                },
                "speed":500,
                "timeout":5000,
                "closeButton":true,
                "closeOnSelfClick":true,
                "closeOnSelfOver":false,
                "modal":true
            });    
        
        }
  
    });
</script>

<?php $wesite_list = explode(',', $this->data['User']['website']); ?>
<?php echo $this->element("front/user_profile_tabs"); ?>
<div class="tab_container">
    <div id="tab1" class="tab_content">
        <div class="ptb21">
            <div class="wrapper">
                <?php /** *******Edit profile link********** */ ?>
                <div class="profile_left mt29">
                    <?php $login = $this->Session->read('Auth.User.slug');
                    if ($login != '' && $this->data['User']['id'] == $this->Session->read('Auth.User.id')) { ?>
                        <div class="button-profile-edit ie_radius"><?php echo $this->Html->link(__('edit_profile', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'edit_profile'), array('class' => 'profile-edit-link ie_radius')); ?>
                        </div>
                    <?php } ?>
                    <?php if ($wesite_list[0] != '' || $login != '') { ?>
                        <div class="left_cont">
                            <div class="grey14"><?php __('websites'); ?> </div>
                            <?php if ($wesite_list[0] == null && $login != '' && $login != '' && $this->data['User']['id'] == $this->Session->read('Auth.User.id')) { ?>
                                <div class="grey12 pt5"><?php __('let_ppl_know'); ?></div>
                            <?php } ?>
                            <ul>
                                <?php if ($wesite_list[0] != null) {
                                    foreach ($wesite_list as $website) { ?>			
                                        <li><?php echo $this->Html->link($website, 'http://' . $website, array('target' => '_blank')); ?></li>
                                        <?php
                                    }
                                } else
                                if ($login != '' && $this->data['User']['id'] == $this->Session->read('Auth.User.id')) {
                                    ?>
                                    <li><?php echo $this->Html->link(__('add_websites', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'edit_profile')); ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <div class="clr pt10"></div>
                    <div class="left_cont">
                    <div class="aligncenter">
						<?php echo $this->element('front/profile_chart',$chartData);?>
					</div>
                    </div>
                </div>
                <?php /*   * *******start here project********** */
                if (!empty($user_activities)) { ?>  
                    <div class="profile_right">
                      <?php echo $this->element('front/activities');?>
                    </div>
                <?php } else { ?>
                    <div class="profile_right"><div class="aligncenter pt10 grey14"></div><div class="pt40 grey14 lh18">
                    <?php 
                    if($this->Session->read('Auth.User.slug')==$this->params['slug']){
                         echo sprintf(__('profile_activity_empty_msg',true),$this->Html->link(__('discover',true),array('plugin'=>false,'controller'=>'projects','action'=>'discover'),array('class'=>'blue16 ')),$this->Html->link(__('profile_start_your_project_lnk',true),array('plugin'=>false,'controller'=>'home','action'=>'start'),array('class'=>'blue16 ')));
                    }else{
                       echo sprintf(__('profile_activity_empty_msg_other_users',true),$this->data['User']['name']); 
                    }
                    ?>
                        </div></div>
                <?php } ?>	
                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>
