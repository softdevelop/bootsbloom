<?php echo $javascript->link('front/swfobject.js'); ?>
<?php
$wesite_list = explode(',', $this->data['User']['website']);

$paginator->options = array('url' =>
		array_merge(array('slug' => $this->params['slug']), $this->passedArgs)
);
?>
<!--condition for this view can not load this element start -->
<?php if($this->params['action'] != "user_comments") {?>
<div class="ptb21">
    <div class="wrapper">
        <?php /*********Edit profile link********** */ ?>
		<?php if($this->params['action'] != "profile") { ?>
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
             <div class="clr pt10"></div>
             <div class="left_cont grey14">
                *<?php __('info_editable_when_project_live')?>
                <ul>
                <li>
                    <?php __('info_proj_desc')?>
                </li>
                <li>
                     <?php __('info_video_image')?>
                </li>
                <li>
                    <?php __('info_reward_edit')?>
                </li>
                <li>
                     <?php __('info_your_profile')?>
                </li>
                <li>
                   <?php __('info_your_project_faq')?>
                </li>
                </ul>
             </div>
             <div class="clr pt10"></div>
             <div class="left_cont grey14">
                 <?php __('info_not_editable_when_project_live')?>
                 <ul>
                <li>
                   <?php __('info_not_editable_funding_goal')?>
               </li>
                <li>
                   <?php __('info_not_editable_rewards')?>
                </li>
                 </ul>
             </div>
        </div>
		<?php } ?>
        <?php /*         * *******start here project********** */ ?>
		<?php
		$style=" ";
		$class="profile_right";
		 ?> 
		
        <div class="<?php echo $class;?>" style="<?php echo $style;?>">
            <div>
                <div id="loading_content">
                    <?php
                       echo $this->element('front/load_more_project_content'); 
                    ?>
                      
                </div>  
                <?php if(count($projects)>0){ ?> 
                <div id="loadmore_loader" class="aligncenter" style="display: none;">
                    <?php echo $this->Html->image('front/ajax-loader.gif'); ?>
                </div>
                <div id="loadContentId" class='loadmore'>
                    <?php
                          if($current_page!=$last_page){
                                echo $this->Html->link($this->Html->tag('span',__('blog_load_more',true)),array('plugin' => 'users', 'controller' => 'users', 'action' => 'load_more_project_content/' . $type.'/'.$slug, 'page' => $page),array('escape'=>false,'class'=>'loadmoreicon','id' => 'loadMoreContent'));
                              
                          } ?>
                </div>
                <?php } ?>	
            </div>
            <div class="clr "></div>
        </div> 
    </div>	
</div>
<?php } ?>
<div class="clr pt40"></div>
