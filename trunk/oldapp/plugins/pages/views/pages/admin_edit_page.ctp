<?php
	if(isset($this->params['pass'][1])){
		$language=$this->params['pass'][1];
	} else {
		$language='eng';
	}
?>  
<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Edit Page</div>
    <div class="floatright padtop_6px">
        <div class="floatleft" style="font-size:10px;"></div>
        <div class="floatleft " style="font-size:10px;">
           <?php  echo $this->Html->link("Back ",array('action' => 'index'),array("class"=>'back_lnk'));?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></div>
<script type="text/javascript">
	$(document).ready(function() {
		//Default Action
		$(".tab_content").hide(); //Hide all content
		<?php if($language=='eng') { ?>
			$("ul.tabs li:first").addClass("active").show(); //Activate first tab
			$(".tab_content:first").show(); //Show first tab content
		<?php } else if($language=='hy') {  ?>
			$("#armenian").addClass("active").show(); //Activate first tab
			$("#tab2").show(); //Show first tab content
		<?php } ?>
		//On Click Event
		$("ul.tabs li").click(function() {
			$("ul.tabs li").removeClass("active"); //Remove any "active" class
			$(this).addClass("active"); //Add "active" class to selected tab
			$(".tab_content").hide(); //Hide all tab content
			var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
			$(activeTab).fadeIn(); //Fade in the active content
			return false;
		});
	}); 
</script>
<?php echo $this->Session->flash();?>
 <div class="padtop_4px">
          <ul class="tabs">
            <li><a href="#tab1">English</a></li>
			<li id="armenian" ><a href="#tab2" >Armenian</a></li>
          </ul>
</div>
<div class="tab_container">	
	<?php /********************first tab start here ************************/?>
	<div id="tab1" class="tab_content">
		<div class="wrapper">		
		
		<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
		<?	echo $this->Form->create($model,array("url"=>array('plugin'=>'pages','controller' => 'pages','action'=>'admin_edit_page',$page_id,'eng')));
		?>
			<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
				<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
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
					<td align='left' valign="top" class="padding_left_40">MetaKeywords<font color='red'>*</font></td>
					<td width="1%" valign="top">:</td>
					<td>
						<?php echo $form->textarea($model.'.metakeyword', array('label' => '','class'=>'ui-widget-content ui-corner-all','style'=>'width:250px;height:50px;'));?>
					</td>
					<td width="30%" valign="middle">
						<?php if(isset($this->validationErrors[$model]['metakeyword'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div class="floatleft"><?php echo $this->validationErrors[$model]['metakeyword'];?></div>
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
					<td align='left' width="19%" valign="top" class="padding_left_40">MetaDescription<font color='red'>*</font></td>
					<td width="1%" valign="top">:</td>
					<td ><?php echo $form->textarea($model.'.metadescription', array('label' => '','class'=>'ui-widget-content ui-corner-all','style'=>'width:250px;height:50px;'));?></td>
					<td width="30%" valign="middle">
						<?php if(isset($this->validationErrors[$model]['metadescription'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div class="floatleft"><?php echo $this->validationErrors[$model]['metadescription'];?></div>
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
			
				<tr class="odd_row">
					<td align='left' colspan="4" style="padding:10px 0px 10px 200px">
						<table>
							<tr><td>
								<?php echo $this->Form->hidden('id');
                                                                echo $form->submit('Submit',array('border'=>'0','class'=>'submit_button')); ?>
							</td>
							<td><?php					
							echo $html->link('Cancel', array('action' => 'index'), array('escape' => false,'class'=>'cancel_lnk'));
								?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<?php echo $form->end(); ?>
		</div>
	</div>	
</div>
<?php /********************Second tab start here ************************/ ?>
	<div id="tab2" class="tab_content">
		<div class="wrapper">		
		<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
		<?php	echo $this->Form->create($model,array("url"=>array('plugin'=>'pages','controller' => 'pages','action'=>'admin_edit_page',$page_id,'hy'))); ?>
			<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
				<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
					</td></tr>
				<tr class="odd_row">
					<td align='left' width="19%" valign="top" class="padding_left_40">Title<font color='red'>*</font></td>
					<td width="1%" valign="top">:</td>
					<td > <?php echo $form->text($model.".title_hy", array("class" => "ui-widget-content ui-corner-all")); ?></td>
					<td width="30%" valign="middle">
					<?php  if(isset($this->validationErrors[$model]['title_hy'])){ ?>
						<div  class="errormsg">
						  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
						  <div class="floatleft"><?php echo $this->validationErrors[$model]['title_hy'];?></div>
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
						echo $form->textarea($model.'.description_hy', array('label' => '','class'=>'ui-widget-content ui-corner-all','style'=>'width:600px;height:500px;'));
						echo $this->Editor->render($model.'DescriptionHy');
					?>
					</td>
					<td width="30%" valign="middle">
						<?php if(isset($this->validationErrors[$model]['description_hy'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div class="floatleft"><?php echo $this->validationErrors[$model]['description_hy'];?></div>
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
					<td align='left' valign="top" class="padding_left_40">MetaKeywords<font color='red'>*</font></td>
					<td width="1%" valign="top">:</td>
					<td>
						<?php echo $form->textarea($model.'.metakeyword_hy', array('label' => '','class'=>'ui-widget-content ui-corner-all','style'=>'width:250px;height:50px;'));?>
					</td>
					<td width="30%" valign="middle">
						<?php if(isset($this->validationErrors[$model]['metakeyword_hy'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div class="floatleft"><?php echo $this->validationErrors[$model]['metakeyword_hy'];?></div>
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
					<td align='left' width="19%" valign="top" class="padding_left_40">MetaDescription<font color='red'>*</font></td>
					<td width="1%" valign="top">:</td>
					<td ><?php echo $form->textarea($model.'.metadescription_hy', array('label' => '','class'=>'ui-widget-content ui-corner-all','style'=>'width:250px;height:50px;'));?></td>
					<td width="30%" valign="middle">
						<?php if(isset($this->validationErrors[$model]['metadescription_hy'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div class="floatleft"><?php echo $this->validationErrors[$model]['metadescription_fr'];?></div>
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
				<tr class="odd_row" ><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></td></tr>		
				<tr class="odd_row">
					<td align='left' valign="top" class="padding_left_40">Show at home page</td>
					<td width="1%" valign="top">:</td>
					<td><?php  echo $form->input('home_page',array('label' => '','options' => array('0'=>'No','1'=>'Yes'), null,'class'=>'ui_dropdown'));  ?></td>
					<td width="30%" valign="middle">
						<?php if(isset($this->validationErrors[$model]['home_page'])){?>
							<div  class="errormsg">
							  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
							  <div class="floatleft"><?php echo $this->validationErrors[$model]['home_page'];?></div>
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
			
			<tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
					</td></tr>
			<tr class="even_row">
				<td align='left' width="19%" valign="top" class="padding_left_40">Position<font color='red'>*</font></td>
				<td width="1%" valign="top">:</td>
				<td > <?php echo $form->text($model.".position", array("class" => "ui-widget-content ui-corner-all")); ?></td>
				<td width="30%" valign="middle">
				<?php  if(isset($this->validationErrors[$model]['position'])){ ?>
					<div  class="errormsg">
					  <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL;?>img/error_icon.gif" width="10" height="10" alt="" /></div>
					  <div class="floatleft"><?php echo $this->validationErrors[$model]['position'];?></div>
					  <div class="clear"></div>
					  <div class="errtl"></div>
					  <div class="errtr"></div>
					  <div class="errbl"></div> 
					  <div class="errbr"></div>
					</div>
				<?php } ?>
				</td>
			</tr>
			<tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?>
				</td>
			</tr> 
			<tr class="odd_row" ><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></td></tr>	
			<tr class="odd_row">
				<td align='left' valign="top" class="padding_left_40">Status</td>
				<td width="1%" valign="top">:</td>
				<td>
					<?php echo $form->input('active',array('label' => '','options' => array('0'=>'Inactive','1'=>'Active'), null,'class'=>'ui_dropdown'));  ?>
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
			<tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif',array('alt'=>'','width'=>'1px','height'=>'10px'));?></td></tr> 
				<tr class="even_row">
					<td align='left' colspan="4" style="padding:10px 0px 10px 200px">
						<table>
							<tr><td>
								<?php   echo $this->Form->hidden('id');
									echo $form->input('active',array('type'=>'hidden','value'=>1));  
									echo $form->input('position',array('type'=>'hidden','value'=>1));  
									echo $form->submit('Submit',array('border'=>'0','class'=>'submit_button')); 
								?>
							</td>
							<td><?php	echo $html->link('Cancel', array('action' => 'index'), array('escape' => false,'class'=>'cancel_lnk'));?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<?php echo $form->end(); ?>
		</div>
	</div>	
</div>
</div>
