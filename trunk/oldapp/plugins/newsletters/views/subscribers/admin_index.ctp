<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Subscribers List</div>
    <div class="floatright padtop_6px">
        <div class="floatleft  " style="font-size:10px;"></div>
        <div class="floatleft " style="font-size:10px;padding-right:2px;">
            <?php echo $this->Html->link('Activate All','javascript:void(0);',array('class'=>'activate_all'));?>
			<?php echo $this->Html->link('Inactive All','javascript:void(0);',array('class'=>'inactivate_all'));?>
			<?php echo $this->Html->link('Delete All','javascript:void(0);',array('class'=>'delete_all'));?>
            <?php echo $this->Html->link("Add New",array("action"=>"add_subscriber"),array("class"=>'add_lnk'));?>
        </div>
		<div class="floatright " style="font-size:10px;">
            <?php echo $this->Html->link("Send Mail",array("action"=>"subscriber_send_mail"),array("class"=>'add_lnk'));?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info');  ?>
</div>
<div class="pagging float_right ">
	<?php echo $this->Form->create($model, array('class'=>''));?>
	<?php echo $form->text("email", array("class" => "status ui-widget-content ui-corner-all",'value' =>'Email', "onclick" => "if (this.value == 'Email') this.value = ''", "onblur" => "if (this.value == '') this.value = 'Email'")); ?>&nbsp;&nbsp;	
	<?php echo $this->Form->button("Search",array('class'=>'search_lnk','escape'=>false));?> &nbsp;&nbsp;
	<?php echo $this->Form->end();?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1','height'=>'10'));?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1','height'=>'5'));?></div>
<?php echo $this->element("admin/subscriber_index"); ?>
