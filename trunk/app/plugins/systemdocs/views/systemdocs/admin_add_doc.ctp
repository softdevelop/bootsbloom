<?php echo $this->Form->create($model, array("class" => "form-horizontal", "type" => "file")); ?>
<?php echo $this->Html->script('/systemdocs/js/admin/systemdocs.js'); ?>
<div class="ochead" >
	<div class="floatleft" id="breadcrumb">Add Doc</div>
	<div class="floatright padtop_6px">
		<div class="floatleft " style="font-size:10px;"></div>
		<div class="floatleft" style="font-size:10px;">
			<?php echo $this->Html->link("Back", array('action' => 'index'), array("class" => 'back_lnk')); ?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>	
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>
<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
    <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td></tr>
        <tr>
            <td  width='19%' valign='top'>Select Docs<font color='red'>*</font></td><td width='1%' valign="top">:</td><td width='80%'>
                <div id="adddoc">
                    <div class="controls addmore" >
                        <input type="file" name="data[Systemdoc][doc_name][]" id="adImages_0" value="" class="ui-widget-content ui-corner-all"/>
                        <a href="javascript:void(0);" onClick="addMore()" class="add_lnk">Add more</a>
                    </div>
                    <div style="float:right;"><?php if (isset($this->validationErrors[$model]['doc_name'])) { ?>
                            <div  class="errormsg">
                                <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                                <div class="floatleft"><?php echo $this->validationErrors[$model]['doc_name']; ?> </div>
                                <div class="clear"></div>
                                <div class="errtl"></div>
                                <div class="errtr"></div>
                                <div class="errbl"></div>
                                <div class="errbr"></div>
                            </div>
                        <?php } ?></div>
                </div>
            </td>
        </tr>
        <tr class="odd_row">
            <td align='left' colspan="4" style="padding:10px 0px 10px 200px">
                <table>
                    <tr><td>
                            <?php echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button')); ?>
                        </td>
                        <td><?php
                            echo $html->link('Cancel', array('action' => 'index'), array('escape' => false, 'class' => 'cancel_lnk'));
                            ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<?php echo $form->end(); ?>
