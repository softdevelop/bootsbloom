<?php 	echo $this->Form->create($model,array("url"=>array("action"=>"admin_add_post",$blog_id)));
		echo $this->Form->hidden('blog_id',array('value'=>$blog_id)); 		
?>

<div> <?php echo $this->Html->image("admin/dot.gif", array("width" => "1", "height" => "10", "alt" => "")); ?></div>
<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Add <?php if(isset($blog)){ 
														foreach($blog as $blog){
														echo ucfirst(substr($blog,0,50));}}?>'s Post</div>
    <div class="floatright padtop_6px">
        <div class="floatleft " style="font-size:10px;"></div>
        <div class="floatleft " style="font-size:10px;">
           <?php  echo $this->Html->link("Back ",array('plugin'=>'blogs','controller' => 'blog_posts', 'action' => 'index',$blog_id),array("class"=>'back_lnk'));?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
		<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></div>
		<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
				<tr><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
					</td></tr>
				<tr class="odd_row">
					<td align='left' width="19%" valign="top" class="padding_left_40">Title<font color='red'>*</font></td>
					<td width="1%" valign="top">:</td>
					<td > <?php echo $form->text($model.".title", array("class" => "ui-widget-content ui-corner-all")); ?></td>
					<td width="30%" valign="middle">
					<?php  if(isset($this->validationErrors[$model]['title'])){ ?>
						<div  class="errormsg">
						  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
						  <div class="floatleft"><?php echo $this->validationErrors[$model]['title'];?></div>
						  <div class="clear"></div>
						  <div class="errtl"></div>
						  <div class="errtr"></div>
						  <div class="errbl"></div>
						  <div class="errbr"></div>
						</div>
					<?php } ?>
					</td>
				</tr>
				<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
					</td>
				</tr> 
				<tr class="even_row" ><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
					</td>
				</tr>		
				<tr class="even_row">
					<td align='left' width="19%" valign="top" class="padding_left_40">Description<font color='red'>*</font></td>
					<td width="1%" valign="top">:</td>
					<td ><?php 
						echo $form->textarea($model.'.description', array('label' => '','class'=>'ui-widget-content ui-corner-all','style'=>'width:600px;height:500px;'));
						echo $this->Editor->render($model.'Description');
					?>
					</td>
					<td width="30%" valign="middle">
						<?php if(isset($this->validationErrors[$model]['description'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div class="floatleft"><?php echo $this->validationErrors[$model]['description'];?></div>
							  <div class="clear"></div>
							  <div class="errtl"></div>
							  <div class="errtr"></div>
							  <div class="errbl"></div>
							  <div class="errbr"></div>
							</div>
						<?php }?>
					</td>
				</tr>	
				<tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></td></tr> 
				<tr class="odd_row" ><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
					</td>
				</tr>	
				<tr class="odd_row">
					<td align='left' valign="top" class="padding_left_40">Category<font color='red'>*</font></td>
					<td width="1%" valign="top">:</td>
					<td>
						<?php echo $form->Select("blog_category_id",$data,null,array('empty' =>'Select category',"class" => "ui_dropdown")); ?>
					</td>
					<td width="30%" valign="middle">
						<?php if(isset($this->validationErrors[$model]['blog_category_id'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div class="floatleft"><?php echo $this->validationErrors[$model]['blog_category_id'];?></div>
							  <div class="clear"></div>
							  <div class="errtl"></div>
							  <div class="errtr"></div>
							  <div class="errbl"></div>
							  <div class="errbr"></div>
							</div>
						<?php }?>
					</td>
				</tr>
				<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></td></tr>  
				<tr class="even_row" ><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
						</td>
					</tr>		
				<tr class="even_row">
					<td align='left' valign="top" class="padding_left_40">Status</td>
					<td width="1%" valign="top">:</td>
					<td>
						<?php 
							echo $form->input('active',array('label' => '','options' => array('0'=>'Inactive','1'=>'Active'), null,'class'=>'ui_dropdown')); 
						?>
					</td>
					<td width="30%" valign="middle">
						<?php if(isset($this->validationErrors[$model]['active'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div class="floatleft"><?php echo $this->validationErrors[$model]['active'];?></div>
							  <div class="clear"></div>
							  <div class="errtl"></div>
							  <div class="errtr"></div>
							  <div class="errbl"></div>
							  <div class="errbr"></div>
							</div>
						<?php }?>
					</td>
				</tr>
				<tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></td></tr> 
				<tr class="odd_row" ><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
						</td>
					</tr>	
				<tr class="odd_row">
					<td align='left' valign="top" class="padding_left_40">Allow Comment</td>
					<td width="1%" valign="top">:</td>
					<td>
						<?php echo $form->input('allow_comment',array('label' => '','options' => array('0'=>'Not Allowed','1'=>'Allowed'), null,'class'=>'ui_dropdown'));  ?>
					</td>
					<td width="30%" valign="middle">
						<?php if(isset($this->validationErrors[$model]['allow_comment'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div class="floatleft"><?php echo $this->validationErrors[$model]['allow_comment'];?></div>
							  <div class="clear"></div>
							  <div class="errtl"></div>
							  <div class="errtr"></div>
							  <div class="errbl"></div>
							  <div class="errbr"></div>
							</div>
						<?php }?>
					</td>
				</tr>
			<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></td></tr> 
				<tr class="even_row">
					<td align='left' colspan="4" style="padding:10px 0px 10px 200px">
						<table>
							<tr><td>
								<?php echo $form->submit('Submit',array('border'=>'0','class'=>'submit_button')); ?>
							</td>
							<td><?php					
							echo $html->link('Cancel', array('plugin'=>'blogs','controller' => 'blog_posts', 'action' => 'index',$blog_id), array('escape' => false,'class'=>'cancel_lnk'));
								?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
<?php echo $form->end(); ?>