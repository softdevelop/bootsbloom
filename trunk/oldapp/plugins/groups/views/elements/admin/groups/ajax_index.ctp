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
		<td align="left"><?php echo $paginator->sort('Name', 'name');?><span <?php if($sortKey=="Group.name"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
		<td align="left"><?php echo $paginator->sort('Status', 'active');?><span <?php if($sortKey=="Group.active"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
	</tr>
	<?php
	if(count($results)>0)
	{
	$i=0;
	$class	=	'odd_row';	
	foreach ($results as $result){ 
		$class	=	(($i+1)%2==0) ? 'even_row' : 'odd_row';
	?>
	<tr class="<?php echo $class;?>" id="row_<?php echo $result[$model]['id'];?>">
		<td width="5%" class="padleft_15px" valign="top">
			<?php echo $form->checkbox('usersChk',array('name' => 'data[usersChk][]', 'id' => 'iId_'.$i,'value' => $result[$model]['id']), $return = false); ?>
		</td>
		<td valign="top">
			<?php
				echo ucwords($result[$model]['name']);
			?>
			<div id="action_row_<?php echo $result[$model]['id'];?>" style="visibility:hidden;" class="action_row">
				<?php
					echo $html->link("Edit",array('action' => 'edit', $result[$model]['id']),array('escape' => false,'title'=>'Edit user information','alt'=>'Edit Group','class'=>'vtip'));
				?>
			</div>
		</td>
		<td align='left' valign="top">
			<?php
				if (!$result[$model]['active'] == '0') {
					echo $this->Html->image('admin/icon-active.gif', array('title' => 'Active', 'alt' => 'Active', 'class' => 'vtip'));
				} else {
					echo $this->Html->image('admin/inactive-icon.gif', array('title' => 'Inactive', 'alt' => 'Inactive', 'class' => 'vtip'));
				}
			?>
		</td>
	</tr>
	<?php	
		$i++;
		}
	?>
	<tr>
		<td colspan="4"><div class="ochead"></div></td>
	</tr>	
	<tr class="odd_row">
		<td class="td-listing" colspan="4" align="right"><?php echo $this->element('admin/pagination');?></td>
	</tr>	
	<?php } else {  ?>
	<tr class="odd_row"><td colspan="8" align="center">No record  found!</td></tr>
	<?php } ?>
</table>
 </div>
<?php echo $form->end(); ?>
</div>
