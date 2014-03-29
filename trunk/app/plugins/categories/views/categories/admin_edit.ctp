<?php
echo $this->Form->create($model, array("action" => "edit"));
echo $this->Html->script('/users/js/user.js');
echo $form->hidden("parent_id");
?>
<div class="ochead">
    <div class="floatleft padright_10px">


    </div>
    <div class="floatleft padtop_20px">Edit Category</div>
    <div class="floatright padtop_6px">

        <div class="floatleft padright_10px" style="font-size:10px;">

<?php echo $this->Html->link("Back To Categories", array("plugin" => "categories", "controller" => "categories", "action" => "index", $this->data['Category']['parent_id']), array("class" => 'back_lnk')); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>

<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>
<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
    <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td></tr>
        <tr class="odd_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Category Name<font color='red'>*</font></td>
            <td width="1%" valign="top">:</td>
            <td > <?php echo $form->text($model . ".category_name", array("class" => "ui-widget-content ui-corner-all")); ?></td>
            <td width="30%" valign="middle">
<?php if (isset($this->validationErrors[$model]['category_name'])) { ?>
                    <div  class="errormsg">
                        <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                        <div class="floatleft"><?php echo $this->validationErrors[$model]['category_name']; ?></div>
                        <div class="clear"></div>
                        <div class="errtl"></div>
                        <div class="errtr"></div>
                        <div class="errbl"></div>
                        <div class="errbr"></div>
                    </div>
<?php } ?>
            </td>
        </tr>
        <tr class="odd_row" ><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>

        <tr class="even_row">
            <td align='left' colspan="4" style="padding:10px 0px 10px 200px">
                <table>
                    <tr><td>
<?php echo $form->submit('Submit', array('border' => '0', 'class' => 'submit_button')); ?>
                        </td>

                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<?php echo $form->end(); ?>