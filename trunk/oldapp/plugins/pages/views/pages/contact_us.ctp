<div class="pl10" >
	<div class="forgot_password" ><?php __('how_help_u');?></div>
	<?php	echo $this->Form->create('Page',array("url"=>array("plugin"=>"pages","controller"=>"pages","action"=>"contact_us"))); ?>
	<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center" >
		<tr ><td  align="left" colspan="3"> <div class="clr pt10"> </div>
				<?php if ($this->validationErrors) { ?>
					<div class="error pt10">
						<?php
						echo "<ul>";
						foreach ($this->validationErrors['Page'] as $error) {
							?>
							<li><?php echo $error; ?></li>
						<?php
						}
						echo "</ul>";
						?>
					</div>
				<?php } ?>
			</td>
		</tr>
		
		<tr><td align="left" colspan="3"><?php __('cont_question');?> *</td></tr>
		<tr>
			<td colspan="3" align="left"><?php echo $form->text("Page.question",array('class'=>'con_input-text','style' => 'width:98%;height:20px;')); ?>
			</td>
		</tr>
		<tr ><td colspan="3"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td>
		</tr>		
		<tr><td align="left" colspan="3"><?php __('cont_question_details');?> *</td></tr>	
		<tr>
			<td colspan="3" align="left"><?php echo $form->textarea("Page.details",array('class'=>'con_input-text','style' => 'width:98%;height:95px;')); ?>
			</td>
		</tr>
		<tr ><td colspan="3"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td>
		</tr>	
		<tr>
			<td align="left" width="45%"><?php __('cont_sender_name');?> *</td>
			<td width="10%"></td>
			<td align="left" width="45%"><?php __('cont_sender_email');?> *</td>
		</tr>
		<tr>
			<td ><?php echo $form->text("Page.name",array('class'=>'con_input-text','style' => 'height:20px;')); ?></td>
			<td width="5%">&nbsp;</td>
			<td><?php echo $form->text("Page.email",array('class'=>'con_input-text','style' => 'height:20px;')); ?></td>
		</tr>
		<tr ><td colspan="3"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td>
		</tr>		
		<tr><td align="left" colspan="3"><?php __('cont_sender_lnk');?>&nbsp;(<?php __('Have_One');?>)</td></tr>
		<tr>
			<td colspan="3" align="left"> <?php echo $form->text("Page.profile_lnk",array('class'=>'con_input-text','style' => 	'width:98%;height:20px;')); ?>
			</td>
		</tr>		
		<tr ><td colspan="3"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td>
		</tr>	
		<tr><td align="left" colspan="3"><?php __('cont_question_abt');?> *</td></tr>	
		
		
		<?php 
		$userloginId = $this->Session->read('Auth.User.id');
		
		if($userloginId != '' && $userloginId > '0'){ ?>
		<tr>
			<td colspan="3" align="left"> <?php 
				$question_about_login_array=Configure::read('question_about_login_array'); 
				echo $form->select("Page.question_about",$question_about_login_array,null,array('empty' =>__('question_about',true),'onchange'=>'get_page_question_val(this.value)')); ?>
			</td>
		</tr>	
		<?php  }else{ ?>
		<tr>
			<td colspan="3" align="left"> <?php 
				$question_about=Configure::read('question_about_array'); 
				echo $form->select("Page.question_about",$question_about,null,array('empty' =>__('question_about',true))); ?>
			</td>
		</tr>	
		<?php } ?>
		
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		
		<tr id="projects_for_cancel" style="display:none"><td align="left" colspan="3"><?php __('cancelled_projects');?> *</td></tr>	
		<tr id="projects_for_cancel1" style="display:none">
			<td colspan="3" align="left"> <?php 
				$question_about=Configure::read('question_about_array'); 
				echo $form->select("Page.cancel_project",$project_list,null,array('empty' =>__('cancel_projects',true))); ?>
			</td>
		</tr>	
		
	</table>
	<?php echo $form->end(); ?>	
</div>	
<script type="text/javascript">
	function get_page_question_val(ques){
		$("#projects_for_cancel").hide();
		$("#projects_for_cancel1").hide();
		if(ques == 'project cancel request'){
			$("#projects_for_cancel").show();
			$("#projects_for_cancel1").show();
		}else{
			$("#projects_for_cancel").hide();
			$("#projects_for_cancel1").hide();
		}	
	} 
	
	$(function(){
		var pageQues	=	$("#PageQuestionAbout").val();
		if(pageQues == 'project cancel request'){
			$("#projects_for_cancel").show();
			$("#projects_for_cancel1").show();
		}		
	});

</script>

<div><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></div>
