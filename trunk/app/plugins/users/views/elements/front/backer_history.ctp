<?php
if (count($project_backers) > 0) {
    foreach ($project_backers as $project_backer) {
        $remaining_time = $this->GeneralFunctions->get_remainig_time(time(), $project_backer['Project']['project_end_date']);
        ?>
        <div class="user_d fl">
            <div class="fl pdetail">
                <div class="fl p5">
                    <div class="fl">
                        <?php
                        echo $this->Html->link($this->Html->image($this->GeneralFunctions->show_project_image($project_backer['Project']['image'], '150px', '150px'), array('height' => '150', 'width' => '150')), array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project_backer['Project']['User']['slug'], $project_backer['Project']['slug']), array('escape' => false));
                        ?> 
                    </div>
                    <div class="fl p5 pinnerdetail">
                        <?php echo $this->Html->link($project_backer['Project']['title'], array('plugin' => false, 'controller' => 'projects', 'action' => 'detail', $project_backer['Project']['User']['slug'], $project_backer['Project']['slug']), array('class' => 'blue18')); ?>
                        <br>
                        <p class="grey12"><?php echo $project_backer['Project']['short_description'] ?></p>
                        <br>
                        <?php
                        $total_funded_percentage = $this->GeneralFunctions->total_funded_percentage($project_backer['Project']['id'], $project_backer['Project']['funding_goal'], $project_backer['Project']['Backer']);
                        if ($total_funded_percentage > 100) {
                            $total_funded_slider_percentage = 100;
                        } else {
                            $total_funded_slider_percentage = $total_funded_percentage;
                        }
                        ?>

                        <div class="backdetailbox">
                            <div class="back_history_backker pl10" style="width: 40px;">
                                <div class="grey22 mt9"><?php echo count($project_backer['Project']['Backer']); ?><br>
                                    <span class="grey11"><?php __('faq_backer'); ?></span>
                                </div>
                            </div>

                            <div class="back_history_backker pl10">
                                <div class="grey22 mt9"><?php echo $total_funded_percentage; ?> %<br>
                                    <span class="grey11"><?php __('frnt_funded'); ?></span>
                                </div>
                            </div>
                            <div class="back_history_backker pl10">
                                <div class="grey22 mt9"><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $this->GeneralFunctions->get_total_pledge_amount($project_backer['Project']['Backer']); ?><br>
                                    <span class="grey11"><?php __('frnt_pledged'); ?></span>
                                </div>
                            </div>
                            <div class="back_history_funded" style="width: 100px">
                                <div class="grey22 mt9"><?php __('frnt_funded'); ?><br>
                                    <span class="grey11"><?php echo date(Configure::read('FRONT_UPDATES_DATE_FORMAT'), $project_backer['Project']['project_end_date']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fl pddetail">
                <div class="fl p5 pinnerdetail grey14">
                    <span >
                        <?php __('backer_history_pledge_amount'); ?> <span class=""><?php echo Configure::read('CONFIG_CURRENCYSYMB'); ?><?php echo $project_backer['Backer']['amount']; ?></span> <br /><?php __('backer_history_regarding_reward'); ?>  
                        <span class="blue14">"<?php
                if ($project_backer['Backer']['reward_id'] != 0) {
                    echo __('frnt_pledged') . ' ' . Configure::read('CONFIG_CURRENCYSYMB') . '' . $project_backer['Reward']['pledge_amount'] . ' ' . __('backer_or_more', true);
                } else {
                    echo __('backer_no_thanks');
                }
                        ?>"</span> <br /> <?php __('backer_history_on'); ?> <?php echo $this->GeneralFunctions->get_project_ending_date_format($project_backer['Backer']['created']); ?>
                    </span>
                </div>

            </div>
            <div class="fl pactiondetail alignjustify">
                <?php
				if($project_backer['Backer']['is_cancelled'] == 1){
				__('backer_history_project_cancelled'); 
				}else{
					if ($remaining_time > 0 ) {
						echo $this->Html->link(__('backer_cancel_pledge', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'cancel_pledge', $project_backer['Backer']['id'], $project_backer['Project']['slug']), array('class' => 'button ie_radius'));
						echo "<div class='clr pt10'></div>";
						echo $this->Html->link(__('backer_update_pledge', true), array('plugin' => false, 'controller' => 'projects', 'action' => 'pledge', $project_backer['Project']['slug'], $project_backer['Backer']['id']), array('class' => 'button ie_radius'));
					} else {
						?>
						<?php __('backer_history_project_closed'); ?>
						
					<?php 
					} 
				}
				?>

            </div>
        </div>
        <?php
    }
    if ($this->params['isAjax']) {
        if ($current_page != $last_page) {
            echo "=================" . $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'backed_history', 'page' => $page));
        } else {
            echo "=================";
        }
    }
} else {
    ?>
    <div class="user_d aligncenter"><?php __('backer_history_no_msg_found'); ?></div>
    <?php
}
?>
