<div class="ochead" >
	<div class="floatleft" id="breadcrumb">View Email</div>
		<div class="floatright padtop_6px">
			<div class="floatleft padright_10px" style="font-size:10px;"></div>
			<div class="floatleft padright_10px" style="font-size:10px;">
			   <?php  echo $this->Html->link("Back",array('action' => 'index'),array("class"=>'back_lnk'));?>
			</div>
			<div class="clear"></div>
		</div>
	<div class="clear"></div>
</div>	
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></div>
<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
		<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td></tr>
		<tr class="odd_row">
			<td align='left' width="19%" valign="top" class="padding_left_40">Email To</td>
			<td width="1%" valign="top">:</td>
			<td > <?php echo $emaillog_details['Emaillog']['email_to'];?></td>
			<td width="30%" valign="middle"></td>
		</tr>
		<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td>
		</tr>
		
		<tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td></tr>
		<tr class="even_row">
			<td align='left' width="19%" valign="top" class="padding_left_40">Email From</td>
			<td width="1%" valign="top">:</td>
			<td > <?php echo $emaillog_details['Emaillog']['email_from'];?></td>
			<td width="30%" valign="middle"></td>
		</tr>
		<tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td>
		</tr>
		<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td></tr>
		<tr class="odd_row">
			<td align='left' width="19%" valign="top" class="padding_left_40">Email Subject</td>
			<td width="1%" valign="top">:</td>
			<td > <?php echo $emaillog_details['Emaillog']['subject'];?></td>
			<td width="30%" valign="middle"></td>
		</tr>
		<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td>
		</tr>
		<tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td></tr>
		<tr class="even_row">
			<td align='left' width="19%" valign="top" class="padding_left_40">Message</td>
			<td width="1%" valign="top">:</td>
			<td > <?php echo nl2br($emaillog_details['Emaillog']['message']);?></td>
			<td width="30%" valign="middle"></td>
		</tr>
		<tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td>
		</tr>
		<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td></tr>
		<tr class="odd_row">
			<td align='left' width="19%" valign="top" class="padding_left_40">Send On</td>
			<td width="1%" valign="top">:</td>
			<td ><?php echo date('M, d Y',$emaillog_details[$model]['created']); ?>	 </td>
			<td width="30%" valign="middle"></td>
		</tr>
		<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
			</td>
		</tr>
		
	</table>
</div>
