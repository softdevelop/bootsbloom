<div id="ajaxpanel">
    <?php
    echo $this->Form->create($model, array('name' => 'AdminsOperateForm', 'action' => 'operate', 'id' => 'AdminsOperateForm', "method" => "post"));
    echo $form->hidden('operation', array('value' => '', 'id' => 'AdminsOperation'));
    $sortKey = $paginator->sortKey();
    $sortDir = $paginator->sortDir();
    ?>
    <div  class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
            <tr class="ui-widget-header ui-corner-all" style="height:30px;">
                <td align="left" class="padleft_15px"><?php echo $form->checkbox('chkAll', array('id' => 'chkAll', 'name' => 'chkAll', 'value' => '', 'onclick' => 'checkAll()')); ?></td>

                <td align="left"><?php echo $paginator->sort('Name', 'name'); ?><span <?php if ($sortKey == "Blog.name") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>

                <td align="left"><?php echo $paginator->sort('Description', 'description'); ?><span <?php if ($sortKey == "Blog.description") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>

                <td align="center">Category</td>

                <td align="center">Post</td>

                <td align="center"><?php echo $paginator->sort('Status', 'active'); ?><span <?php if ($sortKey == "Blog.active") { ?> class="<?php echo $sortDir; ?>" <?php } ?>>&nbsp;</span></td>
            </tr>
            <?php
            if (count($result) > 0) {
                $i = 0;
                $class = 'odd_row';
                foreach ($result as $records) {

                    $class = (($i + 1) % 2 == 0) ? 'even_row' : 'odd_row';
                    ?>
                    <tr class="<?php echo $class; ?>" id="row_<?php echo $records['Blog']['id']; ?>">
                        <td width="3%" class="padleft_15px" valign="top">
                            <?php echo $form->checkbox('usersChk', array('name' => 'data[usersChk][]', 'id' => 'iId_' . $i, 'value' => $records[$model]['id']), $return = false); ?>
                        </td>
                        <td width="22%" valign="top">
                            <?php echo ucwords($records[$model]['name']); ?>
                            <div id="action_row_<?php echo $records[$model]['id']; ?>" style="visibility:hidden;" class="action_row">
                                <?php echo $this->Html->link('Edit', array('action' => 'admin_edit_blog', $records[$model]['id']), array('escape' => false, 'title' => 'Edit blog', 'alt' => 'Edit blog', 'class' => 'vtip')) ?>&nbsp;|&nbsp;
                                <?php
                                if ($records[$model]['active'] == '0') {
                                    echo $this->Html->link('Active', array('action' => 'change_blog_status', $records[$model]['active'], $records[$model]['id']), array('title' => 'Change Blog Status To Active', 'class' => 'vtip'), 'Are you sure you want to change blog status ?');
                                } else {
                                    echo $this->Html->link('Inactive', array('action' => 'change_blog_status', $records[$model]['active'], $records[$model]['id']), array('title' => 'Change Blog Status To Inactive', 'class' => 'vtip'), 'Are you sure you want to change blog status ?');
                                }
                                ?>&nbsp;|&nbsp;

                                <?php echo $this->Html->link('Delete', array('action' => 'admin_delete_blog', $records[$model]['id']), array('title' => 'Delete Blog', 'class' => 'vtip'), 'Are you sure you want to delete blog ?');
                                ?>
                            </div>
                        </td>
                        <td width="30%" valign="top"><?php echo ucfirst(substr($records[$model]['description'], 0, 60)); ?></td>
                        <td width="20%"valign="top" align="center">
        <?php echo $this->Html->link('Categories', array('plugin' => 'blogs', 'controller' => 'blog_categories', 'action' => 'index', $records[$model]['id']), array('class' => 'add_lnk', 'escape' => false)) ?>
                        </td>

                        <td width="15%"valign="top" align="center">
        <?php echo $this->Html->link(' Posts', array('plugin' => 'blogs', 'controller' => 'blog_posts', 'action' => 'index', $records[$model]['id']), array('class' => 'add_lnk', 'escape' => false)) ?>
                        </td>

                        <td width="10%" valign="top" align="center">
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