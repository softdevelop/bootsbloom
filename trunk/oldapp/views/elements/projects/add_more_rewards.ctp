<div id="reward_append_to_div_<?php echo $new_div_id; ?>">
    <div class="greybox mb12">
        <div class="p10">
            <div class="fl width160 pt7">
				<?php echo $this->Html->link(__('project_add_more_reward',true).'#'.$reward_counter,array('plugin' => 'help_categories', 'controller' => 'schools', 'action' => 'school_home'),array('class'=>'helplink','target'=>'_blank')); ?>
			</div>
            <div class="fl width1490 grey12">
                <div class="rewardbox">
                    <div class="greybrdbot">
                        <div class="fl">
                            <div class="rewardfield"><?php __('project_edit_reward_pledge_amount'); ?></div>
                            <div class="fl">
                                <?php echo $this->Form->input("Reward.pledge_amount", array('type' => 'text', 'name' => 'data[Reward][pledge_amount][]', 'class' => 'input-text100', 'label' => false, 'error' => false, 'div' => false)); ?>
                            </div>
                            <div class="clr"></div>    
                        </div>
                        <div class="deletebutton">
                            <a href="javascript:void(0);" onclick="remove_reward(<?php echo $new_div_id; ?>)"><?php __('project_edit_reward_delete'); ?></a>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="greybrdbot">
                        <div class="rewardfield h94"><?php __('project_edit_reward_description'); ?></div>
                        <div class="fl">

                            <?php echo $this->Form->textarea("Reward.description", array('class' => 'textarea60', 'name' => 'data[Reward][description][]', 'label' => false, 'error' => false)); ?>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="greybrdbot">
                        <div class="rewardfield">Est. <?php __('project_edit_reward_delivery_date'); ?></div>
                        <div class="fl"><?php echo $this->Time->month_select('Project.month_select', '', array('label' => false, 'error' => false, 'empty' => 'Select Month', 'name' => 'data[Reward][est_delivery_month][]', 'error' => false, 'div' => false, 'class' => 'select230')); ?></div>
                        <div class="fl">
                            <?php echo $this->Time->year_select('Project.est_delivery_year', '', 5, array('label' => false, 'error' => false, 'empty' => 'Select Year', 'name' => 'data[Reward][est_delivery_year][]', 'error' => false, 'div' => false, 'class' => 'select138')); ?>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="ptb9">
                        <div class="fl backersico2 mr40">0 <?php __('projt_dtl_project_backers'); ?></div>
                        <div class="fl">
                            <?php echo $this->Form->checkbox("Reward.limit", array('class' => '', 'value' => 1, 'label' => false, 'name' => 'data[Reward][limit][]', 'error' => false, 'hiddenField' => false, 'id' => 'RewardLimit_' . $new_div_id, 'onclick' => 'return check_limit_value(' . $new_div_id . ')')); ?>
                        </div>
                        <div class="fl pl5"><?php __('project_edit_reward_limit_available'); ?></div>
                        <div class="fl pl5" id="limit_value_div_<?php echo $new_div_id; ?>" style="display: none;">
                            <?php echo $this->Form->text('Reward.limit_value', array('class' => 'input-text100', 'name' => 'data[Reward][limit_value][]', 'error' => false, 'id' => 'RewardLimitValue_' . $new_div_id)); ?>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <div class="greyboxtl"></div>
        <div class="greyboxtr"></div>
        <div class="greyboxbl"></div>
        <div class="greyboxbr"></div>
    </div>
    <?php echo $this->Form->input("Reward.id", array('type' => 'hidden', 'name' => 'data[Reward][id][]', 'label' => false, 'error' => false, 'div' => false)); ?>
    <div class="clr"><br /></div>
</div>
