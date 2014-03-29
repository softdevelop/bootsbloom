<?php 	
	echo $this->Html->script('/newsletters/js/newsletter.js');
	echo $this->Form->create($model,array('action'=>'subscriber_send_mail'));
?>
<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Send Mail </div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;"></div>
        <div class="floatleft padright_10px" style="font-size:10px;">
           <?php  echo $this->Html->link("Back ",array('action' => 'admin_index'),array("class"=>'back_lnk'));?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></div>
<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
		<tr class="odd_row"><td colspan="5"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td></tr>
		<tr class="odd_row">
			<td width="17%" class="padding_left_40" valign="top"> To <font color='red'>*</font></td>
			<td width="1%" valign="top" >:</td>
			<td width="30%">
				<?php echo $this->Form->select('SelectedMail',null,null,array('multiple' =>'multiple', 'size' =>'5', 'style' => 'width:250px;height:120px;'));?>
			</td>	
			<td width="15%" >
				<input type="button" value="Add" id="btnAdd" class="add_lnk"><br />
				<input type="button" value="Add All" id="btnAddAll" class="add_lnk"><br />
				<input type="button" value="Remove" id="btnRemove" class="add_lnk"><br />
				<input type="button" value="Remove All" id="btnRemoveAll" class="add_lnk">
			</td>
			<td  ><?php echo $form->select('TargetMail',$data,null,array('multiple' =>'multiple', 'size' =>'5', 'style' => 'width:250px;height:120px;'));?>
			<span class="help-inline"><?php echo $form->error("TargetMail"); ?></span>
			</td>
			</tr>
		<tr >
			<td colspan="5" >
				<div style="width:25%;padding-left:180px;">	
				<span class="help-inline"><?php if(isset($this->validationErrors[$model]['SelectedMail'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div class="floatleft"><?php echo $this->validationErrors[$model]['SelectedMail'];?></div>
							  <div class="clear"></div>
							  <div class="errtl"></div>
							  <div class="errtr"></div>
							  <div class="errbl"></div>
							  <div class="errbr"></div>
							</div>
						<?php }?></span>
				</div>
			</td>
		</tr>	
		<tr class="odd_row" ><td colspan="5"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td>
		</tr>
		<tr class="even_row"><td colspan="5"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td></tr>
		<tr class="even_row">
			<td colspan="5">
				<table border="0" width="100%">
					<tr>
						<td align='left' width="19%" valign="top" class="padding_left_40">Templates<font color='red'>*</font></td>
					<td width="1%" valign="top">:</td>
					<td ><?php echo $form->Select("template",$templete,null,array('empty' =>'Select news letter',"class"=>"span2 ui_dropdown" )); ?></td>
					<td width="30%" valign="middle">
						<?php if(isset($this->validationErrors[$model]['template'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px" style="float:left;" ><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div style="padding-left:20px; width:200px;"><?php echo $this->validationErrors[$model]['template'];?></div>
							  <div class="clear"></div>
							  <div class="errtl"></div>
							  <div class="errtr"></div>
							  <div class="errbl"></div>
							  <div class="errbr"></div>
							</div>
						<?php }?>
					</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class="even_row" ><td colspan="5"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td>
		</tr>
		 
		<tr class="odd_row">
			<td align='left' colspan="5" style="padding:10px 0px 10px 200px">
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
