<div class="grey_gradient">
    <div class="pt20">
        <div class="wrapper">
            <h2 class="pageheading"><?php _('find_friend_get_social'); ?>
                <span class="project_short_desc">  <?php __('find_friend_follow_friend_discover_project'); ?>
                </span></h2>
            <!--Modified -->
        </div>
    </div>
</div>
<div class="ptb21">
    <div class="wrapper">
        <div class="fl">
            <div class="facebook">
                <div id="friends_opted_out" class="fr">
                    <span class="grey18"><strong> <?php __('opt_out_have_not_opted_out_following'); ?> </strong></span>
                    <div class="clr"></div>  
                    <span class="grey15">
                        <?php __('opt_out_u_and_no_one_can_follow_each_other_if_mistake'); ?> 
                        <?php echo $this->Html->link('opt' . ' ' . __('opt_out_back_in', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'opt_in'), array('class' => 'blue15')); ?>.
                    </span>
                </div>
            </div>   
            <div class="clr"></div>  
            <div class="face_t_box_wrap">
                <div class="face_t_box">
                    <h2><?php __('opt_out_personalized_browsing'); ?></h2>
                    <p><?php __('opt_out_personalized_browsing_colom'); ?></p>
                </div><div class="face_t_box">
                    <h2><?php __('opt_out_email_notification'); ?></h2>
                    <p><?php __('opt_out_email_notification_colom'); ?></p>
                </div><div class="face_t_box">
                    <h2><?php __('opt_out_pledge_privacy'); ?></h2>
                    <p><?php __('opt_out_pledge_privacy_colom'); ?></p>
                </div>
            </div>   
        </div>
        <div class="clr"></div>
    </div>
</div>