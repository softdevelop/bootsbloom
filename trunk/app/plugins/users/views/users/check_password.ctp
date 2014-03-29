<div class="pl10" >
    <div class="forgot_password" ><?php __('check_password_enter_password'); ?></div>
    <?php echo $this->Form->create($model, array("url" => array("action" => "account_setting"), 'onsubmit' => 'return false')); ?>
    <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center" >
        <tr ><td  align="left" colspan="3"> <div class="clr pt10"> </div>
                <?php if (isset($error)) { ?>
                    <div class="error pt10">
                        <?php
                        echo "<ul>";
                        ?>
                        <li><?php echo $error; ?></li>
                        <?php
                        echo "</ul>";
                        ?>
                    </div>
                <?php } ?>
            </td>
        </tr>
        <tr><td  align="center"  colspan="3" class="blk17"><?php __('check_password_current_password'); ?></td></tr>
        <tr><td align="left" colspan="3"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>
        <tr>
            <td align="right"><?php __('check_password_password'); ?> *</td>
            <td align="center" width="10%">:</td>
            <td align="left" ><?php echo $form->password($model . ".password", array('class' => 'con_input-text')); ?>
            </td>
        </tr>				
    </table>
    <?php echo $form->end(); ?>	
</div>
<div><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>