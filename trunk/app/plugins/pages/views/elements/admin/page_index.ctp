<div id="ajaxpanel">
<?php
	echo $this->Form->create($model, array('class'=>'form-inline'));
	echo $form->hidden('operation',array('value' => ''));
	$sortKey	=	 $paginator->sortKey();
	$sortDir	=	 $paginator->sortDir();	
?>
<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
	<table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
		<tr class="ui-widget-header ui-corner-all" style="height:30px;">
			<td align="left" class="padleft_15px" width="10%"><?php echo $form->checkbox('chkAll',array('id' => 'chkAll','name' => 'chkAll','value' => '','onclick' => 'checkAll()')); ?></td>
			<td align="left" width="40%"><?php echo $paginator->sort('Title', 'title');?><span <?php if($sortKey=="Page.name"){?> class="<?php echo $sortDir;?>" <?php }?>>&nbsp;</span></td>
			<td align="left" width="50%">Static Page Link</td>
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
			<td width="22%" valign="top"> <?php echo ucwords($records[$model]['title']); ?>
				<div id="action_row_<?php echo $records[$model]['id'];?>" style="visibility:hidden;" class="action_row">
					<?php echo $this->Html->link('Edit', array('action' => 'admin_edit_page',$records[$model]['id'],'eng'),array('class'=>'vtip','escape' => false,'title'=>'Edit Page'))?> 
				</div>
			</td>
			<td width="35%" valign="top" ><?php echo WEBSITE_URL . "pages/pages/display/" . $records[$model]['slug']; ?></td>
		</tr>
	<?php $i++;
		} ?>
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
