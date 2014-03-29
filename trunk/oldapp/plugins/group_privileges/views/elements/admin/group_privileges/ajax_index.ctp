<div id="ajaxpanel">
<?php
    echo $this->Form->create('Groups',array('name' => 'GroupsOperateForm','action' => 'index')); 
	echo $this->Form->hidden('operation',array('value' => ''));
?>
<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
   <tr class="ui-widget-header ui-corner-all" style="height:30px;">
	<td align="left"><?php echo 'Name';?></td>
	<td align="left"><?php echo 'Action';?></td>
  </tr>
<?php
	if(count($results)>0)
	{
	$i=0;
	$class	=	'odd_row';	
	foreach ($results as $result){ 
		$class	=	(($i+1)%2==0) ? 'even_row' : 'odd_row';
?>
	<tr class="<?php echo $class;?>" id="row_<?php echo $result['Group']['id'];?>">
		<td valign="top">
			<?php echo ucwords($result['Group']['name']); ?>
		</td>
		<td valign="top">
			<?php echo $this->Html->link("Manage Privileges",array("controller"=>"group_privileges","action"=>"privileges",$result['Group']['id'])); ?>
		</td>
	</tr>
<?php	$i++; } ?>
	<tr>
		<td colspan="4"><div class="ochead"></div></td>
	</tr>	
<?php } else {  ?>
	<tr class="odd_row"><td colspan="8" align="center">No record  found!</td></tr>
<?php } ?>
</table>
 </div>
<?php echo $form->end(); ?>
</div>
