<div class="grey_gradient">
    <div class="pt20">
        <div class="wrapper">
            <h2 class="pageheading">
                <?php echo __('notification'); ?>
            </h2>
        </div>
    </div>
</div>

<div class="ptb21">
    <div class="innerwrapper">
        <?php
        if ($recentActivities) {
            foreach ($recentActivities as $recentActivity) {
                if ($recentActivity['Notification']['notification_type'] == 'follow') {
                    ?>
                    <div  style="width: 100% " class="grey16">
                        <div class="fl width50per">
                            <?php $follow_user = $this->GeneralFunctions->get_user_info($recentActivity['Notification']['subject_id'], $fields = array('User.name', 'User.profile_image', 'User.fb_image_url')); ?>
                            <div class="fl pr10">
                                <?php echo $this->Html->image($follow_user['User']['profile_image_url'], array('height' => 40, 'width' => 40, 'escape' => false)); ?>
                            </div>
                            <div>
                                <?php echo $follow_user['User']['name']; ?> is now following you! <?php echo $this->Html->link('Manage Friends', array('plugin' => 'users', 'controller' => 'users', 'action' => 'find_friends')); ?> 
                            </div>


                        </div>
                        <div class="grey16"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $recentActivity['Notification']['created']); ?></div>
                    </div>
                    <div class="clr"></div>
                <?php }
            }
        } else { ?>
            <div  style="width: 100% " class="grey16"><?php __('frnt_notification_empty',true);?>.</div>
<?php } ?>
        <div class="clr"></div>
    </div>
</div>