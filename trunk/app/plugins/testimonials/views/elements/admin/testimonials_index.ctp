<div id="ajaxpanel">
<?php
    echo $this->Form->create($model, array('name' => 'AdminsOperateForm', 'action' => 'operate', 'id' => 'AdminsOperateForm'));
    echo $this->Form->hidden('operation', array('value' => '', 'id' => 'AdminsOperation'));
	$sortKey	=	 $paginator->sortKey();
	$sortDir	=	 $paginator->sortDir();	
?>
<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
	<table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
	   <tr class="ui-widget-header ui-corner-all" style="height:30px;">
			<td align="left" class="padleft_15px"><?php echo $form->checkbox('chkAll',array('id' => 'chkAll','name' => 'chkAll','value' => '','onclick' => 'checkAll()')); ?></td>
			
			<td align="left"><?php echo $paginator->sort('Added From', 'from_name');?><span <?php if($sortKey=="Testimonial.from_name"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
			
			<td align="left"><?php echo $paginator->sort('Subject', 'testimonial_title');?><span <?php if($sortKey=="Testimonial.testimonial_title"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
			
			<td align="center"><?php echo $paginator->sort('Date', 'created');?><span <?php if($sortKey=="Testimonial.created"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
			
			<td align="center"><?php echo $paginator->sort('Status', 'active');?><span <?php if($sortKey=="Testimonial.active"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
		
	  </tr>
		<?php
		if(count($result)>0)
		{
		$i=0;
		$class	=	'odd_row';	
		foreach ($result as $records){ 
		
			$class	=	(($i+1)%2==0) ? 'even_row' : 'odd_row';
		?>
		<tr class="<?php echo $class;?>" id="row_<?php echo $records[$model]['id'];?>">
		
			<td width="3%" class="padleft_15px" valign="top">
				<?php echo $form->checkbox('usersChk',array('name' => 'data[usersChk][]', 'id' => 'iId_'.$i,'value' => $records[$model]['id']), $return = false); ?>
			</td>
			<td width="30%" valign="top">
				<?php	echo ucwords($records[$model]['from_name']); ?>
				<div id="action_row_<?php echo $records[$model]['id'];?>" style="visibility:hidden;" class="action_row">
				 <?php echo $this->Html->link('Edit', array('action' => 'admin_edit_testimonial',$records[$model]['id']),array('class'=>'vtip','escape' => false,'title'=>'edit testimonial'))?>
				 &nbsp;|&nbsp;
				 <?php 
					if($records[$model]['active'] == '0'){
						
						echo $this->Html->link('Active',array('action' => 'admin_change_testimonial_status',$records[$model]['active'],$records[$model]['id']),array('title'=>'change testimonial status to active','class'=>'vtip'), 'Are you sure you want to change subscriber status ?');
						
					}else{
						echo $this->Html->link('Inactive',array('action' => 'admin_change_testimonial_status',$records[$model]['active'],$records[$model]['id']),array('title'=>'change testimonial status to inactive','class'=>'vtip'),'Are you sure you want to change subscriber status ?');
						
					}
					?>&nbsp;|&nbsp;
					<?php echo $this->Html->link('Delete',array('action' => 'admin_delete_testimonial',$records[$model]['id']),array('title'=>'delete testimonial','class'=>'vtip'),'Are you sure you want to delete testimonial ?'); ?>
				</div>
			</td>
			
			<td width="30%" valign="top"><?php echo ucfirst(substr($records[$model]['testimonial_title'],0,60)); ?></td>
			<td width="20%" valign="top" align="center"><?php echo date('M, d Y',$records[$model]['created']); ?>	</td>
			<td width="17%" valign="top" align="center">
			<?php 
					if($records[$model]['active'] == '1'){
						echo $html->image('active.png',array('border'=>'0','alt' => 'Active Page'));
					}else{
						echo $html->image('inactive.png',array('border'=>'0','alt' => 'Inactive Page'));
					}
			?></td>
			
		</tr>
	<?php $i++; } ?>
		<tr>
			<td colspan="8"><div class="ochead"></div></td>
		</tr>	
		<tr class="odd_row">
			<td class="td-listing" colspan="8" align="right"><?php echo $this->element('admin/pagination');?></td>
		</tr>	
		<?php } else {  ?>
			<tr class="odd_row"><td colspan="8" align="center">No record  found!</td></tr>
		<?php } ?>		   
	</table>
 </div>
<?php echo $form->end(); ?>
</div>
