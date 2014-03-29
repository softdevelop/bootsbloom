<?php echo $this->Form->create($model,array("class"=>"form-horizontal"));?>	
<div class="ochead" >
	<div class="floatleft" id="breadcrumb">Edit Testimonial</div>
	<div class="floatright padtop_6px">
	<div class="floatleft " style="font-size:10px;"></div>
		<div class="floatleft " style="font-size:10px;">
		<?php  echo $this->Html->link("Back ",array('action' => 'index'),array("class"=>'back_lnk'));?>
		</div>
	<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
        <div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></div>
		<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
				<tr><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
					</td></tr>
				<tr class="odd_row">
					<td align='left' width="19%" valign="top" class="padding_left_40">From Name<font color='red'>*</font></td>
					<td width="1%" valign="top">:</td>
					<td > <?php echo $form->text($model.".from_name", array("class" => "ui-widget-content ui-corner-all")); ?></td>
					<td width="30%" valign="middle">
					<?php  if(isset($this->validationErrors[$model]['from_name'])){ ?>
						<div  class="errormsg">
						  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
						  <div class="floatleft"><?php echo $this->validationErrors[$model]['from_name'];?></div>
						  <div class="clear"></div>
						  <div class="errtl"></div>
						  <div class="errtr"></div>
						  <div class="errbl"></div>
						  <div class="errbr"></div>
						</div>
					<?php } ?>
					</td>
				</tr>
				<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
					</td>
				</tr>  
				<tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
					</td>
				</tr>   
				
				<tr class="even_row">
					<td align='left' width="19%" valign="top" class="padding_left_40">Subject<font color='red'>*</font></td>
					<td width="1%" valign="top">:</td>
					<td ><?php echo $form->textarea($model.'.testimonial_title', array('label' => '','class'=>'ui-widget-content ui-corner-all','style'=>'width:250px;height:50px;'));?></td>
					<td width="30%" valign="middle">
						<?php if(isset($this->validationErrors[$model]['testimonial_title'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div class="floatleft"><?php echo $this->validationErrors[$model]['testimonial_title'];?></div>
							  <div class="clear"></div>
							  <div class="errtl"></div>
							  <div class="errtr"></div>
							  <div class="errbl"></div>
							  <div class="errbr"></div>
							</div>
						<?php }?>
					</td>
				</tr>	
				<tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></td></tr> 
				
				<tr><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
					</td></tr>
				<tr class="odd_row">
					<td align='left' width="19%" valign="top" class="padding_left_40">Message<font color='red'>*</font></td>
					<td width="1%" valign="top">:</td>
					<td><?php 
						echo $form->textarea($model.'.testimonial_description', array('label' => '','class'=>'ui-widget-content ui-corner-all','style'=>'width:250px;height:50px;'));
						echo $this->Editor->render($model.'TestimonialDescription');
					?>
					</td>
					<td width="30%" valign="middle">
					<?php  if(isset($this->validationErrors[$model]['testimonial_description'])){ ?>
						<div  class="errormsg">
						  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
						  <div class="floatleft"><?php echo $this->validationErrors[$model]['testimonial_description'];?></div>
						  <div class="clear"></div>
						  <div class="errtl"></div>
						  <div class="errtr"></div>
						  <div class="errbl"></div>
						  <div class="errbr"></div>
						</div>
					<?php } ?>
					</td>
				</tr>
				<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
					</td>
				</tr>  
				
				<tr class="even_row" ><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
					</td>
				</tr>	
			<tr class="even_row">
				<td align='left' valign="top" class="padding_left_40">Status</td>
				<td width="1%" valign="top">:</td>
				<td>
					<?php echo $form->input('active',array('label' => '','options' => array('0'=>'Inactive','1'=>'Active'), null,'class'=>'ui_dropdown'));  ?>
				</td>
				<td width="30%" valign="middle">
					<?php if(isset($this->validationErrors[$model]['active'])){?>
						<div  class="errormsg">
						  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
						  <div class="floatleft"><?php echo $this->validationErrors[$model]['active'];?></div>
						  <div class="clear"></div>
						  <div class="errtl"></div>
						  <div class="errtr"></div>
						  <div class="errbl"></div>
						  <div class="errbr"></div>
						</div>
					<?php }?>
				</td>
			</tr>
			<tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></td></tr> 
				
				<tr class="odd_row">
					<td align='left' colspan="4" style="padding:10px 0px 10px 200px">
						<table>
							<tr><td>
								<?php echo $form->submit('Submit',array('border'=>'0','class'=>'submit_button')); ?>
							</td>
							<td><?php					
							echo $html->link('Cancel', array('action' => 'index'), array('escape' => false,'class'=>'cancel_lnk'));
								?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
<?php echo $form->end(); ?>
