<div class="pl10" >    <div class="forgot_password width450"><?php __('project_backer_comment_below'); ?></div>    <?php echo $this->Form->create($model, array("url" => array("action" => "project_backer_comment"))); ?>    <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center" >        <tr ><td  align="left" colspan="3"> <div class="clr pt10"> </div>                <?php if ($this->validationErrors) { ?>                    <div class="error pt10">                        <?php                        echo "<ul>";                        ?>                        <li><?php echo $this->validationErrors['Project']['comment']; ?></li>                        <?php                        echo "</ul>";                        ?>                    </div>                <?php } ?>            </td>        </tr>        <tr><td align="left" colspan="3"><?php __('projt_dtl_project_comment'); ?> <span class="mandatory_field pl5">*</span></td></tr>	        <tr>            <td colspan="3" align="left"><?php echo $form->textarea($model . ".comment", array('class' => 'con_input-text', 'style' => 'width:98%;height:95px;')); ?>            </td>        </tr>        <tr ><td colspan="3"><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?>            </td>        </tr>	    </table>    <?php echo $form->end(); ?>	</div>	<div><?php echo $html->image('admin/dot.gif', array('alt' => '', 'width' => '1px', 'height' => '10px')); ?></div>