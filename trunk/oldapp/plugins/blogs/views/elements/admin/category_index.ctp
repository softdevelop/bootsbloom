<div id="ajaxpanel">
    <?php
    echo $this->Form->create($model, array('name' => 'AdminsOperateForm', 'action' => 'operate', 'id' => 'AdminsOperateForm', "method" => "post"));
    echo $form->hidden('operation', array('value' => '', 'id' => 'AdminsOperation'));
    echo $form->hidden('category_id', array('value' => $blog_id));
    $sortKey = $paginator->sortKey();
    $sortDir = $paginator->sortDir();
    ?>
    <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
            <tr class="ui-widget-header ui-corner-all" style="height:30px;">

                <td align="left" class="padleft_15px" width="5%"><?php echo $form->checkbox('chkAll', array('id' => 'chkAll', 'name' => 'chkAll', 'value' => '', 'onclick' => 'checkAll()')); ?></td>

                <td align="left" width="30%"><?php echo $paginator->sort('Category Name', 'category_name'); ?><span <?php if ($sortKey == "BlogCategory.category_name") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>

                <td align="left" width="40%"><?php echo $paginator->sort('Description', 'description'); ?><span <?php if ($sortKey == "BlogCategory.description") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>

                <td align="center" width="15%"><?php echo $paginator->sort('Date', 'created'); ?><span <?php if ($sortKey == "BlogCategory.created") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>

                <td align="center" width="10%"><?php echo $paginator->sort('Status', 'active'); ?><span <?php if ($sortKey == "BlogCategory.active") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>

            </tr>
            <?php
            if (count($result) > 0) {
                $i = 0;
                $class = 'odd_row';
                foreach ($result as $records) {

                    $class = (($i + 1) % 2 == 0) ? 'even_row' : 'odd_row';
                    ?>
                    <tr class="<?php echo $class; ?>" id="row_<?php echo $records[$model]['id']; ?>">
                        <td width="5%" class="padleft_15px" valign="top">
                            <?php echo $form->checkbox('usersChk', array('name' => 'data[usersChk][]', 'id' => 'iId_' . $i, 'value' => $records[$model]['id']), $return = false); ?>
                        </td>

                        <td width="30%" valign="top">
                            <?php echo ucwords($records[$model]['category_name']); ?>
                            <div id="action_row_<?php echo $records[$model]['id']; ?>" style="visibility:hidden;" class="action_row">
                                <?php echo $this->Html->link('Edit', array('action' => 'admin_edit_blog_category', $records[$model]['id'], $records[$model]['blog_id']), array('class' => 'vtip', 'title' => 'Edit Category', 'escape' => false)) ?>
                                &nbsp;|&nbsp;
                                <?php
                                if ($records[$model]['active'] == '0') {
                                    echo $this->Html->link('Active', array('action' => 'change_category_status', $records[$model]['active'], $records[$model]['id']), array('title' => 'Change Category Status To Active ', 'class' => 'vtip'), 'Are you sure you want to change category status ?');
                                } else {
                                    echo $this->Html->link('Inactive', array('action' => 'change_category_status', $records[$model]['active'], $records[$model]['id']), array('title' => 'Change Category Status To Inactive ', 'class' => 'vtip'), 'Are you sure you want to change category status ?');
                                }
                                ?>&nbsp;|&nbsp;

                                <?php echo $this->Html->link('Delete', array('action' => 'admin_delete_blog_category', $records[$model]['id']), array('title' => 'Delete Category ', 'class' => 'vtip'), 'Are you sure you want to delete this Category ? '); ?>
                            </div>
                        </td>

                        <td width="40%"valign="top"><?php echo ucfirst(substr($records[$model]['description'], 0, 90)); ?></td>
                        <td width="15%"valign="top" align="center"><?php echo date('M, d Y', $records[$model]['created']); ?></td>
                        <td width="10%"valign="top" align="center">
        <?php
        if ($records[$model]['active'] == '1') {
            echo $html->image('active.png', array('border' => '0', 'alt' => 'Active Page'));
        } else {
            echo $html->image('inactive.png', array('border' => '0', 'alt' => 'Inactive Page'));
        }
        ?>
                        </td>

                    </tr>
                            <?php $i++;
                        } ?>
                <tr>
                    <td colspan="8"><div class="ochead"></div></td>
                </tr>	
                <tr class="odd_row">
                    <td class="td-listing" colspan="8" align="right"><?php echo $this->element('admin/pagination'); ?></td>
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