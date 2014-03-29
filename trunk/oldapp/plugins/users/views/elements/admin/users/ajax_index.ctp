<div id="ajaxpanel">
    <?php
    echo $this->Form->create($model, array('name' => 'AdminsOperateForm', 'action' => 'operate', 'id' => 'AdminsOperateForm'));
    echo $form->hidden('operation', array('value' => '', 'id' => 'AdminsOperation'));
    $sortKey = $paginator->sortKey();
    $sortDir = $paginator->sortDir();
    ?>
    <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">

            <tr class="ui-widget-header ui-corner-all" style="height:30px;">
                <td align="left" class="padleft_15px"><?php echo $form->checkbox('chkAll', array('id' => 'chkAll', 'name' => 'chkAll', 'value' => '', 'onclick' => 'checkAll()')); ?></td>
                <td align="left"><?php echo $paginator->sort('Name', 'name'); ?><span <?php if ($sortKey == "User.firstname") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>

                <td align="left"><?php echo $paginator->sort('Email', 'email'); ?><span <?php if ($sortKey == "User.email") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
                <td align="left"><?php echo $paginator->sort('Created', 'created'); ?><span <?php if ($sortKey == "User.created") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
                <td  align="center"><?php echo $paginator->sort('Status', 'active'); ?><span <?php if ($sortKey == "User.active") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
            </tr>
            <?php
            if (count($users) > 0) {
                $i = 0;
                $class = 'odd_row';
                foreach ($users as $user) {
                    $class = (($i + 1) % 2 == 0) ? 'even_row' : 'odd_row';
                    ?>
                    <tr class="<?php echo $class; ?>" id="row_<?php echo $user['User']['id']; ?>">
                        <td width="5%" class="padleft_15px" valign="top">
                            <?php
                            if ($user['User']['id'] != 1) {
                                echo $form->checkbox('usersChk', array('name' => 'data[usersChk][]', 'id' => 'iId_' . $i, 'value' => $user['User']['id']), $return = false);
                            }
                            ?>
                        </td>
                        <td valign="top">
                            <?php
                            echo ucwords($user['User']['name']);
                            if ($user['User']['id'] != 1) {
                                ?>

                                <div id="action_row_<?php echo $user['User']['id']; ?>" style="visibility:hidden;" class="action_row">
                                    <?php
                                    echo $html->link("Edit", array('action' => 'edit', $user['User']['id']), array('escape' => false, 'title' => 'Edit user information', 'alt' => 'Edit User', 'class' => 'vtip'));
                                    if ($user['User']['id'] != 1) {
                                        ?>&nbsp;|&nbsp;
                                            <?php /*    if ($user['User']['active'] == 1) {
                                                    echo $html->link("Inactive", array('action' => 'status_update', $user['User']['id'], 0, "?time=" . md5(time())), array('escape' => false, 'title' => 'Change user status to inactive', 'alt' => 'Inactive user', 'class' => 'vtip'), sprintf(__('Are you sure, you want to inactivate this User?', true)));
                                                } else {
                                                    echo $html->link("Active", array('action' => 'status_update', $user['User']['id'], 1, "?time=" . md5(time())), array('escape' => false, 'title' => 'Change user status to active', 'alt' => 'Active User', 'class' => 'vtip'), sprintf(__('Are you sure, you want to activate this User?', true)));
                                                }  ?>
                                                                ?>&nbsp;|&nbsp;<?php*/
                                          echo $html->link("Delete", array('action' => 'delete', $user['User']['id']), array('escape' => false, 'title' => 'Delete user', 'alt' => 'Delete user', 'class' => 'vtip'), sprintf(__('Are you sure, you want to delete this User?Please confirm that all the data regarding this user will be removed and can not be recovered.', true)));?>
						&nbsp;|&nbsp;<?php 
                                      
                                        if ($user['User']['group_id'] == 3) {
                                            echo $html->link("View Projects", array('plugin' => false, 'controller' => 'projects', 'action' => 'index', $user['User']['id']), array('escape' => false, 'title' => 'View all projects of this user', 'alt' => 'View all projects of this user', 'class' => 'vtip'));
                                            ?>
                                            &nbsp;|&nbsp;<?php
                        echo $html->link("View Backed Projects", array('plugin' => 'users', 'controller' => 'users', 'action' => 'user_backed_project', $user['User']['id']), array('escape' => false, 'title' => 'View all backed projects of this user', 'alt' => 'View all backed projects of this user', 'class' => 'vtip'));
                    }
                }
                                    ?> 
                                    <?php 
                                 if ($user['User']['is_deleted'] == 1) {
                                     echo "| ".$html->link("Recover Account", array('action' => 'recover_account', $user['User']['id']), array('escape' => false, 'title' => 'Recover user account', 'alt' => 'Edit User', 'class' => 'vtip'));
                                 } ?>
                                </div>
                            <?php } ?>
                        </td>

                        <td valign="top">
                            <?php echo $html->link($user['User']['email'], 'mailto:' . $user['User']['email'], array('escape' => false)); ?>
                        </td>
                        <td valign="top">
                            <?php echo date(ADMIN_DATE_FORMAT, $user['User']['created']); ?>
                        </td>


                        <td align='center' valign="top">
                            <?php
                            if (!$user['User']['active'] == '0') {
                                echo $this->Html->image('admin/icon-active.gif', array('title' => 'Active', 'alt' => 'Active', 'class' => 'vtip'));
                            } else {
                                echo $this->Html->image('admin/inactive-icon.gif', array('title' => 'Inactive', 'alt' => 'Inactive', 'class' => 'vtip'));
                            }
                            ?>

                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                <tr>
                    <td colspan="5"><div class="ochead"></div></td>
                </tr>	
                <tr class="odd_row">
                    <td class="td-listing" colspan="4" align="right"><?php echo $this->element('admin/pagination'); ?></td>
                </tr>	
                <?php
            } else {
                ?>
                <tr class="odd_row"><td colspan="8" align="center">No record  found!</td></tr>
            <?php } ?>

        </table>
    </div>
    <?php echo $form->end(); ?>
</div>