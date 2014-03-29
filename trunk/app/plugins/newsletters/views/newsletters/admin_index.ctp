<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Templates List</div>
    <div class="floatright padtop_6px">
        <div class="floatleft " style="font-size:10px;"></div>
        <div class="floatleft " style="font-size:10px;">
			<?php echo $this->Html->link('Activate All','javascript:void(0);',array('class'=>'activate_all'));?>
			<?php echo $this->Html->link('Inactive All','javascript:void(0);',array('class'=>'inactivate_all'));?>
			<?php echo $this->Html->link('Delete All','javascript:void(0);',array('class'=>'delete_all'));?>
            <?php echo $this->Html->link("Add New",array('plugin'=>'newsletters','controller'=>'newsletters', "action"=>"add_newsletter"),array("class"=>'add_lnk'));?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info');  ?>
</div>
<div class="pagging float_right ">
	<?php echo $this->Form->create($model, array('class'=>''));?>
	<?php echo $form->text("title", array("class" => "status ui-widget-content ui-corner-all",'value' =>'Title', "onclick" => "if (this.value == 'Title') this.value = ''", "onblur" => "if (this.value == '') this.value = 'Title'")); ?>&nbsp;&nbsp;
	<?php echo $this->Form->button("Search",array('class'=>'search_lnk','escape'=>false));?> &nbsp;&nbsp;
	<?php echo $this->Form->end();?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1','height'=>'10'));?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1','height'=>'5'));?></div>
<?php echo $this->element("admin/newsletter_index"); ?>
