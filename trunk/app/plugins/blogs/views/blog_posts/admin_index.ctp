<div class="ochead" >
    <div class="floatleft" id="breadcrumb"><?php if(isset($blog)){ 
														foreach($blog as $blog){
														echo ucfirst(substr($blog,0,50));}}?>'s Posts</div>
    <div class="floatright padtop_6px">
        <div class="floatleft " style="font-size:10px;"></div>
        <div class="floatleft padright_3px" style="font-size:10px;">
            <?php echo $this->Html->link('Activate All','javascript:void(0);',array('class'=>'activate_all'));?>
			<?php echo $this->Html->link('Inactive All','javascript:void(0);',array('class'=>'inactivate_all'));?>
			<?php echo $this->Html->link('Delete All','javascript:void(0);',array('class'=>'delete_all'));?>
            <?php echo $this->Html->link("Add Post",array("action"=>"add_post",$blog_id),array("class"=>'add_lnk'));?>
        </div>
		 <div class="floatright " style="font-size:10px;">
            <?php echo $this->Html->link("Back To Blog",array('plugin'=>'blogs','controller' => 'blogs', 'action' => 'index'),array("class"=>'back_lnk'));?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="width_300 float_left" ><?php echo $this->element('admin/paging_info');  ?>
</div>
<div class="padding_top_6px float_right " > 
		<?php   echo $this->Form->create($model, array('url' => array_merge(array('action' => 'index'), $this->params['pass']))); ?>
	<div class="float_left padright_10px  padding_top_3px" >
	<div  class="float_left padright_10px  padding_top_6px black_color">Filter By:</div>
	<div class="float_right"   > 				
		<?php echo $form->select('blog_category_id',$category_list,null,array('empty'=>'All categories','class'=>'ui_dropdown'));?>
	</div></div>
	
	<?php echo $form->text("title", array("class" => "status ui-widget-content ui-corner-all",'value' =>'Title', "onclick" => "if (this.value == 'Title') this.value = ''", "onblur" => "if (this.value == '') this.value = 'Title'")); ?>
	
	&nbsp;&nbsp;
	<?php echo $this->Form->button("Search",array('class'=>'search_lnk','escape'=>false));?> &nbsp;&nbsp;
	<?php echo $this->Form->end();?>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1','height'=>'10'));?></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1','height'=>'5'));?></div>
<?php echo $this->element("admin/post_index"); ?>

