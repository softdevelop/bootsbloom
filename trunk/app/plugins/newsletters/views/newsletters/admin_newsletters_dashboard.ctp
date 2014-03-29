<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Newsletter Dashboard</div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;"></div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></div>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
	<tr><td>
	  <ul class="dblist">
		<li>
			<?php echo $this->Html->link($this->Html->image('admin/newsletter_icon.png',array('alt'=>'')).'<br>Newsletters', array('plugin'=>'newsletters','controller' => 'newsletters', 'action' => 'index'),array('escape'=>false,'title'=>'Newsletters','class'=>'vtip'));?>
		</li>
		<li>
			<?php echo $this->Html->link($this->Html->image('admin/newsletter_scribers_icon.png',array('alt'=>'')).'<br>Subscribers', array('plugin'=>'newsletters','controller' => 'subscribers', 'action' => 'index'),array('escape'=>false,'title'=>' Newsletters Subscribers','class'=>'vtip'));?>
			</li>
	  </ul>
	<div class="clear"></div>
	</td></tr>
</table>
