<?php $pages = $this->GeneralFunctions->get_page_content_by_id(array('21'), array('Page.id', 'Page.slug', 'Page.slug_hy','title','title_hy')); //pr($pages); ?>
<div class="abprorgt">
    <div class="pagestrips">
        <div class="blacktrans black17 uppercase pl10 pb10"> <span class="blue60 block"><?php echo count($project_detail['Backer']); ?></span><?php __('projt_dtl_project_backers'); ?></div>
        <div class="blacktrans2 black17 uppercase pl10 pb10"> <span class="blue60 block"><?php echo Configure::read('CONFIG_CURRENCYSYMB');?><?php echo $this->GeneralFunctions->get_total_pledge_amount($project_detail['Backer']); ?></span> <?php __('frnt_pledged'); ?> <?php __('projt_dtl_of'); ?> <?php echo Configure::read('CONFIG_CURRENCYSYMB');?><?php echo $project_detail['Project']['funding_goal']; ?>  <?php __('projt_dtl_goal'); ?></div>

        <?php if (($this->params['controller'] == 'projects' && $this->params['action'] == 'preview') || ($this->params['controller'] == 'projects' && $this->params['action'] == 'draft')) { ?>
        <?php if ($project_detail['Project']['active']==0){ // checing if user is viewing preview ?>   
        
        <div class="aligncenter ptb21 blacktrans">
                <div class="black17 uppercase pl10 pb10"><?php __('project_detail_project_not_live'); ?></div>
                <?php __('project_detail_project_in_draft'); ?>
                <div class="clr"></div>
                <span class="grey14">   <?php echo $this->Html->link($pages[0]['Page']['title'.$lang_var], array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'display', $pages[0]['Page']['slug' . $lang_var])); ?></span>
            </div>
            <?php }
            if ($project_detail['Project']['active']==1){ // check if on preview tab and project is live ?>
            <div class="blacktrans black17 uppercase pl10 pb10"> <span class="blue60 block">
                    <?php $time_rem= $this->GeneralFunctions->show_left_time(time(), $project_detail['Project']['project_end_date']);
                    echo $time_rem['time'];
                    ?>
                  
                    </span> <?php  echo sprintf( __('frnt_daystogo',true),$time_rem['unit']); ?>
            </div>
            <?php /* Display only if Project is running .**/ 
            if ($project_detail['Project']['project_end_date'] > time()) { ?>
                <div class="ribbion white15 uppercase">
                    <?php __('projt_dtl_funded_on'); ?> <?php echo $this->GeneralFunctions->get_project_ending_date_format($project_detail['Project']['project_end_date']); ?>.
                </div>
            <?php } 
            }    //end  check if on preview tab and project is live  ?>
        
        <?php } else { ?>
            <div class="blacktrans black17 uppercase pl10 pb10"> <span class="blue60 block">
                    <?php $time_rem= $this->GeneralFunctions->show_left_time(time(), $project_detail['Project']['project_end_date']);
                    echo $time_rem['time'];
                    ?>
                  
                    </span> <?php  echo sprintf( __('frnt_daystogo',true),$time_rem['unit']); ?> </div>
                <?php /* Display only if Project is running .**/ 
                if ($project_detail['Project']['project_end_date'] > time()) { ?>
                    <div class="ribbion white15 uppercase">
                        <?php __('projt_dtl_funded_on'); ?> <?php echo $this->GeneralFunctions->get_project_ending_date_format($project_detail['Project']['project_end_date']); ?>.
                    </div>
                <?php } ?>

            <?php if ($project_detail['Project']['remaining_time'] > 0) { ?>
                <div class="aligncenter ptb21">
                    <div class="relative">

                        <div>
                            <?php echo $this->Html->link('<span class="zindex1">'.__('project_edit_back_this_project',true) .'</span>', array('controller' => 'projects', 'action' => 'pledge', $project_detail['Project']['slug']), array('class' => 'button_yellow10 pb7 ie_radius wrapper225', 'escape' => FALSE)); ?>

                        </div>
                        <div class="pledgehold grey11 italic">
                            (<?php echo Configure::read('CONFIG_CURRENCYSYMB');?><?php echo $project_detail['Reward'][0]['pledge_amount']; ?>
                            <?php __('projt_dtl_min_pledge'); ?>)
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="pagestrips2 greybrdtop_light">
        <?php foreach ($project_detail['Reward'] as $reward) { ?>
            <div class="greybrdbot_light p10 pledge">
                <?php if (($this->params['controller'] == 'projects' && $this->params['action'] == 'preview') || ($this->params['controller'] == 'projects' && $this->params['action'] == 'draft') || ($project_detail['Project']['remaining_time'] <= 0)) { ?>
                    <span class="blue18"><?php __('projt_dtl_pledge').' '; ?> <?php echo Configure::read('CONFIG_CURRENCYSYMB');?><?php echo $reward['pledge_amount'].' '; ?> <?php __('projt_dtl_or_more'); ?></span>

                <?php } else { ?>
                    <?php echo $this->Html->link(__('projt_dtl_pledge', true).' ' . Configure::read('CONFIG_CURRENCYSYMB'). $reward['pledge_amount'] . ' ' . __('projt_dtl_or_more', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'pledge', $project_detail['Project']['slug']), array('class' => 'bold blue18  block')); ?>
                  <?php } ?>
                <div class="mtb10">
                    <span class="backersico"></span>
                    <?php $left_backers=$reward['limit_value']-$this->GeneralFunctions->get_total_backer_on_reward($reward['id'], $project_detail['Backer']); ?>
                    <?php __('projt_dtl_project_backers'); ?>
                    <?php
                    if ($reward['limit'] == 1) {
                        echo ' limited ( ' . $left_backers . ' of ' . $reward['limit_value'] . ' left ) ';
                    }
                    ?>
                </div>
                <div class="grey13 word-wrap"><?php echo $reward['description']; ?></div>
                <div class="grey11 uppercase block mt12"><?php __('projt_dtl_estimated_delivery'); ?>: <?php echo $this->Time->get_month($reward['est_delivery_month']) . " " . $reward['est_delivery_year']; ?> </div>
            </div>
        <?php } ?>

    </div>
    <div class="mt15">
        <div>
            <div class="sprite listingbxtl"></div>
            <div class="listingbxt330"></div>
            <div class="sprite listingbxtr"></div>
            <div class="clr"></div>
        </div>
        <div class="listingbxmid330">
            <div class="greybrdbot_light p7"> <span class="grey11_light block">
                    <?php __('projt_dtl_project_by'); ?> </span> <span class="blue18 block"><?php echo $this->Html->link($project_detail['User']['name'],array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile','slug'=>$project_detail['User']['slug']), array('class' => 'blue18')); ?></span> 
            </div>
            <div class="greybrdbot_light p7">
                <div class="fl img_box">
<?php  
	$user_array['User'] =   $project_detail['User'];
	$user_image_url = $this->GeneralFunctions->get_user_profile_image_using_user_array($user_array,'114px','114px');
	echo $this->Html->image($user_image_url, array());
?>
                </div>
				
                <div class="fl ml15 mt10 iconlink">
<?php 
	$user_city_info    =  $this->GeneralFunctions->get_json_to_city_name($project_detail['User']['city_json']);
	echo $this->Html->link($user_city_info['city_name'], array('plugin' => false, 'controller' => 'projects', 'action' => 'index', 'city', $user_city_info['id']), array('class' => 'locationicon block'));
	echo $this->Html->link(__('projt_dtl_backed', true) . ' ' . $project_detail['User']['backed_projects'] . ' ' . __('frnt_project', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'backed_projects', 'slug' => $project_detail['User']['slug']), array('class' => 'backedicon block')); 
?>
                </div>
                <div class="clr"></div>
            </div>
            <div class="p10 grey14 word-wrap"> <?php echo $project_detail['User']['biography']; ?> </div>
            <div class="clr"></div>
            <div class="grey14 aligncenter"><?php echo $this->Html->link(__('see_full_bio', true), 'javascript:void(0);', array('id' => 'see_full_bio')); ?></div>
        </div>
        <div>
            <div class="sprite listingbxbl"></div>
            <div class="listingbxb330"></div>
            <div class="sprite listingbxbr"></div>
            <div class="clr"></div>
        </div>

    </div>

</div>