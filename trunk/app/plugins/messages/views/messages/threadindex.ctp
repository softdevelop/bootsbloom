<div class="ajax-container">
<div class="grey_gradient">
  <div class="pt20">
    <div class="wrapper">
      <h2 class="pageheading">
		<?php echo $this->Html->link(__('inbox',true),array('plugin'=>'messages','controller'=>'messages','action'=>'index'),array('alt'=>''));?><span class="publish"> / <?php echo $threadProject['Project']['title'];?></span>
	 </h2>
    </div>
  </div>
</div>
<div class="ptb21">
  <div class="innerwrapper">
  <div class="fl massage_l">
	<div class="fl reply_b">
		<?php if(count($threadMessages) > 0) { ?>
		<div class="fl reply"><?php echo $this->Html->link($this->Html->image('front/reply_a.png',array('alt'=>'','width'=>'16','height'=>'20')).'&nbsp;'.__('message_send_message_reply',true),'javascript:void(0);',array('escape'=>false,'alt'=>'','id'=>'reply'));?></div>
		<div class="clr"></div>
		<div id="reply-container" style="display:none;">
			<?php echo $this->Form->create($model,array('url'=>array('plugin'=>'messages','controller'=>'messages','action'=>'index',$threadUser['User']['slug'],$threadProject['Project']['slug']),'id'=>'new_message'));?>
			<div class="clr pt28"></div>
			<div><?php __('message_to'); ?>: <span class="gray14"><?php echo ucwords($threadUser['User']['name']);?></span></div>
			<div class="pt15"></div>
			<?php echo $this->Form->textarea($model.'.message',array('id'=>'message_body','class'=>'massage_box','value'=>''));?>
			<div class="pt10"></div>
			<?php echo $this->Form->submit(__('message_send_message',true),array('class'=>'send_msg fr ie_radius'));?>
			<?php echo $this->Form->end();?>
		</div>
		<?php }else{ ?>
			<div class="aligncenter"> <?php __('message_no_message_in_this_thred');?></div>
		<?php }?>
	</div>
	<div class="clr pt10"></div>
	<?php 
		//pr($threadMessages);
		if(count($threadMessages) > 0) {
			foreach($threadMessages as $message) {
			$user_id	=	$this->Session->read('Auth.User.id');
	?>
			<div class="user_d fl massage_l">
				
				<div class="fr blue14" id="reportspam_<?php echo $message['message']['id'];?>">
				<?php if($message['message']['from_user_id']!=$user_id &&  $message['message']['is_spam'] != 1){?>
				<?php $message_id	=	$message['message']['id'];
					echo $this->Html->link(__('report_spam', true),'javascript:void(0)', array('onclick' => 'report_spam('.$message_id.')')); ?>
				<?php
				
				}
				//$message_id	=	$message['message']['id'];
				//echo $this->Html->link('Report as spam','javascript:void(0)', array('onclick' => 'report_spam('.$message_id.')'));
				?>
				</div>
				
				<?php $user_image_url=$this->GeneralFunctions->get_user_profile_image($message['sender']['id'],'82px','83px' );
                                echo $this->Html->image($user_image_url, array('width' => '83', 'height' => '82')); 
				?>
				<p class="pt5"><span class="blue14"><?php echo $this->Html->link(ucwords($message['sender']['user_name']), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile', 'slug' => $message['sender']['slug'])); ?></span><br>
				<span><?php echo date('M, d Y h:i a',$message['message']['created']);?></span></p>
				<div class="pt10"><?php
				if($message['message']['is_spam']==1){
				__('reported_spam'); 
				}else{
				echo $message['message']['message'];
				}
				?></div>
				
			</div>
			
	<?php }}?>
	</div>
	<div class="fr msg_right">
		<div class="clr pt10"></div>
		<div class="user_d fl msg_right">
			<?php
				if ($threadProject['Project']['image']!='') {
					$project_img    =   $threadProject['Project']['image'];
				} else {
					$project_img    =   'missing_full.png';
				}
				echo $this->Html->image($this->GeneralFunctions->show_project_image($project_img,'83px','82px'),array('alt'=>'','height'=>'82','width'=>'83'));
			?>	
			<p class="pt5 name fl"><?php echo $threadProject['Project']['title']; ?><br>
			<div class="pt10"><?php __('frnt_by'); ?> &nbsp;<?php echo $threadProject['User']['name']; ?></div><br>
			<div class="t_color"><?php __('message_funding_end');?>&nbsp;<?php echo $this->GeneralFunctions->get_project_ending_date_format($threadProject['Project']['project_end_date']); ?></div></p>
		</div>
	</div>
	<div class="clr"></div>
  </div>
</div>
<div id="report_spam" style="display: none; width: 100px;"></div>
</div>
