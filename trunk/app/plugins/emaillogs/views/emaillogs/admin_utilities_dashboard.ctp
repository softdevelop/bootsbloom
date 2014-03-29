<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Utilities</div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;"></div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></div>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
	<tr>
		<td>
			<ul class="dblist">
				<li>
					<?php echo $this->Html->link($this->Html->image('admin/email_log_icon.png',array('alt'=>'')).'<br>Emaillogs', array('plugin'=>'emaillogs','controller' => 'emaillogs', 'action' => 'index'),array('escape'=>false,'title'=>'Emaillogs','class'=>'vtip'));?>
				</li>
				<li>
					<?php echo $this->Html->link($this->Html->image('admin/partner_icon.png',array('alt'=>'')).'<br>Partners List', array('plugin'=>'partners','controller' => 'partners', 'action' => 'index'),array('escape'=>false,'title'=>'Partners List','class'=>'vtip'));?>
				</li>
				<li>
					<?php echo $this->Html->link($this->Html->image('admin/backup_icon.png',array('alt'=>'')).'<br>DB Backup', array('plugin'=>'backups','controller' => 'backups', 'action' => 'index'),array('escape'=>false,'title'=>'DB Backup','class'=>'vtip'));?>
				</li>
				<li>
					<?php echo $this->Html->link($this->Html->image('admin/testimonial_icon.png',array('alt'=>'')).'<br>Testimonials', array('plugin'=>'testimonials','controller' => 'testimonials', 'action' => 'index'),array('escape'=>false,'title'=>'Testimonials','class'=>'vtip'));?>
				</li>
				<li>
					<?php echo $this->Html->link($this->Html->image('admin/page_icon.png',array('alt'=>'')).'<br>Static Pages', array('plugin'=>'pages','controller' => 'pages', 'action' => 'index'),array('escape'=>false,'title'=>'Static Pages','class'=>'vtip'));?>
				</li>
				<li>
					<?php echo $this->Html->link($this->Html->image('admin/image_icon.png',array('alt'=>'')).'<br>System Images', array('plugin'=>'staticimages','controller' => 'staticimages', 'action' => 'index'),array('escape'=>false,'title'=>'System Images','class'=>'vtip'));?>
				</li>
				<li>
					<?php echo $this->Html->link($this->Html->image('admin/document_icon.png',array('alt'=>'')).'<br>System Docs', array('plugin'=>'systemdocs','controller' => 'systemdocs', 'action' => 'index'),array('escape'=>false,'title'=>'System Docs','class'=>'vtip'));?>
				</li>
		  </ul>  
			<div class="clear"></div>
		</td>
	</tr>
</table>
