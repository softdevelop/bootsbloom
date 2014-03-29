<div class="pl10" >
    <div class="forgot_password" style="width: 600px;" >
        <?php echo $pageTitle; ?>
    </div>
    <?php echo $this->Form->create('Message', array('id' => 'ProjectAskedQuestionForm', 'type' => 'POST', 'url' => WEBSITE_FRONT_URL . "sendmessage/" . $project_detail['User']['slug'] . '/' . $project_detail['Project']['slug'], 'name' => 'frmRegister')); ?>
    <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center" >
        <tr ><td  align="left" colspan="3"> <div class="clr pt10"> </div>
                <?php if ($this->validationErrors) { ?>
                    <div class="error pt10">
                        <?php
                        echo "<ul>";
                        foreach ($this->validationErrors['Page'] as $error) {
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
        <tr><td align="left" ><?php __('message_to'); ?>: <strong><?php echo $project_detail['User']['name']; ?></strong></td></tr>
        <tr >
            <td >
                <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>		
        <tr>
            <td  align="left">
                <?php echo $form->textarea('ProjectAskedQuestion.question', array('class' => 'con_input-text required', 'style' => 'width:98%;height:95px;')); ?>
                <br />
                <span id="ProjectAskedQuestionQuestion_error" > </span>
            </td>
        </tr>
        <tr >
            <td >
                <?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>
            </td>
        </tr>	
    </table>
    <?php echo $form->end(); ?>	
</div>

