<div class="pl10" >
	<div class="forgot_password" > <?php echo sprintf(__('report_this_message', true), Configure::read('CONFIG_SITE_TITLE')); ?>
	</div>
	<?php	echo $this->Form->create($model,array("url"=>array("plugins"=>"messages","controller"=>"messages","action"=>"report_spam"),'id'=>'MessageReportSpamForm')); ?>
	<?php //pr($threadMessages);?>
	<div class="user_d fl massage_l">
				
				<?php $user_image_url=$this->GeneralFunctions->get_user_profile_image($threadMessages[0]['sender']['id'],'82px','83px' );
                                echo $this->Html->image($user_image_url, array('width' => '83', 'height' => '82')); 
				?>
				<p class="pt5"><span class="blue14"><?php echo $this->Html->link(ucwords($threadMessages[0]['sender']['user_name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $threadMessages[0]['sender']['slug'])); ?></span><br>
				<span><?php echo date('M, d Y h:i a',$threadMessages[0]['message']['created']);?></span></p>
				<div class="pt10"><?php echo $threadMessages[0]['message']['message'];?></div>
				
	</div>
	<?php echo $form->end(); ?>	
</div>	
<div><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></div>
