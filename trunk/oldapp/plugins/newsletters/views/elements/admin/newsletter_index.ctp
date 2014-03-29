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
			   <td align="left" class="padleft_15px" width="5%"><?php echo $form->checkbox('chkAll',array('id' => 'chkAll','name' => 'chkAll','value' => '','onclick' => 'checkAll()')); ?></td>
				<td align="left" width="15%"><?php echo $paginator->sort('Title', 'title');?><span <?php if($sortKey=="NewsLetters.title"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
				<td align="left" width="25%">Image</td>
				<td align="left" width="15%"><?php echo $paginator->sort('Subject', 'subject');?><span <?php if($sortKey=="NewsLetters.subject"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
				<td align="center" width="20%"><?php echo $paginator->sort('Date', 'created');?><span <?php if($sortKey=="NewsLetters.created"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
				<td align="center" width="20%">Status</td>
			</tr>
			<?php
			if(count($result)>0){
				$i=0;
				$class	=	'odd_row';	
				foreach ($result as $records){ 
				$class	=	(($i+1)%2==0) ? 'even_row' : 'odd_row';
			?>
			<tr class="<?php echo $class;?>" id="row_<?php echo $records[$model]['id'];?>">
				<td width="3%" class="padleft_15px" valign="top">
					<?php echo $form->checkbox('usersChk',array('name' => 'data[usersChk][]', 'id' => 'iId_'.$i,'value' => $records[$model]['id']), $return = false); ?>
				</td>	
				<td width="25%" valign="top">
					<?php echo ucwords(substr($records[$model]['title'],0,90)); ?>
					<div id="action_row_<?php echo $records[$model]['id'];?>" style="visibility:hidden;" class="action_row">
						<?php echo $this->Html->link('Edit',array('action' => 'edit_newsletter',$records[$model]['id']),array('class'=>'vtip','title'=>'Edit Newsletter')); ?> &nbsp;|&nbsp;
						<?php 
								if($records[$model]['active'] == '0'){
									echo $this->Html->link('Active',array('action' => 'admin_change_newsletter_status',$records[$model]['active'],$records[$model]['id']),array('class'=>'vtip','title'=>'Change Newsletter Status To Active'),
										'Are you sure you want to change newsletter status ?');
								}else{
									echo $this->Html->link('Inactive',array('action' => 'admin_change_newsletter_status',$records[$model]['active'],$records[$model]['id']),array('class'=>'vtip','title'=>'Change Newsletter Status To Inactive'),
										'Are you sure you want to change newsletter status ?');
								}
						?>&nbsp;|&nbsp;		
						<?php echo $this->Html->link('Delete',array('action' => 'delete_newsletter',$records[$model]['id']),array('class'=>'vtip',	'title'=>'Delete Newsletter'),'Are you sure you want to delete newsletter ?'); 
						?>
					</div>
				</td>
				<td width="15%" valign="top"><?php echo $this->Html->image(UPLOAD_DIR_URL .$records[$model]['newsletter_image'],array('height'=>'40px','width'=>'40px')); ?></td>
				<td width="15%" valign="top"><?php echo ucfirst(substr($records[$model]['subject'],0,90)); ?></td>
				<td width="15%"valign="top" align="center"><?php echo date('M, d Y',$records[$model]['created']); ?></td>
				<td width="7%"valign="top" align="center">
					<?php 
								if($records[$model]['active'] == '1'){
									echo $this->Html->image('active.png',array('border'=>'0','alt' => 'Active Page'));
								}else{
									echo $this->Html->image('inactive.png',array('border'=>'0','alt' => 'Inactive Page'));
								}
						?>
				</td>
			</tr>
		<?php $i++; } ?>
			<tr>
				<td colspan="8"><div class="ochead"></div></td>
			</tr>	
			<tr class="odd_row">
				<td class="td-listing" colspan="8" align="right"><?php echo $this->element('admin/pagination');?></td>
			</tr>	
			<?php
			}
			else{ ?>
				<tr class="odd_row"><td colspan="8" align="center">No record  found!</td></tr>
			<?php } ?>		   
		</table>
	 </div>
	<?php echo $form->end(); ?>
</div>
