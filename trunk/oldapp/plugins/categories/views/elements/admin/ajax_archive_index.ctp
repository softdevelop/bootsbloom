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
                                echo $html->link("Edit", array('action' => 'edit', $category['Category']['id']), array('escape' => false, 'title' => 'Edit Category', 'alt' => 'Edit Category', 'class' => 'vtip'));
                                ?><?php
                                ?>&nbsp;|&nbsp;
                                <?php echo $html->link("Delete", array('action' => 'delete', $category['Category']['id']), array('escape' => false, 'title' => 'Delete Category', 'alt' => 'Delete Category', 'class' => 'vtip arc_delete'));
                                ?>   

                            </div>
                        </td>
                        <td align='left' valign="top"><?php echo date('M d, Y', $category['Category']['created']); ?></td>
                        <td align='center' valign="top">
                            <?php
                            if (!$category['Category']['active'] == '0') {
                                echo $this->Html->image('admin/icon-active.gif', array('title' => 'Inactive', 'alt' => 'Active', 'class' => 'vtip'));
                            } else {
                                echo $this->Html->image('admin/inactive-icon.gif', array('title' => 'Active', 'alt' => 'Inactive', 'class' => 'vtip'));
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
<div id="arc-dialog-confirm-delete-all" title="Delete Category?" style="display: none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo "Are you sure, you want to delete this Category? If you permanently delete category then it will delete it from the system"; ?></p>
</div>
<!-- Delete All confirmation div end -->