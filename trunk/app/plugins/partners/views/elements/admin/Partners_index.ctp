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
			
			<td align="left"><?php echo $paginator->sort('Curated Page Logo', 'partner_image');?><span <?php if($sortKey=="Partner.partner_image"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
			
			<td align="left"><?php echo $paginator->sort('Curated Page Name', 'partner_name');?><span <?php if($sortKey=="Partner.partner_name"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
			
			<td align="left"><?php echo $paginator->sort('Curated Page Link', 'partner_site_link');?><span <?php if($sortKey=="Partner.partner_site_link"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
			
			<td align="center"><?php echo $paginator->sort('Date', 'cretaed');?><span <?php if($sortKey=="Partner.created"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
			
			<td align="center"><?php echo $paginator->sort('Status', 'active');?><span <?php if($sortKey=="Partner.active"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
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
			<td width="25%" valign="top">
					<?php echo $this->Html->image(WEBSITE_IMG_URL.'image.php?image='.$records[$model]['partner_image'].'&height=80px&width=80px;',array('width'=>'80px','height'=>'80px'));?>			
					<div id="action_row_<?php echo $records[$model]['id'];?>" style="visibility:hidden;" class="action_row">
						<?php echo $this->Html->link('Edit', array('action' => 'admin_edit_partner',$records[$model]['id']),array('class'=>'vtip','escape' => false,'title'=>'Edit curated page information '))?> &nbsp;|&nbsp;
						<?php 
								if($records[$model]['active'] == '0'){
									echo $this->Html->link('Active',array('action' => 'admin_change_partner_status',$records[$model]['active'],$records[$model]['id']),array('title'=>'Change curated page status to active','class'=>'vtip'),
										'Are you sure you want to change curated page status ?');
								}else{
									echo $this->Html->link('Inactive',array('action' => 'admin_change_partner_status',$records[$model]['active'],$records[$model]['id']),array('title'=>'Change curated page status to inactive','class'=>'vtip'),
										'Are you sure you want to change curated page status ?');
								}
						?>&nbsp;|&nbsp;
						<?php echo $this->Html->link('Delete',array('action' => 'admin_delete_partner',$records[$model]['id']),array('title'=>'Delete curated page','class'=>'vtip'),'Are you sure you want to delete curated page ?'); ?>
					</div>
			</td>
			<td width="15%" valign="top" align="left"><?php echo ucwords($records[$model]['partner_name']);?></td>
			<td width="25%" valign="top"><?php echo $records[$model]['partner_site_link']; ?></td>
			<td width="15%" valign="top" align="center"> <?php  echo date('M, d Y',$records[$model]['created']);?></td>
			<td width="10%" valign="top" align="center">
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
		<?php } else{ ?>
			<tr class="odd_row"><td colspan="8" align="center">No record  found!</td></tr>
		<?php } ?>		   
	</table>
 </div>
<?php echo $form->end(); ?>
</div>
