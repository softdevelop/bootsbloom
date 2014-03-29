<div id="header">
    <div class="blackbg">
        <div class="wrapper">
            <div class="fl">
            			<?php echo $this->Html->link(Configure::read('CONFIG_SITE_TITLE'), array('plugin' => '', 'controller' => 'home', 'action' => 'index'), array("class" => "sprite logo2")); ?>

            <span class="white15 fl ml24 mt20"><?php __('header_punch_line'); ?></span>
            <div class="clr"></div>
  
			
			
		
                <div class="clr"></div>
           </div>
            <div class="fr mt0">
                <div>
                    <div class="fr mainnavi13 ml24 pt15">
                        
                    <?php echo $this->Html->link(__('frnt_help',true),array('plugin' => 'help_categories', 'controller' => 'faqs', 'action' => 'help'),array('class'=>"nomar"));?>  <?php if($this->Session->check('Auth.User.id')){ ?> | <?php echo $this->Html->link(__('frnt_logout',true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout'), array('class' => 'more-button', 'onclick' => 'FB.logout();', 'id' => 'logout_link')); ?> <?php } ?></div>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </div>
    <?php  if($this->params['controller']=='projects' && $this->params['action']=='edit'){ ?>
        <div class="darkgreybg">
            <div class="blackshade">
                <div class="wrapper">
                    <div class="steps fl" id="navigation">
                        <ul >
                            <li class="active_step"><a href="#guidelines" class="checkmark"><?php __('guidelines'); ?> </a></li>
                            <li class=""><a href="#basics" class="nav_link"><?php __('project_edit_basic'); ?></a></li>
                            <li class="disable_step "><a href="#rewards" class="nav_link"><?php __('project_edit_rewards');?></a> </li>
                            <li class="disable_step "><a href="#story" class="nav_link"><?php __('project_edit_story'); ?></a> </li>
                            <li class="disable_step "><a href="#about_you" class="nav_link"><?php __('project_edit_about_you'); ?></a> </li>
                            <li class="disable_step "><a href="#account" class="nav_link"><?php __('account'); ?></a></li>
                            <li class="disable_step nodivider" style="color: #FFF;cursor:pointer;">
                                <a href="#review" class="nav_link"><?php __('project_edit_review'); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
        </div>
  <?php  } ?>
</div>
