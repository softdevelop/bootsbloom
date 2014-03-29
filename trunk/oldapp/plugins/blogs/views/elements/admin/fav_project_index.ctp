<div id="ajaxpanel">
    <?php
    echo $this->Form->create('', array('name' => 'AdminsOperateForm', 'action' => 'operate', 'id' => 'AdminsOperateForm', "method" => "post"));
    echo $form->hidden('operation', array('value' => '', 'id' => 'AdminsOperation'));
    ?>
    <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
            <tr class="ui-widget-header ui-corner-all" style="height:30px;">
                <td align="left" class="padleft_15px"><?php echo $form->checkbox('chkAll', array('id' => 'chkAll', 'name' => 'chkAll', 'value' => '', 'onclick' => 'checkAll()')); ?></td>
				<td align="left">Project id</td>
                <td align="left">Title</td>
            </tr>
			
<?php		if (count($fav_projects) > 0) {
                $i = 0;
                $class = 'odd_row';
                foreach ($fav_projects as $records) {

                    $class = (($i + 1) % 2 == 0) ? 'even_row' : 'odd_row';
                    ?>
                    <tr class="<?php echo $class; ?>" id="row_<?php echo $records['Project']['id']; ?>">
                        <td width="3%" class="padleft_15px" valign="top">
                            <?php echo $form->checkbox('usersChk', array('name' => 'data[usersChk][]', 'id' => 'iId_' . $i, 'value' => $records['Project']['id']), $return = false); ?>
                        </td>
						<td width="10%" valign="top">
							<?php echo $records['Project']['id']; ?>
                            <div id="action_row_<?php echo $records['Project']['id']; ?>" style="visibility:hidden;" class="action_row">
                                <?php echo $this->Html->link('Remove', array('action' => 'admin_remove', $records['Project']['id']), array('title' => 'Remove', 'class' => 'vtip'), 'Are you sure you want to remove this project from the list ?');
                                ?>
                            </div>
						</td>
                        <td width="80%" valign="top">
                            <?php echo $records['Project']['title']; ?>
                        </td>
                    </tr>
                            <?php $i++;
                        } ?>
                <tr>
                    <td colspan="8"><div class="ochead"></div></td>
                </tr>	
				
<?php		} else { ?>
                <tr class="odd_row"><td colspan="8" align="center">No records found!</td></tr>
<?php		} ?>
	   
        </table>	
    </div>
            <?php echo $form->end(); ?>
</div>