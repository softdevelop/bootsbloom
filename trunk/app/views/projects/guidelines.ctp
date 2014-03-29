<script>
    $(function(){
        function equalHeight(group) {
			tallest = 0;
			group.height('');
			group.each(function() {
				thisHeight = $(this).height();
				
				if(thisHeight > tallest) {
					tallest = thisHeight;
					
				}
			});
			group.height(tallest);
		}
		equalHeight($("#helpbox>div"));
    });
</script>
<div class="darkgreybg">
    <div class="blackshade">
        <div class="wrapper">
            <div class="steps fl">
                <ul>
                    <li><a href="#" class="active_step"><?php __('frnt_guideline'); ?> </a></li>
                    <li class="disable_step"><?php __('project_edit_basic'); ?> </li>
                    <li class="disable_step"><?php __('project_edit_rewards'); ?> </li>
                    <li class="disable_step"><?php __('project_edit_story'); ?></li>
                    <li class="disable_step"><?php __('project_edit_about_you'); ?></li>
                    <li class="disable_step"><?php __('account'); ?></li>
                    <li class="disable_step nodivider" style="color: #FFF;cursor:pointer;"><?php __('project_edit_review'); ?></li>
                </ul>
            </div>
            <div class="clr"></div>
        </div>
    </div>
</div>
<div class="wrapper grey14">
    <?php echo $this->Form->create('Project', array('action' => 'create')); ?>
    <div class="fl pb80 greybrdrgt pt21 width68per pr50">
        <?php echo $page_content['Page']['description']; ?>
        <div id="helpbox" style = "padding-top:6px;">
			  <div class="fl rbluebg2 white14 pl10 pr33 width373"><span class="ptb15 block"><?php __('project_edit_have_question'); ?></span></div>
			  <div class="fl rbluebg3 white24 relative">
				  <div class="quoteicon">
					<?php echo $this->Html->image('quote2.png',array('width'=>'52','height'=>'46')); ?></div>
					<div class="fl"><?php echo $this->Html->link(__('project_edit_drop_line', true), 'javascript:void(0)', array('class' => 'ptb15 plr20 block', 'onclick' => 'contact_us()')); ?></div>
			  </div>
		 </div>
		 <div class="clr"></div>

        <br />
        <div class="greybrdbot"></div>
        <br/>
        <?php echo $this->Form->checkbox('accept_agreement', array('value' => '1', 'div' => false, 'label' => false, 'id' => 'accept_project_agreement')); ?> &nbsp;<?php __('project_edit_account_check_box_detail'); ?><br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php __('project_edit_eligibility_requirements'); ?>

        <div class="clr"></div>
        <div class="fr">
            <?php echo $this->Html->link(__('project_start_your_project', true), 'javascript:void(0);', array('class' => 'button_grey ie_radius', 'id' => 'project_submit_button')); ?>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
    <div class="fr width23per pt21 pb80">
        <?php echo $right_panel_contents['Page']['description'.$lang_var]; ?>
    </div>
    <div class="clr"></div>
</div>
