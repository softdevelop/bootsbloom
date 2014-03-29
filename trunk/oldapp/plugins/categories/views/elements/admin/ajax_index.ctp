<div id="ajaxpanel">
    <?php
    echo $this->Form->create($model, array('name' => 'AdminsOperateForm', 'action' => 'operate', 'id' => 'AdminsOperateForm'));
    echo $this->Form->hidden('operation', array('value' => '', 'id' => 'AdminsOperation'));
    $sortKey = $paginator->sortKey();
    $sortDir = $paginator->sortDir();
    ?>
    <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">

            <tr class="ui-widget-header ui-corner-all" style="height:30px;">
                <td align="left" class="padleft_15px" width="5%"><?php echo $form->checkbox('chkAll', array('id' => 'chkAll', 'name' => 'chkAll', 'value' => '', 'onclick' => 'checkAll()')); ?></td>
                <td align="left"><?php echo $paginator->sort('Name', 'category_name'); ?><span <?php if ($sortKey == "Category.firstname") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
                <td align="left" width="15%"><?php echo $paginator->sort('Created', 'created'); ?><span <?php if ($sortKey == "Category.firstname") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td> 
                <td  align="center" width="10%"><?php echo $paginator->sort('Status', 'active'); ?><span <?php if ($sortKey == "Category.active") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
            </tr>
            <?php
            if (count($categories) > 0) {
                $i = 0;
                $class = 'odd_row';
                foreach ($categories as $category) {

                    $class = (($i + 1) % 2 == 0) ? 'even_row' : 'odd_row';
                    ?>
                    <tr class="<?php echo $class; ?>" id="row_<?php echo $category['Category']['id']; ?>">
                        <td width="5%" class="padleft_15px" valign="top">
                            <?php echo $form->checkbox('usersChk', array('name' => 'data[usersChk][]', 'id' => 'iId_' . $i, 'value' => $category['Category']['id']), $return = false); ?>
                        </td>
                        <td valign="top">
                            <?php
                            echo ucwords($category['Category']['category_name']);
                            ?>
                            <div id="action_row_<?php echo $category['Category']['id']; ?>" style="visibility:hidden;" class="action_row">
                                <?php
                                echo $html->link("Edit", array('action' => 'edit', $category['Category']['id']), array('escape' => false, 'title' => 'Edit user information', 'alt' => 'Edit Category', 'class' => 'vtip'));
                                ?>&nbsp;|&nbsp;<?php
                        if ($category['Category']['active'] == 1) {
                            echo $html->link("Inactive", array('action' => 'status_update', $category['Category']['id'], $category['Category']['parent_id'], 0, "?time=" . md5(time())), array('escape' => false, 'title' => 'Change user status to inactive', 'alt' => 'Inactive user', 'class' => 'vtip'), sprintf(__('Are you sure, you want to inactivate this Category?', true)));
                        } else {
                            echo $html->link("Active", array('action' => 'status_update', $category['Category']['id'], $category['Category']['parent_id'], 1, "?time=" . md5(time())), array('escape' => false, 'title' => 'Change user status to active', 'alt' => 'Active Category', 'class' => 'vtip'), sprintf(__('Are you sure, you want to activate this Category?', true)));
                        }
                                ?>&nbsp;|&nbsp;
                                <?php echo $html->link("Delete", array('action' => 'delete', $category['Category']['id']), array('escape' => false, 'title' => 'Delete Category', 'alt' => 'Delete Category', 'class' => 'vtip delete'));
                                ?>&nbsp;|&nbsp;<?php echo $this->Html->link("Add Subcategory", array("plugin" => "categories", "controller" => "categories", "action" => "add_category", $category['Category']['id']));
                                ?>&nbsp;|&nbsp;<?php echo $this->Html->link("View Subcategories", array("plugin" => "categories", "controller" => "categories", "action" => "index", $category['Category']['id']));
                                ?>  
                            </div>
                        </td>
                        <td align='left' valign="top"><?php echo date(ADMIN_DATE_FORMAT, $category['Category']['created']); ?></td>
                        <td align='center' valign="top">
                            <?php
                            if (!$category['Category']['active'] == '0') {
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
                    <td colspan="4"><div class="ochead"></div></td>
                </tr>	
                <tr class="odd_row">
                    <td class="td-listing" colspan="4" align="right"><?php echo $this->element('admin/pagination'); ?></td>
                </tr>	
                <?php
            } else {
                ?>
                <tr class="odd_row"><td colspan="4" align="center">No record  found!</td></tr>
            <?php }
            ?>

        </table>
    </div>
    <?php echo $form->end(); ?>
</div>
<!-- Delete All confirmation div -->
<div id="dialog-confirm-delete-all" title="Delete Category?" style="display: none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo "Are you sure, you want to delete this Category?"; ?></p>
</div>
<!-- Delete All confirmation div end -->