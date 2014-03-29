<?php echo $this->Form->create($model, array("class" => "form-horizontal")); ?>

<div class="ochead">

    <div class="floatleft padtop_20px">Add New City</div>
    <div class="floatright padtop_6px">
        <div class="floatleft padright_10px" style="font-size:10px;">
            <?php echo $this->Html->link("Back To Cities", array("plugin" => false, "controller" => "cities", "action" => "index"), array("class" => 'back_lnk')); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>
<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
    <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>
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
            </td>
        </tr>   

        <tr class="even_row">
            <td align='left' width="19%" valign="top" class="padding_left_40">Country<font color='red'>*</font></td>
            <td width="1%" valign="top">:</td>
            <td ><?php
                echo $this->Form->select($model . ".iso3166_1", $countries, null, array("class" => "ui-widget-content ui-corner-all", 'empty' => false, 'label' => false))
                ?></td>
            <td width="30%" valign="middle">
                <?php if (isset($this->validationErrors[$model]['iso3166_1'])) { ?>
                    <div  class="errormsg">
                        <div class="floatleft padright_10px padtop_4px"><img src="<?php echo WEBSITE_URL; ?>img/error_icon.gif" width="10" height="10" alt="" /></div>
                        <div class="floatleft"><?php echo $this->validationErrors[$model]['iso3166_1']; ?></div>
                        <div class="clear"></div>
                        <div class="errtl"></div>
                        <div class="errtr"></div>
                        <div class="errbl"></div>
                        <div class="errbr"></div>
                    </div>
                <?php } ?>
            </td>
        </tr>	
        <tr class="even_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>

        <tr class="odd_row"><td colspan="4"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td></tr>

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