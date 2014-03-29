<?php echo $this->Form->create($model, array("class" => "form-horizontal", "type" => "file")); ?>
<div class="ochead" >
    <div class="floatleft" id="breadcrumb">Edit<?php
if (isset($blog)) {
    foreach ($blog as $blog) {
        echo ucfirst(substr($blog, 0, 50));
    }
}
?> Blog</div>
    <div class="floatright padtop_6px">
        <div class="floatleft " style="font-size:10px;"></div>
        <div class="floatleft " style="font-size:10px;">
<?php echo $this->Html->link("Back", array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'index'), array("class" => 'back_lnk')); ?>
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
        <tr class="odd_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Name<font color='red'>*</font></td>
            <td width="1%" valign="top">:</td>
            <td > <?php echo $form->text($model . ".name", array("class" => "ui-widget-content ui-corner-all")); ?></td>
            <td width="30%" valign="middle">
<?php if (isset($this->validationErrors[$model]['name'])) { ?>
                    <div  class="errormsg">
                        <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                        <div class="floatleft"><?php echo $this->validationErrors[$model]['name']; ?></div>
                        <div class="clear"></div>
                        <div class="errtl"></div>
                        <div class="errtr"></div>
                        <div class="errbl"></div>
                        <div class="errbr"></div>
                    </div>
<?php } ?>
            </td>
        </tr>
        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr> 

        <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td></tr>
        <tr class="even_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Image<font color='red'>*</font></td>
            <td width="1%" valign="top">:</td>
            <td > <?php echo $form->file($model . ".blog_images", array("class" => "ui-widget-content ui-corner-all")); ?>
                <span style="">
                <?php echo $this->Form->hidden('Blog.image_update', array('value' => $blog_image));
                echo $this->Html->image(UPLOAD_DIR_URL . $blog_image, array('width' => '50px', 'height' => '50px')); ?></span>

            </td>
            <td width="30%" valign="middle">
<?php if (isset($this->validationErrors[$model]['blog_images'])) { ?>
                    <div  class="errormsg">
                        <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                        <div class="floatleft"><?php echo $this->validationErrors[$model]['blog_images']; ?></div>
                        <div class="clear"></div>
                        <div class="errtl"></div>
                        <div class="errtr"></div>
                        <div class="errbl"></div>
                        <div class="errbr"></div>
                    </div>
<?php } ?>
            </td>
        </tr>
        <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr> 


        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr> 	
        <tr class="odd_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Description<font color='red'>*</font></td>
            <td width="1%" valign="top">:</td>
            <td ><?php echo $form->textarea($model . '.description', array('label' => '', 'class' => 'ui-widget-content ui-corner-all', 'style' => 'width:350px;height:150px;')); ?></td>
            <td width="30%" valign="middle">
<?php if (isset($this->validationErrors[$model]['description'])) { ?>
                    <div  class="errormsg">
                        <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                        <div class="floatleft"><?php echo $this->validationErrors[$model]['description']; ?></div>
                        <div class="clear"></div>
                        <div class="errtl"></div>
                        <div class="errtr"></div>
                        <div class="errbl"></div>
                        <div class="errbr"></div>
                    </div>
<?php } ?>
            </td>
        </tr>	
        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr> 
        <tr class="even_row">
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