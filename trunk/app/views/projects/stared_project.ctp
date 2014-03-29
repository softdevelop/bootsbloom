<div class="pl10" >
    <div class="forgot_password"><?php __('project_stared_email_to_update_project'); ?></div>
    <?php echo $this->Form->create($model, array("url" => array("action" => "stared_project", $project_id))); ?>
    <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center" >
        <tr ><td  align="left" colspan="3"> <div class="clr pt10"> </div>
                <?php if ($this->validationErrors) { ?>
                    <div class="error pt10">
                        <?php
                        echo "<ul>";
                        foreach ($this->validationErrors['Project'] as $error) {
                            ?>
                            <li><?php echo $error; ?></li>
                            <?php
                        }
                        echo "</ul>";
                        ?>
                    </div>
                <?php } ?>
            </td>
        </tr>
        <tr><td align="left" colspan="3"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></td></tr>
        <tr>
            <td align="right"><?php __('email'); ?> *</td>
            <td align="center" width="10%">:</td>
            <td align="left" ><?php echo $form->text("StaredProject.email", array('class' => 'con_input-text')); ?>
            </td>
        </tr>				
    </table>
    <?php echo $form->end(); ?>	
</div>	
<div><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>