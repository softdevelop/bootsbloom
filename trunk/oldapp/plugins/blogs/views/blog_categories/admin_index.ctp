<div class="ochead">
    <div class="floatleft" id="breadcrumb"><?php if(isset($blog)){ 
														foreach($blog as $blog){
														echo ucfirst(substr($blog,0,50));}}?>'s Categories</div>
    <div class="floatright padtop_6px" >
        <div class="floatleft " style="font-size:10px;"></div>
        <div class="floatleft padright_3px" style="font-size:10px;">
			<?php echo $this->Html->link('Activate All','javascript:void(0);',array('class'=>'activate_all'));?>
			<?php echo $this->Html->link('Inactive All','javascript:void(0);',array('class'=>'inactivate_all'));?>
			<?php echo $this->Html->link('Delete All','javascript:void(0);',array('class'=>'delete_all'));?>
            <?php echo $this->Html->link("Add Category",array("action"=>"add_blog_category",$blog_id),array("class"=>'add_lnk'));?>
        </div>
		<div class="floatleft " style="font-size:10px;">
			<?php echo $this->Html->link("Back To Blog",array('plugin'=>'blogs','controller' => 'blogs', 'action' => 'index'),array("class"=>'back_lnk'));?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info');  ?>
</div>
 
	<div class="pagging float_right "> 
		<?php echo $this->Form->create($model,array('url' => array('action' => 'index',$blog_id))); ?>
		<?php echo $form->text("category_name", array("class" => "status ui-widget-content ui-corner-all",'value' =>'Category Name', "onclick" => "if (this.value == 'Category Name') this.value = ''", "onblur" => "if (this.value == '') this.value = 'Category Name'")); ?>
		&nbsp;&nbsp;
		<?php echo $this->Form->button("Search",array('class'=>'search_lnk','escape'=>false));?> &nbsp;&nbsp;
		<?php echo $this->Form->end();?>
	</div>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1','height'=>'10'));?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1','height'=>'5'));?></div>
<?php echo $this->element("admin/category_index"); ?>

